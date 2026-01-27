@extends('superadmin.layouts.app')

@section('title', 'Kelola Admin Kategori')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-2xl font-extrabold text-gray-800">
            Kelola Admin Kategori
            </h2>
        </div>

        {{-- Flash Messages (Disesuaikan dengan style Kelola User) --}}
        @if (session('success'))
            <div id="flash-message-success" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 shadow transition-opacity duration-500 flex items-center justify-between">
                <p class="font-medium flex items-center"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
                <button type="button" class="text-green-800 hover:text-green-900 focus:outline-none close-alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @elseif(session('error'))
            <div id="flash-message-error" class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 shadow transition-opacity duration-500 flex items-center justify-between">
                <p class="font-medium flex items-center"><i class="fas fa-times-circle mr-2"></i> {{ session('error') }}</p>
                <button type="button" class="text-red-800 hover:text-red-900 focus:outline-none close-alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Konten Utama (Mobile & Desktop) --}}
        @if($admins->isEmpty())
            <div class="text-center py-10 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 shadow-lg">
                <i class="fas fa-info-circle text-2xl mb-3 text-gray-400"></i>
                <p class="font-semibold text-lg">Tidak ada admin tersedia untuk dikelola kategorinya.</p>
            </div>
        @else
            <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6">
                
                {{-- Mobile View (Card List) --}}
                <div class="md:hidden space-y-4">
                    @foreach($admins as $admin)
                        <div class="bg-white p-4 rounded-xl shadow-lg border-l-4 border-red-500"
                            style="background: linear-gradient(90deg, #fff7f7 0%, #ffe9ec 100%);">
                            
                            <h5 class="font-bold text-lg text-red-700 mb-2 flex items-center">
                                <i class="fas fa-user-tie mr-2"></i> {{ $admin->name }}
                            </h5>

                            <div class="mb-3 border-t pt-2 border-red-200">
                                <small class="text-gray-600 font-semibold block mb-1">Kategori Saat Ini:</small>
                                @if($admin->kategori->isNotEmpty())
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($admin->kategori as $k)
                                            <span class="px-3 py-1 text-white text-xs bg-red-600 rounded-full shadow-md font-medium">
                                                {{ $k->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="italic text-gray-500 text-sm">Belum ada kategori</p>
                                @endif
                            </div>

                            {{-- Tombol Atur Kategori Mobile --}}
                            <button class="w-full px-4 py-2 mt-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-md toggle-form-btn"
                                data-target="#form-mobile-{{ $admin->id_user }}">
                                <i class="fas fa-pencil-alt mr-1"></i> Atur Kategori
                            </button>

                            {{-- Form Atur Kategori Mobile --}}
                            <div id="form-mobile-{{ $admin->id_user }}" class="kategori-form-tail mt-4 hidden">
                                <form method="POST" action="{{ route('superadmin.kategori-admin.update', $admin->id_user) }}">
                                    @csrf
                                    @method('PUT')
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kategori:</label>
                                    
                                    <select name="kategori_ids[]" multiple class="w-full kategori-select" style="width: 100%;">
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" 
                                                {{ $admin->kategori->contains('id', $kategori->id) ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-2 px-4 rounded-full mt-3 hover:bg-red-700 transition shadow-lg text-sm">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop View (Table) --}}
                <div class="hidden md:block">
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">
                        <table class="min-w-full table-auto text-sm text-gray-700">
                            <thead class="bg-red-600 text-white text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="p-3 text-center font-bold w-[5%] rounded-tl-xl">No</th>
                                    <th class="p-3 text-left font-bold w-[25%]">Admin OPD</th>
                                    <th class="p-3 text-left font-bold w-[45%]">Kategori Saat Ini</th>
                                    <th class="p-3 text-center font-bold w-[25%] rounded-tr-xl">Atur Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($admins as $index => $admin)
                                    <tr class="hover:bg-red-50 transition-all duration-200 align-top">
                                        <td class="p-3 text-center">
                                            {{ $admins->firstItem() + $index }}
                                        </td>
                                        <td class="p-3 font-semibold text-sm break-words" style="max-width: 250px;">
                                            {{ $admin->name }}
                                        </td>
                                        <td class="p-3">
                                            @if($admin->kategori->isNotEmpty())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($admin->kategori as $k)
                                                        <span class="px-3 py-1 text-white text-xs bg-red-600 rounded-full shadow-md font-medium">
                                                            {{ $k->nama }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <em class="text-gray-500">Belum ada kategori</em>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center">
                                            {{-- Tombol Atur Kategori Desktop --}}
                                            <button class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-md toggle-form-btn"
                                                data-target="#form-desktop-{{ $admin->id_user }}">
                                                <i class="fas fa-cog mr-1"></i> Atur
                                            </button>

                                            {{-- Form Atur Kategori Desktop --}}
                                            <div id="form-desktop-{{ $admin->id_user }}" class="kategori-form-tail mt-3 hidden text-left">
                                                <form method="POST"
                                                    action="{{ route('superadmin.kategori-admin.update', $admin->id_user) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kategori:</label>
                                                    <select name="kategori_ids[]" multiple class="w-full kategori-select" style="width: 100%;">
                                                        @foreach($kategoris as $kategori)
                                                            <option value="{{ $kategori->id }}" 
                                                                {{ $admin->kategori->contains('id', $kategori->id) ? 'selected' : '' }}>
                                                                {{ $kategori->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                    <button type="submit" class="bg-green-600 text-white font-bold py-1.5 px-3 rounded-lg mt-2 text-sm hover:bg-green-700 transition shadow-md">
                                                        Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination Links (Disesuaikan dengan style Kelola User) --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                    <p class="text-gray-600 mb-2 md:mb-0">
                        Menampilkan <span class="font-bold text-gray-800">{{ $admins->firstItem() }}</span> sampai <span
                            class="font-bold text-gray-800">{{ $admins->lastItem() }}</span> dari total <span
                            class="font-bold text-gray-800">{{ $admins->total() }}</span> admin.
                    </p>
                    <div>
                        {{ $admins->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    {{-- Dependencies --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <style>
        /* Custom Tailwind-like style for the form container */
        .kategori-form-tail {
            background: #f0f8ff; /* Light blue */
            border-left: 4px solid #3b82f6; /* Blue-500 */
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        /* Select2 compatibility adjustments */
        .select2-container {
            /* Pastikan select2 mengambil 100% lebar dari parentnya */
            width: 100% !important; 
        }

        .select2-container--default .select2-selection--multiple {
            border-color: #d1d5db !important; /* gray-300 */
            border-radius: 0.5rem !important; /* rounded-lg */
            padding: 0.25rem 0.5rem !important;
            min-height: 40px !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6 !important; /* blue-500 */
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.5) !important;
        }

        /* Adjusting table row vertical alignment (for desktop table) */
        .align-top td {
            vertical-align: top !important;
        }
    </style>

    <script>
        $(document).ready(function () {
            // Initialize Select2 on all elements with class .kategori-select
            $('.kategori-select').select2({
                placeholder: 'Pilih kategori (bisa lebih dari satu)',
                allowClear: true
            });

            // Toggle form visibility logic
            $('.toggle-form-btn').on('click', function () {
                const button = $(this);
                const targetId = button.data('target');
                const targetElement = $(targetId);
                
                // Slide toggle the form
                targetElement.slideToggle(200);
                
                // Toggle the 'hidden' class and change button text/style
                if (targetElement.hasClass('hidden')) {
                    targetElement.removeClass('hidden');
                    button.html('<i class="fas fa-times mr-1"></i> Batalkan');
                    button.removeClass('bg-blue-600 hover:bg-blue-700').addClass('bg-gray-500 hover:bg-gray-600');
                } else {
                    targetElement.addClass('hidden');
                    // Determine if it's mobile or desktop button to restore correct text
                    const isMobile = button.closest('.md\\:hidden').length > 0;
                    if (isMobile) {
                        button.html('<i class="fas fa-pencil-alt mr-1"></i> Atur Kategori');
                    } else {
                        button.html('<i class="fas fa-cog mr-1"></i> Atur');
                    }
                    button.removeClass('bg-gray-500 hover:bg-gray-600').addClass('bg-blue-600 hover:bg-blue-700');
                }

                // Re-initialize Select2 if the form was just shown (due to potential rendering issues when hidden)
                if (!targetElement.hasClass('hidden')) {
                    targetElement.find('.kategori-select').select2({
                        placeholder: 'Pilih kategori (bisa lebih dari satu)',
                        allowClear: true
                    });
                }
            });

            // Flash message auto-hide/close logic
            const successAlert = $('#flash-message-success');
            const errorAlert = $('#flash-message-error');

            if (successAlert.length || errorAlert.length) {
                setTimeout(() => {
                    successAlert.fadeOut(500);
                    errorAlert.fadeOut(500);
                }, 4000);
            }

            $('.close-alert').on('click', function() {
                $(this).closest('div').fadeOut(300);
            });
        });
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