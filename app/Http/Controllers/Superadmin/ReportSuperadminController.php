<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Report;
use App\Models\FollowUp;
use App\Models\Comment;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Traits\HasActivityLog;

class ReportSuperadminController extends Controller
{
    use HasActivityLog;
    /**
     * Menampilkan semua laporan milik user (atau semua jika tidak login).
     */
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                // Ambil kategori non_wbs_admin yang ditugaskan ke admin
                $kategoriIds = $user->kategori()
                    ->where('tipe', 'non_wbs_admin')
                    ->pluck('id')
                    ->toArray();

                $reports = Report::whereIn('kategori_id', $kategoriIds)
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
            } elseif ($user->role === 'superadmin') {
                // Superadmin bisa lihat semua kategori non_wbs_admin
                $reports = Report::whereHas('kategori', function ($q) {
                    $q->where('tipe', 'non_wbs_admin');
                })
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
            } else {
                // User biasa: hanya aduan sendiri, tapi tetap non_wbs_admin
                $reports = Report::where('user_id', $user->id_user)
                    ->whereHas('kategori', function ($q) {
                        $q->where('tipe', 'non_wbs_admin');
                    })
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
            }
        } else {
            // Guest: hanya report non_wbs_admin
            $reports = Report::whereHas('kategori', function ($q) {
                $q->where('tipe', 'non_wbs_admin');
            })
                ->latest()
                ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
        }

        return view('superadmin.welcome', compact('reports'));
    }

    /**
     * Tampilkan form pembuatan laporan.
     */
    public function create()
    {
        return view('user.aduan.create');
    }

    /**
     * Simpan laporan baru.
     */

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nik' => 'nullable|string|max:20|unique:users,nik',
            'nomor_telepon' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,superadmin',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['email_verified_at'] = now();         // ✅ langsung verified
        $validated['remember_token'] = Str::random(10);  // ✅ generate token

        try {
            User::create($validated);
            return redirect()->back()->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail laporan lengkap dengan komentar & follow up.
     */
    public function show($id)
    {
        $report = Report::with([
            'kategori',
            'wilayah',
            'user',
            'admin',
            'followUps.user',
            'comments.user'
        ])->findOrFail($id);

        if (auth()->check() && auth()->user()->role === 'admin') {
            if ($report->admin_id !== auth()->user()->id_user) {
                return response()->view('errors.akses-ditolak', [], 403);
            }
        }

        $sessionKey = 'report_viewed_' . $id;
        if (!session()->has($sessionKey)) {
            $report->increment('views');
            session()->put($sessionKey, true);
        }

        $followUps = $report->followUps->filter(function ($item) {
            return $item->user && in_array($item->user->role, ['admin', 'superadmin']);
        });
        $comments = $report->comments;
        $admins = User::where('role', 'admin')->get();
        $kategoriList = KategoriUmum::all(); // ✅ ganti biar sesuai dengan Blade
        $wilayahList = WilayahUmum::all();   // ✅ ganti biar konsisten

        return view('superadmin.daftar-aduan.detail.index', compact(
            'report',
            'followUps',
            'comments',
            'admins',
            'kategoriList',
            'wilayahList'
        ));
    }

    public function like($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan like.');
        }

        $report = Report::findOrFail($id);
        $vote = Vote::where('user_id', $user->id_user)->where('report_id', $report->id)->first();

        if ($vote && $vote->vote_type === 'like') {
            $vote->delete();
            $report->decrement('likes');
            Session::forget('vote_report_' . $report->id); // hapus session
        } elseif ($vote && $vote->vote_type === 'dislike') {
            $vote->update(['vote_type' => 'like']);
            $report->increment('likes');
            $report->decrement('dislikes');
            Session::put('vote_report_' . $report->id, 'like');
        } else {
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'like',
            ]);
            $report->increment('likes');
            Session::put('vote_report_' . $report->id, 'like');
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:255',
            'isi' => 'nullable|string',
            'status' => 'nullable|in:Diajukan,Dibaca,Direspon,Selesai,Revisi,Arsip',
            'kategori_id' => 'nullable|exists:kategori_umum,id',
            'wilayah_id' => 'nullable|exists:wilayah_umum,id',
            'admin_id' => 'nullable|exists:users,id_user',
            'lokasi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tracking_id' => 'nullable|string|max:255',
            'komentar_revisi' => 'nullable|string',
            'file.*' => 'nullable|file|max:2048',
        ]);

        // Ambil data update normal
        $data = $request->only([
            'judul',
            'isi',
            'status',
            'kategori_id',
            'wilayah_id',
            'admin_id',
            'lokasi',
            'latitude',
            'longitude',
            'tracking_id',
            'komentar_revisi',
        ]);

        $data['updated_by'] = auth()->id();

        // Logika: Batalkan selesai → balik ke Dibaca/Direspon
        if ($report->status === Report::STATUS_SELESAI && $request->status === Report::STATUS_DIBACA) {
            if ($report->followUps->isNotEmpty()) {
                $data['status'] = Report::STATUS_DIRESPON;
            } else {
                $data['status'] = Report::STATUS_DIBACA;
            }
        }

        // Kalau admin dipilih tapi kategori kosong → isi kategori pertama admin
        if (!empty($request->admin_id) && empty($request->kategori_id)) {
            $admin = User::with('kategori')->where('id_user', $request->admin_id)->first();
            if ($admin && $admin->kategori->count() > 0) {
                $data['kategori_id'] = $admin->kategori->first()->id;
            }
        }

        // Handle Lampiran Baru → simpan langsung ke public/report_files
        $files = (array) $report->file; // data lama (array JSON)
        if ($request->hasFile('file')) {
            $destinationPath = public_path('report_files'); // folder publik

            // buat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('file') as $uploadedFile) {
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                $uploadedFile->move($destinationPath, $filename);
                $files[] = 'report_files/' . $filename; // path relatif
            }
        }
        $data['file'] = $files;

        // Deteksi perubahan
        $changes = [];
        foreach ($data as $key => $value) {
            if ($key === 'file') {
                if (json_encode($report->file) !== json_encode($value)) {
                    $changes[$key] = [
                        'old' => $report->file,
                        'new' => $value
                    ];
                }
            } elseif ($report->$key != $value) {
                $changes[$key] = [
                    'old' => $report->$key,
                    'new' => $value
                ];
            }
        }

        // Update laporan
        $oldStatus = $report->status;
        $report->update($data);
        $newStatus = $report->status;

        // Log the change
        if (!empty($changes)) {
            $this->logActivity(
                'UPDATE',
                'Report',
                $report->id,
                "Superadmin memperbarui laporan #{$report->tracking_id}",
                $changes
            );
        }

        // 🔔 NOTIFIKASI STATUS BERUBAH
        if ($oldStatus !== $newStatus) {
            // Notifikasi ke User Pelapor
            if ($report->pelapor) {
                $report->pelapor->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }

            // Notifikasi ke Admin terkait (jika yang ubah Superadmin)
            if ($report->admin) {
                $report->admin->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }

            // Notifikasi ke Superadmins lainnya
            $superadmins = \App\Models\User::where('role', 'superadmin')->get();
            foreach ($superadmins as $superadmin) {
                $superadmin->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }
        }

        // 🔹 Buat notifikasi
        $messages = [];
        foreach ($changes as $field => $change) {
            switch ($field) {
                case 'judul':
                    $messages[] = "Judul laporan diubah.";
                    break;
                case 'isi':
                    $messages[] = "Isi laporan diperbarui.";
                    break;
                case 'status':
                    $messages[] = "Status laporan menjadi {$change['new']}.";
                    break;
                case 'kategori_id':
                    $messages[] = "Kategori laporan diperbarui.";
                    break;
                case 'wilayah_id':
                    $messages[] = "Wilayah laporan diperbarui.";
                    break;
                case 'admin_id':
                    $messages[] = "Admin penanggung jawab diperbarui.";
                    break;
                case 'lokasi':
                    $messages[] = "Lokasi laporan diubah.";
                    break;
                case 'latitude':
                case 'longitude':
                    $messages[] = "Koordinat laporan diperbarui.";
                    break;
                case 'tracking_id':
                    $messages[] = "Tracking ID laporan diperbarui.";
                    break;
                case 'file':
                    $messages[] = "Lampiran baru ditambahkan.";
                    break;
                case 'updated_by':
                    $messages[] = "Laporan diperbarui oleh " . (auth()->user()->name ?? 'System') . ".";
                    break;
            }
        }

        if (empty($messages)) {
            $messages[] = "Tidak ada perubahan pada laporan.";
        }

        return redirect()
            ->route('superadmin.reports.show', $id)
            ->with('success', implode(" ", $messages));
    }

    public function deleteFile($id, $index)
    {
        $report = Report::findOrFail($id);

        $files = (array) $report->file;

        if (isset($files[$index])) {
            $file = $files[$index];

            // Hapus langsung dari folder publik
            $filePath = public_path($file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus dari array JSON
            unset($files[$index]);
            $report->file = array_values($files); // reindex array
            $report->save();

            $this->logActivity(
                'DELETE_FILE',
                'Report',
                $report->id,
                "Superadmin menghapus lampiran pada laporan #{$report->tracking_id}",
                ['file_index' => $index, 'filename' => $file]
            );
        }

        return back()->with('success', 'Lampiran berhasil dihapus.');
    }

    public function dislike($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan dislike.');
        }

        $report = Report::findOrFail($id);
        $vote = Vote::where('user_id', $user->id_user)->where('report_id', $report->id)->first();

        if ($vote && $vote->vote_type === 'dislike') {
            $vote->delete();
            if ($report->dislikes > 0) {
                $report->decrement('dislikes');
            }
            Session::forget('vote_report_' . $report->id); // hapus session
        } elseif ($vote && $vote->vote_type === 'like') {
            $vote->update(['vote_type' => 'dislike']);
            if ($report->likes > 0) {
                $report->decrement('likes');
            }
            $report->increment('dislikes');
            Session::put('vote_report_' . $report->id, 'dislike');
        } else {
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'dislike',
            ]);
            $report->increment('dislikes');
            Session::put('vote_report_' . $report->id, 'dislike');
        }

        return back();
    }

    /**
     * Simpan tindak lanjut dari admin.
     */
    public function storeFollowUp(Request $request, $reportId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Hanya admin atau superadmin yang dapat memberikan tindak lanjut.');
        }

        $followUp = new FollowUp([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        $report = Report::findOrFail($reportId);

        if ($request->hasFile('file')) {
            $followUp->file = $request->file('file')->store('followup_files', 'public');
        }

        $followUp->save();

        $this->logActivity(
            'CREATE',
            'FollowUp',
            $followUp->id,
            "Superadmin menambahkan tindak lanjut pada laporan #{$report->tracking_id}",
            ['pesan' => $request->pesan]
        );

        // Update status laporan menjadi 'Direspon' hanya jika status sebelumnya 'Dibaca'
        if (in_array($report->status, [Report::STATUS_DIAJUKAN, Report::STATUS_DIBACA])) {
            $report->status = Report::STATUS_DIRESPON;
            $report->save();
        }

        // 🔔 DISTRIBUSI NOTIFIKASI TINDAK LANJUT
        $currentUser = Auth::user();
        $notifiableUsers = collect();

        // 1. Ke User (Pelapor)
        if ($report->pelapor) {
            $notifiableUsers->put($report->pelapor->id_user, $report->pelapor);
        }

        // 2. Ke Admin (Penanggung Jawab Kategori)
        if ($report->admin) {
            $notifiableUsers->put($report->admin->id_user, $report->admin);
        }

        // 3. Ke Semua Superadmin
        $superadmins = \App\Models\User::where('role', 'superadmin')->get();
        foreach ($superadmins as $superadmin) {
            $notifiableUsers->put($superadmin->id_user, $superadmin);
        }

        // 4. Pastikan pembuat aksi juga dapat
        $notifiableUsers->put($currentUser->id_user, $currentUser);

        // Kirim
        foreach ($notifiableUsers as $userToNotify) {
            $userToNotify->notify(new \App\Notifications\NewFollowUpNotification($report, $followUp, $currentUser));
        }

        return back()->with('success', 'Tindak lanjut berhasil dikirim' .
            ($report->status === Report::STATUS_DIRESPON ? ', Status Aduan menjadi Direspon' : ''));
    }

    /**
     * Simpan komentar dari user.
     */
    public function storeComment(Request $request, $reportId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        if (Auth::user()->role !== 'user' && Auth::user()->role !== 'admin') {
            abort(403, 'Hanya user dan admin yang dapat mengirim komentar.');
        }

        $comment = new Comment([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $comment->file = $request->file('file')->store('comment_files', 'public');
        }

        $comment->save();

        if (Auth::user()->role === 'superadmin') {
            $report = Report::find($reportId);
            $this->logActivity(
                'CREATE',
                'Comment',
                $comment->id,
                "Superadmin menambahkan komentar pada laporan #{$report->tracking_id}",
                ['pesan' => $request->pesan]
            );
        }

        // 🔔 DISTRIBUSI NOTIFIKASI KOMENTAR
        $currentUser = Auth::user();
        $report = Report::find($reportId);

        if ($report) {
            $notifiableUsers = collect();

            // 1. Ke User (Pelapor)
            if ($report->pelapor) {
                $notifiableUsers->put($report->pelapor->id_user, $report->pelapor);
            }

            // 2. Ke Admin (Penanggung Jawab Kategori)
            if ($report->admin) {
                $notifiableUsers->put($report->admin->id_user, $report->admin);
            }

            // 3. Ke Semua Superadmin
            $superadmins = \App\Models\User::where('role', 'superadmin')->get();
            foreach ($superadmins as $superadmin) {
                $notifiableUsers->put($superadmin->id_user, $superadmin);
            }

            // 4. Pastikan pembuat komentar juga dapat
            $notifiableUsers->put($currentUser->id_user, $currentUser);

            // Kirim
            foreach ($notifiableUsers as $userToNotify) {
                $userToNotify->notify(new \App\Notifications\NewCommentNotification($report, $comment, $currentUser));
            }
        }

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function getBadgeCounts($id)
    {
        $report = Report::withCount(['followUps', 'comments'])->findOrFail($id);

        return response()->json([
            'followUps' => $report->follow_ups_count,
            'comments' => $report->comments_count,
            'lampiran' => $report->file ? 1 : 0,
        ]);
    }

    /**
     * Hapus komentar.
     */
    public function deleteComment($id)
    {
        $comment = Comment::with('user')->findOrFail($id);
        $user = Auth::user();

        // Hak akses: Superadmin bisa hapus apa saja, Admin/User hanya milik sendiri
        if ($user->role !== 'superadmin' && $comment->user_id !== $user->id_user) {
            abort(403, 'Anda tidak diizinkan menghapus komentar ini.');
        }

        // 🔹 Hapus file langsung dari public/comment_files jika ada
        if ($comment->file) {
            $filePath = public_path($comment->file);
            if (file_exists($filePath)) {
                @unlink($filePath); // @ supaya tidak error jika gagal
            }
        }

        $comment->delete();

        $this->logActivity(
            'DELETE',
            'Comment',
            $id,
            "Superadmin menghapus komentar pada laporan #" . ($comment->report->tracking_id ?? 'N/A')
        );

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Hapus tindak lanjut (hanya admin atau superadmin yang bisa).
     */
    public function deleteFollowUp($reportId, $followUpId)
    {
        $followUp = FollowUp::with('user')->findOrFail($followUpId);
        $user = Auth::user();

        // Hak akses: Superadmin bisa hapus apa saja, Admin hanya milik sendiri
        if ($user->role !== 'superadmin') {
            if ($user->role === 'admin') {
                if ($followUp->user_id !== $user->id_user) {
                    abort(403, 'Anda tidak diizinkan menghapus tindak lanjut ini.');
                }
            } else {
                abort(403, 'Anda tidak diizinkan menghapus tindak lanjut ini.');
            }
        }

        // Hapus file terkait di public/followup_files
        if ($followUp->file) {
            $filePath = public_path($followUp->file);
            if (file_exists($filePath)) {
                try {
                    unlink($filePath);
                } catch (\Exception $e) {
                    \Log::error("Gagal menghapus file followup: " . $filePath . " - " . $e->getMessage());
                }
            }
        }

        // Hapus record followup
        $followUp->delete();

        $this->logActivity(
            'DELETE',
            'FollowUp',
            $followUpId,
            "Superadmin menghapus tindak lanjut pada laporan #" . ($followUp->report->tracking_id ?? 'N/A')
        );

        // Update status laporan jika tidak ada tindak lanjut lagi
        $report = Report::findOrFail($reportId);
        if ($report->followUps()->count() === 0 && $report->status === Report::STATUS_DIRESPON) {
            $report->status = Report::STATUS_DIBACA;
            $report->save();

            return back()->with('success', 'Tindak lanjut berhasil dihapus, Status Aduan menjadi Dibaca');
        }

        return back()->with('success', 'Tindak lanjut berhasil dihapus');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if (Auth::user()->role !== 'superadmin' && $comment->user_id !== Auth::user()->id_user) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah komentar ini.');
        }

        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $comment->pesan = $request->pesan;

        if ($request->hasFile('file')) {
            if ($comment->file && file_exists(public_path($comment->file))) {
                unlink(public_path($comment->file));
            }
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('comment_files'), $filename);
            $comment->file = 'comment_files/' . $filename;
        }

        $comment->save();

        $this->logActivity(
            'UPDATE',
            'Comment',
            $comment->id,
            "Superadmin memperbarui komentar pada laporan #" . ($comment->report->tracking_id ?? 'N/A'),
            ['pesan' => $request->pesan]
        );

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function updateFollowUp(Request $request, $id)
    {
        $followUp = FollowUp::findOrFail($id);

        if (Auth::user()->role !== 'superadmin' && $followUp->user_id !== Auth::user()->id_user) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah tindak lanjut ini.');
        }

        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $followUp->pesan = $request->pesan;

        if ($request->hasFile('file')) {
            if ($followUp->file && file_exists(public_path($followUp->file))) {
                unlink(public_path($followUp->file));
            }
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('followup_files'), $filename);
            $followUp->file = 'followup_files/' . $filename;
        }

        $followUp->save();

        $this->logActivity(
            'UPDATE',
            'FollowUp',
            $followUp->id,
            "Superadmin memperbarui tindak lanjut pada laporan #" . ($followUp->report->tracking_id ?? 'N/A'),
            ['pesan' => $request->pesan]
        );

        return back()->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    public function lacak(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $report = Report::where('tracking_id', $request->tracking_id)->first();

        if (!$report) {
            return redirect()->back()->with('error', 'Nomor Tiket Aduan tidak ditemukan.');
        }

        // Redirect ke halaman detail
        return redirect()->route('superadmin.reports.show', ['id' => $report->id]);
    }

    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat aduan.');
        }

        $user = auth()->user();

        // Tidak peduli role-nya apa, ambil aduan berdasarkan siapa yang mengajukan (user_id)
        $aduan = Report::where('user_id', $user->id_user)
            ->latest()
            ->get(['id', 'tracking_id', 'judul', 'status', 'created_at', 'is_anonim']);

        return view('superadmin.daftar-aduan.riwayat', compact('aduan'));
    }

    public function riwayatWbs()
    {
        // Misal: pakai model WbsReport, atau kamu bisa sesuaikan sendiri
        $aduan = Report::where('user_id', auth()->id()) // ganti kalau beda tabel
            ->where('kategori_id', 999) // contoh filter WBS
            ->latest()
            ->get(['id', 'tracking_id', 'judul', 'status', 'created_at', "is_anonim"]);

        return view('superadmin.daftar-aduan.riwayat-wbs', compact('aduan'));
    }
}
