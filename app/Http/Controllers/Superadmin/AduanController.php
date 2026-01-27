<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use App\Models\Report;
use App\Models\User;
use App\Models\WilayahUmum;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Traits\HasActivityLog;

class AduanController extends Controller
{
    use HasActivityLog;
    public function index(Request $request)
    {
        $adminId = $request->input('admin_id');
        $kategoriId = $request->input('kategori_id');
        $status = $request->input('status');
        $tahun = $request->input('tahun');
        $wilayahId = $request->input('wilayah_id');
        $search = $request->input('search');

        // ====================================
        // FILTER TANGGAL (AUTO FIX)
        // ====================================
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Jika hanya tanggal mulai → jadikan tanggal selesai sama
        if ($tanggalMulai && !$tanggalSelesai) {
            $tanggalSelesai = $tanggalMulai;
        }

        // Jika hanya tanggal selesai → jadikan tanggal mulai sama
        if ($tanggalSelesai && !$tanggalMulai) {
            $tanggalMulai = $tanggalSelesai;
        }

        // ====================================
        // QUERY DASAR
        // ====================================
        $query = Report::with(['admin', 'kategori', 'wilayah']);

        // FILTER ADMIN
        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        // FILTER KATEGORI
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        // FILTER WILAYAH
        if ($wilayahId) {
            $query->where('wilayah_id', $wilayahId);
        }

        // FILTER STATUS
        if ($status) {
            if ($status === 'Terlambat') {
                // Filter untuk aduan terlambat (lebih dari 3 hari & belum direspon)
                $query->whereNotIn('status', ['Direspon', 'Selesai', 'Arsip'])
                    ->where('created_at', '<=', now()->subDays(3));
            } else {
                $query->where('status', $status);
            }
        }

        // FILTER TAHUN
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // FILTER RANGE TANGGAL
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereDate('created_at', '>=', $tanggalMulai)
                ->whereDate('created_at', '<=', $tanggalSelesai);
        }

        // ====================================
        // FILTER SEARCH
        // ====================================
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')

                    // Admin / OPD
                    ->orWhereHas('admin', function ($qAdmin) use ($search) {
                        $qAdmin->where('name', 'like', '%' . $search . '%');
                    })

                    // Kategori
                    ->orWhereHas('kategori', function ($qKategori) use ($search) {
                        $qKategori->where('nama', 'like', '%' . $search . '%');
                    })

                    // Wilayah
                    ->orWhereHas('wilayah', function ($qWilayah) use ($search) {
                        $qWilayah->where('nama', 'like', '%' . $search . '%');
                    })

                    // User Pelapor
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'like', '%' . $search . '%');
                    })

                    // Status
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        // Total laporan berdasarkan filter aktif
        $totalReports = (clone $query)->count();

        // Pagination
        $reports = $query->latest()->paginate(8)->appends($request->query());

        // Data Dropdown
        $admins = User::where('role', 'admin')->get();
        $kategoris = KategoriUmum::query()
            ->where('tipe', 'non_wbs_admin')
            ->when($adminId, function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->get();

        $wilayahs = WilayahUmum::all();

        // Daftar tahun
        $tahuns = Report::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // ====================================
        // SUMMARY COUNTER (RINGKASAN)
        // ====================================
        $summaryQuery = Report::query();

        if ($tahun) {
            $summaryQuery->whereYear('created_at', $tahun);
        }
        if ($adminId) {
            $summaryQuery->where('admin_id', $adminId);
        }
        if ($kategoriId) {
            $summaryQuery->where('kategori_id', $kategoriId);
        }
        if ($wilayahId) {
            $summaryQuery->where('wilayah_id', $wilayahId);
        }
        if ($tanggalMulai && $tanggalSelesai) {
            $summaryQuery->whereDate('created_at', '>=', $tanggalMulai)
                ->whereDate('created_at', '<=', $tanggalSelesai);
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

        return view('superadmin.aduan.index', compact(
            'reports',
            'admins',
            'kategoris',
            'wilayahs',
            'tahuns',
            'adminId',
            'kategoriId',
            'wilayahId',
            'status',
            'tahun',
            'totalReports',
            'summary',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'nullable|string',
            'komentar_revisi' => 'nullable|string',
            'admin_id' => 'nullable|exists:users,id_user',
            'kategori_id' => 'nullable|exists:kategori_umum,id',
        ]);

        $report = Report::findOrFail($id);
        $oldStatus = $report->status;

        // Update status jika ada
        if (isset($validated['status'])) {
            $report->status = $validated['status'];
        }

        // Update admin_id jika ada (dari Disposisi)
        if (isset($validated['admin_id'])) {
            $report->admin_id = $validated['admin_id'];
        }

        // Update kategori_id jika ada (dari Disposisi)
        if (isset($validated['kategori_id'])) {
            $report->kategori_id = $validated['kategori_id'];
        }

        if (isset($validated['status']) && $validated['status'] === 'Revisi') {
            $report->komentar_revisi = $validated['komentar_revisi'];
        }

        $report->save();
        $newStatus = $report->status;

        // === LOG AKTIVITAS ===
        // Bedakan antara update status dan disposisi
        if (isset($validated['admin_id']) || isset($validated['kategori_id'])) {
            // Jika ada update admin_id atau kategori_id = Disposisi
            $admin = isset($validated['admin_id']) ? \App\Models\User::find($validated['admin_id']) : null;
            $adminName = $admin ? $admin->name : 'tidak diubah';

            $kategori = isset($validated['kategori_id']) ? \App\Models\KategoriUmum::find($validated['kategori_id']) : null;
            $kategoriName = $kategori ? $kategori->nama : 'tidak diubah';

            $this->logActivity(
                'DISPOSISI',
                'Report',
                $report->id,
                "Superadmin mendisposisikan laporan #{$report->tracking_id} ke Admin: {$adminName}, Kategori: {$kategoriName}",
                ['admin_id' => $validated['admin_id'] ?? null, 'kategori_id' => $validated['kategori_id'] ?? null]
            );
        }

        if (isset($validated['status']) && $oldStatus !== $newStatus) {
            // Jika ada update status
            $this->logActivity(
                'UPDATE_STATUS',
                'Report',
                $report->id,
                "Superadmin mengubah status laporan #{$report->tracking_id} dari {$oldStatus} menjadi {$newStatus}",
                ['old_status' => $oldStatus, 'new_status' => $newStatus]
            );
        }

        // 🔔 NOTIFIKASI STATUS BERUBAH
        if ($oldStatus !== $newStatus) {
            // Notifikasi ke User Pelapor
            if ($report->pelapor) {
                $report->pelapor->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }

            // Notifikasi ke Admin terkait
            if ($report->admin) {
                $report->admin->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }

            // Opsional: Notifikasi ke semua Superadmin kecuali pengubah (tapi di sini kita notifikasi semua saja biar konsisten)
            $superadmins = \App\Models\User::where('role', 'superadmin')->get();
            foreach ($superadmins as $superadmin) {
                $superadmin->notify(new \App\Notifications\ReportStatusChanged($report, $oldStatus, $newStatus));
            }
        }

        return redirect()->route('superadmin.kelola-aduan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $trackingId = $report->tracking_id;
        $report->delete();

        // === LOG AKTIVITAS ===
        $this->logActivity(
            'DELETE',
            'Report',
            $id,
            "Superadmin menghapus laporan #{$trackingId}"
        );

        return redirect()->route('superadmin.kelola-aduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
