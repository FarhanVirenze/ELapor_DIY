<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatistikController extends Controller
{
    /**
     * Public Statistics Dashboard
     * Adapted from DashboardSuperadminController - showing public-safe data only
     */
    public function index(Request $request)
    {
        // === FILTERING LOGIC ===
        $period = $request->input('period', 'all'); // today, week, month, year, all, custom
        $startDate = $request->input('date_start');
        $endDate = $request->input('date_end');
        $statusFilter = $request->input('status', 'all'); // Filter by status

        // Base Query untuk filter tanggal
        $query = Report::query();
        $filterLabel = 'Semua Waktu';

        // Apply Status Filter to Base Query if specific status selected
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($period == 'today') {
            $query->whereDate('created_at', Carbon::today());
            $filterLabel = 'Hari Ini (' . Carbon::today()->translatedFormat('d M Y') . ')';
        } elseif ($period == 'week') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            $filterLabel = 'Minggu Ini';
        } elseif ($period == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
            $filterLabel = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
        } elseif ($period == 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
            $filterLabel = 'Tahun Ini (' . Carbon::now()->year . ')';
        } elseif ($period == 'custom' && $startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            $filterLabel = Carbon::parse($startDate)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($endDate)->translatedFormat('d M Y');
        }

        // Clone query untuk berbagai penghitungan agar tidak saling tumpuk
        $qTotal = clone $query;
        $qPending = clone $query;
        $qRead = clone $query;
        $qResponded = clone $query;
        $qCompleted = clone $query;
        $qRevisi = clone $query;
        $qWilayah = clone $query;
        $qKategori = clone $query;
        $qAdmin = clone $query;
        $qPriority = clone $query;
        $qArsip = clone $query;
        $qMap = clone $query;

        // === COUNTS ===
        $totalReports = $qTotal->count();
        $pendingCount = $qPending->where('status', 'Diajukan')->count();
        $readCount = $qRead->where('status', 'Dibaca')->count();
        $respondedCount = $qResponded->where('status', 'Direspon')->count();
        $completedCount = $qCompleted->where('status', 'Selesai')->count();
        $revisiCount = $qRevisi->where('status', 'Revisi')->count();
        $arsipCount = $qArsip->where('status', 'Arsip')->count();

        // Completion Rate
        $completionRate = $totalReports > 0 ? round(($completedCount / $totalReports) * 100, 1) : 0;

        // === DISTRIBUSI WILAYAH ===
        $wilayahData = $qWilayah->selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->with('wilayah')
            ->get();
        $wilayahLabels = $wilayahData->pluck('wilayah.nama')->map(fn($n) => $n ?? 'Tidak Diketahui');
        $wilayahCounts = $wilayahData->pluck('total');

        // === STATISTIK KATEGORI ADUAN ===
        $kategoriSemua = $qKategori->selectRaw('kategori_id, COUNT(*) as total')
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
        ];

        // === GRAFIK AKTIVITAS LAPORAN ===
        $qAktivitas = clone $query;

        if ($period == 'today') {
            // Group by hour for today filter
            $aktivitasData = $qAktivitas->selectRaw('HOUR(created_at) as jam, COUNT(*) as jumlah')
                ->groupBy('jam')
                ->orderBy('jam')
                ->get();

            // Fill missing hours
            $hourlyData = [];
            for ($i = 0; $i < 24; $i++) {
                $hourlyData[$i] = 0;
            }

            foreach ($aktivitasData as $data) {
                $hourlyData[$data->jam] = $data->jumlah;
            }

            $aktivitasChart = [
                'label' => collect(array_keys($hourlyData))->map(fn($h) => sprintf('%02d:00', $h)),
                'data' => collect(array_values($hourlyData))
            ];
        } else {
            // Default group by date
            $selectDate = 'DATE(created_at) as tanggal';
            $aktivitasData = $qAktivitas->selectRaw("$selectDate, COUNT(*) as jumlah")
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $aktivitasChart = [
                'label' => $aktivitasData->map(function ($item) {
                    return Carbon::parse($item->tanggal)->translatedFormat('d M');
                }),
                'data' => $aktivitasData->pluck('jumlah')
            ];
        }

        // === TOP OPD/ADMIN (Leaderboard) ===
        $adminSemua = $qAdmin->where('status', 'Selesai')
            ->whereNotNull('admin_id')
            ->selectRaw('admin_id, COUNT(*) as jumlah')
            ->groupBy('admin_id')
            ->orderByDesc('jumlah')
            ->get()
            ->map(function ($item) {
                $admin = User::find($item->admin_id);
                return [
                    'nama' => $admin ? $admin->name : 'Tidak diketahui',
                    'jumlah' => $item->jumlah,
                ];
            });

        $adminTop5 = $adminSemua->take(5);

        // === STATUS CHART DATA ===
        $statusData = [
            'Diajukan' => $pendingCount,
            'Dibaca' => $readCount,
            'Direspon' => $respondedCount,
            'Selesai' => $completedCount,
            'Revisi' => $revisiCount,
            'Arsip' => $arsipCount,
        ];

        // === PRIORITY DATA (with Smart Fallback) ===
        $reportsForPrio = (clone $qPriority)->select(['id', 'judul', 'isi', 'priority'])->get();

        $prioLow = 0;
        $prioMedium = 0;
        $prioHigh = 0;
        $prioEmergency = 0;

        foreach ($reportsForPrio as $r) {
            $p = $r->effective_priority;
            if ($p === 'Emergency')
                $prioEmergency++;
            elseif ($p === 'High')
                $prioHigh++;
            elseif ($p === 'Medium')
                $prioMedium++;
            else
                $prioLow++;
        }

        $priorityData = [
            'Low' => $prioLow,
            'Medium' => $prioMedium,
            'High' => $prioHigh,
            'Emergency' => $prioEmergency
        ];

        // === RECENT REPORTS ===
        // Always respect filter
        $recentReports = clone $query;
        $recentReports = $recentReports->where('is_anonim', false)
            ->whereNotIn('status', ['Arsip'])
            ->with(['kategori', 'wilayah'])
            ->latest()
            ->take(5)
            ->get();

        // === TODAY STATS (Global) ===
        $todayReports = Report::whereDate('created_at', Carbon::today())->count();

        $heatmapData = $qMap->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(['latitude', 'longitude', 'priority', 'status', 'judul', 'isi'])
            ->get()
            ->each(function ($item) {
                $item->append('effective_priority');
            });

        // === VARIABLES FOR VIEW ===
        return view('portal.statistik.index', compact(
            'pendingCount',
            'readCount',
            'respondedCount',
            'completedCount',
            'revisiCount',
            'arsipCount',
            'totalReports',
            'completionRate',
            'wilayahLabels',
            'wilayahCounts',
            'kategoriUmumData',
            'aktivitasChart',
            'adminTop5',
            'statusData',
            'priorityData',
            'recentReports',
            'todayReports',
            'filterLabel',
            'heatmapData',
            'period',
            'startDate',
            'endDate',
            'statusFilter'
        ));
    }
}
