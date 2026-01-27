<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil admin yang sedang login
        $adminId = auth()->user()->id_user;
        $adminName = auth()->user()->name;

        // === Hitung status laporan (khusus admin login) ===
        $pendingCount = Report::where('admin_id', $adminId)->where('status', 'Diajukan')->count();
        $readCount = Report::where('admin_id', $adminId)->where('status', 'Dibaca')->count();
        $respondedCount = Report::where('admin_id', $adminId)->where('status', 'Direspon')->count();
        $completedCount = Report::where('admin_id', $adminId)->where('status', 'Selesai')->count();
        $revisiCount = Report::where('admin_id', $adminId)->where('status', 'Revisi')->count();
        $arsipCount = Report::where('admin_id', $adminId)->where('status', 'Arsip')->count();
        $totalReports = Report::where('admin_id', $adminId)->count();

        // === Anonim vs Terdaftar ===
        $anonimCount = Report::where('admin_id', $adminId)->where('is_anonim', true)->count();
        $registeredCount = Report::where('admin_id', $adminId)->where('is_anonim', false)->count();

        // === Distribusi wilayah ===
        $wilayahData = Report::where('admin_id', $adminId)
            ->selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->with('wilayah')
            ->get();

        $wilayahLabels = $wilayahData->pluck('wilayah.nama');
        $wilayahCounts = $wilayahData->pluck('total');

        // === Statistik kategori aduan ===
        $kategoriSemua = Report::where('admin_id', $adminId)
            ->selectRaw('kategori_id, COUNT(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->kategori->nama ?? 'Tidak diketahui',
                    'jumlah' => $item->total,
                ];
            });

        $kategoriTop10 = $kategoriSemua->take(10);

        $kategoriUmumData = [
            'top10' => [
                'labels' => $kategoriTop10->pluck('nama'),
                'counts' => $kategoriTop10->pluck('jumlah'),
            ],
            'all' => [
                'labels' => $kategoriSemua->pluck('nama'),
                'counts' => $kategoriSemua->pluck('jumlah'),
            ],
        ];

        // === Kategori berdasarkan admin (dalam hal ini admin login sendiri) ===
        $kategoriPerAdmin = Report::where('admin_id', $adminId)
            ->selectRaw('kategori_id, COUNT(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        $kategoriAdminData = $kategoriPerAdmin->map(function ($item) {
            return [
                'kategori' => $item->kategori->nama ?? 'Tidak diketahui',
                'jumlah' => $item->total,
            ];
        });

        // === Grafik Aktivitas Laporan (7, 30, 60, 90, 180, 365, 730 hari terakhir) ===
        $ranges = ['7', '30', '60', '90', '180', '365', '730'];
        $aktivitasSemuaRange = [];

        foreach ($ranges as $range) {
            $start = Carbon::now()->subDays((int) $range);

            $data = Report::where('admin_id', $adminId)
                ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
                ->where('created_at', '>=', $start)
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $aktivitasSemuaRange[$range] = [
                'tanggal' => $data->pluck('tanggal'),
                'jumlah' => $data->pluck('jumlah'),
            ];
        }

        // === Aktivitas Hari Ini (Per Jam) ===
        $todayData = Report::where('admin_id', $adminId)
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('HOUR(created_at) as jam, COUNT(*) as jumlah')
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();

        $aktivitasHariIni = [
            'jam' => $todayData->pluck('jam')->map(fn($h) => sprintf('%02d:00', $h)),
            'jumlah' => $todayData->pluck('jumlah'),
        ];

        // === Priority Statistics (with Smart Fallback) ===
        // Ambil ID dan konten text untuk analisis
        $reportsForStats = Report::where('admin_id', $adminId)
            ->select(['id', 'judul', 'isi', 'priority'])
            ->get();

        $prioLow = 0;
        $prioMedium = 0;
        $prioHigh = 0;
        $prioEmergency = 0;

        foreach ($reportsForStats as $r) {
            $p = $r->effective_priority; // Pakai accessor
            if ($p === 'Emergency')
                $prioEmergency++;
            elseif ($p === 'High')
                $prioHigh++;
            elseif ($p === 'Medium')
                $prioMedium++;
            else
                $prioLow++;
        }

        $priorityStats = [
            'Low' => $prioLow,
            'Medium' => $prioMedium,
            'High' => $prioHigh,
            'Emergency' => $prioEmergency
        ];

        // === AI Executive Summary ===
        $latestReports = Report::where('admin_id', $adminId)->latest()->take(20)->pluck('judul')->toArray();
        $trendingTopics = implode(", ", $latestReports);

        // === Geospatial Data (Heatmap) ===
        $heatmapData = Report::where('admin_id', $adminId)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(['latitude', 'longitude', 'priority', 'judul', 'isi'])
            ->get()
            ->each(function ($item) {
                $item->append('effective_priority');
            });

        return view('admin.dashboard', compact(
            'pendingCount',
            'readCount',
            'respondedCount',
            'completedCount',
            'revisiCount',
            'arsipCount',
            'totalReports',
            'anonimCount',
            'registeredCount',
            'wilayahLabels',
            'wilayahCounts',
            'kategoriUmumData',
            'kategoriAdminData',
            'aktivitasSemuaRange',
            'aktivitasHariIni',
            'adminName',
            'priorityStats',
            'trendingTopics',
            'heatmapData'
        ));
    }
}
