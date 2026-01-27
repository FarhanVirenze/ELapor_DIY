<?php

namespace App\Http\Controllers\Superadmin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use App\Models\Report;
use App\Models\User;
use App\Models\WilayahUmum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanSuperadminController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->admin_id;
        $kategoriId = $request->kategori_id;
        $wilayahId = $request->wilayah_id;
        $status = $request->status;
        $tahun = $request->tahun;
        $search = $request->search;
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $query = Report::with(['admin', 'kategori', 'wilayah', 'user', 'updatedBy']);

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

        // FILTER RENTANG TANGGAL
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

        $reports = $query->latest()->paginate(8)->appends($request->query());

        $admins = User::where('role', 'admin')->get();
        // Filter kategori berdasarkan admin OPD
        $kategoris = KategoriUmum::query()
            ->where('tipe', 'non_wbs_admin')
            ->when($adminId, function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->get();

        $wilayahs = WilayahUmum::all();

        $tahuns = Report::selectRaw('YEAR(created_at) tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

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

        // FILTER TANGGAL UNTUK SUMMARY
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

        return view('superadmin.laporan.index', compact(
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

    public function exportExcel(Request $request)
    {
        $query = Report::with(['admin', 'kategori', 'wilayah', 'user']);

        // FILTER ADMIN
        if ($request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }

        // FILTER KATEGORI
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // FILTER WILAYAH
        if ($request->wilayah_id) {
            $query->where('wilayah_id', $request->wilayah_id);
        }

        // FILTER STATUS
        if ($request->status) {
            if ($request->status === 'Terlambat') {
                $query->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                    ->where('created_at', '<', now()->subDays(3));
            } else {
                $query->where('status', $request->status);
            }
        }

        // FILTER TAHUN
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        // ===============================
        // ✅ FILTER RENTANG TANGGAL FIX
        // ===============================
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        if ($mulai && $selesai) {
            // Dua tanggal → gunakan rentang
            $query->whereBetween('created_at', [
                $mulai . ' 00:00:00',
                $selesai . ' 23:59:59',
            ]);
        } elseif ($mulai) {
            // Hanya tanggal mulai
            $query->where('created_at', '>=', $mulai . ' 00:00:00');
        } elseif ($selesai) {
            // Hanya tanggal selesai
            $query->where('created_at', '<=', $selesai . ' 23:59:59');
        }

        // FILTER SEARCH
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

        // GET DATA
        $reports = $query->orderBy('created_at', 'desc')->get();

        // EXPORT EXCEL
        return Excel::download(new LaporanExport($reports), 'laporan_aduan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Report::with(['kategori', 'wilayah', 'user', 'admin']);

        // FILTER ADMIN
        if ($request->admin_id) {

            $query->where('admin_id', $request->admin_id);

            // HARUS pakai where('id_user') karena PK user = id_user
            $adminModel = User::where('id_user', $request->admin_id)->first();

            $adminName = $adminModel
                ? $adminModel->name
                : 'Admin tidak ditemukan';

        } else {
            $adminName = 'Semua Admin';
        }

        // ===========================
        // FILTER KATEGORI
        // ===========================
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);

            $kategoriModel = KategoriUmum::find($request->kategori_id);
            $kategoriName = $kategoriModel ? $kategoriModel->nama : 'Kategori tidak ditemukan';
        } else {
            $kategoriName = 'Semua Kategori';
        }

        // ===========================
        // FILTER WILAYAH
        // ===========================
        if ($request->wilayah_id) {
            $query->where('wilayah_id', $request->wilayah_id);

            $wilayahModel = WilayahUmum::find($request->wilayah_id);
            $wilayahName = $wilayahModel ? $wilayahModel->nama : 'Wilayah tidak ditemukan';
        } else {
            $wilayahName = 'Semua Wilayah';
        }

        // ===========================
        // FILTER STATUS
        // ===========================
        if ($request->status) {
            $statusName = ucfirst($request->status);
            if ($request->status === 'Terlambat') {
                $query->whereNotIn('status', [Report::STATUS_DIRESPON, Report::STATUS_SELESAI, Report::STATUS_ARSIP])
                    ->where('created_at', '<', now()->subDays(3));
            } else {
                $query->where('status', $request->status);
            }
        } else {
            $statusName = 'Semua Status';
        }

        // ===========================
        // FILTER TAHUN
        // ===========================
        if ($request->tahun) {
            $tahunName = $request->tahun;
            $query->whereYear('created_at', $request->tahun);
        } else {
            $tahunName = 'Semua Tahun';
        }

        // ===========================
        // FILTER TANGGAL
        // ===========================
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        if ($mulai && $selesai) {
            $tanggalName = date('d-m-Y', strtotime($mulai)) . ' s/d ' . date('d-m-Y', strtotime($selesai));
            $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
        } elseif ($mulai) {
            $tanggalName = 'Mulai ' . date('d-m-Y', strtotime($mulai));
            $query->where('created_at', '>=', $mulai . ' 00:00:00');
        } elseif ($selesai) {
            $tanggalName = 'Sampai ' . date('d-m-Y', strtotime($selesai));
            $query->where('created_at', '<=', $selesai . ' 23:59:59');
        } else {
            $tanggalName = 'Semua Tanggal';
        }

        // ===========================
        // GET DATA
        // ===========================
        $reports = $query->orderBy('created_at', 'desc')->get();

        // ===========================
        // FILTER INFO
        // ===========================
        $filterInfo = [
            'admin' => $adminName,
            'kategori' => $kategoriName,
            'wilayah' => $wilayahName,
            'status' => $statusName,
            'tahun' => $tahunName,
            'tanggal' => $tanggalName,
            'dicetak' => auth()->user()->name,
        ];

        // ===========================
        // GENERATE PDF
        // ===========================
        $pdf = Pdf::loadView('superadmin.laporan.pdf', compact('reports', 'filterInfo'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_aduan.pdf');
    }
}
