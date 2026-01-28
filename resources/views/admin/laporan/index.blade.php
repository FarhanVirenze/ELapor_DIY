@extends('admin.layouts.app')

@section('title', 'Laporan Aduan')

@section('content')
    <div class="container mt-4">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="mb-6 text-2xl font-semibold text-[#37474F]">
                Laporan Aduan
            </h2>

            <div class="flex gap-3 mb-4">
                <a href="{{ route('admin.laporan.export.excel', [
                    'kategori_id' => request('kategori_id'),
                    'wilayah_id' => request('wilayah_id'),
                    'status' => request('status'),
                    'tahun' => request('tahun'),
                    'search' => request('search'),
                    'tanggal_mulai' => request('tanggal_mulai'),
                    'tanggal_selesai' => request('tanggal_selesai'),
                ]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white rounded-xl font-semibold shadow hover:bg-green-700 transition transform hover:scale-[1.03]">
                    <i class="fas fa-file-excel text-lg"></i> Export Excel
                </a>

                <a href="{{ route('admin.laporan.export.pdf', [
                    'kategori_id' => request('kategori_id'),
                    'wilayah_id' => request('wilayah_id'),
                    'status' => request('status'),
                    'tahun' => request('tahun'),
                    'search' => request('search'),
                    'tanggal_mulai' => request('tanggal_mulai'),
                    'tanggal_selesai' => request('tanggal_selesai'),
                ]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white rounded-xl font-semibold shadow hover:bg-red-700 transition transform hover:scale-[1.03]">
                    <i class="fas fa-file-pdf text-lg"></i> Export PDF
                </a>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="mb-6 bg-white p-4 md:p-5 rounded-2xl shadow-lg border border-gray-200 animate-fade-in">
            <form method="GET" action="{{ route('admin.laporan.index') }}"
                class="flex flex-wrap gap-4 md:gap-6 items-end justify-start">

                <span class="text-base md:text-lg font-semibold text-gray-800 w-full md:w-auto">
                    Filter Data:
                </span>

                {{-- Filter Tahun --}}
                <div class="flex-1 min-w-[130px] md:min-w-[160px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun:</label>
                    <select name="tahun" onchange="this.form.submit()"
                        class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($tahuns as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                {{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kategori --}}
                <div class="flex-1 min-w-[180px] md:min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori:</label>
                    <select name="kategori_id" onchange="this.form.submit()"
                        class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Wilayah + Tombol Reset --}}
                <div class="flex-1 min-w-[180px] md:min-w-[200px] flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Wilayah:</label>
                        <select name="wilayah_id" onchange="this.form.submit()"
                            class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="">-- Semua Wilayah --</option>
                            @foreach ($wilayahs as $wilayah)
                                <option value="{{ $wilayah->id }}"
                                    {{ request('wilayah_id') == $wilayah->id ? 'selected' : '' }}>
                                    {{ $wilayah->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Reset Filter Button (sebelah kanan Wilayah) --}}
                    @if (request()->filled('tahun') ||
                            request()->filled('kategori_id') ||
                            request()->filled('wilayah_id') ||
                            request()->filled('search') ||
                            request()->filled('status') ||
                            request()->filled('tanggal_mulai') ||
                            request()->filled('tanggal_selesai'))
                        <a href="{{ route('admin.laporan.index') }}"
                            class="px-4 py-2 text-sm bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg shadow-md 
               hover:from-gray-700 hover:to-gray-800 transition flex items-center gap-2">

                            <i class="fas fa-undo"></i>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                </div>

                {{-- Filter Rentang Tanggal --}}
                <div class="flex flex-col md:flex-row gap-4 w-full">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                            class="w-full border border-gray-300 px-3 py-2 rounded-lg text-sm shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>

                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai:</label>
                        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                            class="w-full border border-gray-300 px-3 py-2 rounded-lg text-sm shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>

                    <button type="submit"
                        class="px-4 py-2 mt-6 md:mt-[30px] text-sm bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        {{-- Main Table Container --}}
        <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6 space-y-6">

            <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                {{-- LEFT: Search --}}
                <div class="w-full md:w-1/3">
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="relative">
                        {{-- Keep filter except search + page --}}
                        @foreach (request()->except(['search', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <input type="text" name="search" placeholder="Cari Judul, Pelapor, Kategori, Wilayah..."
                            value="{{ request('search') }}"
                            class="w-full border border-gray-300 px-4 py-2 text-sm rounded-lg shadow-inner focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150">

                        <button type="submit"
                            class="absolute right-0 top-0 mt-2.5 mr-3 text-gray-400 hover:text-red-600 transition duration-150">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                {{-- CENTER: Status Tabs --}}
                <nav class="flex items-center space-x-2 p-1.5 bg-gray-100/80 backdrop-blur-sm rounded-xl shadow-inner flex-1 w-full md:w-auto overflow-x-auto scrollbar-thin scrollbar-thumb-red-400 scrollbar-track-gray-100">

                    @php
                        $statuses = [
                            'Diajukan' => 'Belum Dicek',
                            'Dibaca' => 'Disetujui',
                            'Revisi' => 'Revisi',
                            'Direspon' => 'Direspon',
                            'Selesai' => 'Selesai',
                            'Arsip' => 'Arsip',
                            'Terlambat' => 'Terlambat',
                        ];

                        $currentStatus = request('status', '');
                    @endphp

                    @foreach (['' => 'Semua'] + $statuses as $value => $label)
                        @php
                            $isActive = ($value == $currentStatus && $value != '') || (empty($value) && empty(request('status')));

                            $url = route(
                                'admin.laporan.index',
                                array_merge(request()->except('status', 'page'), ['status' => $value]),
                            );
                        @endphp

                        <a href="{{ $url }}"
                            class="px-3 py-1.5 text-[11px] md:text-sm font-bold rounded-lg whitespace-nowrap transition-all duration-300 ease-out flex-shrink-0
                    {{ $isActive
                        ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg scale-[1.05]'
                        : 'bg-white text-gray-600 hover:bg-red-50 hover:text-red-600 hover:shadow-sm' }}">
                            {{ $label }}
                        </a>
                    @endforeach

                </nav>

                {{-- Right: Total Aduan Card --}}
                <div
                    class="flex items-center gap-4 bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white rounded-xl px-4 py-2 shadow-lg w-full md:w-auto justify-center md:justify-end transition-transform duration-300 hover:scale-[1.02] hover:shadow-xl">

                    {{-- Icon Section --}}
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white shadow-inner">
                        <i class="fas fa-file text-2xl text-red-600"></i>
                    </div>

                    {{-- Text Section --}}
                    <div class="text-left">
                        <p class="text-sm opacity-90 font-extrabold leading-tight tracking-wide">
                            Total Aduan
                        </p>
                        <h4 class="text-xl font-extrabold tracking-wide drop-shadow-sm">
                            {{ $totalReports ?? 0 }}
                        </h4>
                    </div>
                </div>

            </div>

            {{-- MAIN TABLE SECTION --}}
            @if ($reports->isEmpty())

                <div class="text-center py-10 rounded-lg bg-red-50 text-red-600 border border-red-200">
                    <i class="fas fa-info-circle text-xl mb-2"></i>
                    <p class="font-semibold text-lg">Tidak ada data aduan yang tersedia.</p>
                    <p class="text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                </div>
            @else
                {{-- WRAPPER --}}
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">

                    <table class="min-w-full table-auto text-sm text-gray-800">
                        <thead class="bg-red-700 text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="p-3 text-center font-bold rounded-tl-lg w-10"></th>
                                <th class="p-3 text-left font-bold">No</th>
                                <th class="p-3 text-left font-bold">Tracking ID</th>
                                <th class="p-3 text-left font-bold w-[25%]">Judul</th>
                                <th class="p-3 text-left font-bold hidden lg:table-cell">Pelapor</th>
                                <th class="p-3 text-left font-bold hidden md:table-cell">Kategori</th>
                                <th class="p-3 text-left font-bold hidden xl:table-cell">Wilayah</th>
                                <th class="p-3 text-center font-bold">Status</th>
                                <th class="p-3 text-center font-bold">Urgensi</th>
                                <th class="p-3 text-center font-bold rounded-tr-lg">SLA</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @foreach ($reports as $report)
                                {{-- ========== ROW UTAMA ========== --}}
                                <tr class="hover:bg-red-50 transition-all duration-200">

                                    {{-- Toggle Button --}}
                                    <td class="p-3 text-center align-top">
                                        <button
                                            class="toggle-btn text-gray-600 hover:text-red-600 transition text-xl leading-none"
                                            data-target="detail-row-{{ $loop->iteration }}">
                                            ⯈
                                        </button>
                                    </td>

                                    <td class="p-3 font-bold text-gray-700 align-top">
                                        {{ $reports->firstItem() + $loop->index }}
                                    </td>

                                    <td class="p-3 font-bold text-red-600 align-top">
                                        {{ $report->tracking_id }}
                                    </td>

                                    <td class="p-3 font-semibold text-gray-900 align-top break-words">
                                        {{ $report->judul }}
                                    </td>

                                    <td class="p-3 align-top hidden lg:table-cell text-xs">{{ $report->user?->name ?? 'Anonim' }}</td>
                                    <td class="p-3 align-top hidden md:table-cell text-xs">{{ $report->kategori?->nama ?? '-' }}</td>
                                    <td class="p-3 align-top hidden xl:table-cell text-xs">{{ $report->wilayah?->nama ?? '-' }}</td>

                                    @php
                                        $statusLabel =
                                            [
                                                'Diajukan' => 'Belum Dicek',
                                                'Dibaca' => 'Disetujui',
                                                'Revisi' => 'Revisi',
                                                'Direspon' => 'Direspon',
                                                'Selesai' => 'Selesai',
                                                'Arsip' => 'Arsip',
                                            ][$report->status] ?? $report->status;

                                        $statusClass =
                                            [
                                                'Diajukan' => 'bg-red-500 text-white',
                                                'Dibaca' => 'bg-blue-500 text-white',
                                                'Revisi' => 'bg-orange-500 text-white',
                                                'Direspon' => 'bg-yellow-500 text-white',
                                                'Selesai' => 'bg-green-500 text-white',
                                                'Arsip' => 'bg-purple-500 text-white',
                                            ][$report->status] ?? 'bg-gray-200 text-gray-800';
                                    @endphp

                                    <td class="p-3 text-center align-top">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold shadow-sm whitespace-nowrap {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Urgensi Column --}}
                                    <td class="p-3 text-center align-top">
                                        @php
                                            $priority = $report->effective_priority;
                                            $priorityClass = match($priority) {
                                                'Emergency' => 'bg-red-700 text-white animate-pulse',
                                                'High' => 'bg-red-100 text-red-700 border border-red-300',
                                                'Medium' => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                                                'Low' => 'bg-green-100 text-green-700 border border-green-300',
                                                default => 'bg-green-100 text-green-700'
                                            };

                                            $sentiment = $report->effective_sentiment;
                                            $sentimentIcon = match($sentiment) {
                                                'Positive' => 'fa-smile text-green-500',
                                                'Neutral' => 'fa-meh text-gray-400',
                                                'Negative' => 'fa-frown text-red-500',
                                                default => 'fa-meh text-gray-400'
                                            };
                                        @endphp
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-block rounded-lg px-2 py-0.5 text-[10px] font-black uppercase tracking-wider {{ $priorityClass }}">
                                                {{ $priority }}
                                            </span>
                                            <i class="fas {{ $sentimentIcon }} text-xs" title="Sentimen: {{ $sentiment }}"></i>
                                        </div>
                                    </td>

                                    {{-- SLA Column --}}
                                    <td class="p-3 text-center align-top">
                                        @php
                                            $slaStatus = $report->sla_status;
                                            $slaBadge = match($slaStatus) {
                                                'Terlambat' => 'bg-red-600 text-white animate-pulse',
                                                'Warning' => 'bg-yellow-500 text-white',
                                                default => 'bg-green-100 text-green-700'
                                            };
                                        @endphp
                                        <div class="flex flex-col items-center gap-1 text-[10px]">
                                            <span class="inline-block rounded-lg px-2 py-0.5 font-bold uppercase tracking-wider shadow-sm {{ $slaBadge }}">
                                                {{ $slaStatus }}
                                            </span>
                                            <span class="text-[9px] text-gray-400">{{ $report->created_at->format('d/m/y') }}</span>
                                        </div>
                                    </td>

                                </tr>

                                {{-- ========== DETAIL ROW (TAB VIEW) ========== --}}
                                <tr id="detail-row-{{ $loop->iteration }}" class="detail-row hidden">
                                    <td colspan="10" class="bg-gray-50 border-t border-b py-2 px-5">

                                        {{-- TAB HEADER --}}
                                        <div class="flex gap-4 border-b pb-2 mb-4 text-sm font-semibold">
                                            <button class="tab-btn active-tab"
                                                data-tab="detail-{{ $loop->iteration }}">Detail</button>
                                            <button class="tab-btn"
                                                data-tab="lampiran-{{ $loop->iteration }}">Lampiran</button>
                                            <button class="tab-btn"
                                                data-tab="lokasi-{{ $loop->iteration }}">Lokasi</button>
                                        </div>
                                        {{-- TAB CONTENTS --}}
                                        <div class="tab-content" id="detail-{{ $loop->iteration }}">
                                            <div class="space-y-2 text-sm">

                                                {{-- INFO DETAIL LAPORAN --}}
                                                <div class="grid grid-cols-1 gap-1">

                                                    {{-- Tracking ID --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Tracking ID</span>
                                                        <span class="flex-grow">: {{ $report->tracking_id ?? '-' }}</span>
                                                    </p>

                                                    {{-- Judul Aduan --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Judul Aduan</span>
                                                        <span class="flex-grow">: {{ $report->judul ?? '-' }}</span>
                                                    </p>

                                                    {{-- Tanggal & Jam Dibuat --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Tanggal & Jam</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->created_at->format('d M Y H:i') ?? '-' }}</span>
                                                    </p>

                                                    {{-- Kategori --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Kategori</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->kategori?->nama ?? '-' }}</span>
                                                    </p>

                                                    {{-- Wilayah --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Wilayah</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->wilayah?->nama ?? '-' }}</span>
                                                    </p>

                                                    {{-- Status --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Status</span>
                                                        <span class="flex-grow">: {{ $report->status ?? '-' }}</span>
                                                    </p>

                                                    {{-- Pelapor --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Pelapor</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->user?->name ?? 'Anonim' }}</span>
                                                    </p>

                                                    {{-- Email --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Email</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->user ? $report->email_pengadu ?? '-' : '-' }}</span>
                                                    </p>

                                                    {{-- No. Telp --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">No. Telp</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->user ? $report->telepon_pengadu ?? '-' : '-' }}</span>
                                                    </p>

                                                    {{-- NIK --}}
                                                    <p class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">NIK</span>
                                                        <span class="flex-grow">:
                                                            {{ $report->user ? $report->nik ?? '-' : '-' }}</span>
                                                    </p>

                                                    {{-- Isi Aduan --}}
                                                    <div class="flex">
                                                        <span class="font-semibold w-36 flex-shrink-0">Isi Aduan</span>
                                                        <span class="flex-grow text-justify">:
                                                            {{ $report->isi ?? '-' }}</span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-content hidden" id="lampiran-{{ $loop->iteration }}">
                                            @if (!empty($report->file))
                                                <div class="flex flex-wrap gap-4 mt-2">
                                                    @foreach ($report->file as $file)
                                                        @php
                                                            $filePath = asset(ltrim($file, '/'));
                                                            $extension = strtolower(
                                                                pathinfo($file, PATHINFO_EXTENSION),
                                                            );
                                                        @endphp

                                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            {{-- Preview gambar --}}
                                                            <div
                                                                class="w-32 h-32 border rounded overflow-hidden shadow cursor-pointer">
                                                                <img src="{{ $filePath }}" alt="Lampiran Gambar"
                                                                    class="w-full h-full object-cover"
                                                                    onclick="openImageModal('{{ $filePath }}')">
                                                            </div>
                                                        @elseif($extension === 'pdf')
                                                            <div class="p-2 border rounded shadow">
                                                                <a href="{{ $filePath }}" target="_blank"
                                                                    class="text-red-600 flex items-center gap-1">
                                                                    <i class="fas fa-file-pdf"></i> PDF
                                                                </a>
                                                            </div>
                                                        @elseif(in_array($extension, ['doc', 'docx']))
                                                            <div class="p-2 border rounded shadow">
                                                                <a href="{{ $filePath }}" target="_blank"
                                                                    class="text-blue-600 flex items-center gap-1">
                                                                    <i class="fas fa-file-word"></i> Word
                                                                </a>
                                                            </div>
                                                        @elseif(in_array($extension, ['xls', 'xlsx']))
                                                            <div class="p-2 border rounded shadow">
                                                                <a href="{{ $filePath }}" target="_blank"
                                                                    class="text-green-600 flex items-center gap-1">
                                                                    <i class="fas fa-file-excel"></i> Excel
                                                                </a>
                                                            </div>
                                                        @elseif($extension === 'zip')
                                                            <div class="p-2 border rounded shadow">
                                                                <a href="{{ $filePath }}" target="_blank"
                                                                    class="text-yellow-600 flex items-center gap-1">
                                                                    <i class="fas fa-file-archive"></i> ZIP
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="p-2 border rounded shadow">
                                                                <a href="{{ $filePath }}" target="_blank"
                                                                    class="text-gray-600 flex items-center gap-1">
                                                                    <i class="fas fa-file"></i> Lihat File
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-gray-600">Tidak ada lampiran.</p>
                                            @endif
                                        </div>

                                        <script>
                                            function openImageModal(src) {
                                                document.getElementById('modalImage').src = src;
                                                document.getElementById('imageModal').classList.remove('hidden');
                                            }

                                            function closeImageModal() {
                                                document.getElementById('imageModal').classList.add('hidden');
                                                document.getElementById('modalImage').src = '';
                                            }
                                        </script>
                                        <div class="tab-content hidden" id="lokasi-{{ $loop->iteration }}">
                                            <p><span class="font-semibold">Alamat:</span> {{ $report->lokasi ?? '-' }}</p>

                                            <div class="">
                                                <p><span class="font-semibold">Latitude:</span>
                                                    {{ $report->latitude ?? '-' }}</p>
                                                <p><span class="font-semibold">Longitude:</span>
                                                    {{ $report->longitude ?? '-' }}</p>
                                            </div>

                                            @if ($report->latitude && $report->longitude)
                                                <iframe width="100%" height="350" class="rounded-lg mt-3"
                                                    src="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}&hl=es;z=14&output=embed"></iframe>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Modal Preview Gambar --}}
                    <div id="imageModal"
                        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
                        <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer"
                            onclick="closeImageModal()">&times;</span>
                        <img id="modalImage" class="max-w-3xl max-h-[90vh] rounded shadow-xl" alt="Preview">
                    </div>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                    <p class="text-gray-600 mb-2 md:mb-0">
                        Menampilkan
                        <span class="font-bold">{{ $reports->firstItem() }}</span>
                        sampai
                        <span class="font-bold">{{ $reports->lastItem() }}</span>
                        dari total
                        <span class="font-bold">{{ $reports->total() }}</span>
                        aduan.
                    </p>

                    <div>
                        {{ $reports->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>

            @endif

        </div>

        <style>
            .active-tab {
                color: #dc2626;
                border-bottom: 2px solid #dc2626;
                padding-bottom: 3px;
            }
        </style>

        {{-- ========== JS TOGGLE DETAIL ========== --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // ========== TOGGLE DETAIL ROW ========== //
                const buttons = document.querySelectorAll(".toggle-btn");

                buttons.forEach(btn => {
                    btn.addEventListener("click", function(event) {
                        event.stopPropagation();

                        const targetId = this.dataset.target;
                        const detailRow = document.getElementById(targetId);
                        const isOpening = detailRow.classList.contains("hidden");

                        // Tutup semua row & reset icon
                        document.querySelectorAll(".detail-row").forEach(row => row.classList.add(
                            "hidden"));
                        document.querySelectorAll(".toggle-btn").forEach(b => b.textContent = "⯈");

                        // Buka baris yang dipilih
                        if (isOpening) {
                            detailRow.classList.remove("hidden");
                            this.textContent = "⯆";
                        }
                    });
                });

                // ========== TAB SYSTEM ========== //
                document.querySelectorAll(".tab-btn").forEach(tab => {
                    tab.addEventListener("click", function() {
                        const tabId = this.dataset.tab;
                        const parent = this.closest("td");

                        // hide semua tab-content
                        parent.querySelectorAll(".tab-content").forEach(x => x.classList.add("hidden"));

                        // remove active-tab dari semua button
                        parent.querySelectorAll(".tab-btn").forEach(x => x.classList.remove(
                            "active-tab"));

                        // tampilkan tab yang dipilih
                        document.getElementById(tabId).classList.remove("hidden");
                        this.classList.add("active-tab");
                    });
                });

            });
        </script>
    @endsection
