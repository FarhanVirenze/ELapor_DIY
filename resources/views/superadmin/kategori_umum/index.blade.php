@extends('superadmin.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header + Tombol Tambah (Sejajar) --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-extrabold text-gray-800">
               Kelola Kategori
            </h2>

            {{-- Tombol Tambah Kategori --}}
            <button type="button"
                class="w-full sm:w-auto px-4 py-2 text-white bg-red-600 rounded-xl shadow hover:bg-red-700 transition font-semibold"
                data-toggle="modal" data-target="#addKategoriModal">
                <i class="fas fa-plus mr-1"></i> Tambah Kategori
            </button>
        </div>
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 md:gap-6">

        {{-- Filter Tipe --}}
        <form method="GET" id="filter-tipe-form" class="w-full md:w-auto md:flex-shrink-0">
            {{-- Pertahankan parameter search jika ada saat filtering --}}
            @if (request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div class="flex items-center gap-2">
                <label for="tipe" class="text-sm font-bold text-gray-700 whitespace-nowrap mt-2">Filter
                    Tipe:</label>
                <select name="tipe" id="tipe"
                    class="w-full md:w-48 border border-gray-300 rounded-xl px-3 py-2 h-10 shadow-sm bg-white hover:border-red-500 focus:ring-2 focus:ring-red-400 focus:border-red-500 transition cursor-pointer"
                    onchange="document.getElementById('filter-tipe-form').submit()">
                    <option value="">-- Semua Tipe --</option>
                    <option value="non_wbs_admin" {{ request('tipe') === 'non_wbs_admin' ? 'selected' : '' }}>Non WBS</option>
                    <option value="wbs_admin" {{ request('tipe') === 'wbs_admin' ? 'selected' : '' }}>WBS Admin</option>
                </select>
            </div>
        </form>

        {{-- Search --}}
        <form action="{{ route('superadmin.kelola-kategori.index') }}" method="GET" class="relative w-full md:flex-grow">
            {{-- Pertahankan parameter tipe jika ada saat searching --}}
            @if (request('tipe'))
                <input type="hidden" name="tipe" value="{{ request('tipe') }}">
            @endif
            <input type="text" name="search"
                class="w-full border border-gray-300 rounded-xl pl-4 pr-24 py-2 h-10 shadow-inner focus:ring-2 focus:ring-red-400 focus:border-red-500 transition"
                placeholder="Cari kategori..." value="{{ request('search') }}">

            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-red-600 transition">
                <i class="fas fa-search"></i>
            </button>

            @if (request('search') || request('tipe'))
                <a href="{{ route('superadmin.kelola-kategori.index', ['tipe' => request('tipe')]) }}"
                    class="absolute right-10 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-xs font-semibold whitespace-nowrap">
                    Reset
                </a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div id="flash-message" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 shadow">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div id="flash-message" class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 shadow">
            {{ session('error') }}
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    // Tambahkan efek fade out
                    flashMessage.style.transition = "opacity 0.5s ease-out";
                    flashMessage.style.opacity = '0';
                    // Setelah fade out, hapus elemen
                    setTimeout(() => flashMessage.remove(), 500);
                }, 3000); // 3000ms = 3 detik
            }
        });
    </script>
    
    <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6">
        @if($kategori->isEmpty())
            <div class="text-center py-10 rounded-lg bg-red-50 text-red-800 border border-red-200">
                <i class="fas fa-info-circle text-xl mb-2"></i>
                <p class="font-semibold text-lg">Tidak ada kategori ditemukan.</p>
                <p class="text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
            </div>
        @else
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 shadow-md scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <table class="min-w-full table-auto text-sm text-gray-700">
                    <thead class="bg-red-600 text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-3 text-center font-bold rounded-tl-lg w-[5%]">No</th>
                            <th class="p-3 text-left font-bold w-[50%]">Nama Kategori</th>
                            <th class="p-3 text-center font-bold w-[15%]">Tipe</th>
                            <th class="p-3 text-center font-bold rounded-tr-lg w-[30%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($kategori as $index => $kat)
                            <tr class="hover:bg-red-50 transition-all duration-200">
                                <td class="p-3 text-center">
                                    {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}
                                </td>
                                <td class="p-3 font-semibold break-words max-w-xs">{{ $kat->nama }}</td>
                                <td class="p-3 text-center">
                                    @if($kat->tipe === 'wbs_admin')
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold rounded-full 
                                            bg-red-100 text-red-700 border border-red-300 shadow-sm">
                                            WBS Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold rounded-full 
                                            bg-blue-100 text-blue-700 border border-blue-300 shadow-sm">
                                            Non WBS
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-center">
                                    <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                        <button type="button"
                                            class="w-full sm:w-auto px-3 py-1 text-xs bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white font-medium shadow transition duration-150"
                                            data-toggle="modal" data-target="#editKategoriModal"
                                            data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}" data-tipe="{{ $kat->tipe }}">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>

                                        <button type="button"
                                            class="w-full sm:w-auto px-3 py-1 text-xs bg-red-600 hover:bg-red-700 rounded-lg text-white font-medium shadow transition duration-150"
                                            data-toggle="modal" data-target="#deleteKategoriModal"
                                            data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                <p class="text-gray-600 mb-2 md:mb-0">
                    Menampilkan <span class="font-bold text-gray-800">{{ $kategori->firstItem() }}</span> sampai <span
                        class="font-bold text-gray-800">{{ $kategori->lastItem() }}</span> dari total <span
                        class="font-bold text-gray-800">{{ $kategori->total() }}</span> kategori.
                </p>
                <div>
                    {{ $kategori->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <form action="{{ route('superadmin.kelola-kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                </div>
                <div class="modal-body space-y-3">
                    <div>
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div>
                        <label for="tipe" class="form-label">Tipe Kategori</label>
                        <select name="tipe" class="form-control" required>
                            <option value="non_wbs_admin">Non WBS</option>
                            <option value="wbs_admin">WBS Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <form method="POST" id="editKategoriForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNama">Nama Kategori</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editTipe">Tipe Kategori</label>
                        <select name="tipe" id="editTipe" class="form-control" required>
                            <option value="wbs_admin">WBS Admin</option>
                            <option value="non_wbs_admin">Non WBS</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteKategoriModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <form method="POST" id="deleteKategoriForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Kategori</h5>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah Anda yakin ingin menghapus kategori 
                        <strong id="kategoriNama"></strong>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modal Edit
    $('#editKategoriModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const nama = button.data('nama');
        const tipe = button.data('tipe');

        const modal = $(this);
        modal.find('#editKategoriForm').attr('action', `/superadmin/kelola-kategori/${id}`);
        modal.find('#editNama').val(nama);
        modal.find('#editTipe').val(tipe);
    });

    // Modal Hapus
    $('#deleteKategoriModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const nama = button.data('nama');

        const modal = $(this);
        modal.find('#deleteKategoriForm').attr('action', `/superadmin/kelola-kategori/${id}`);
        modal.find('#kategoriNama').text(nama);
    });

    // Auto-hide alert
    setTimeout(() => {
        $('#alert-success').fadeOut('slow');
        $('#alert-error').fadeOut('slow');
    }, 3000);
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
