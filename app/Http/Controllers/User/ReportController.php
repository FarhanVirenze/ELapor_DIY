<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FollowUp;
use App\Models\FollowupRating;
use App\Models\KategoriUmum;
use App\Models\Report;
use App\Models\Vote;
use App\Models\WbsComment;
use App\Models\WbsReport;
use App\Services\TextCensorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Menampilkan semua laporan milik user (atau semua jika tidak login).
     */
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $kategoriIds = $user->kategori->pluck('id')->toArray();

                $reports = Report::whereIn('kategori_id', $kategoriIds)
                    ->with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            } elseif ($user->role === 'superadmin') {
                $reports = Report::with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            } else {
                $reports = Report::where('user_id', $user->id_user)
                    ->with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            }
        } else {
            $reports = Report::with('pelapor')
                ->latest()
                ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
        }

        // 🔹 Tambahkan statistik di sini
        $totalAduan = Report::count();

        $aduanBulanIni = Report::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $aduanSelesai = Report::where('status', Report::STATUS_SELESAI)->count();

        return view('portal.welcome', compact('reports', 'totalAduan', 'aduanBulanIni', 'aduanSelesai'));
    }

    /**
     * Tampilkan form pembuatan laporan.
     */
    public function create()
    {
        return view('user.aduan.create');
    }

    public function store(Request $request, TextCensorService $censor)
    {
        // ✅ Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|min:10|max:150',
            'isi' => 'required|string|min:20|max:1000',
            'kategori_id' => 'required|exists:kategori_umum,id',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'file' => 'nullable|array|max:3',
            'file.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_anonim' => 'nullable|boolean',
            'is_arsip' => 'nullable|boolean',
            'g-recaptcha-response' => 'required',
        ]);

        // ✅ Verifikasi reCAPTCHA
        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('captcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($verify->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
            ])->withInput();
        }

        // ✅ Upload file ke folder public/report_files
        $filePaths = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $uploadedFile) {
                $fileName = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('report_files'), $fileName);
                $filePaths[] = 'report_files/' . $fileName;
            }
        }
        $validated['file'] = $filePaths;

        // ✅ Set nilai tambahan
        $validated['is_anonim'] = $request->boolean('is_anonim');
        $validated['is_arsip'] = $request->boolean('is_arsip');
        $validated['status'] = $validated['is_arsip'] ? 'Arsip' : Report::STATUS_DIAJUKAN;

        // ✅ Pastikan user login
        $user = auth()->user();
        if (!$user) {
            return back()->with('error', 'Pengguna tidak terautentikasi.');
        }

        $validated['user_id'] = $user->id_user;

        // ✅ Data pelapor
        if ($validated['is_anonim']) {
            $validated += [
                'nama_pengadu' => 'Anonim',
                'email_pengadu' => 'anonim@domain.com',
                'telepon_pengadu' => null,
                'nik' => null,
            ];
        } else {
            $validated += [
                'nama_pengadu' => $user->name,
                'email_pengadu' => $user->email,
                'telepon_pengadu' => $user->nomor_telepon ?? null,
                'nik' => $user->nik ?? null,
            ];
        }

        // ✅ Tentukan admin berdasarkan kategori
        $kategori = KategoriUmum::find($validated['kategori_id']);
        if (!$kategori || !$kategori->admin_id) {
            return back()->with('error', 'Kategori belum memiliki admin yang ditugaskan.')->withInput();
        }
        $validated['admin_id'] = $kategori->admin_id;

        // 🧠 Moderasi & Analisis AI
        try {
            $textToCheck = "Judul: {$validated['judul']}\nIsi: {$validated['isi']}";

            // =========================
            // 1️⃣ Moderasi kasar
            // =========================
            $moderation = $censor->hasForbiddenWords($textToCheck);

            Log::info('AI Moderation Check Started', [
                'user_id' => $user->id_user,
                'judul' => $validated['judul']
            ]);

            if ($moderation['forbidden']) {

                Log::warning('Report blocked by AI moderation', [
                    'user_id' => $user->id_user,
                    'judul' => $validated['judul'],
                    'reason' => $moderation['reason'],
                    'mode' => 'moderation_block'
                ]);

                return back()
                    ->withErrors(['isi' => 'Laporan ditolak oleh Sistem Moderasi AI.'])
                    ->with('ai_reason', $moderation['reason'])
                    ->with('ai_decision', 'Ditolak')
                    ->withInput();
            }

            // =========================
            // 2️⃣ Analisis AI
            // =========================
            $analysis = $censor->analyzeReport($textToCheck);

            Log::info('AI Analysis Completed', [
                'user_id' => $user->id_user,
                'judul' => $validated['judul'],
                'analysis_mode' => $analysis['analysis_mode'] ?? 'unknown',
                'analysis_reason' => $analysis['analysis_reason'] ?? null,
                'priority' => $analysis['priority'],
                'sentiment' => $analysis['sentiment'],
                'suggested_category_id' => $analysis['suggested_category_id']
            ]);

            // =========================
            // 3️⃣ Simpan hasil ke validated
            // =========================
            $validated['priority'] = $analysis['priority'];
            $validated['sentiment'] = $analysis['sentiment'];
            $validated['ai_analysis'] = $analysis['ai_summary'];
            $validated['suggested_kategori_id'] = $analysis['suggested_category_id'];

            // Tambahan metadata analysis
            $validated['analysis_mode'] = $analysis['analysis_mode'] ?? null;
            $validated['analysis_reason'] = $analysis['analysis_reason'] ?? null;

            // =========================
            // 4️⃣ Sensor manual fallback
            // =========================
            $validated['judul'] = $censor->censor($validated['judul']);
            $validated['isi'] = $censor->censor($validated['isi']);

        } catch (\Throwable $e) {

            Log::error('AI moderation/analysis failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id_user,
                'judul' => $validated['judul'] ?? null,
                'mode' => 'controller_fallback'
            ]);

            // =========================
            // 5️⃣ Safe fallback
            // =========================
            $validated['priority'] = 'Low';
            $validated['sentiment'] = 'Neutral';
            $validated['ai_analysis'] = 'AI gagal menganalisis laporan.';
            $validated['suggested_kategori_id'] = null;
            $validated['analysis_mode'] = 'fallback';
            $validated['analysis_reason'] = $e->getMessage();
        }

        // ✅ Simpan laporan ke database
        try {
            $report = Report::create($validated);

            // 🔔 NOTIFIKASI KE USER
            $user->notify(new \App\Notifications\ReportSubmittedSuccessfully($report));

            // 🔔 NOTIFIKASI KE ADMIN KATEGORI
            if ($report->admin) {
                $report->admin->notify(new \App\Notifications\NewReportSubmitted($report));
            }

            // 🔔 NOTIFIKASI KE SUPERADMIN
            $superadmins = \App\Models\User::where('role', 'superadmin')->get();
            foreach ($superadmins as $superadmin) {
                $superadmin->notify(new \App\Notifications\NewReportSubmitted($report));
            }

            return redirect()->route('user.aduan.riwayat')
                ->with('success', 'Laporan berhasil dikirim dan telah diperiksa oleh Sistem Moderasi AI.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id, TextCensorService $censor)
    {
        // Ambil laporan
        $report = Report::findOrFail($id);

        // Pastikan user pemilik laporan
        if ($report->user_id !== auth()->user()->id_user) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah laporan ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|min:10|max:150',
            'isi' => 'required|string|min:20|max:1000',
            'kategori_id' => 'required|exists:kategori_umum,id',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'file' => 'nullable|array|max:3',
            'file.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'is_anonim' => 'nullable|boolean',
            'is_arsip' => 'nullable|boolean',
            'g-recaptcha-response' => 'required',
        ]);

        // reCAPTCHA
        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('captcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($verify->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
            ])->withInput();
        }

        // Upload file baru bila ada
        $filePaths = $report->file ?? [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $uploadedFile) {
                $fileName = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('report_files'), $fileName);
                $filePaths[] = 'report_files/' . $fileName;
            }
        }

        $validated['file'] = $filePaths;

        // Tambahan data
        $validated['is_anonim'] = $request->boolean('is_anonim');
        $validated['is_arsip'] = $request->boolean('is_arsip');
        $validated['status'] = $validated['is_arsip'] ? 'Arsip' : Report::STATUS_DIAJUKAN;

        // Data pelapor
        $user = auth()->user();

        if ($validated['is_anonim']) {
            $validated += [
                'nama_pengadu' => 'Anonim',
                'email_pengadu' => 'anonim@domain.com',
                'telepon_pengadu' => null,
                'nik' => null,
            ];
        } else {
            $validated += [
                'nama_pengadu' => $user->name,
                'email_pengadu' => $user->email,
                'telepon_pengadu' => $user->nomor_telepon ?? null,
                'nik' => $user->nik ?? null,
            ];
        }

        // Tentukan admin berdasarkan kategori
        $kategori = KategoriUmum::find($validated['kategori_id']);
        if (!$kategori || !$kategori->admin_id) {
            return back()->with('error', 'Kategori belum memiliki admin yang ditugaskan.')->withInput();
        }

        $validated['admin_id'] = $kategori->admin_id;

        // 🧠 Moderasi & Analisis AI (gabungkan judul + isi)
        try {
            $textToCheck = "Judul: {$validated['judul']}\nIsi: {$validated['isi']}";

            // =========================
            // 1️⃣ Moderasi kasar
            // =========================
            Log::info('AI Moderation Check Started (update)', [
                'user_id' => $user->id_user,
                'id_report' => $report->id_report ?? null,
                'judul' => $validated['judul']
            ]);

            $moderation = $censor->hasForbiddenWords($textToCheck);

            if ($moderation['forbidden']) {

                Log::warning('Report update blocked by AI moderation', [
                    'user_id' => $user->id_user,
                    'id_report' => $report->id_report ?? null,
                    'judul' => $validated['judul'],
                    'reason' => $moderation['reason'],
                    'mode' => 'moderation_block'
                ]);

                return back()
                    ->withErrors(['isi' => 'Laporan ditolak oleh Sistem Moderasi AI.'])
                    ->with('ai_reason', $moderation['reason'])
                    ->with('ai_decision', 'Ditolak')
                    ->withInput();
            }

            // =========================
            // 2️⃣ Analisis AI
            // =========================
            $analysis = $censor->analyzeReport($textToCheck);

            Log::info('AI Analysis Completed (update)', [
                'user_id' => $user->id_user,
                'id_report' => $report->id_report ?? null,
                'analysis_mode' => $analysis['analysis_mode'] ?? 'unknown',
                'analysis_reason' => $analysis['analysis_reason'] ?? null,
                'priority' => $analysis['priority'],
                'sentiment' => $analysis['sentiment'],
                'suggested_category_id' => $analysis['suggested_category_id']
            ]);

            // =========================
            // 3️⃣ Simpan hasil AI ke validated
            // =========================
            $validated['priority'] = $analysis['priority'];
            $validated['sentiment'] = $analysis['sentiment'];
            $validated['ai_analysis'] = $analysis['ai_summary'];
            $validated['suggested_kategori_id'] = $analysis['suggested_category_id'];

            // Metadata tambahan AI
            $validated['analysis_mode'] = $analysis['analysis_mode'] ?? null;
            $validated['analysis_reason'] = $analysis['analysis_reason'] ?? null;

            // =========================
            // 4️⃣ Sensor manual fallback
            // =========================
            $validated['judul'] = $censor->censor($validated['judul']);
            $validated['isi'] = $censor->censor($validated['isi']);

        } catch (\Throwable $e) {

            Log::error('AI moderation/analysis failed (update)', [
                'error' => $e->getMessage(),
                'user_id' => $user->id_user,
                'id_report' => $report->id_report ?? null,
                'mode' => 'controller_fallback_update'
            ]);

            // =========================
            // 5️⃣ Safe fallback (SAMAKAN DENGAN STORE)
            // =========================
            $validated['priority'] = 'Low';
            $validated['sentiment'] = 'Neutral';
            $validated['ai_analysis'] = 'AI gagal menganalisis laporan.';
            $validated['suggested_kategori_id'] = null;
            $validated['analysis_mode'] = 'fallback';
            $validated['analysis_reason'] = $e->getMessage();
        }

        // Simpan ke database
        try {
            $report->update($validated);

            return redirect()->route('user.aduan.riwayat')
                ->with('success', 'Laporan berhasil diperbarui dan diperiksa oleh sistem.');

        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail laporan lengkap dengan komentar & follow up.
     */
    public function show($id)
    {
        $report = Report::with([
            'kategori.admin',
            'wilayah',
            'user',
            'followUps.user',
            'followUps.ratings.user', // ⬅️ tambahin relasi rating+user
            'comments.user',
            'admin',
            'updatedBy',
            // ⬇️ tambahin ini supaya tiap followUp ada avg & count
            'followUps' => function ($q) {
                $q->withAvg('ratings', 'rating')
                    ->withCount('ratings');
            },
        ])->findOrFail($id);

        // 🔹 Validasi: Admin hanya bisa melihat laporan sesuai kategori
        if (auth()->check() && auth()->user()->role === 'admin') {
            if ($report->admin_id !== auth()->user()->id_user) {
                return response()->view('errors.akses-ditolak', [], 403);
            }
        }

        // 🔹 Tambah jumlah view
        $sessionKey = 'report_viewed_' . $id;
        if (!session()->has($sessionKey)) {
            $report->increment('views');
            session()->put($sessionKey, true);
        }

        // 🔹 Update status jika admin membuka aduan yang belum dibaca
        if (auth()->check() && auth()->user()->role === 'admin' && $report->status === Report::STATUS_DIAJUKAN) {
            $report->status = Report::STATUS_DIBACA;
            $report->save();
            session()->flash('success', 'Status laporan diperbarui menjadi Dibaca');
        }

        $followUps = $report->followUps->filter(function ($item) {
            return $item->user && in_array($item->user->role, ['admin', 'superadmin']);
        });

        $comments = $report->comments;

        // 🔹 --- HITUNG RATING ---
        $ratings = FollowupRating::whereIn('followup_id', $report->followUps->pluck('id'))->get();

        $totalReviews = $ratings->count();
        $averageRating = $totalReviews > 0 ? round($ratings->avg('rating'), 1) : 0;

        $ratingBreakdown = $ratings->groupBy('rating')->map->count();
        $ratingStats = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingStats[$i] = $ratingBreakdown->get($i, 0);
        }

        // 🔹 --- BUAT TIMELINE ---
        $timeline = [];

        // Aduan dibuat
        $timeline[] = [
            'time' => $report->created_at,
            'type' => 'created',
            'title' => 'Aduan dengan Nomor ' . $report->tracking_id . ' dibuat oleh '
                . ($report->is_anonim ? 'Anonim' : $report->nama_pengadu)
                // Jika arsip, langsung tambahkan keterangan Arsip
                . ($report->is_arsip ? ' (Status: Arsip)' : ''),
        ];

        // Disposisikan ke admin kategori (jika ada)
        if ($report->kategori && $report->kategori->admin) {
            $timeline[] = [
                'time' => $report->created_at,
                'type' => 'assigned',
                'title' => 'Aduan didisposisikan otomatis oleh sistem ke Admin ' . optional($report->kategori->admin)->name,
            ];
        }

        // Disposisi diubah (hanya jika sudah ada admin_id sebelumnya dan kemudian diganti)
        if ($report->wasChanged('admin_id') && $report->getOriginal('admin_id') !== null) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'reassigned',
                'title' => 'Aduan didisposisikan ulang ke Admin ' . (optional($report->admin)->name ?? '-')
                    . ' oleh ' . (optional($report->updatedBy)->name ?? 'System'),
            ];
        }

        // Waktu admin pertama bertindak
        $firstAdminActionTime = optional(
            $report->followUps
                ->filter(fn($fu) => in_array($fu->user->role ?? '', ['admin', 'superadmin']))
                ->sortBy('created_at')
                ->first()
        )->created_at;

        // Dibaca admin
        if ($report->status !== Report::STATUS_DIAJUKAN) {
            $timeline[] = [
                'time' => $firstAdminActionTime ?? $report->updated_at,
                'type' => 'read',
                'title' => 'Admin ' . (optional($report->admin)->name ?? '-') . ' telah membaca aduan',
            ];
        }

        // Status Revisi
        if ($report->status === Report::STATUS_REVISI) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'revision',
                'title' => 'Status aduan diubah menjadi Revisi oleh ' . (optional($report->admin)->name ?? 'Admin'),
            ];
        }

        // Status Arsip
        if ($report->status === Report::STATUS_ARSIP) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'archived',
                'title' => 'Aduan telah diarsipkan oleh ' . (optional($report->admin)->name ?? 'Admin'),
            ];
        }

        // Follow up
        foreach ($followUps as $fu) {
            $timeline[] = [
                'time' => $fu->created_at,
                'type' => 'followup',
                'title' => 'Tindak Lanjut oleh ' . (optional($fu->user)->name ?? 'Admin'),
            ];
        }

        // Komentar
        foreach ($comments as $c) {
            $timeline[] = [
                'time' => $c->created_at,
                'type' => 'comment',
                'title' => 'Komentar dari ' . (optional($c->user)->name ?? 'Anonim'),
            ];
        }

        // Status selesai
        if ($report->status === Report::STATUS_SELESAI) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'done',
                'title' => 'Aduan telah dinyatakan Selesai oleh ' . (optional($report->admin)->name ?? 'Admin'),
            ];
        }

        // Urutkan dari terbaru
        $timeline = collect($timeline)->sortByDesc('time')->values()->all();

        return view('portal.daftar-aduan.detail.index', compact(
            'report',
            'followUps',
            'comments',
            'timeline',
            'averageRating',
            'totalReviews',
            'ratingStats',
            'ratings'
        ));
    }

    public function trackByTrackingId(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $trackingId = $request->tracking_id;

        $aduan = WbsReport::where('tracking_id', $trackingId)->first();

        if (!$aduan) {
            return redirect()
                ->route('wbs.index', ['tab' => 'riwayat'])
                ->with('error', 'Kode unik tidak ditemukan.')
                ->withInput();
        }

        // Redirect ke halaman detail WBS sesuai id
        return redirect()->route('user.aduan.riwayatwbs.show', ['id' => $aduan->id]);
    }

    public function showWbs($id)
    {
        $aduan = WbsReport::with(['kategori', 'wilayah'])->findOrFail($id);

        return view('portal.daftar-aduan.detail.riwayatwbs', compact('aduan'));
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
            // batalin like
            $vote->delete();
            $report->decrement('likes');
        } elseif ($vote && $vote->vote_type === 'dislike') {
            // ubah dislike jadi like
            $vote->update(['vote_type' => 'like']);
            $report->increment('likes');
            if ($report->dislikes > 0) {
                $report->decrement('dislikes');
            }
        } else {
            // baru pertama kali like
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'like',
            ]);
            $report->increment('likes');
        }

        return back();
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
            // batalin dislike
            $vote->delete();
            if ($report->dislikes > 0) {
                $report->decrement('dislikes');
            }
        } elseif ($vote && $vote->vote_type === 'like') {
            // ubah like jadi dislike
            $vote->update(['vote_type' => 'dislike']);
            if ($report->likes > 0) {
                $report->decrement('likes');
            }
            $report->increment('dislikes');
        } else {
            // baru pertama kali dislike
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'dislike',
            ]);
            $report->increment('dislikes');
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
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Hanya admin atau superadmin yang dapat memberikan tindak lanjut.');
        }

        $followUp = new FollowUp([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('followup_files'); // folder public/followup_files
            $file->move($destinationPath, $filename);

            // simpan path relatif untuk akses via asset()
            $followUp->file = 'followup_files/' . $filename;
        }

        $followUp->save();

        // Update status laporan menjadi 'Direspon' hanya jika status sebelumnya 'Dibaca' atau 'Diajukan'
        $report = Report::findOrFail($reportId);

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

        // 4. Pastikan si pembuat aksi juga dapat (log konfirmasi)
        $notifiableUsers->put($currentUser->id_user, $currentUser);

        // Kirim Notifikasi
        foreach ($notifiableUsers as $userToNotify) {
            $userToNotify->notify(new \App\Notifications\NewFollowUpNotification($report, $followUp, $currentUser));
        }

        return back()->with('success', 'Tindak lanjut berhasil dikirim' .
            ($report->status === Report::STATUS_DIRESPON ? ', Status Aduan menjadi Direspon' : ''));
    }

    public function storeFollowupRating(Request $request, $followupId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberi rating.');
        }

        // Cek kalau user sudah pernah kasih rating → update
        $rating = FollowupRating::updateOrCreate(
            [
                'followup_id' => $followupId,
                'user_id' => $user->id_user,
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]
        );

        return back()->with('success', 'Rating berhasil dikirim.');
    }

    public function updateFollowupRating(Request $request, $followupId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengubah rating.');
        }

        $rating = FollowupRating::where('followup_id', $followupId)
            ->where('user_id', $user->id_user)
            ->first();

        if (!$rating) {
            return back()->with('error', 'Rating tidak ditemukan.');
        }

        $rating->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Rating berhasil diperbarui.');
    }

    public function deleteFollowupRating($followupId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menghapus rating.');
        }

        $rating = FollowupRating::where('followup_id', $followupId)
            ->where('user_id', $user->id_user)
            ->first();

        if (!$rating) {
            return back()->with('error', 'Rating tidak ditemukan.');
        }

        $rating->delete();

        return back()->with('success', 'Rating berhasil dihapus.');
    }

    public function storeWbsComment(Request $request, $wbsId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $comment = new WbsComment([
            'report_id' => $wbsId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan langsung ke public/wbs_comment_files
            $file->move(public_path('wbs_comment_files'), $filename);

            $comment->file = 'wbs_comment_files/' . $filename;
        }

        $comment->save();

        return back()->with('success', 'Komentar WBS berhasil dikirim.');
    }

    public function updateWbsComment(Request $request, WbsComment $comment)
    {
        if ($comment->user_id !== Auth::user()->id_user && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah komentar ini.');
        }

        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $comment->pesan = $request->pesan;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan langsung ke public/wbs_comment_files
            $file->move(public_path('wbs_comment_files'), $filename);

            $comment->file = 'wbs_comment_files/' . $filename;
        }

        $comment->save();

        return back()->with('success', 'Komentar berhasil diperbarui.');
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

        if (!in_array(Auth::user()->role, ['user', 'admin', 'superadmin'])) {
            abort(403, 'Hanya user, admin, dan superadmin yang dapat mengirim komentar.');
        }

        $comment = new Comment([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan langsung ke public/comment_files
            $file->move(public_path('comment_files'), $filename);

            // simpan path relatif biar bisa dipanggil dengan asset()
            $comment->file = 'comment_files/' . $filename;
        }

        $comment->save();

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

            // 4. Pastikan pembuat komentar juga dapat (log konfirmasi)
            $notifiableUsers->put($currentUser->id_user, $currentUser);

            // Kirim Notifikasi
            foreach ($notifiableUsers as $userToNotify) {
                $userToNotify->notify(new \App\Notifications\NewCommentNotification($report, $comment, $currentUser));
            }
        }

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        // Validasi hak akses: hanya pemilik komentar atau admin/superadmin
        if ($comment->user_id !== Auth::user()->id_user && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah komentar ini.');
        }

        // Validasi input
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        // Update pesan
        $comment->pesan = $request->pesan;

        // Jika ada file baru, hapus lama lalu upload baru
        if ($request->hasFile('file')) {
            // hapus file lama kalau ada
            if ($comment->file && file_exists(public_path($comment->file))) {
                unlink(public_path($comment->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan ke public/comment_files
            $file->move(public_path('comment_files'), $filename);

            $comment->file = 'comment_files/' . $filename;
        }

        $comment->save();

        return back()->with('success', 'Komentar berhasil diperbarui.');
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

    public function deleteWbsComment($id)
    {
        $comment = WbsComment::findOrFail($id);

        // Cek apakah user adalah pemilik komentar, admin, atau superadmin
        if (Auth::user()->id_user !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak diizinkan menghapus komentar WBS ini.');
        }

        // Hapus file jika ada
        if ($comment->file) {
            $filePath = public_path($comment->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $comment->delete();

        return back()->with('success', 'Komentar WBS berhasil dihapus.');
    }

    /**
     * Hapus komentar.
     */
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Cek apakah user adalah pemilik komentar, admin, atau superadmin
        if (Auth::user()->id_user !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak diizinkan menghapus komentar ini.');
        }

        // Hapus file jika ada
        if ($comment->file) {
            $filePath = public_path($comment->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Hapus tindak lanjut (hanya admin yang bisa).
     */
    public function deleteFollowUp($reportId, $followUpId)
    {
        $followUp = FollowUp::findOrFail($followUpId);

        // Cek apakah user adalah admin atau superadmin
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak diizinkan menghapus tindak lanjut ini.');
        }

        $userRole = Auth::user()->role;

        // Hapus file jika ada
        if ($followUp->file) {
            $filePath = public_path($followUp->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus tindak lanjut
        $followUp->delete();

        // Ambil ulang report dan cek tindak lanjut tersisa
        $report = Report::findOrFail($reportId);
        $hasFollowUps = $report->followUps()->exists();

        // Jika tidak ada tindak lanjut lagi dan statusnya DIRESPON, atur ulang status sesuai role
        if (!$hasFollowUps && $report->status === Report::STATUS_DIRESPON) {
            $statusSelesai = Report::STATUS_SELESAI; // contoh constant

            if ($report->status !== $statusSelesai) {
                $report->status = Report::STATUS_DIBACA;
                $report->save();

                $pesanStatus = 'Status Aduan menjadi Dibaca';

                return back()->with('success', 'Tindak lanjut berhasil dihapus, ' . $pesanStatus);
            }
        }

        return back()->with('success', 'Tindak lanjut berhasil dihapus');
    }

    public function updateFollowUp(Request $request, $id)
    {
        $followUp = FollowUp::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'superadmin' && $followUp->user_id !== Auth::user()->id_user) {
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
        return redirect()->route('reports.show', ['id' => $report->id]);
    }

    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat aduan.');
        }

        $user = auth()->user();

        $aduan = Report::where('user_id', $user->id_user)
            ->latest()
            ->paginate(6, ['id', 'tracking_id', 'judul', 'isi', 'status', 'created_at', 'file', 'is_anonim', 'priority', 'sentiment']);

        return view('portal.daftar-aduan.riwayat', compact('aduan'));
    }

    public function riwayatWbs()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat WBS.');
        }

        $user = auth()->user();

        // Ambil semua aduan user, termasuk yang anonim
        $aduan = WbsReport::where('user_id', $user->id_user)
            ->latest()
            ->paginate(6);

        return view('portal.daftar-aduan.riwayatwbs', compact('aduan'));
    }
}
