@extends('superadmin.layouts.app')

@section('title', 'Kelola Aduan Umum')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-6 text-2xl font-extrabold text-[#37474F]">
            Approval Aduan
        </h2>

        {{-- Alert Success (Fixed Top Right - Red Style) --}}
        @if (session('success'))
            <div id="alert-success" class="fixed top-4 right-4 z-50 animate-fade-in-down">
                <div class="bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 border-l-4 border-red-800">
                    <div class="bg-white/20 p-2 rounded-full">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Berhasil!</h4>
                        <p class="text-sm opacity-90">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('alert-success').style.display='none'" class="ml-4 text-white/70 hover:text-white transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <script>
                // Auto hide after 3 seconds
                setTimeout(function() {
                    var alert = document.getElementById('alert-success');
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(function() { alert.remove(); }, 500);
                    }
                }, 3000);
            </script>
        @endif

        {{-- Filter Section --}}
        <div class="mb-6 bg-white p-4 md:p-5 rounded-2xl shadow-lg border border-gray-200 animate-fade-in">

            <form method="GET" action="{{ route('superadmin.kelola-aduan.index') }}"
                class="flex flex-wrap gap-4 md:gap-6 items-end justify-start">

                <span class="text-base md:text-lg font-bold text-gray-800 flex-shrink-0 w-full md:w-auto">
                    Filter Data:
                </span>

                {{-- Filter Tahun --}}
                <div class="flex-1 min-w-[130px] md:min-w-[160px]">
                    <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-1">Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm 
                focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($tahuns as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Admin OPD --}}
                <div class="flex-1 min-w-[180px] md:min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Admin OPD:</label>
                    <select name="admin_id"
                        onchange="
            document.querySelector('select[name=kategori_id]').value = '';
            this.form.submit();
        "
                        class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        <option value="">-- Semua Admin --</option>

                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id_user }}"
                                {{ (string) request('admin_id') === (string) $admin->id_user ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
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
                                {{ (string) request('kategori_id') === (string) $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Filter Wilayah --}}
                <div class="flex-1 min-w-[180px] md:min-w-[200px]">
                    <label for="wilayah_id" class="block text-sm font-semibold text-gray-700 mb-1">Wilayah:</label>
                    <select name="wilayah_id" id="wilayah_id" onchange="this.form.submit()"
                        class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm 
                focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150">
                        <option value="">-- Semua Wilayah --</option>
                        @foreach ($wilayahs as $wilayah)
                            <option value="{{ $wilayah->id }}"
                                {{ request('wilayah_id') == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Reset Filter (pindah ke sebelah kanan Wilayah) --}}
                @if (request()->filled('tahun') ||
                        request()->filled('admin_id') ||
                        request()->filled('kategori_id') ||
                        request()->filled('wilayah_id') ||
                        request()->filled('search') ||
                        request()->filled('status') ||
                        request()->filled('tanggal_mulai') ||
                        request()->filled('tanggal_selesai'))
                    <a href="{{ route('superadmin.kelola-aduan.index') }}"
                        class="px-4 py-2 text-sm bg-gradient-to-r from-gray-600 to-gray-700 text-white 
                hover:from-gray-700 hover:to-gray-800 rounded-lg font-medium shadow-md 
                transition-all duration-200 flex items-center gap-2 flex-shrink-0">
                        <i class="fas fa-undo"></i>
                        <span>Reset Filter</span>
                    </a>
                @endif

                {{-- Filter Rentang Tanggal --}}
                <div class="flex flex-col md:flex-row gap-4 w-full mt-2">
                    <div class="flex-1">
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-1">
                            Tanggal Mulai:
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            value="{{ request('tanggal_mulai') }}"
                            class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm
                    focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150">
                    </div>

                    <div class="flex-1">
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700 mb-1">
                            Tanggal Selesai:
                        </label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                            value="{{ request('tanggal_selesai') }}"
                            class="w-full border border-gray-300 px-3 py-2 text-sm rounded-lg shadow-sm
                    focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150">
                    </div>

                    <button type="submit"
                        class="px-4 py-2 mt-6 md:mt-[30px] text-sm bg-red-600 text-white rounded-lg shadow-md 
                hover:bg-red-700 transition">
                        Terapkan
                    </button>
                </div>

            </form>
        </div>

        {{-- Summary Cards Section --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 xl:grid-cols-7 gap-4 mb-6">
            {{-- Card Template --}}
            @php
                $cards = [
                    [
                        'title' => 'Jumlah Belum Dicek',
                        'count' => $summary['diajukan'] ?? 0,
                        'color' => 'red',
                        'icon' => 'fa-file-alt',
                    ],
                    [
                        'title' => 'Jumlah Disetujui',
                        'count' => $summary['dibaca'] ?? 0,
                        'color' => 'blue',
                        'icon' => 'fa-check-circle',
                    ],
                    [
                        'title' => 'Jumlah Revisi',
                        'count' => $summary['revisi'] ?? 0,
                        'color' => 'orange',
                        'icon' => 'fa-sync-alt',
                    ],
                    [
                        'title' => 'Jumlah Direspon',
                        'count' => $summary['direspon'] ?? 0,
                        'color' => 'yellow',
                        'icon' => 'fa-comment',
                    ],
                    [
                        'title' => 'Jumlah Selesai',
                        'count' => $summary['selesai'] ?? 0,
                        'color' => 'green',
                        'icon' => 'fa-clipboard-check',
                    ],
                    [
                        'title' => 'Jumlah Arsip',
                        'count' => $summary['arsip'] ?? 0,
                        'color' => 'purple',
                        'icon' => 'fa-archive',
                    ],
                    [
                        'title' => 'Aduan Terlambat',
                        'count' => $summary['terlambat'] ?? 0,
                        'color' => 'red-dark',
                        'icon' => 'fa-exclamation-triangle',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                @php
                    $colorClasses = [
                        'red' => 'border-red-500 text-red-700',
                        'blue' => 'border-blue-500 text-blue-700',
                        'orange' => 'border-orange-500 text-orange-700',
                        'yellow' => 'border-yellow-500 text-yellow-700',
                        'green' => 'border-green-500 text-green-700',
                        'purple' => 'border-purple-500 text-purple-700',
                        'red-dark' => 'border-red-800 text-red-900 bg-red-50',
                    ];
                @endphp

                <div
                    class="bg-white {{ $colorClasses[$card['color']] ?? 'border-gray-500 text-gray-700' }} 
        border-b-4 p-4 rounded-2xl shadow-lg 
        flex flex-col items-start hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center justify-between w-full">
                        <h3 class="text-sm font-semibold text-gray-500">{{ $card['title'] }}</h3>
                        <div class="{{ $colorClasses[$card['color']] ?? 'text-gray-700' }} text-2xl">
                            <i class="fas {{ $card['icon'] }}"></i>
                        </div>
                    </div>
                    <p class="text-4xl centerfont-extrabold mt-2">
                        {{ $card['count'] }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Main Table Section --}}
        <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

                {{-- Left: Search Form --}}
                <div class="w-full md:w-1/3">
                    <form method="GET" action="{{ route('superadmin.kelola-aduan.index') }}" class="relative">
                        @foreach (request()->except(['search', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" name="search" placeholder="Cari Judul, Pelapor, Admin, Kategori, Wilayah..."
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
                                'superadmin.kelola-aduan.index',
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

            {{-- Table Section --}}
            @if ($reports->isEmpty())
                <div class="text-center py-10 rounded-lg bg-red-50 text-red-600 border border-red-200">
                    <i class="fas fa-info-circle text-xl mb-2"></i>
                    <p class="font-semibold text-lg">Tidak ada data aduan yang tersedia.</p>
                    <p class="text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                </div>
            @else
                {{-- Responsive Wrapper --}}
                <div
                    class="overflow-x-auto rounded-xl border border-gray-200 shadow-md scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <table class="min-w-full table-auto text-sm text-gray-800">
                        <thead class="bg-red-700 text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="p-3 text-center font-bold rounded-tl-lg w-[5%]">No</th>
                                <th class="p-3 text-left font-bold w-[25%]">Judul</th>
                                <th class="p-3 text-left font-bold w-[15%]">Pelapor</th>
                                <th class="p-3 text-left font-bold w-[15%]">Admin OPD</th>
                                <th class="p-3 text-left font-bold w-[10%]">Kategori</th>
                                <th class="p-3 text-left font-bold w-[10%]">Wilayah</th>
                                <th class="p-3 text-center font-bold w-[10%]">Status</th>
                                <th class="p-3 text-center font-bold w-[10%]">Urgensi</th>
                                <th class="p-3 text-center font-bold w-[10%]">SLA</th>
                                <th class="p-3 text-center font-bold rounded-tr-lg w-[10%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($reports as $index => $report)
                                <tr class="hover:bg-red-50 transition-all duration-200">
                                    <td class="p-3 text-center align-top">
                                        {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="p-3 font-semibold text-gray-900 align-top break-words">
                                        {{ $report->judul }}
                                    </td>
                                    <td class="p-3 align-top">
                                        {{ $report->user->name ?? ($report->pelapor_nama ?? 'Anonim') }}</td>
                                    <td class="p-3 align-top">{{ $report->admin->name ?? '-' }}</td>
                                    <td class="p-3 align-top">{{ $report->kategori->nama ?? '-' }}</td>
                                    <td class="p-3 align-top">{{ $report->wilayah->nama ?? '-' }}</td>

                                    {{-- Status Badge --}}
                                    <td class="p-3 text-center align-top">
                                        @php
                                            $statuses = [
                                                'Diajukan' => 'Belum Dicek',
                                                'Dibaca' => 'Disetujui',
                                                'Revisi' => 'Revisi',
                                                'Direspon' => 'Direspon',
                                                'Selesai' => 'Selesai',
                                                'Arsip' => 'Arsip',
                                            ];
                                            $statusClass =
                                                [
                                                    'Diajukan' => 'bg-red-500 text-white',
                                                    'Dibaca' => 'bg-blue-500 text-white',
                                                    'Direspon' => 'bg-yellow-500 text-white',
                                                    'Selesai' => 'bg-green-500 text-white',
                                                    'Revisi' => 'bg-orange-500 text-white',
                                                    'Arsip' => 'bg-purple-500 text-white',
                                                ][$report->status] ?? 'bg-gray-100 text-gray-800';
                                            $statusText = $statuses[$report->status] ?? $report->status;
                                        @endphp
                                        <span
                                            class="inline-block rounded-full px-3 py-1 text-xs font-bold shadow {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>

                                    {{-- AI Priority --}}
                                    <td class="p-3 text-center align-top">
                                        @php
                                            $priority = $report->priority ?: 'Low';
                                            $priorityClass =
                                                [
                                                    'Emergency' => 'bg-red-700 text-white animate-pulse',
                                                    'High' => 'bg-red-100 text-red-700 border border-red-300',
                                                    'Medium' =>
                                                        'bg-yellow-100 text-yellow-700 border border-yellow-300',
                                                    'Low' => 'bg-green-100 text-green-700 border border-green-300',
                                                ][$priority] ?? 'bg-green-100 text-green-700 border border-green-300';

                                            $sentiment = $report->sentiment ?: 'Neutral';
                                            $sentimentIcon =
                                                [
                                                    'Positive' => 'fa-smile text-green-500',
                                                    'Neutral' => 'fa-meh text-gray-400',
                                                    'Negative' => 'fa-frown text-red-500',
                                                ][$sentiment] ?? 'fa-meh text-gray-400';
                                        @endphp
                                        <div class="flex flex-col items-center gap-1">
                                            <span
                                                class="inline-block rounded-lg px-2 py-1 text-[10px] font-black uppercase tracking-wider {{ $priorityClass }}">
                                                {{ $priority }}
                                            </span>
                                            <i class="fas {{ $sentimentIcon }} text-xs"
                                                title="Sentimen: {{ $sentiment }}"></i>
                                        </div>
                                    </td>

                                    {{-- SLA Monitoring --}}
                                    <td class="p-3 text-center align-top">
                                        @php
                                            $slaStatus = $report->sla_status;
                                            $slaBadge = match($slaStatus) {
                                                'Terlambat' => 'bg-red-600 text-white animate-pulse',
                                                'Warning' => 'bg-yellow-500 text-white',
                                                default => 'bg-green-100 text-green-700'
                                            };
                                        @endphp
                                        <span class="inline-block rounded-lg px-2 py-1 text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $slaBadge }}">
                                            {{ $slaStatus }}
                                        </span>
                                        @if($slaStatus !== 'Normal')
                                            <p class="text-[9px] text-gray-500 mt-1">Deadline: {{ $report->sla_deadline->format('d/m/y') }}</p>
                                        @endif
                                    </td>

                                    {{-- Aksi Buttons --}}
                                    <td class="p-3 text-center align-top">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('superadmin.reports.show', ['id' => $report->id]) }}"
                                                class="px-2 py-1 text-xs bg-blue-500 hover:bg-blue-600 rounded-lg text-white font-medium shadow transition duration-150">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                            <button type="button"
                                                class="px-2 py-1 text-xs bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#editAduanModal"
                                                data-id="{{ $report->id }}" data-status="{{ $report->status }}"
                                                data-komentar="{{ $report->komentar_revisi }}">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                            <button
                                                class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 rounded-lg text-white font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#deleteAduanModal"
                                                data-id="{{ $report->id }}" data-judul="{{ $report->judul }}">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                            <button type="button" data-toggle="modal"
                                                data-target="#disposisiModal-{{ $report->id }}"
                                                class="px-2 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded-lg shadow">
                                                <i class="fas fa-share mr-1"></i> Disposisi
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Disposisi --}}
                                <div class="modal fade" id="disposisiModal-{{ $report->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                                        <div class="modal-content">
                                            <form action="{{ route('superadmin.kelola-aduan.update', $report->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Disposisi Aduan</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label>Pilih Admin</label>
                                                        <select name="admin_id" id="adminSelect-{{ $report->id }}" class="form-control">
                                                            <option value="">-- Pilih Admin --</option>
                                                            @foreach (\App\Models\User::where('role', 'admin')->get() as $admin)
                                                                <option value="{{ $admin->id_user }}"
                                                                    {{ $report->admin_id == $admin->id_user ? 'selected' : '' }}>
                                                                    {{ $admin->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Pilih Kategori</label>
                                                        <select name="kategori_id" id="kategoriSelect-{{ $report->id }}" class="form-control">
                                                            <option value="">-- Pilih Kategori --</option>
                                                            @foreach (\App\Models\KategoriUmum::all() as $kategori)
                                                                <option value="{{ $kategori->id }}"
                                                                    data-admin="{{ $kategori->admin_id }}"
                                                                    {{ $report->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                    {{ $kategori->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination and Info --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                    <p class="text-gray-600 mb-2 md:mb-0">
                        Menampilkan <span class="font-bold text-gray-800">{{ $reports->firstItem() }}</span> sampai <span
                            class="font-bold text-gray-800">{{ $reports->lastItem() }}</span> dari total <span
                            class="font-bold text-gray-800">{{ $reports->total() }}</span> aduan.
                    </p>
                    <div>
                        {{ $reports->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>

            @endif
        </div>

        {{-- ========================= --}}
        {{-- ✏️ Edit Modal --}}
        {{-- ========================= --}}
        <div class="modal fade" id="editAduanModal" tabindex="-1" role="dialog" aria-labelledby="editAduanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered max-w-md w-full px-4 sm:px-0" role="document">
                <div class="modal-content rounded-2xl shadow-2xl border-t-4 border-yellow-500 overflow-hidden">

                    {{-- Form Edit --}}
                    <form method="POST" id="editAduanForm" class="w-full">
                        @csrf
                        @method('PUT')

                        {{-- Header --}}
                        <div class="modal-header bg-yellow-500 text-white flex items-center justify-between p-4">
                            <h5 class="modal-title text-base sm:text-lg font-bold flex items-center gap-2"
                                id="editAduanModalLabel">
                                <i class="fas fa-edit"></i> Edit Status Aduan
                            </h5>
                            <button type="button"
                                class="close text-white opacity-80 hover:opacity-100 text-2xl leading-none"
                                data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        {{-- Body --}}
                        <div class="modal-body p-5 space-y-4">
                            <div>
                                <label for="editStatus" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Pilih Status:
                                </label>
                                <select name="status" id="editStatus"
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-yellow-500 focus:border-yellow-500 text-sm transition duration-150"
                                    required>
                                    <option value="Diajukan">Belum Dicek</option>
                                    <option value="Dibaca">Disetujui</option>
                                    <option value="Revisi">Revisi</option>
                                    <option value="Direspon">Direspon</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Arsip">Arsip</option>
                                </select>
                            </div>

                            <div id="revisiContainer" class="hidden">
                                <label for="komentar_revisi" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Catatan Revisi:
                                </label>
                                <textarea name="komentar_revisi" id="komentar_revisi" rows="3"
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-yellow-500 focus:border-yellow-500 text-sm transition duration-150"
                                    placeholder="Masukkan alasan revisi..."></textarea>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer flex flex-col sm:flex-row justify-end gap-3 p-4 border-t border-gray-200">
                            <button type="button"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-150"
                                data-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-medium bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-md transition duration-150">
                                <i class="fas fa-upload mr-1"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================= --}}
        {{-- 🗑️ Delete Modal --}}
        {{-- ========================= --}}
        <div class="modal fade" id="deleteAduanModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteAduanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered max-w-md w-full px-4 sm:px-0" role="document">
                <div class="modal-content rounded-2xl shadow-2xl border-t-4 border-red-500 overflow-hidden">

                    {{-- Form Delete --}}
                    <form method="POST" id="deleteAduanForm" class="w-full">
                        @csrf
                        @method('DELETE')

                        {{-- Header --}}
                        <div class="modal-header bg-red-500 text-white flex items-center justify-between p-4">
                            <h5 class="modal-title text-base sm:text-lg font-bold flex items-center gap-2"
                                id="deleteAduanModalLabel">
                                <i class="fas fa-trash-alt"></i> Konfirmasi Hapus Aduan
                            </h5>
                            <button type="button"
                                class="close text-white opacity-80 hover:opacity-100 text-2xl leading-none"
                                data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        {{-- Body --}}
                        <div class="modal-body p-5">
                            <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
                                Apakah Anda yakin ingin menghapus aduan
                                <span id="aduanJudul" class="font-bold text-red-600"></span>?
                                <br>
                                <span class="text-gray-500 text-xs sm:text-sm">Tindakan ini tidak dapat dibatalkan.</span>
                            </p>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer flex flex-col sm:flex-row justify-end gap-3 p-4 border-t border-gray-200">
                            <button type="button"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-medium bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-150"
                                data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition duration-150">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus Permanen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Style for Animations and Utilities --}}
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes progress {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        @keyframes pop {
            from {
                transform: scale(0.6);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        .animate-progress {
            animation: progress 3.5s linear forwards;
        }

        .animate-pop {
            animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Ensure form-control in modals looks right if Tailwind is overriding default BS styles */
        .modal-content select.form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>

    {{-- Toast Notifications (Error Only - Success is handled at top) --}}
    @if(session('error'))
        <div id="errorMessage"
            class="fixed top-5 right-5 z-[1050] flex items-center gap-4 
                w-[420px] max-w-[90vw] px-6 py-4 rounded-xl shadow-2xl 
                bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-sm text-white 
                transition-all duration-500 opacity-100 animate-fade-in border border-red-400">
            <div class="flex-shrink-0">
                <svg id="error-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <svg id="error-x" class="w-7 h-7 text-white hidden scale-75" stroke="currentColor" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <span class="flex-1 font-semibold tracking-wide">{{ session('error') }}</span>
            <button onclick="document.getElementById('errorMessage').remove()"
                class="text-white/70 hover:text-white font-bold transition-colors text-lg ml-2">✕</button>
            <div
                class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl">
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            // Logika Notifikasi
            const showCheckOrX = (idPrefix, iconClass, removeClass) => {
                setTimeout(() => {
                    const spinner = document.getElementById(idPrefix + '-spinner');
                    const icon = document.getElementById(idPrefix + iconClass);
                    if (spinner && icon) {
                        spinner.classList.add('hidden');
                        icon.classList.remove('hidden');
                        icon.classList.add('animate-pop');
                    }
                }, 800);

                setTimeout(() => {
                    const alert = document.getElementById(idPrefix + 'Message');
                    if (alert) {
                        alert.classList.add('opacity-0', removeClass);
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3500);
            };

            // SUCCESS
            if (document.getElementById('successMessage')) {
                showCheckOrX('success', '-check', 'translate-y-2');
            }

            // ERROR
            if (document.getElementById('errorMessage')) {
                showCheckOrX('error', '-x', 'translate-y-2');
            }

            // Logika Modal Edit
            $('#editAduanModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const status = button.data('status');
                const komentar = button.data('komentar'); // Ambil komentar revisi

                const modal = $(this);
                const statusSelect = modal.find('#editStatus');
                const revisiContainer = modal.find('#revisiContainer');
                const komentarInput = modal.find('#komentar_revisi');

                modal.find('#editStatus').val(status);
                komentarInput.val(komentar); // Isi textarea

                // Fungsi toggle visibility
                function toggleRevisi() {
                    if (statusSelect.val() === 'Revisi') {
                        revisiContainer.removeClass('hidden');
                        komentarInput.prop('required', true);
                    } else {
                        revisiContainer.addClass('hidden');
                        komentarInput.prop('required', false);
                    }
                }

                // Jalankan saat modal dibuka
                toggleRevisi();

                // Jalankan saat status berubah
                statusSelect.on('change', toggleRevisi);

                // Sesuaikan rute untuk update (PUT request)
                modal.find('#editAduanForm').attr('action', `/superadmin/kelola-aduan/${id}`);
            });

            // Logika Modal Delete
            $('#deleteAduanModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var judul = button.data('judul');

                var modal = $(this);
                modal.find('#aduanJudul').text(judul);
                // Sesuaikan rute untuk delete (DELETE request)
                modal.find('#deleteAduanForm').attr('action', '/superadmin/kelola-aduan/' + id);
            });

            // ========================
            // Filter kategori sesuai admin (per report)
            // ========================
            @foreach ($reports as $report)
                $('#adminSelect-{{ $report->id }}').on('change', function() {
                    var selectedAdmin = $(this).val();
                    var kategoriSelect = $('#kategoriSelect-{{ $report->id }}');

                    // sembunyikan semua kategori dulu
                    kategoriSelect.find('option').hide();
                    kategoriSelect.find('option[value=""]').show(); // opsi default

                    if (selectedAdmin) {
                        // tampilkan kategori yang sesuai admin
                        kategoriSelect.find('option').each(function() {
                            var adminId = $(this).data('admin');
                            // Compare directly since each category has one admin_id
                            if (adminId == selectedAdmin) {
                                $(this).show();
                            }
                        });

                        // otomatis pilih kategori pertama yang sesuai admin
                        var firstVisibleOption = kategoriSelect.find('option:visible:not([value=""])').first().val();
                        if (firstVisibleOption) {
                            kategoriSelect.val(firstVisibleOption);
                        } else {
                            kategoriSelect.val('');
                        }
                    } else {
                        // tampilkan semua jika tidak ada admin terpilih
                        kategoriSelect.find('option').show();
                    }
                });

                // trigger pada saat modal dibuka untuk filter kategori sesuai admin yang sudah terpilih
                $('#disposisiModal-{{ $report->id }}').on('show.bs.modal', function() {
                    $('#adminSelect-{{ $report->id }}').trigger('change');
                });
            @endforeach
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
        <script>
            // ⚙️ Konfigurasi default NProgress
            NProgress.configure({
                showSpinner: false,
                trickleSpeed: 200,
                minimum: 0.08
            });

            // 🔹 1. Tangkap klik semua link internal
            document.addEventListener("click", function(e) {
                const link = e.target.closest("a");
                if (link && link.href && link.origin === window.location.origin) {
                    NProgress.start();
                    setTimeout(() => NProgress.set(0.9), 150);
                }
            });

            // 🔹 2. Patch untuk XMLHttpRequest
            (function(open) {
                XMLHttpRequest.prototype.open = function() {
                    NProgress.start();
                    this.addEventListener("loadend", function() {
                        NProgress.set(1.0);
                        setTimeout(() => NProgress.done(), 300);
                    });
                    open.apply(this, arguments);
                };
            })(XMLHttpRequest.prototype.open);

            // 🔹 3. Patch untuk Fetch API
            const originalFetch = window.fetch;
            window.fetch = function() {
                NProgress.start();
                return originalFetch.apply(this, arguments).finally(() => {
                    NProgress.set(1.0);
                    setTimeout(() => NProgress.done(), 300);
                });
            };

            // 🔹 4. Saat halaman selesai load
            window.addEventListener("pageshow", () => {
                NProgress.set(1.0);
                setTimeout(() => NProgress.done(), 300);
            });

            // 🔹 5. Tangkap submit form (SAMAIN dengan klik link)
            document.addEventListener("submit", function(e) {
                const form = e.target;
                if (form.tagName === "FORM") {
                    NProgress.start();
                    setTimeout(() => NProgress.set(0.9), 150);
                }
            }, true);
        </script>
    @endpush
@endsection
