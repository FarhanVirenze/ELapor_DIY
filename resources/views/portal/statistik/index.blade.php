@extends('portal.layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 pt-20">
        
        {{-- Hero Section & Filter --}}
        <section class="bg-white shadow border-b border-gray-200 sticky top-20 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Title & Active Filter --}}
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-chart-line text-red-600"></i> Statistik Data
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Filter: <span class="font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded">{{ $filterLabel }}</span>
                            @if($statusFilter !== 'all')
                                • Status: <span class="font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $statusFilter }}</span>
                            @endif
                        </p>
                    </div>

                    {{-- Filter Form --}}
                    <form id="filterForm" action="{{ route('statistik') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <input type="hidden" name="period" id="periodInput" value="{{ $period ?? 'all' }}">
                        
                        {{-- Status Filter --}}
                        <select name="status" onchange="document.getElementById('filterForm').submit()" 
                                class="text-xs font-medium border-gray-200 rounded-lg focus:ring-red-500 focus:border-red-500 py-1.5 bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                            <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Diajukan" {{ $statusFilter == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Dibaca" {{ $statusFilter == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                            <option value="Direspon" {{ $statusFilter == 'Direspon' ? 'selected' : '' }}>Direspon</option>
                            <option value="Selesai" {{ $statusFilter == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Revisi" {{ $statusFilter == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                            <option value="Arsip" {{ $statusFilter == 'Arsip' ? 'selected' : '' }}>Arsip</option>
                        </select>

                        {{-- Period Buttons --}}
                        <div class="flex bg-gray-100 p-1 rounded-lg">
                            @foreach(['today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini', 'all' => 'Semua'] as $key => $label)
                                <button type="button" onclick="setPeriod('{{ $key }}')" 
                                    class="px-3 py-1.5 text-xs font-medium rounded-md transition-all {{ $period == $key ? 'bg-white text-red-600 shadow-sm font-bold' : 'text-gray-600 hover:bg-gray-200' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                        
                        {{-- Custom Date Trigger --}}
                        <div x-data="{ open: {{ $period == 'custom' ? 'true' : 'false' }} }" class="relative">
                            <button @click="open = !open" type="button"
                                class="px-3 py-1.5 text-xs font-medium rounded-lg border transition-all flex items-center gap-2
                                {{ $period == 'custom' ? 'bg-red-50 border-red-200 text-red-700 font-bold' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            
                            {{-- Dropdown Date Picker --}}
                            <div x-show="open" @click.outside="open = false" x-cloak
                                class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-4 z-50 animate-fade-in-down">
                                <h3 class="text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">Pilih Rentang Tanggal</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-[10px] text-gray-500 uppercase font-semibold">Dari Tanggal</label>
                                        <input type="date" name="date_start" value="{{ $startDate }}" 
                                            class="w-full text-sm border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-gray-500 uppercase font-semibold">Sampai Tanggal</label>
                                        <input type="date" name="date_end" value="{{ $endDate }}" 
                                            class="w-full text-sm border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <button type="button" onclick="setPeriod('custom')" 
                                        class="w-full bg-red-600 text-white text-sm font-bold py-2 rounded-lg hover:bg-red-700 transition">
                                        Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        {{-- Dashboard Content --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            {{-- Summary Cards (6 Cards Layout) --}}
            {{-- Summary Cards (7 Cards Layout) --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-10">
                {{-- Total --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                                <i class="fas fa-file-invoice text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total</p>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800">{{ number_format($totalReports) }}</h3>
                    </div>
                </div>

                {{-- Diajukan --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Diajukan</p>
                        </div>
                        <h3 class="text-2xl font-black text-red-600">{{ number_format($pendingCount) }}</h3>
                    </div>
                </div>

                {{-- Dibaca --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fas fa-eye text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dibaca</p>
                        </div>
                        <h3 class="text-2xl font-black text-blue-600">{{ number_format($readCount) }}</h3>
                    </div>
                </div>

                {{-- Direspon --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600">
                                <i class="fas fa-reply-all text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Direspon</p>
                        </div>
                        <h3 class="text-2xl font-black text-yellow-600">{{ number_format($respondedCount) }}</h3>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                                <i class="fas fa-check-double text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Selesai</p>
                        </div>
                        <h3 class="text-2xl font-black text-green-600">{{ number_format($completedCount) }}</h3>
                    </div>
                </div>

                {{-- Revisi --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                                <i class="fas fa-edit text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Revisi</p>
                        </div>
                        <h3 class="text-2xl font-black text-orange-600">{{ number_format($revisiCount) }}</h3>
                    </div>
                </div>

                {{-- Arsip --}}
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                <i class="fas fa-archive text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Arsip</p>
                        </div>
                        <h3 class="text-2xl font-black text-purple-600">{{ number_format($arsipCount) }}</h3>
                    </div>
                </div>
            </div>

            {{-- 🗺️ SEBARAN GEOSPATIAL (MAP) --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-map-marked-alt text-red-600"></i> Sebaran Laporan
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Visualisasi persebaran aduan di wilayah DIY</p>
                    </div>

                    {{-- Map Type Toggle --}}
                    <div class="flex bg-gray-100 p-1 rounded-xl w-full md:w-auto">
                        <button type="button" onclick="setMapMode('heatmap')" id="btn-heatmap"
                            class="flex-1 md:flex-none px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2 bg-white text-red-600 shadow-sm">
                            <i class="fas fa-fire"></i> Heatmap Urgensi
                        </button>
                        <button type="button" onclick="setMapMode('markers')" id="btn-markers"
                            class="flex-1 md:flex-none px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2 text-gray-600 hover:bg-gray-200">
                            <i class="fas fa-map-marker-alt"></i> Titik Status
                        </button>
                    </div>
                </div>

                {{-- Map Legend --}}
                <div id="map-legend" class="mb-4 flex flex-wrap gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    {{-- Legend Heatmap (Default) --}}
                    <div id="legend-heatmap" class="flex flex-wrap gap-4 text-[10px] font-black uppercase tracking-widest">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background-color: #ef4444; animation: pulse 1s infinite;"></span> Emergency</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background-color: #f97316;"></span> High</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background-color: #eab308;"></span> Medium</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full" style="background-color: #22c55e;"></span> Low</span>
                    </div>
                    {{-- Legend Markers (Hidden by default) --}}
                    <div id="legend-markers" class="hidden flex flex-wrap gap-3 text-[10px] font-black uppercase tracking-widest">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#ef4444]"></span> Diajukan</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#3b82f6]"></span> Dibaca</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#eab308]"></span> Direspon</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#22c55e]"></span> Selesai</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#f97316]"></span> Revisi</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#a855f7]"></span> Arsip</span>
                    </div>
                </div>

                <div id="map-container" class="h-[500px] w-full rounded-2xl border border-gray-100 z-10"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {{-- Left Column: Charts --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Activity Chart --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-chart-area text-red-500"></i> Trend Aktivitas
                            </h3>
                        </div>
                        <div class="h-72">
                            <canvas id="aktivitasChart"></canvas>
                        </div>
                    </div>

                    {{-- Top Categories --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-th-list text-blue-500"></i> Kategori Terpopuler
                        </h3>
                        <div class="h-72">
                            <canvas id="kategoriChart"></canvas>
                        </div>
                    </div>

                    {{-- Recent Reports --}}
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-clock text-green-500"></i> Laporan Terbaru
                            </h3>
                            <a href="{{ route('daftar-aduan') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3">Judul Laporan</th>
                                        <th class="px-6 py-3">Kategori</th>
                                        <th class="px-6 py-3">Urgensi</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3 text-right">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentReports as $report)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('reports.show', $report->id) }}" class="font-medium text-gray-800 hover:text-red-600 line-clamp-1 max-w-xs">
                                                {{ $report->judul }}
                                            </a>
                                            <span class="text-xs text-gray-500 block mt-0.5">{{ $report->wilayah->nama ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $report->kategori->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- Urgensi --}}
                                            @php
                                                $priority = $report->effective_priority ?? $report->priority;
                                                
                                                if (!$priority) {
                                                    $text = strtolower($report->judul . ' ' . $report->isi);
                                                    if (Str::contains($text, ['kebakaran', 'api besar', 'meledak', 'kecelakaan', 'darah', 'luka', 'pembunuhan', 'begal', 'senjata', 'banjir bandang', 'gempa', 'darurat', 'tolong'])) {
                                                        $priority = 'Emergency';
                                                    } elseif (Str::contains($text, ['jalan putus', 'jembatan', 'pohon tumbang', 'tiang', 'kabel', 'tersengat', 'banjir', 'tanggul', 'gas bocor', 'rawan', 'ancaman'])) {
                                                        $priority = 'High';
                                                    } elseif (Str::contains($text, ['sampah', 'bau', 'macet', 'antrean', 'parkir', 'trotoar', 'lampu', 'gelap', 'jalan berlubang', 'air mati', 'keruh', 'pelayanan', 'lambat', 'pungli', 'berisik'])) {
                                                        $priority = 'Medium';
                                                    } else {
                                                        $priority = 'Low';
                                                    }
                                                }

                                                $prioColor = match($priority) {
                                                    'Emergency' => 'bg-red-600 text-white animate-pulse',
                                                    'High' => 'bg-orange-500 text-white',
                                                    'Medium' => 'bg-yellow-500 text-white',
                                                    'Low' => 'bg-green-500 text-white',
                                                    default => 'bg-green-500 text-white'
                                                };
                                            @endphp
                                            <div class="flex flex-col items-start gap-1">
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $prioColor }}">
                                                    {{ $priority }}
                                                </span>

                                                {{-- Sentimen --}}
                                                @php
                                                    $sentiment = $report->sentiment;
                                                    if (!$sentiment) {
                                                        $text = strtolower($report->judul . ' ' . $report->isi);
                                                        if (Str::contains($text, ['terima kasih', 'bagus', 'mantap', 'memuaskan', 'hebat', 'apresiasi'])) {
                                                            $sentiment = 'Positive';
                                                        } elseif (Str::contains($text, [
                                                            'kebakaran', 'api', 'meledak', 'kecelakaan', 'darah', 'luka', 'pembunuhan', 'begal', 'senjata', 'banjir', 'gempa', 'darurat', 
                                                            'jancok','goblok','kecewa', 'parah', 'buruk', 'lambat', 'susah', 'tolong', 'mohon', 'rusak', 'bantu', 'bau', 'anjing', 'bodoh', 'gimana sih',
                                                            'macet', 'antrean', 'sampah', 'jalan berlubang', 'keruh', 'pungli'
                                                        ])) {
                                                            $sentiment = 'Negative';
                                                        } else {
                                                            $sentiment = 'Neutral';
                                                        }
                                                    }

                                                    $sentColor = match($sentiment) {
                                                        'Negative' => 'text-red-500',
                                                        'Positive' => 'text-green-600',
                                                        'Neutral' => 'text-gray-500',
                                                        default => 'text-gray-500'
                                                    };
                                                    $sentIcon = match($sentiment) {
                                                        'Negative' => 'fa-frown',
                                                        'Positive' => 'fa-smile',
                                                        'Neutral' => 'fa-meh',
                                                        default => 'fa-meh'
                                                    };
                                                @endphp
                                                <span class="text-[9px] font-bold flex items-center {{ $sentColor }}">
                                                    <i class="fas {{ $sentIcon }} mr-1"></i> {{ $sentiment }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                {{ match($report->status) {
                                                    'Selesai' => 'bg-green-100 text-green-700',
                                                    'Direspon' => 'bg-yellow-100 text-yellow-700',
                                                    'Dibaca' => 'bg-blue-100 text-blue-700',
                                                    'Diajukan' => 'bg-red-100 text-red-700',
                                                    'Revisi' => 'bg-orange-100 text-orange-700',
                                                    'Arsip' => 'bg-purple-100 text-purple-700',
                                                    default => 'bg-gray-100 text-gray-700'
                                                } }}">
                                                {{ $report->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-500 text-xs">
                                            {{ $report->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Side Stats --}}
                <div class="space-y-6">
                    
                    {{-- Status Donut --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Komposisi Status</h3>
                        <div class="relative h-56">
                            <canvas id="statusChart"></canvas>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2 text-xs text-gray-600">
                            @foreach($statusData as $status => $count)
                            <div class="flex justify-between items-center bg-gray-50 px-2 py-1 rounded">
                                <span>{{ $status }}</span>
                                <span class="font-bold">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Priority Chart --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                         <h3 class="text-lg font-bold text-gray-800 mb-4">Tingkat Urgensi</h3>
                         <div class="relative h-48">
                            <canvas id="priorityChart"></canvas>
                         </div>
                    </div>

                    {{-- Leaderboard OPD --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-medal text-yellow-500"></i> Top Instansi Selesai
                        </h3>
                        <div class="space-y-4">
                            @forelse($adminTop5 as $index => $admin)
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 flex items-center justify-center rounded bg-gray-100 text-xs font-bold text-gray-600">{{ $index + 1 }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $admin['nama'] }}</p>
                                    <div class="h-1 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width: {{ min(($admin['jumlah'] / max($adminTop5->max('jumlah') ?: 1, 1)) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-green-600">{{ $admin['jumlah'] }}</span>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 text-center">Belum ada data</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Wilayah --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Sebaran Wilayah</h3>
                         <div class="relative h-48">
                            <canvas id="wilayahChart"></canvas>
                         </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .animate-fade-in-down { animation: fadeInDown 0.3s ease-out; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        [x-cloak] { display: none !important; }
    </style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function setPeriod(period) {
        document.getElementById('periodInput').value = period;
        if (period !== 'custom') document.getElementById('filterForm').submit();
    }

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10 }, boxWidth: 8 } } }
    };

    // 1. Aktivitas Chart
    new Chart(document.getElementById('aktivitasChart'), {
        type: 'line',
        data: {
            labels: @json($aktivitasChart['label']),
            datasets: [{
                label: 'Aduan Masuk',
                data: @json($aktivitasChart['data']),
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            ...commonOptions,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(@json($statusData)),
            datasets: [{
                data: Object.values(@json($statusData)),
                backgroundColor: ['#ef4444', '#3b82f6', '#eab308', '#22c55e', '#f97316', '#a855f7'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: { ...commonOptions, cutout: '65%' }
    });

    // 3. Priority + Wilayah + Kategori Charts setup similar to before...
    // Priority Chart
    new Chart(document.getElementById('priorityChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(@json($priorityData)),
            datasets: [{
                data: Object.values(@json($priorityData)),
                backgroundColor: ['#22c55e', '#eab308', '#ef4444', '#991b1b'],
                borderWidth: 0
            }]
        },
        options: { ...commonOptions, cutout: '65%' }
    });

    // Wilayah Chart
    new Chart(document.getElementById('wilayahChart'), {
        type: 'pie',
        data: {
            labels: @json($wilayahLabels),
            datasets: [{
                data: @json($wilayahCounts),
                backgroundColor: ['#ef4444', '#3b82f6', '#22c55e', '#eab308', '#a855f7', '#6b7280'],
                borderWidth: 0
            }]
        },
        options: commonOptions
    });

    // Kategori Chart
    new Chart(document.getElementById('kategoriChart'), {
        type: 'bar',
        data: {
            labels: @json($kategoriUmumData['top10']['labels']),
            datasets: [{
                label: 'Jumlah',
                data: @json($kategoriUmumData['top10']['counts']),
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                barThickness: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { grid: { display: false } } }
        }
    });

    // === MAP LOGIC ===
    const reportsData = @json($heatmapData);
    let map, heatmapLayer, markerLayer, urgencyMarkerLayer;
    let currentMapMode = 'heatmap';

    function initMap() {
        if (typeof L === 'undefined') {
            console.error('Leaflet not loaded');
            return;
        }

        // Fokus ke DIY
        map = L.map('map-container', {
            scrollWheelZoom: true
        }).setView([-7.8014, 110.3731], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Prepare Data
        const heatPoints = [];
        const statusMarkers = [];
        const urgencyMarkers = [];

        const statusColors = {
            'Diajukan': '#ef4444',
            'Dibaca': '#3b82f6',
            'Direspon': '#eab308',
            'Selesai': '#22c55e',
            'Revisi': '#f97316',
            'Arsip': '#a855f7'
        };

        const priorityColors = {
            'Emergency': '#ef4444', // Red
            'High': '#f97316',      // Orange (was Blue)
            'Medium': '#eab308',    // Yellow (was Green)
            'Low': '#22c55e'        // Green (was Yellow)
        };

        const priorityIntensities = {
            'Emergency': 1.0,
            'High': 0.7,
            'Medium': 0.4,
            'Low': 0.2
        };

        reportsData.forEach(function(report) {
            if (report.latitude && report.longitude) {
                const lat = parseFloat(report.latitude);
                const lng = parseFloat(report.longitude);
                if (isNaN(lat) || isNaN(lng)) return;

                const priority = report.effective_priority || report.priority || 'Low';
                const status = report.status || 'Diajukan';

                // Heatmap point
                const intensity = priorityIntensities[priority] || 0.2;
                heatPoints.push([lat, lng, intensity]);

                // Helper to create pin HTML
                const createPinHtml = (color, animate = false) => `
                    <div style="position: relative; width: 30px; height: 42px; transform: scale(0.85);">
                        <svg viewBox="0 0 24 36" style="width: 30px; height: 42px; filter: drop-shadow(0 3px 4px rgba(0,0,0,0.3));">
                            <path d="M12 0C5.4 0 0 5.4 0 12c0 9 12 24 12 24s12-15 12-24C24 5.4 18.6 0 12 0z" fill="${color}"/>
                            <circle cx="12" cy="12" r="6" fill="white"/>
                            <circle cx="12" cy="12" r="3" fill="${color}"/>
                        </svg>
                        ${animate ? `<div style="position:absolute; top:0; left:0; width:100%; height:100%; border-radius:50%; animation: pulse 1.5s infinite; background: ${color}40; z-index:-1;"></div>` : ''}
                    </div>
                `;

                // === URGENCY MARKER ===
                const uColor = priorityColors[priority] || '#22c55e';
                const urgencyIcon = L.divIcon({
                    html: createPinHtml(uColor, priority === 'Emergency'),
                    className: '',
                    iconSize: [24, 34],
                    iconAnchor: [12, 34],
                    popupAnchor: [0, -34]
                });

                urgencyMarkers.push(L.marker([lat, lng], { icon: urgencyIcon, zIndexOffset: 500 })
                    .bindPopup(`<b>${report.judul}</b><br>Urgensi: <span style="color:${uColor};font-weight:bold">${priority}</span>`));

                // === STATUS MARKER ===
                const sColor = statusColors[status] || '#9ca3af';
                const statusIcon = L.divIcon({
                    html: createPinHtml(sColor, false),
                    className: '',
                    iconSize: [24, 34],
                    iconAnchor: [12, 34],
                    popupAnchor: [0, -34]
                });

                statusMarkers.push(L.marker([lat, lng], { icon: statusIcon, zIndexOffset: 500 })
                    .bindPopup(`<b>${report.judul}</b><br>Status: <span style="background:${sColor}20;color:${sColor};padding:2px 6px;border-radius:4px;font-weight:bold">${status}</span>`));
            }
        });

        // Initialize Layers
        if (typeof L.heatLayer !== 'undefined') {
            heatmapLayer = L.heatLayer(heatPoints, {
                radius: 25,
                blur: 15,
                maxZoom: 17,
                gradient: { 0.4: 'blue', 0.65: 'lime', 1: 'red' }
            });
        }

        markerLayer = L.layerGroup(statusMarkers);
        urgencyMarkerLayer = L.layerGroup(urgencyMarkers);

        // Set Initial Mode (Heatmap with urgency markers)
        if (currentMapMode === 'heatmap') {
            if (heatmapLayer) heatmapLayer.addTo(map);
            urgencyMarkerLayer.addTo(map);
        } else {
            markerLayer.addTo(map);
        }
    }

    function setMapMode(mode) {
        if (!map) return;
        
        currentMapMode = mode;
        
        // Update Buttons
        const btnHeatmap = document.getElementById('btn-heatmap');
        const btnMarkers = document.getElementById('btn-markers');
        const legendHeatmap = document.getElementById('legend-heatmap');
        const legendMarkers = document.getElementById('legend-markers');

        if (mode === 'heatmap') {
            btnHeatmap.classList.add('bg-white', 'text-red-600', 'shadow-sm');
            btnHeatmap.classList.remove('text-gray-600', 'hover:bg-gray-200');
            btnMarkers.classList.remove('bg-white', 'text-red-600', 'shadow-sm');
            btnMarkers.classList.add('text-gray-600', 'hover:bg-gray-200');
            
            legendHeatmap.classList.remove('hidden');
            legendMarkers.classList.add('hidden');

            if (markerLayer) map.removeLayer(markerLayer);
            if (heatmapLayer) heatmapLayer.addTo(map);
            if (urgencyMarkerLayer) urgencyMarkerLayer.addTo(map);
        } else {
            btnMarkers.classList.add('bg-white', 'text-red-600', 'shadow-sm');
            btnMarkers.classList.remove('text-gray-600', 'hover:bg-gray-200');
            btnHeatmap.classList.remove('bg-white', 'text-red-600', 'shadow-sm');
            btnHeatmap.classList.add('text-gray-600', 'hover:bg-gray-200');

            legendMarkers.classList.remove('hidden');
            legendHeatmap.classList.add('hidden');

            if (heatmapLayer) map.removeLayer(heatmapLayer);
            if (urgencyMarkerLayer) map.removeLayer(urgencyMarkerLayer);
            if (markerLayer) markerLayer.addTo(map);
        }
    }

    // Initialize map after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initMap, 300);
    });
</script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

<style>
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(211, 47, 47, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(211, 47, 47, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(211, 47, 47, 0); }
    }
</style>
@endpush
