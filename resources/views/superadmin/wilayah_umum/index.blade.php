@extends('superadmin.layouts.app')

@section('title', 'Kelola Wilayah')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header + Tombol Tambah --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-extrabold text-gray-800">
             Kelola Wilayah
            </h2>
            
            {{-- Tombol Tambah Wilayah --}}
            <button class="px-4 py-2 text-white bg-red-600 rounded-xl shadow hover:bg-red-700 transition font-semibold"
                data-toggle="modal" data-target="#addWilayahModal">
                <i class="fas fa-plus mr-1"></i> Tambah Wilayah
            </button>
        </div>

        {{-- Flash Messages (Disesuaikan dengan style sebelumnya) --}}
        @if (session('success'))
            <div id="flash-message-success" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 shadow transition-opacity duration-500 flex items-center justify-between">
                <p class="font-medium flex items-center"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
                <button type="button" class="text-green-800 hover:text-green-900 focus:outline-none close-alert" onclick="document.getElementById('flash-message-success').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @elseif(session('error'))
            <div id="flash-message-error" class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 shadow transition-opacity duration-500 flex items-center justify-between">
                <p class="font-medium flex items-center"><i class="fas fa-times-circle mr-2"></i> {{ session('error') }}</p>
                <button type="button" class="text-red-800 hover:text-red-900 focus:outline-none close-alert" onclick="document.getElementById('flash-message-error').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6">
            @if($wilayah->isEmpty())
                <div class="text-center py-10 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 shadow-lg">
                    <i class="fas fa-info-circle text-2xl mb-3 text-gray-400"></i>
                    <p class="font-semibold text-lg">Tidak ada wilayah yang ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">
                    <table class="min-w-full table-auto text-sm text-gray-700">
                        <thead class="bg-red-600 text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="p-3 text-center font-bold w-[5%] rounded-tl-xl">No</th>
                                <th class="p-3 text-left font-bold w-[65%]">Nama Wilayah</th>
                                <th class="p-3 text-center font-bold w-[30%] rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($wilayah as $index => $wil)
                                <tr class="hover:bg-red-50 transition-all duration-200">
                                    <td class="p-3 text-center align-middle">
                                        {{ ($wilayah->currentPage() - 1) * $wilayah->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="p-3 font-semibold text-gray-800">
                                        {{ $wil->nama }}
                                    </td>
                                    <td class="p-3 text-center align-middle">
                                        <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                            {{-- Tombol Edit --}}
                                            <button class="w-full sm:w-auto px-3 py-1 text-xs bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#editWilayahModal"
                                                data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <button class="w-full sm:w-auto px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#deleteWilayahModal"
                                                data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links (Disesuaikan dengan style sebelumnya) --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                    <p class="text-gray-600 mb-2 md:mb-0">
                        Menampilkan <span class="font-bold text-gray-800">{{ $wilayah->firstItem() }}</span> sampai <span
                            class="font-bold text-gray-800">{{ $wilayah->lastItem() }}</span> dari total <span
                            class="font-bold text-gray-800">{{ $wilayah->total() }}</span> wilayah.
                    </p>
                    <div>
                        {{-- Pastikan Anda menggunakan view pagination::tailwind --}}
                        {{ $wilayah->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="addWilayahModal" tabindex="-1" role="dialog" aria-labelledby="addWilayahModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-wilayah.index') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Wilayah</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Wilayah</label>
                                <input type="text" name="nama" class="form-control" required>
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
        <div class="modal fade" id="editWilayahModal" tabindex="-1" role="dialog" aria-labelledby="editWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <form method="POST" id="editWilayahForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Wilayah</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editWilayahNama">Nama Wilayah</label>
                                <input type="text" name="nama" id="editWilayahNama" class="form-control" required>
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
        <div class="modal fade" id="deleteWilayahModal" tabindex="-1" role="dialog" aria-labelledby="deleteWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <form method="POST" id="deleteWilayahForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus Wilayah</h5>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus wilayah <strong id="wilayahNama"></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal Edit
        $('#editWilayahModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#editWilayahForm').attr('action', `/superadmin/kelola-wilayah/${id}`);
            modal.find('#editWilayahNama').val(nama);
        });

        // Modal Delete
        $('#deleteWilayahModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#deleteWilayahForm').attr('action', `/superadmin/kelola-wilayah/${id}`);
            modal.find('#wilayahNama').text(nama);
        });

        // Auto-hide alert
        setTimeout(() => {
            $('#alert-success').fadeOut('slow');
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
