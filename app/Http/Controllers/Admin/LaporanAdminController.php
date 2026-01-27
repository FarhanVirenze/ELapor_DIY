<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExportAdmin;
use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use App\Models\Report;
use App\Models\User;
use App\Models\WilayahUmum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAdminController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user(); // admin login

        $adminId = $request->admin_id;
        $kategoriId = $request->kategori_id;
        $wilayahId = $request->wilayah_id;
        $status = $request->status;
        $tahun = $request->tahun;
        $search = $request->search;
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        // ================================
        // QUERY UTAMA — BATASI KE KATEGORI ADMIN
        // ================================
        $query = Report::with(['admin', 'kategori', 'wilayah', 'user', 'updatedBy'])
            ->whereHas('kategori', function ($q) use ($admin) {
                $q->where('admin_id', $admin->id_user);
            });

        // FILTER ADMIN (opsional jika di dropdown)
        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }
        if ($wilayahId) {
            $query->where('wilayah_id', $wilayahId);
        }
        if ($status) {
            if ($status === 'Terlambat') {
                $query->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                    ->where('created_at', '<', now()->subDays(3));
            } else {
                $query->where('status', $status);
            }
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // ==========================
        // FILTER RENTANG TANGGAL
        // ==========================
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('created_at', [
                $tanggalMulai . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59',
            ]);
        } elseif ($tanggalMulai) {
            $query->where('created_at', '>=', $tanggalMulai . ' 00:00:00');
        } elseif ($tanggalSelesai) {
            $query->where('created_at', '<=', $tanggalSelesai . ' 23:59:59');
        }

        // ==========================
        // SEARCH
        // ==========================
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhereHas('admin', fn($a) => $a->where('name', 'like', "%$search%"))
                    ->orWhereHas('kategori', fn($k) => $k->where('nama', 'like', "%$search%"))
                    ->orWhereHas('wilayah', fn($w) => $w->where('nama', 'like', "%$search%"))
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"));
            });
        }

        $totalReports = (clone $query)->count();
        $reports = $query->latest()->paginate(10)->appends($request->query());

        // ================================
        // LIST FILTER SESUAI ADMIN LOGIN
        // ================================
        $admins = User::where('role', 'admin')->get();
        $kategoris = KategoriUmum::where('admin_id', $admin->id_user)->get();
        $wilayahs = WilayahUmum::all();

        $tahuns = Report::whereHas('kategori', function ($q) use ($admin) {
            $q->where('admin_id', $admin->id_user);
        })
            ->selectRaw('YEAR(created_at) tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // ================================
        // SUMMARY (RINGKASAN STATUS)
        // ================================
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

        if ($tanggalMulai && $tanggalSelesai) {
            $summaryQuery->whereBetween('created_at', [
                $tanggalMulai . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59',
            ]);
        }

        $summary = [
            'diajukan' => (clone $summaryQuery)->where('status', 'Diajukan')->count(),
            'dibaca' => (clone $summaryQuery)->where('status', 'Dibaca')->count(),
            'direspon' => (clone $summaryQuery)->where('status', 'Direspon')->count(),
            'selesai' => (clone $summaryQuery)->where('status', 'Selesai')->count(),
            'revisi' => (clone $summaryQuery)->where('status', 'Revisi')->count(),
            'arsip' => (clone $summaryQuery)->where('status', 'Arsip')->count(),
            'terlambat' => (clone $summaryQuery)->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                ->where('created_at', '<', now()->subDays(3))
                ->count(),
        ];

        return view('admin.laporan.index', compact(
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
            'search',
            'tanggalMulai',
            'tanggalSelesai',
            'totalReports',
            'summary'
        ));
    }

    // =====================================================================
    // EXPORT EXCEL – juga wajib dibatasi ke kategori admin
    // =====================================================================
    public function exportExcel(Request $request)
    {
        $admin = Auth::user();

        $query = Report::with(['admin', 'kategori', 'wilayah', 'user'])
            ->whereHas(
                'kategori',
                fn($q) => $q->where('admin_id', $admin->id_user)
            );

        if ($request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->wilayah_id) {
            $query->where('wilayah_id', $request->wilayah_id);
        }
        if ($request->status) {
            if ($request->status === 'Terlambat') {
                $query->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                    ->where('created_at', '<', now()->subDays(3));
            } else {
                $query->where('status', $request->status);
            }
        }
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        if ($mulai && $selesai) {
            $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
        } elseif ($mulai) {
            $query->where('created_at', '>=', $mulai . ' 00:00:00');
        } elseif ($selesai) {
            $query->where('created_at', '<=', $selesai . ' 23:59:59');
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhereHas('admin', fn($a) => $a->where('name', 'like', "%$search%"))
                    ->orWhereHas('kategori', fn($k) => $k->where('nama', 'like', "%$search%"))
                    ->orWhereHas('wilayah', fn($w) => $w->where('nama', 'like', "%$search%"))
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"));
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        return Excel::download(new LaporanExportAdmin($reports), 'laporan_aduan.xlsx');
    }

    // =====================================================================
    // EXPORT PDF – juga wajib dibatasi ke kategori admin
    // =====================================================================
    public function exportPdf(Request $request)
    {
        $admin = Auth::user();

        $query = Report::with(['kategori', 'wilayah', 'user', 'admin'])
            ->whereHas(
                'kategori',
                fn($q) => $q->where('admin_id', $admin->id_user)
            );

        if ($request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->wilayah_id) {
            $query->where('wilayah_id', $request->wilayah_id);
        }
        if ($request->status) {
            if ($request->status === 'Terlambat') {
                $query->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                    ->where('created_at', '<', now()->subDays(3));
            } else {
                $query->where('status', $request->status);
            }
        }
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        if ($mulai && $selesai) {
            $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
        } elseif ($mulai) {
            $query->where('created_at', '>=', $mulai . ' 00:00:00');
        } elseif ($selesai) {
            $query->where('created_at', '<=', $selesai . ' 23:59:59');
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhereHas('admin', fn($a) => $a->where('name', 'like', "%$search%"))
                    ->orWhereHas('kategori', fn($k) => $k->where('nama', 'like', "%$search%"))
                    ->orWhereHas('wilayah', fn($w) => $w->where('nama', 'like', "%$search%"))
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"));
            });
        }

        $filterInfo = [
            'kategori' => $request->kategori_id ? (KategoriUmum::find($request->kategori_id)->nama ?? 'Tidak ditemukan') : 'Semua Kategori',
            'wilayah' => $request->wilayah_id ? (WilayahUmum::find($request->wilayah_id)->nama ?? 'Tidak ditemukan') : 'Semua Wilayah',
            'status' => $request->status ? ucfirst($request->status) : 'Semua Status',
            'tahun' => $request->tahun ?? 'Semua Tahun',
            'tanggal' => ($mulai && $selesai) ? date('d-m-Y', strtotime($mulai)) . ' s/d ' . date('d-m-Y', strtotime($selesai)) :
                ($mulai ? ('Mulai ' . date('d-m-Y', strtotime($mulai))) :
                    ($selesai ? ('Sampai ' . date('d-m-Y', strtotime($selesai))) : 'Semua Tanggal')),
            'dicetak' => $admin->name,
        ];

        $reports = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'reports' => $reports,
            'admin' => $admin,
            'filterInfo' => $filterInfo,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan_aduan.pdf');
    }
}
