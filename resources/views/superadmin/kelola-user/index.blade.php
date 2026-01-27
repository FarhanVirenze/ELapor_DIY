@extends('superadmin.layouts.app')

@section('title', 'Kelola User')

@section('content')
    <div class="container mt-6">

        {{-- Header + Tambah User --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-extrabold text-gray-800">Kelola User</h2>
            <button type="button" class="px-4 py-2 text-white bg-red-600 rounded-xl shadow font-semibold hover:bg-red-700 transition"
                data-toggle="modal" data-target="#createUserModal">
                + Tambah User
            </button>
        </div>

        {{-- Filter + Search Section (Rapi dan Sejajar) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 md:gap-6">

            {{-- Filter Role --}}
            <form method="GET" id="filter-role-form" class="w-full md:w-auto md:flex-shrink-0">
                <div class="flex items-center gap-2">
                    <label for="role" class="text-sm font-bold text-gray-700 whitespace-nowrap mt-2">Filter
                        Role:</label>
                    <select name="role" id="role"
                        class="w-full md:w-48 border border-gray-300 rounded-xl px-3 py-2 h-10 shadow-sm bg-white hover:border-red-500 focus:ring-2 focus:ring-red-400 focus:border-red-500 transition cursor-pointer"
                        onchange="document.getElementById('filter-role-form').submit()">
                        <option value="">-- Semua --</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin
                        </option>
                    </select>
                </div>
            </form>

            {{-- Search --}}
            <form method="GET" class="relative w-full md:flex-grow">
                @if (request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <input type="text" name="search"
                    class="w-full border border-gray-300 rounded-xl pl-4 pr-24 py-2 h-10 shadow-inner focus:ring-2 focus:ring-red-400 focus:border-red-500 transition"
                    placeholder="Cari nama, email, NIK, nomor telepon..." value="{{ request('search') }}">

                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-red-600 transition">
                    <i class="fas fa-search"></i>
                </button>

                @if (request('search'))
                    <a href="{{ route('superadmin.kelola-user.index', ['role' => request('role')]) }}"
                        class="absolute right-10 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-semibold whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Flash Messages --}}
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

        {{-- Table --}}
        <div class="bg-white shadow-xl rounded-2xl p-4 md:p-6">

            @if ($users->isEmpty())
                <div class="text-center py-10 rounded-lg bg-green-50 text-green-800 border border-green-200">
                    <i class="fas fa-info-circle text-xl mb-2"></i>
                    <p class="font-semibold text-lg">Tidak ada user ditemukan.</p>
                    <p class="text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                </div>
            @else
                <div
                    class="overflow-x-auto rounded-xl border border-gray-200 shadow-md scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <table class="min-w-full table-auto text-sm text-gray-700">
                        <thead class="bg-red-600 text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="p-3 text-center font-bold rounded-tl-lg w-[5%]">No</th>
                                <th class="p-3 text-left font-bold w-[20%]">Nama</th>
                                <th class="p-3 text-left font-bold w-[20%]">Email</th>
                                <th class="p-3 text-left font-bold w-[15%]">NIK</th>
                                <th class="p-3 text-left font-bold w-[15%]">No Telepon</th>
                                <th class="p-3 text-center font-bold w-[10%]">Role</th>
                                <th class="p-3 text-center font-bold rounded-tr-lg w-[15%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($users as $index => $user)
                                <tr class="hover:bg-red-50 transition-all duration-200">
                                    <td class="p-3 text-center">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="p-3 font-semibold">{{ $user->name }}</td>
                                    <td class="p-3">{{ $user->email }}</td>
                                    <td class="p-3">{{ $user->nik ?? '-' }}</td>
                                    <td class="p-3">{{ $user->nomor_telepon ?? '-' }}</td>
                                    <td class="p-3 text-center">
                                        @php
                                            $roleColors = [
                                                'user' => 'bg-blue-600 text-white',
                                                'admin' => 'bg-yellow-600 text-white',
                                                'superadmin' => 'bg-red-600 text-white',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold shadow {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                            <button type="button"
                                                class="w-full sm:w-auto px-2 py-1 text-xs bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#editUserModal"
                                                data-id="{{ $user->id_user }}" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-nik="{{ $user->nik }}"
                                                data-phone="{{ $user->nomor_telepon }}" data-role="{{ $user->role }}">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                            <button type="button"
                                                class="w-full sm:w-auto px-2 py-1 text-xs bg-red-600 hover:bg-red-700 rounded-lg text-white font-medium shadow transition duration-150"
                                                data-toggle="modal" data-target="#deleteUserModal"
                                                data-id="{{ $user->id_user }}" data-name="{{ $user->name }}">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm">
                    <p class="text-gray-600 mb-2 md:mb-0">
                        Menampilkan <span class="font-bold text-gray-800">{{ $users->firstItem() }}</span> sampai <span
                            class="font-bold text-gray-800">{{ $users->lastItem() }}</span> dari total <span
                            class="font-bold text-gray-800">{{ $users->total() }}</span> user.
                    </p>
                    <div>
                        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <form method="POST" action="{{ route('superadmin.users.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah User Baru</h5>
                        </div>

                        <div class="modal-body">
                            <!-- Nama -->
                            <div class="form-group">
                                <label for="createName">Nama</label>
                                <input type="text" class="form-control" id="createName" name="name"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="createEmail">Email</label>
                                <input type="email" class="form-control" id="createEmail" name="email"
                                    placeholder="contoh@email.com" required>
                            </div>

                            <!-- NIK -->
                            <div class="form-group">
                                <label for="createNik">NIK</label>
                                <input type="text" class="form-control" id="createNik" name="nik"
                                    placeholder="Masukkan NIK (opsional)">
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="form-group">
                                <label for="createPhone">Nomor Telepon</label>
                                <input type="text" class="form-control" id="createPhone" name="nomor_telepon"
                                    placeholder="Masukkan nomor telepon (opsional)">
                            </div>

                            <!-- Password + Toggle -->
                            <div class="form-group position-relative">
                                <label for="createPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="createPassword" name="password"
                                        placeholder="Masukkan password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="form-group">
                                <label for="createRole">Role</label>
                                <select class="form-control" id="createRole" name="role" required>
                                    <option value="" disabled selected>Pilih role</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Tambah User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       <!-- Modal Edit -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <form method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editName">Nama</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="editNik">NIK</label>
                                <input type="text" class="form-control" id="editNik" name="nik" required>
                            </div>
                            <div class="form-group">
                                <label for="editPhone">Nomor Telepon</label>
                                <input type="text" class="form-control" id="editPhone" name="nomor_telepon" required>
                            </div>
                            <div class="form-group">
                                <label for="editRole">Role</label>
                                <select class="form-control" id="editRole" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <form method="POST" id="deleteUserForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
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
            // Modal Edit User
            $('#editUserModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id') || '';
                const name = button.data('name') || '';
                const email = button.data('email') || '';
                const nik = button.data('nik') || '';
                const phone = button.data('phone') || '';
                const role = button.data('role') || '';

                const modal = $(this);
                modal.find('form').attr('action', `/superadmin/kelola-user/${id}`);
                modal.find('#editName').val(name);
                modal.find('#editEmail').val(email);
                modal.find('#editNik').val(nik);
                modal.find('#editPhone').val(phone);
                modal.find('#editRole').val(role);
            });

            // Modal Hapus User
            $('#deleteUserModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id') || '';
                const name = button.data('name') || '';

                const modal = $(this);
                modal.find('form').attr('action', `/superadmin/kelola-user/${id}`);
                modal.find('#deleteUserName').text(name);
            });

            // Auto-hide flash messages (3 detik)
            setTimeout(() => {
                $('#alert-success').fadeOut('slow');
                $('#alert-error').fadeOut('slow');
            }, 3000);
        </script>

        <script>
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordField = document.getElementById('createPassword');
                const icon = this.querySelector('i');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
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
