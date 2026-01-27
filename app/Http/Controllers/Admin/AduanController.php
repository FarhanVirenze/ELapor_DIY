<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasActivityLog;

class AduanController extends Controller
{
    use HasActivityLog;
    public function index(Request $request)
    {
        $admin = Auth::user();

        // Ambil filter dari request
        $kategoriId = $request->input('kategori_id');
        $status = $request->input('status');
        $tahun = $request->input('tahun');
        $wilayahId = $request->input('wilayah_id');
        $search = $request->input('search');

        // Query hanya untuk kategori yang ditangani oleh admin ini
        $query = Report::with(['kategori', 'wilayah', 'user'])
            ->whereHas('kategori', function ($q) use ($admin) {
                $q->where('admin_id', $admin->id_user);
            });

        // Filter kategori
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        // Filter wilayah
        if ($wilayahId) {
            $query->where('wilayah_id', $wilayahId);
        }

        // Filter status
        if ($status) {
            if ($status === 'Terlambat') {
                // Filter untuk aduan terlambat (lebih dari 3 hari & belum direspon)
                $query->whereNotIn('status', ['Direspon', 'Selesai', 'Arsip'])
                    ->where('created_at', '<=', now()->subDays(3));
            } else {
                $query->where('status', $status);
            }
        }

        // Filter tahun
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // --- PENCARIAN ---
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($qKategori) use ($search) {
                        $qKategori->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('wilayah', function ($qWilayah) use ($search) {
                        $qWilayah->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Total laporan (untuk ringkasan)
        $totalReports = (clone $query)->count();

        // Ambil data laporan
        $reports = $query->latest()->paginate(10)->appends($request->query());

        // Daftar kategori milik admin ini
        $kategoris = KategoriUmum::where('admin_id', $admin->id_user)->get();

        // Daftar wilayah
        $wilayahs = WilayahUmum::all();

        // Daftar tahun dari laporan yang ditangani admin
        $tahuns = Report::whereHas('kategori', function ($q) use ($admin) {
            $q->where('admin_id', $admin->id_user);
        })
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // --- RINGKASAN STATUS ---
        $summaryQuery = Report::whereHas('kategori', function ($q) use ($admin) {
            $q->where('admin_id', $admin->id_user);
        });

        if ($tahun) {
            $summaryQuery->whereYear('created_at', $tahun);
        }
        if ($kategoriId) {
            $summaryQuery->where('kategori_id', $kategoriId);
        }
        if ($wilayahId) {
            $summaryQuery->where('wilayah_id', $wilayahId);
        }

        $summary = [
            'diajukan' => (clone $summaryQuery)->where('status', 'Diajukan')->count(),
            'dibaca' => (clone $summaryQuery)->where('status', 'Dibaca')->count(),
            'direspon' => (clone $summaryQuery)->where('status', 'Direspon')->count(),
            'selesai' => (clone $summaryQuery)->where('status', 'Selesai')->count(),
            'revisi' => (clone $summaryQuery)->where('status', 'Revisi')->count(),
            'arsip' => (clone $summaryQuery)->where('status', 'Arsip')->count(),
            'terlambat' => (clone $summaryQuery)
                ->whereNotIn('status', ['Direspon', 'Selesai', 'Arsip'])
                ->where('created_at', '<=', now()->subDays(3))
                ->count(),
        ];

        return view('admin.aduan.index', compact(
            'reports',
            'kategoris',
            'wilayahs',
            'tahuns',
            'kategoriId',
            'status',
            'tahun',
            'wilayahId',
            'totalReports',
            'summary',
            'search'
        ));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        // Validasi: hanya admin yang menangani kategori ini yang boleh update
        $adminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$adminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui laporan ini.');
        }

        $validated = $request->validate([
            'status' => 'nullable|string',
            'komentar_revisi' => 'nullable|string',
            'admin_id' => 'nullable', // Removed exists check for debugging
            'kategori_id' => 'nullable', // Removed exists check for debugging
        ]);

        $oldStatus = $report->status;

        // Update status jika ada
        if ($request->filled('status')) {
            $report->status = $request->input('status');
        }

        // Update admin_id jika ada (dari Disposisi)
        if ($request->filled('admin_id')) {
            $report->admin_id = $request->input('admin_id');
        }

        // Update kategori_id jika ada (dari Disposisi)
        if ($request->filled('kategori_id')) {
            $report->kategori_id = $request->input('kategori_id');
        }

        if ($request->filled('status') && $request->input('status') === 'Revisi') {
            $report->komentar_revisi = $request->input('komentar_revisi');
        }

        $report->save();
        $newStatus = $report->status;

        // === LOG AKTIVITAS ===
        try {
            // Log Disposisi
            if ($request->filled('admin_id') || $request->filled('kategori_id')) {
                $adminName = 'Unknown';
                if ($request->filled('admin_id')) {
                    $u = \App\Models\User::find($request->input('admin_id'));
                    if ($u)
                        $adminName = $u->name;
                }

                $kategoriName = 'Unknown';
                if ($request->filled('kategori_id')) {
                    $k = \App\Models\KategoriUmum::find($request->input('kategori_id'));
                    if ($k)
                        $kategoriName = $k->nama;
                }

                $this->logActivity(
                    'DISPOSISI',
                    'Report',
                    $report->id,
                    "Admin mendisposisikan laporan #{$report->tracking_id} ke Admin: {$adminName}, Kategori: {$kategoriName}",
                    ['admin_id' => $request->admin_id, 'kategori_id' => $request->kategori_id]
                );
            }
            // Log Status Update
            if ($request->filled('status') && $oldStatus !== $newStatus) {
                $this->logActivity(
                    'UPDATE_STATUS',
                    'Report',
                    $report->id,
                    "Admin mengubah status laporan #{$report->tracking_id} dari {$oldStatus} menjadi {$newStatus}",
                    ['old_status' => $oldStatus, 'new_status' => $newStatus]
                );
            }
        } catch (\Exception $e) {
            \Log::error('Activity Log Error: ' . $e->getMessage());
        }

        // 🔔 NOTIFIKASI STATUS BERUBAH
        if ($oldStatus !== $newStatus) {
            // Notifikasi ke User Pelapor
            if ($report->pelapor) {
                $report->pelapor->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }

            // Notifikasi ke Superadmin
            $superadmins = \App\Models\User::where('role', 'superadmin')->get();
            foreach ($superadmins as $superadmin) {
                $superadmin->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }
        }

        return redirect()->route('admin.kelola-aduan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $trackingId = $report->tracking_id;

        $adminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$adminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $report->delete();

        // === LOG AKTIVITAS ===
        $this->logActivity(
            'DELETE',
            'Report',
            $id,
            "Admin menghapus laporan #{$trackingId}"
        );

        return redirect()->route('admin.kelola-aduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
