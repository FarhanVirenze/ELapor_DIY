@extends('portal.layouts.appnofooter')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

    <div class="w-full max-w-screen-xl mx-auto py-16 px-3 sm:px-6 text-gray-800">
        <h1 class="text-2xl font-bold text-center mt-12 text-gray-900">
            Riwayat Aduan Wbs
        </h1>
        @if (session('success'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-lg animate__animated animate__fadeIn">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-lg animate__animated animate__shakeX">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                    <div>
                        <p class="font-bold">Kesalahan!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif



        <div class="py-12" x-data="{ view: 'table' }"> {{-- ✅ Alpine toggle view --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                @component('components.riwayat-tabs')
                <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                    {{-- ✅ Total Aduan (hanya desktop) --}}
                    <p class="text-sm text-gray-600 hidden md:block">Total: {{ $aduan->total() }} Aduan</p>

                    {{-- ✅ Toggle View Desktop --}}
                    <div class="hidden md:flex items-center rounded-full border border-red-300 overflow-hidden">
                        {{-- Table View --}}
                        <button @click="view = 'table'" :class="view === 'table' 
                                                                            ? 'bg-red-600 text-white' 
                                                                            : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 flex items-center gap-1 transition">
                            <template x-if="view === 'table'">
                                <i class="fas fa-check mr-1"></i>
                            </template>
                            <i class="fas fa-list"></i>
                        </button>

                        {{-- Card View --}}
                        <button @click="view = 'card'" :class="view === 'card' 
                                                                            ? 'bg-red-600 text-white' 
                                                                            : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 flex items-center gap-1 transition border-l border-red-300">
                            <template x-if="view === 'card'">
                                <i class="fas fa-check mr-1"></i>
                            </template>
                            <i class="fas fa-border-all"></i>
                        </button>
                    </div>
                </div>

                {{-- ✅ Desktop: Tabel --}}
                <div x-show="view === 'table'" style="display:none"
                    class="overflow-x-auto bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-red-100 hidden md:block">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gradient-to-r from-red-700 to-red-500 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">No Aduan</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama Terlapor</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($aduan as $index => $item)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $aduan->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 font-semibold text-gray-700">{{ $item->tracking_id }}</td>
                                    <td class="px-4 py-3">{{ $item->nama_terlapor }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="text-xs font-semibold px-3 py-1 rounded-full shadow-sm
                                                                                                                                                                                            @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                                                                                                                            @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                                                                                                                            @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                                                                                                                            @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                                                                                                                            @else bg-gray-200 text-gray-800 @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('user.aduan.riwayatwbs.show', $item->id) }}"
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-search"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada aduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Desktop: Card/Grid --}}
                <div x-show="view === 'card'" style="display:none" class="hidden md:grid grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($aduan as $index => $item)
                        @php
                            $defaultImage = asset('images/image.jpg');
                            $thumbnail = $defaultImage;

                            if (!empty($item->lampiran)) {
                                $files = is_array($item->lampiran) ? $item->lampiran : json_decode($item->file, true);
                                if (is_array($files)) {
                                    foreach ($files as $f) {
                                        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $thumbnail = asset($f);
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <div
                            class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">
                            {{-- Foto Thumbnail --}}
                            <div class="relative group cursor-pointer overflow-hidden rounded-t-2xl"
                                onclick="openImageModal('{{ $thumbnail }}')">
                                <img src="{{ $thumbnail }}" alt="Foto Aduan"
                                    class="w-full h-48 md:h-56 object-cover transition duration-300 group-hover:brightness-75">
                            </div>

                            {{-- Header Info --}}
                            <div
                                class="bg-gradient-to-r from-red-700 to-red-500 p-3 px-4 text-white text-xs flex justify-between items-center">
                                <div>
                                    <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                        {{ $item->tracking_id }}</span><br>
                                    <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <span
                                    class="text-[11px] font-semibold px-3 py-1 rounded-full shadow-sm
                                                                                                                    @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                                                    @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                                                    @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                                                    @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                                                    @else bg-gray-200 text-gray-800 @endif">
                                    {{ $item->status }}
                                </span>
                            </div>

                            {{-- Body Info --}}
                            <div class="bg-white text-gray-800 p-4 flex justify-between items-center">
                                <div class="font-semibold text-base text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($item->nama_terlapor, 40, '...') }}
                                </div>
                                <a href="{{ route('user.aduan.riwayatwbs.show', $item->id) }}"
                                    class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-search mr-1"></i> Lihat
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 col-span-3">Tidak ada aduan.</div>
                    @endforelse
                </div>

                {{-- ✅ Mobile: List & Card dengan Toggle --}}
                <div class="md:hidden" x-data="{ view: 'list' }">
                    {{-- ✅ Header: Toggle View Mobile --}}
                    <div class="flex items-center justify-between mb-3 px-2">
                        <p class="text-sm text-gray-600">Total: {{ $aduan->total() }} Aduan</p>
                        <div class="flex items-center rounded-full border border-red-300 overflow-hidden">
                            {{-- List View --}}
                            <button @click="view = 'list'" :class="view === 'list' 
                                                        ? 'bg-red-600 text-white' 
                                                        : 'bg-white text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-1.5 flex items-center gap-1 text-sm transition">
                                <template x-if="view === 'list'">
                                    <i class="fas fa-check mr-1"></i>
                                </template>
                                <i class="fas fa-list"></i>
                            </button>

                            {{-- Card View --}}
                            <button @click="view = 'card'" :class="view === 'card' 
                                                        ? 'bg-red-600 text-white' 
                                                        : 'bg-white text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-1.5 flex items-center gap-1 text-sm transition border-l border-red-300">
                                <template x-if="view === 'card'">
                                    <i class="fas fa-check mr-1"></i>
                                </template>
                                <i class="fas fa-border-all"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ✅ Mobile: List (WBS) --}}
                    <div x-show="view === 'list'" style="display: none" class="space-y-4 p-2">
                        @forelse ($aduan as $index => $item)
                            <div
                                class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">

                                {{-- Header --}}
                                <div
                                    class="bg-gradient-to-r from-red-700 to-red-500 p-3 px-4 text-white text-xs flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                            {{ $item->tracking_id }}</span><br>
                                        <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full shadow-sm
                                                            @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                            @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                            @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                            @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                            @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                {{-- Body --}}
                                <div class="bg-white text-gray-800 p-4">
                                    <div class="font-semibold text-sm text-gray-700 truncate">
                                        {{ $item->nama_terlapor }}
                                    </div>

                                    <div class="mt-3 flex justify-end">
                                        <a href="{{ route('user.aduan.riwayatwbs.show', $item->id) }}"
                                            class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-search mr-1"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">Tidak ada aduan.</div>
                        @endforelse
                    </div>

                    {{-- ✅ Mobile: Card/Grid (WBS) --}}
                    <div x-show="view === 'card'" style="display: none" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-2">
                        @forelse ($aduan as $index => $item)
                            @php
                                $defaultImage = asset('images/image.jpg');
                                $thumbnail = $defaultImage;

                                if (!empty($item->lampiran)) {
                                    $files = is_array($item->lampiran) ? $item->lampiran : json_decode($item->lampiran, true);
                                    if (is_array($files)) {
                                        foreach ($files as $f) {
                                            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                $thumbnail = asset($f);
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <div
                                class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">

                                {{-- Foto Thumbnail --}}
                                <div class="relative group cursor-pointer overflow-hidden rounded-t-2xl"
                                    onclick="openImageModal('{{ $thumbnail }}')">
                                    <img src="{{ $thumbnail }}" alt="Foto Aduan"
                                        class="w-full h-40 object-cover transition duration-300 group-hover:brightness-75">
                                </div>

                                {{-- Header Info --}}
                                <div
                                    class="bg-gradient-to-r from-red-700 to-red-500 p-2 px-3 text-white text-xs flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                            {{ $item->tracking_id }}</span><br>
                                        <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                    <span class="text-[11px] font-semibold px-2 py-1 rounded-full shadow-sm
                                                @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                {{-- Body Info --}}
                                <div class="bg-white text-gray-800 p-3 flex justify-between items-center">
                                    <div class="font-semibold text-sm text-gray-700 truncate">
                                        {{ $item->nama_terlapor }}
                                    </div>
                                    <a href="{{ route('user.aduan.riwayatwbs.show', $item->id) }}"
                                        class="inline-flex items-center text-xs font-semibold text-red-600 hover:text-red-800 transition-colors">
                                        <i class="fas fa-search mr-1"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 col-span-2">Tidak ada aduan.</div>
                        @endforelse
                    </div>
                </div>
                {{-- ✅ Pagination --}}
                <div class="mt-10 mb-16 lg:mt-4 lg:mb-6 px-2">
                    {{ $aduan->links() }}
                </div>
                @endcomponent
            </div>
        </div>
        @push('scripts')


            <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
            <script>
                // ⚙️ Konfigurasi default NProgress
                NProgress.configure({
                    showSpinner: false,
                    trickleSpeed: 200,
                    minimum: 0.08
                });

                // 🔹 1. Tangkap klik semua link internal
                document.addEventListener("click", function (e) {
                    const link = e.target.closest("a");
                    if (link && link.href && link.origin === window.location.origin) {
                        NProgress.start();
                        setTimeout(() => NProgress.set(0.9), 150);
                    }
                });

                // 🔹 2. Patch untuk XMLHttpRequest
                (function (open) {
                    XMLHttpRequest.prototype.open = function () {
                        NProgress.start();
                        this.addEventListener("loadend", function () {
                            NProgress.set(1.0);
                            setTimeout(() => NProgress.done(), 300);
                        });
                        open.apply(this, arguments);
                    };
                })(XMLHttpRequest.prototype.open);

                // 🔹 3. Patch untuk Fetch API
                const originalFetch = window.fetch;
                window.fetch = function () {
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
                document.addEventListener("submit", function (e) {
                    const form = e.target;
                    if (form.tagName === "FORM") {
                        NProgress.start();
                        setTimeout(() => NProgress.set(0.9), 150);
                    }
                }, true);
            </script>

        @endpush
@endsection