@extends('superadmin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .step-active { background: #dc2626; color: white; }
        .step-completed { background: #16a34a; color: white; }
        .step-inactive { background: #e5e7eb; color: #9ca3af; }
        
        [x-cloak] { display: none !important; }
        
        .sticky-column {
            position: sticky;
            top: 110px; /* Adjust based on floating header height */
            align-self: start;
        }

        /* Custom Scrollbar for isi laporan */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
@endsection

@section('content')
    @php
        // AI Analysis Fallbacks
        $priority = $report->priority;
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
        $pColor = match($priority) {
            'Emergency' => 'bg-red-600 text-white',
            'High' => 'bg-orange-500 text-white',
            'Medium' => 'bg-yellow-500 text-slate-900',
            'Low' => 'bg-green-500 text-white',
            default => 'bg-green-500 text-white'
        };

        $sentiment = $report->sentiment;
        if (!$sentiment) {
            $text = strtolower($report->judul . ' ' . $report->isi);
            if (Str::contains($text, ['terima kasih', 'bagus', 'mantap', 'memuaskan', 'hebat', 'apresiasi'])) {
                $sentiment = 'Positive';
            } elseif (Str::contains($text, ['jancok','goblok','kecewa', 'parah', 'buruk', 'lambat', 'susah', 'tolong', 'mohon', 'rusak', 'bantu', 'bau', 'anjing', 'bodoh', 'gimana sih'])) {
                $sentiment = 'Negative';
            } else {
                $sentiment = 'Neutral';
            }
        }
        $sColor = match($sentiment) { 'Positive' => 'text-green-500', 'Neutral' => 'text-slate-400', 'Negative' => 'text-red-500', default => 'text-slate-400' };
        $sIcon = match($sentiment) { 'Positive' => 'fa-smile', 'Neutral' => 'fa-meh', 'Negative' => 'fa-frown', default => 'fa-meh' };
        
        $badges = ['tindak' => $followUps->count(), 'komentar' => $comments->count(), 'lampiran' => is_array($report->file) ? count($report->file) : 0];
        $tabs = [
            'tindak' => ['label' => 'Tindak Lanjut', 'icon' => 'fa-clipboard-check'],
            'komentar' => ['label' => 'Komentar', 'icon' => 'fa-comments'],
            'lampiran' => ['label' => 'Lampiran', 'icon' => 'fa-paperclip'],
            'lokasi' => ['label' => 'Lokasi', 'icon' => 'fa-map-marker-alt'],
        ];
        $authUser = auth()->user();
    @endphp

    <div class="min-h-screen bg-[#F8FAFC] pb-12">
        <!-- Floating Header Section -->
        <div class="sticky top-0 z-30 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('superadmin.kelola-aduan.index') }}" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-500 transition-all">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <nav class="flex mb-1" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">Pusat Bantuan</li>
                                    <li class="flex items-center text-[10px] font-bold uppercase tracking-widest text-red-600">
                                        <i class="fas fa-chevron-right text-[10px] text-gray-300 mx-1"></i> Detail Aduan
                                    </li>
                                </ol>
                            </nav>
                            <h1 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">
                                Detail Pelaporan <span class="text-red-600">ID: {{ $report->tracking_id }}</span>
                            </h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($report->status != 'Selesai')
                            <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold text-sm shadow-lg shadow-green-200 transition-all hover:-translate-y-0.5">
                                    <i class="fas fa-check-double"></i> <span>Selesaikan Aduan</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Dibaca">
                                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-200 transition-all hover:-translate-y-0.5">
                                    <i class="fas fa-undo"></i> <span>Batalkan Selesai</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div x-data="{ openStatus: false, currentStatus: '{{ $report->status }}' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            
            {{-- Floating Flash Messages --}}
            @if (session('success') || session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-10"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform translate-x-10"
                     class="fixed top-28 right-8 z-[9999] w-[400px] max-w-[90vw]">
                    
                    <div class="rounded-[2rem] p-6 shadow-2xl border border-red-400 bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white flex items-center gap-4 relative overflow-hidden">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center text-xl shadow-inner">
                            <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-white uppercase tracking-wider mb-1">{{ session('success') ? 'Berhasil' : 'Galat' }}</h4>
                            <p class="text-xs text-white/90 font-medium leading-relaxed">{{ session('success') ?? session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-white/70 hover:text-white transition-colors">
                            <i class="fas fa-times"></i>
                        </button>

                        {{-- Progress bar timer --}}
                        <div class="absolute bottom-0 left-0 h-1 bg-white/40 animate-progress-timer" style="width: 100%"></div>
                    </div>
                </div>

                <style>
                    @keyframes progress-timer {
                        from { width: 100%; }
                        to { width: 0%; }
                    }
                    .animate-progress-timer {
                        animation: progress-timer 5s linear forwards;
                    }
                </style>
            @endif

            <!-- Status Timeline -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 mb-8 relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <i class="fas fa-tasks text-red-600"></i> Progres Penanganan Aduan
                    </h3>
                    <button @click="openStatus = true" class="px-5 py-2.5 bg-red-50 text-red-600 rounded-2xl font-black text-[10px] hover:bg-red-600 hover:text-white transition-all flex items-center gap-2 shadow-sm uppercase tracking-widest border border-red-100">
                        <i class="fas fa-edit"></i> UBAH STATUS
                    </button>
                </div>

                @php
                    $steps = [
                        ['key' => 'Diajukan', 'label' => 'Diajukan', 'icon' => 'fa-paper-plane', 'color' => 'red-600', 'ring' => 'red-100'],
                        ['key' => 'Dibaca', 'label' => 'Disetujui', 'icon' => 'fa-eye', 'color' => 'blue-600', 'ring' => 'blue-100'],
                        ['key' => 'Direspon', 'label' => 'Direspon', 'icon' => 'fa-reply-all', 'color' => 'yellow-500', 'ring' => 'yellow-100'],
                        ['key' => 'Selesai', 'label' => 'Selesai', 'icon' => 'fa-check-circle', 'color' => 'green-600', 'ring' => 'green-100'],
                    ];
                    $currentIndex = -1;
                    foreach($steps as $idx => $step) {
                        if($step['key'] == $report->status) {
                            $currentIndex = $idx;
                            break;
                        }
                    }
                    
                    // Handle special visual state for Revisi and Arsip
                    $visualIndex = $currentIndex;
                    if ($report->status == 'Revisi') $visualIndex = 0.5;
                    if ($report->status == 'Arsip') $visualIndex = 4; // Beyond the last step
                @endphp

                <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative px-4">
                    {{-- Connecting Line (Background) --}}
                    <div class="hidden md:block absolute top-[24px] left-[50px] right-[50px] h-[3px] bg-slate-100 z-0 rounded-full overflow-hidden">
                        {{-- Active Progress Overlay --}}
                        <div class="h-full bg-red-600 transition-all duration-1000 ease-in-out" 
                             style="width: {{ $visualIndex !== -1 ? ($visualIndex / (count($steps)-1) * 100) : 0 }}%"></div>
                    </div>
                    @foreach($steps as $index => $step)
                        @php
                            $isCompleted = ($currentIndex !== -1 && $index < $currentIndex);
                            $isActive = $report->status == $step['key'];
                            
                            if ($isActive) {
                                $stepClass = "bg-{$step['color']} text-white ring-4 ring-{$step['ring']} scale-110";
                                $textClass = "text-{$step['color']}";
                            } elseif ($isCompleted || ($report->status == 'Arsip' && $index <= 3)) {
                                $stepClass = "bg-{$step['color']} text-white opacity-80";
                                $textClass = "text-{$step['color']}";
                            } else {
                                $stepClass = "bg-slate-100 text-slate-400";
                                $textClass = "text-slate-400";
                            }
                        @endphp
                        <div class="flex flex-col items-center gap-2 relative z-10 bg-white px-2">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg {{ $stepClass }} transition-all duration-500 shadow-lg">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>
                            <span class="text-[9px] font-black {{ $textClass }} uppercase tracking-wider">{{ $step['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                @if ($report->status == 'Revisi')
                    <div class="mt-8 p-5 bg-orange-50 border-l-4 border-orange-400 rounded-r-2xl animate__animated animate__fadeIn">
                        <div class="flex items-center gap-3 text-orange-800 font-bold mb-2">
                            <i class="fas fa-exclamation-circle text-lg"></i> <span class="text-[10px] uppercase tracking-[0.15em]">Instruksi Revisi untuk Warga</span>
                        </div>
                        <p class="text-sm text-orange-700 font-medium leading-relaxed">{{ $report->komentar_revisi ?? 'Mohon lengkapi data laporan Anda agar dapat segera kami tangani.' }}</p>
                    </div>
                @endif

                @if ($report->status == 'Arsip')
                    <div class="mt-8 p-5 bg-purple-50 border-l-4 border-purple-400 rounded-r-2xl animate__animated animate__fadeIn">
                        <div class="flex items-center gap-3 text-purple-800 font-bold mb-2">
                            <i class="fas fa-archive text-lg"></i> <span class="text-[10px] uppercase tracking-[0.15em]">Laporan Ini Telah Diarsipkan</span>
                        </div>
                        <p class="text-sm text-purple-700 font-medium leading-relaxed">Laporan telah diproses dan dipindahkan ke arsip sistem untuk dokumentasi jangka panjang.</p>
                    </div>
                @endif
            </div>

            <!-- Modal Edit Status -->
            <div x-show="openStatus" x-cloak x-transition.opacity 
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
                <div @click.away="openStatus = false" 
                    class="bg-white rounded-[2.5rem] p-10 w-full max-w-md shadow-2xl relative animate__animated animate__zoomIn animate__faster border border-white">
                    <div class="absolute top-0 right-0 p-8">
                        <button @click="openStatus = false" class="text-slate-300 hover:text-red-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Update Progres</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-8">Pilih tahapan penanganan saat ini</p>
                    
                    <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST" class="space-y-6">
                        @csrf @method('PUT')
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Status Aduan</label>
                                <select name="status" x-model="currentStatus" 
                                    class="w-full rounded-[1.25rem] border-slate-100 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-red-50 transition-all outline-none">
                                    <option value="Diajukan">Belum Dicek</option>
                                    <option value="Dibaca">Disetujui</option>
                                    <option value="Revisi">Revisi (Perlu Perbaikan)</option>
                                    <option value="Direspon">Direspon</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Arsip">Arsip</option>
                                </select>
                            </div>

                            <div x-show="currentStatus === 'Revisi'" x-transition 
                                class="space-y-2 animate__animated animate__fadeIn">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Instruksi Revisi</label>
                                <textarea name="komentar_revisi" rows="4" 
                                    class="w-full rounded-[1.25rem] border-slate-100 bg-slate-50 p-4 font-medium text-slate-700 focus:ring-4 focus:ring-red-50 transition-all outline-none" 
                                    placeholder="Berikan instruksi jelas bagian mana yang harus diperbaiki oleh warga...">{{ $report->komentar_revisi }}</textarea>
                            </div>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <button type="button" @click="openStatus = false" 
                                class="flex-1 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl hover:bg-slate-200 transition-colors uppercase tracking-widest text-[10px]">Batal</button>
                            <button type="submit" 
                                class="flex-1 py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-200 hover:bg-red-700 transition-all hover:scale-[1.02] uppercase tracking-widest text-[10px]">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
                <!-- Left Column -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex-1 flex flex-col">
                        <div class="relative h-4 w-full bg-gradient-to-r from-red-600 via-red-500 to-red-400"></div>
                        <div class="p-6 md:p-8">
                            <div x-data="{ editing: false }">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="p-3 rounded-2xl bg-red-50 text-red-600"><i class="fas fa-file-alt text-2xl"></i></div>
                                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight" x-show="!editing">{{ $report->judul }}</h2>
                                    </div>
                                    <button @click="editing = true" x-show="!editing" class="px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </button>
                                </div>
                                <div class="prose prose-slate max-w-none mb-8" x-show="!editing">
                                    <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100 italic text-slate-700 leading-relaxed whitespace-pre-line custom-scrollbar max-h-96 overflow-y-auto">
                                        {{ $report->isi }}
                                    </div>
                                </div>
                                <form x-show="editing" action="{{ route('superadmin.reports.update', $report->id) }}" method="POST" x-cloak>
                                    @csrf @method('PUT')
                                    <div class="space-y-4 mb-6">
                                        <input type="text" name="judul" value="{{ $report->judul }}" class="w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 font-bold text-xl">
                                        <textarea name="isi" rows="6" class="w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500">{{ $report->isi }}</textarea>
                                    </div>
                                    <div class="flex justify-end gap-3 pb-6">
                                        <button type="button" @click="editing = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold">Batal</button>
                                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-bold shadow-lg shadow-red-100">Simpan</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Card Footer to fill space --}}
                            <div class="mt-auto pt-8 border-t border-slate-50">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                   
                                    <div class="flex flex-col gap-1 border-l border-slate-100 pl-4">
                                      
                                    </div>
                                   
                                    <div class="flex flex-col gap-1 border-l border-slate-100 pl-4">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" x-data="{ currentTab: 'tindak' }">
                        <div class="flex border-b border-gray-100 bg-slate-50/50">
                            @foreach ($tabs as $key => $tab)
                                <button @click="currentTab = '{{ $key }}'; $dispatch('tab-changed', { tab: '{{ $key }}' })" 
                                    :class="currentTab == '{{ $key }}' ? 'text-red-600 border-b-2 border-red-600 bg-white' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50'"
                                    class="flex-1 px-4 py-4 text-[10px] md:text-xs font-black uppercase tracking-widest transition-all">
                                    <div class="flex flex-col md:flex-row items-center justify-center gap-2">
                                        <i class="fas {{ $tab['icon'] }}"></i>
                                        <span class="hidden md:inline">{{ $tab['label'] }}</span>
                                        @if (!empty($badges[$key]))
                                            <span class="px-1.5 py-0.5 rounded-full bg-red-600 text-white text-[9px]">{{ $badges[$key] }}</span>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        <div class="p-6 md:p-8 min-h-[400px]">
                            <div x-show="currentTab == 'tindak'" x-transition class="flex flex-col h-full">
                                <div class="flex-1 overflow-y-auto custom-scrollbar max-h-[450px] pr-4">
                                    <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                                        @forelse ($followUps as $item)
                                            <div class="relative" x-data="{ editing: false, pesan: '{{ addslashes($item->pesan) }}' }">
                                                <div class="absolute -left-[29px] top-0 w-4 h-4 rounded-full bg-white border-4 border-red-600 shadow-sm z-10"></div>
                                                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 relative group">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">{{ substr($item->user->name, 0, 1) }}</div>
                                                            <div><h4 class="text-sm font-extrabold text-slate-800">{{ $item->user->name }}</h4><p class="text-[10px] text-slate-400 font-bold uppercase">{{ $item->created_at->diffForHumans() }}</p></div>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            @if($authUser->role === 'superadmin' || $authUser->id_user === $item->user_id)
                                                                <button @click="editing = !editing" class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-blue-600 transition-all"><i class="fas fa-edit"></i></button>
                                                                <button onclick="openDeleteModal('{{ route('superadmin.reports.followup.delete', [$report->id, $item->id]) }}')" class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-700 transition-all"><i class="fas fa-trash-alt"></i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div x-show="!editing">
                                                        <p class="text-slate-700 text-sm">{{ $item->pesan }}</p>
                                                        @if($item->file)
                                                            <a href="{{ asset(ltrim($item->file, '/')) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                                                                <i class="fas fa-paperclip text-slate-400"></i> Lampiran
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <div x-show="editing" x-cloak>
                                                        <form action="{{ route('superadmin.reports.followup.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                            @csrf @method('PUT')
                                                            <textarea name="pesan" x-model="pesan" class="w-full rounded-xl border-slate-200 text-sm focus:ring-red-600" rows="3"></textarea>
                                                            <div class="flex justify-between items-center">
                                                                <input type="file" name="file" class="text-[10px] text-slate-400">
                                                                <div class="flex gap-2">
                                                                    <button type="button" @click="editing = false" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg uppercase">Batal</button>
                                                                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-[10px] font-bold rounded-lg uppercase shadow-sm">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-center text-slate-400 py-12 font-bold">Belum ada aktivitas tindak lanjut</p>
                                        @endforelse
                                    </div>
                                </div>
                                <form action="{{ route('superadmin.reports.followup', ['id' => $report->id]) }}" method="POST" enctype="multipart/form-data" class="mt-8 pt-8 border-t border-slate-100 space-y-4 bg-white sticky bottom-0 z-10">
                                    @csrf
                                    <textarea name="pesan" rows="4" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:bg-white font-medium text-slate-800" placeholder="Berikan tindak lanjut..." required></textarea>
                                    <div class="flex flex-col md:flex-row gap-4 items-center">
                                        <input type="file" name="file" class="flex-1 w-full rounded-xl border border-dashed border-slate-300 p-2 text-xs">
                                        <button type="submit" class="w-full md:w-14 h-14 bg-red-600 text-white font-extrabold rounded-2xl shadow-lg shadow-red-100 flex items-center justify-center transition-all hover:scale-105 active:scale-95">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div x-show="currentTab == 'komentar'" x-transition class="flex flex-col h-full">
                                <div class="flex-1 overflow-y-auto custom-scrollbar max-h-[450px] pr-4">
                                    <div class="space-y-6">
                                        @forelse ($comments as $item)
                                            <div class="group" x-data="{ editing: false, pesan: '{{ addslashes($item->pesan) }}' }">
                                                <div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-sm relative transition-all group-hover:shadow-md">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-500 text-xs shadow-inner">{{ substr($item->user->name, 0, 1) }}</div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between">
                                                                <h4 class="text-sm font-black text-slate-800">{{ $item->user->name }}</h4>
                                                                <div class="flex items-center gap-3">
                                                                    <span class="text-[10px] font-bold text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                                                                    <div class="flex items-center gap-2">
                                                                        @if($authUser->role === 'superadmin' || $authUser->id_user === $item->user_id)
                                                                            <button @click="editing = !editing" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-blue-600 transition-all"><i class="fas fa-edit text-[10px]"></i></button>
                                                                            <button onclick="openDeleteModal('{{ route('superadmin.reports.comment.delete', $item->id) }}')" class="opacity-0 group-hover:opacity-100 text-red-300 hover:text-red-700 transition-all"><i class="fas fa-trash-alt text-[10px]"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div x-show="!editing" class="pl-0 md:pl-14">
                                                        <p class="text-slate-600 text-sm leading-relaxed">{{ $item->pesan }}</p>
                                                        @if($item->file) <a href="{{ asset(ltrim($item->file, '/')) }}" target="_blank" class="mt-3 text-xs font-bold text-red-600 inline-flex items-center gap-2 hover:underline"><i class="fas fa-paperclip"></i> Lihat Media</a> @endif
                                                    </div>

                                                    <div x-show="editing" x-cloak class="mt-2 pl-0 md:pl-14">
                                                        <form action="{{ route('superadmin.reports.comment.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                            @csrf @method('PUT')
                                                            <textarea name="pesan" x-model="pesan" class="w-full rounded-2xl border-slate-200 text-sm focus:ring-red-600 p-3" rows="2"></textarea>
                                                            <div class="flex justify-between items-center">
                                                                <input type="file" name="file" class="text-[10px] text-slate-400">
                                                                <div class="flex gap-2">
                                                                    <button type="button" @click="editing = false" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-black rounded-xl uppercase tracking-wider">Batal</button>
                                                                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-[10px] font-black rounded-xl uppercase tracking-wider shadow-lg shadow-red-100">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-center text-slate-400 py-12 font-bold">Belum ada diskusi</p>
                                        @endforelse
                                    </div>
                                </div>
                                <form action="{{ route('superadmin.reports.comment', ['id' => $report->id]) }}" method="POST" enctype="multipart/form-data" class="mt-8 pt-8 border-t border-slate-100 flex items-center gap-4 bg-white sticky bottom-0 z-10">
                                    @csrf
                                    <textarea name="pesan" rows="1" class="flex-1 rounded-2xl border-slate-200 bg-slate-50 p-4 min-h-[56px] focus:ring-red-600 focus:border-red-600 focus:bg-white transition-all text-sm font-medium text-slate-700" placeholder="Berikan komentar..." required></textarea>
                                    <button type="submit" class="w-14 h-14 rounded-2xl bg-red-600 text-white flex items-center justify-center shadow-lg shadow-red-200 hover:bg-red-700 hover:shadow-red-300 transition-all hover:scale-105 active:scale-95 group"><i class="fas fa-paper-plane text-lg group-hover:rotate-12 transition-transform"></i></button>
                                </form>
                            </div>

                            <div x-show="currentTab == 'lokasi'" x-transition class="space-y-6">
                                @if ($report->lokasi && $report->latitude && $report->longitude)
                                    <div id="map" class="w-full h-80 rounded-3xl shadow-lg border-4 border-white overflow-hidden"></div>
                                @else
                                    <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200"><i class="fas fa-map-marked text-4xl text-slate-200 mb-4"></i><p class="text-slate-400 font-bold">Data lokasi spasial tidak tersedia</p></div>
                                @endif
                            </div>

                            <div x-show="currentTab == 'lampiran'" x-transition class="space-y-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                     @if (!empty($report->file) && is_array($report->file))
                                        @foreach ($report->file as $index => $file)
                                            <div class="relative group aspect-square rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                                 @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif']))
                                                    <img src="{{ asset(ltrim($file, '/')) }}" class="w-full h-full object-cover">
                                                 @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fas fa-file-alt text-4xl"></i></div>
                                                 @endif
                                                 <div class="absolute inset-0 bg-red-900/60 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center p-4">
                                                     <p class="text-[10px] text-white font-black uppercase mb-3">{{ pathinfo($file, PATHINFO_EXTENSION) }}</p>
                                                     <div class="flex gap-2">
                                                        <a href="{{ asset(ltrim($file, '/')) }}" target="_blank" class="w-10 h-10 rounded-full bg-white text-slate-800 flex items-center justify-center"><i class="fas fa-eye"></i></a>
                                                        <form action="{{ route('superadmin.reports.file.delete', [$report->id, $index]) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center" onclick="return confirm('Hapus lampiran ini?')"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                     </div>
                                                 </div>
                                            </div>
                                        @endforeach
                                     @endif
                                </div>
                                <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="mt-8 p-6 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row gap-4">
                                    @csrf @method('PUT')
                                    <input type="file" name="file[]" multiple class="flex-1 rounded-xl border-slate-200 bg-white p-2 text-xs">
                                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-black rounded-xl">Unggah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="flex flex-col gap-8 sticky-column">
                    <!-- Informas Pelapor & Disposisi -->
                    <div class="glass-card rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white flex-1 flex flex-col">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Informasi Pelapor</h3>
                        <div class="flex items-center gap-5 mb-8">
                            <div class="relative">
                                @php
                                    $userPhoto = asset('images/avatar.jpg');
                                    if(!$report->is_anonim && $report->pelapor) {
                                        if($report->pelapor->foto) { $userPhoto = asset(ltrim($report->pelapor->foto, '/')); }
                                        elseif($report->pelapor->avatar) { $userPhoto = $report->pelapor->avatar; }
                                    }
                                @endphp
                                <div class="w-16 h-16 rounded-[1.25rem] overflow-hidden border-2 border-white shadow-lg">
                                    <img src="{{ $userPhoto }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-green-500 border-4 border-white"></div>
                            </div>
                            <div>
                                <h4 class="text-lg font-extrabold text-slate-800 leading-tight">{{ $report->is_anonim ? 'Anonim' : $report->pelapor->name ?? 'User Tak Terdaftar' }}</h4>
                                <p class="flex items-center gap-1.5 mt-1 text-slate-400 text-[11px] font-bold"><i class="fas fa-globe-asia"></i> Pelaporan Warga</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4 text-xs mb-8">
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-white/50">
                                <span class="font-black text-slate-400 uppercase">Waktu Masuk</span>
                                <span class="font-extrabold text-slate-800">{{ $report->created_at->isoFormat('D MMM YYYY, HH:mm') }}</span>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-white/50">
                                    <span class="font-black text-slate-400 uppercase">Wilayah</span>
                                    <div class="flex items-center gap-2"><span class="font-extrabold text-slate-800">{{ Str::limit($report->wilayah->nama, 15) }}</span><button @click="open = true" class="text-red-500 hover:scale-110 transition-transform"><i class="fas fa-edit"></i></button></div>
                                </div>
                                <div x-show="open" @click.away="open = false" class="absolute top-full left-0 w-full mt-2 p-4 bg-white rounded-2xl shadow-2xl border z-20" x-cloak x-transition>
                                    <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <select name="wilayah_id" class="w-full rounded-xl border-slate-200 mb-3 text-xs" onchange="this.form.submit()">
                                            @foreach ($wilayahList as $wil)<option value="{{ $wil->id }}" @selected($report->wilayah_id == $wil->id)>{{ $wil->nama }}</option>@endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-white/50">
                                <span class="font-black text-slate-400 uppercase">Popularitas</span>
                                <span class="font-extrabold text-red-600"><i class="fas fa-eye mr-1"></i> {{ number_format($report->views) }} Views</span>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                                <span class="font-black text-indigo-400 uppercase">Interaksi</span>
                                <div class="flex items-center gap-3"><span class="font-extrabold text-blue-600"><i class="fas fa-thumbs-up mr-1"></i> {{ $report->likes }}</span><span class="font-extrabold text-rose-600"><i class="fas fa-thumbs-down mr-1"></i> {{ $report->dislikes }}</span></div>
                            </div>
                        </div>

                        <!-- Section Disposisi (Moved here) -->
                        <div class="pt-6 border-t border-slate-100" x-data="{ openDis: false, selectedAdmin: '{{ $report->admin_id }}', selectedKategori: '{{ $report->kategori_id }}', kategoriList: [ @foreach ($kategoriList as $k) { id: '{{ $k->id }}', nama: '{{ $k->nama }}', admin_id: '{{ $k->admin_id }}' }, @endforeach ], get filteredKategori() { return this.kategoriList.filter(k => k.admin_id == this.selectedAdmin); } }">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.1em]">Disposisi OPD Pelaksana</h3>
                                <button @click="openDis = true" class="text-red-600 hover:text-red-700 transition-colors">
                                    <i class="fas fa-user-edit text-sm"></i>
                                </button>
                            </div>
                            @if ($report->admin)
                                <div class="bg-red-50/50 border border-red-100/50 rounded-2xl p-4 group relative overflow-hidden">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-black shadow-sm">{{ substr($report->admin->name, 0, 1) }}</div>
                                        <div>
                                            <h4 class="text-xs font-black text-slate-800 leading-none">{{ $report->admin->name }}</h4>
                                            <p class="text-[10px] text-slate-400 font-bold mt-1.5 uppercase tracking-tighter">{{ $report->kategori->nama }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button @click="openDis = true" class="w-full bg-slate-50 text-slate-400 border border-slate-200 border-dashed rounded-2xl p-4 font-bold text-[10px] flex items-center justify-center gap-2 hover:bg-slate-100 transition-all uppercase tracking-widest leading-none py-6">
                                    <i class="fas fa-user-plus text-lg"></i> BELUM DIDISPOSISIKAN
                                </button>
                            @endif

                            <!-- Modal Disposisi -->
                            <div x-show="openDis" x-cloak x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
                                <div @click.away="openDis = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-md shadow-2xl relative border border-white">
                                    <div class="absolute top-0 right-0 p-8"><button @click="openDis = false" class="text-slate-300 hover:text-red-600 transition-colors"><i class="fas fa-times text-xl"></i></button></div>
                                    <h3 class="text-2xl font-black text-slate-800 mb-2">Assign Petugas</h3>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-8">Tentukan admin penanggung jawab</p>
                                    <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST" class="space-y-6">
                                        @csrf @method('PUT')
                                        <div class="space-y-6">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Admin OPD</label>
                                                <select x-model="selectedAdmin" name="admin_id" class="w-full rounded-[1.25rem] border-slate-100 bg-slate-50 p-4 font-bold text-slate-700 outline-none focus:ring-4 focus:ring-red-50 transition-all" @change="if (filteredKategori.length > 0) { selectedKategori = filteredKategori[0].id; } else { selectedKategori = ''; }">
                                                    <option value="">-- Pilih Admin --</option>
                                                    @foreach ($admins as $admin)<option value="{{ $admin->id_user }}">{{ $admin->name }}</option>@endforeach
                                                </select>
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Sub-Kategori Layanan</label>
                                                <select x-model="selectedKategori" name="kategori_id" class="w-full rounded-[1.25rem] border-slate-100 bg-slate-50 p-4 font-bold text-slate-700 outline-none focus:ring-4 focus:ring-red-50 transition-all" :disabled="!selectedAdmin">
                                                    <template x-for="kategori in filteredKategori" :key="kategori.id"><option :value="kategori.id" x-text="kategori.nama"></option></template>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pt-4 flex gap-4">
                                            <button type="button" @click="openDis = false" class="flex-1 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl uppercase tracking-widest text-[10px]">Batal</button>
                                            <button type="submit" class="flex-1 py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-200 uppercase tracking-widest text-[10px] hover:scale-105 transition-all">Update Disposisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Analysis Card (Restyled to White) -->
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
                        <div class="relative z-10 space-y-8">
                            <div>
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> Analisis Sistem AI
                                </h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center justify-between">
                                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Tingkat Urgensi</span>
                                        <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase shadow-sm {{ $pColor }}">{{ $priority }}</span>
                                    </div>
                                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center justify-between">
                                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Sentimen Pelaporan</span>
                                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-xl border border-slate-200 shadow-sm {{ $sColor }}">
                                            <i class="fas {{ $sIcon }} text-sm"></i>
                                            <span class="text-[10px] font-black uppercase">{{ $sentiment }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="imgModal" class="fixed inset-0 bg-black/90 backdrop-blur-md hidden z-[9999] flex items-center justify-center p-4">
        <span class="absolute top-6 right-6 text-white text-4xl cursor-pointer hover:scale-110 transition-transform" onclick="closeImgModal()">&times;</span>
        <img id="modalImage" class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl">
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-[9999] flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] p-8 w-full max-w-sm shadow-2xl text-center">
            <div class="w-20 h-20 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-6 text-3xl"><i class="fas fa-trash-alt"></i></div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Item?</h3>
            <p class="text-sm text-slate-400 mb-8">Tindakan ini tidak dapat dibatalkan.</p>
            <form id="deleteForm" method="POST" class="flex gap-4">
                @csrf @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3 bg-slate-100 text-slate-500 font-bold rounded-xl whitespace-nowrap">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-black rounded-xl whitespace-nowrap">Hapus</button>
            </form>
        </div>
    </div>
@endsection

@section('include-js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        let map;
        function initMap() {
            const lat = {{ $report->latitude ?? 0 }};
            const lng = {{ $report->longitude ?? 0 }};
            const mapElement = document.getElementById('map');
            
            if (lat && lng && mapElement && !map) {
                map = L.map(mapElement).setView([lat, lng], 17);
                // Voyager Street Theme (Cleaner)
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);
                L.marker([lat, lng]).addTo(map);
            }
            
            if (map) {
                setTimeout(() => map.invalidateSize(), 100);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            initMap();
            
            // Re-invalidate size when tab changes to lokasi
            window.addEventListener('tab-changed', (e) => {
                if (e.detail.tab === 'lokasi') {
                    initMap();
                }
            });
        });

        function openDeleteModal(url) { document.getElementById('deleteForm').action = url; document.getElementById('deleteModal').classList.remove('hidden'); }
        function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); }
        function openImgModal(src) { document.getElementById('modalImage').src = src; document.getElementById('imgModal').classList.remove('hidden'); }
        function closeImgModal() { document.getElementById('imgModal').classList.add('hidden'); }

        NProgress.configure({ showSpinner: false });
        document.addEventListener("click", e => { const l = e.target.closest("a"); if (l && l.href && l.origin === window.location.origin) NProgress.start(); });
        document.addEventListener("submit", () => NProgress.start());
        window.addEventListener("pageshow", () => NProgress.done());
    </script>
@endsection
