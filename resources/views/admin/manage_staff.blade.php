@extends('layouts.app')

@section('title', 'Manajemen Staff')

@section('header-title', 'Manajemen Staff')

@section('content')
    <div class="w-full h-full bg-white rounded-lg shadow">
        <div class="p-6">
            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 rounded border border-green-400"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 rounded border border-red-400" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 bg-red-50 rounded-md border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Terjadi kesalahan saat menambahkan staff:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="space-y-1 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Manajemen Staff</h3>
                <button type="button" onclick="openAddModal()"
                    class="px-4 py-2 text-white bg-teal-500 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Tambah Staff
                </button>
            </div>

            <div class="mb-4">
                <input type="text" id="staffSearchInput" placeholder="Search"
                    class="px-3 py-2 w-64 leading-tight text-gray-700 rounded border shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No.
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nomor
                                Telepon</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Email
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="staffTableBody" class="bg-white divide-y divide-gray-200">
                        @foreach ($staff as $index => $member)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->email }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <button onclick="openDetailModal({{ $member->id }})"
                                        class="mr-3 text-green-600 hover:text-green-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="inline" viewBox="0 0 16 16">
                                            <path
                                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                        </svg>
                                    </button>
                                    <button onclick="openEditModal({{ $member->id }})"
                                        class="mr-3 text-blue-600 hover:text-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="inline" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </button>
                                    <button onclick="openDeleteModal({{ $member->id }})"
                                        class="text-red-600 hover:text-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="inline" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div id="addModal" class="hidden overflow-y-auto fixed inset-0 w-full h-full bg-gray-600/50">
        <div class="relative top-50 m-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Tambah Staff</h3>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required minlength="2" maxlength="255"
                                value="{{ old('name') }}" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" required minlength="3"
                                maxlength="255" pattern="[a-zA-Z0-9_-]+"
                                title="Username hanya boleh berisi huruf, angka, underscore, dan dash"
                                value="{{ old('username') }}"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="phone" class="block mb-1 text-sm font-medium text-gray-700">Nomer
                                Telepon</label>
                            <input type="text" name="phone" id="phone" pattern="[0-9\+\-\(\)\s]+"
                                title="Nomor telepon hanya boleh berisi angka, +, -, (, ), dan spasi"
                                value="{{ old('phone') }}"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="birth_date" class="block mb-1 text-sm font-medium text-gray-700">Tanggal
                                Lahir</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required minlength="8"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter, harus mengandung huruf dan angka</p>
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                minlength="8" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="address" class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" id="address" rows="3" maxlength="500"
                            class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">{{ old('address') }}</textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="py-2 w-full font-semibold text-white bg-teal-500 rounded-md hover:bg-teal-600">
                            Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div id="editModal" class="hidden overflow-y-auto fixed inset-0 w-full h-full bg-gray-600/50">
        <div class="relative top-50 mx-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit Staff</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_name" class="block mb-1 text-sm font-medium text-gray-700">Nama
                                Lengkap</label>
                            <input type="text" name="name" id="edit_name" required minlength="2" maxlength="255"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="edit_username"
                                class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="edit_username" required minlength="3"
                                maxlength="255" pattern="[a-zA-Z0-9_-]+"
                                title="Username hanya boleh berisi huruf, angka, underscore, dan dash"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="edit_email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="edit_email" required maxlength="255"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="edit_phone" class="block mb-1 text-sm font-medium text-gray-700">Nomer
                                Telepon</label>
                            <input type="text" name="phone" id="edit_phone" pattern="[0-9\+\-\(\)\s]+"
                                title="Nomor telepon hanya boleh berisi angka, +, -, (, ), dan spasi"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="edit_birth_date" class="block mb-1 text-sm font-medium text-gray-700">Tanggal
                                Lahir</label>
                            <input type="date" name="birth_date" id="edit_birth_date"
                                class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                        <div>
                            <label for="edit_password" class="block mb-1 text-sm font-medium text-gray-700">Password Baru (optional)</label>
                            <input type="password" name="password" id="edit_password" minlength="8"
                                   class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter, harus mengandung huruf dan angka</p>
                        </div>
                        <div>
                            <label for="edit_password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="edit_password_confirmation" minlength="8"
                                   class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="edit_address" class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" id="edit_address" rows="3" maxlength="500"
                            class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="py-2 w-full font-semibold text-white bg-teal-500 rounded-md hover:bg-teal-600">
                            Update Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden overflow-y-auto fixed inset-0 w-full h-full bg-gray-600/50">
        <div class="relative top-70 mx-auto p-5 w-[500px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Hapus Staff?</h3>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="mb-4 text-gray-500">Menghapus Staff akan menghilangkannya dari toko Anda. Yakin ingin
                    melanjutkan?</p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 text-gray-700 rounded-md border border-gray-400">Tidak Jadi</button>
                        <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Iya,
                            Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Staff Detail Modal -->
    <div id="detailModal" class="hidden overflow-y-auto fixed inset-0 w-full h-full bg-gray-600/50">
        <div class="relative top-50 m-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Detail Staff</h3>
                    <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div id="detail_name" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"></div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                            <div id="detail_username" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"></div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                            <div id="detail_email" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"></div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Nomer Telepon</label>
                            <div id="detail_phone" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"></div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <div id="detail_birth_date" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                            <div id="detail_role"
                                class="px-3 py-2 w-full text-gray-900 capitalize bg-gray-100 rounded-md"></div>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                        <div id="detail_address" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md"
                            style="min-height: 84px;"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                            <div id="detail_created_at" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Terakhir Diupdate</label>
                            <div id="detail_updated_at" class="px-3 py-2 w-full text-gray-900 bg-gray-100 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="button" onclick="closeDetailModal()"
                            class="py-2 w-full font-semibold text-white bg-gray-500 rounded-md hover:bg-gray-600">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            form.action = `/admin/staff/${id}`;

            // Show loading state
            showLoading('Memuat data staff...', 'edit-staff');

            // Fetch staff data
            fetch(`/admin/staff/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_username').value = data.username;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_phone').value = data.phone || '';
                    document.getElementById('edit_birth_date').value = data.birth_date || '';
                    document.getElementById('edit_address').value = data.address || '';
                    document.getElementById('edit_password').value = ''; // Clear password field
                    
                    hideLoading('edit-staff');
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    hideLoading('edit-staff');
                    showError('Gagal memuat data staff: ' + error.message);
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/staff/${id}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function openDetailModal(id) {
            const modal = document.getElementById('detailModal');

            // Show loading state
            showLoading('Memuat detail staff...', 'detail-staff');

            // Fetch staff data
            fetch(`/admin/staff/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detail_name').textContent = data.name || '-';
                    document.getElementById('detail_username').textContent = data.username || '-';
                    document.getElementById('detail_email').textContent = data.email || '-';
                    document.getElementById('detail_phone').textContent = data.phone || '-';
                    document.getElementById('detail_birth_date').textContent = data.birth_date ? new Date(data
                        .birth_date).toLocaleDateString('id-ID') : '-';
                    document.getElementById('detail_role').textContent = data.role || '-';
                    document.getElementById('detail_address').textContent = data.address || '-';
                    document.getElementById('detail_created_at').textContent = data.created_at || '-';
                    document.getElementById('detail_updated_at').textContent = data.updated_at || '-';
                    
                    hideLoading('detail-staff');
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    hideLoading('detail-staff');
                    showError('Gagal mengambil detail staff: ' + error.message);
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Enhanced form validation with better error handling
        document.addEventListener('DOMContentLoaded', function() {
            const addForm = document.querySelector('form[action="{{ route('admin.staff.store') }}"]');
            const editForm = document.getElementById('editForm');
            const deleteForm = document.getElementById('deleteForm');

            // Auto-open add modal if there are validation errors
            @if ($errors->any() && old('_token'))
                openAddModal();
            @endif

            // Add form validation
            if (addForm) {
                const passwordField = addForm.querySelector('#password');
                const confirmPasswordField = addForm.querySelector('#password_confirmation');

                function validatePasswords() {
                    if (passwordField.value && confirmPasswordField.value) {
                        if (passwordField.value !== confirmPasswordField.value) {
                            confirmPasswordField.setCustomValidity('Password tidak cocok');
                            return false;
                        } else {
                            confirmPasswordField.setCustomValidity('');
                            return true;
                        }
                    }
                    return true;
                }

                passwordField.addEventListener('input', validatePasswords);
                confirmPasswordField.addEventListener('input', validatePasswords);

                addForm.addEventListener('submit', function(e) {
                    if (!validatePasswords() || !this.checkValidity()) {
                        e.preventDefault();
                        showError('Mohon periksa kembali form Anda. Pastikan semua field required telah diisi dan password konfirmasi cocok.');
                        return false;
                    }
                    
                    return handleFormSubmit(this, {
                        loadingText: 'Menambahkan staff...',
                        successMessage: 'Staff berhasil ditambahkan'
                    });
                });
            }

            // Edit form validation
            if (editForm) {
                const editPasswordField = editForm.querySelector('#edit_password');
                const editConfirmPasswordField = editForm.querySelector('#edit_password_confirmation');

                function validateEditPasswords() {
                    if (editPasswordField.value || editConfirmPasswordField.value) {
                        if (editPasswordField.value !== editConfirmPasswordField.value) {
                            editConfirmPasswordField.setCustomValidity('Password tidak cocok');
                            return false;
                        } else {
                            editConfirmPasswordField.setCustomValidity('');
                            return true;
                        }
                    }
                    return true;
                }

                editPasswordField.addEventListener('input', validateEditPasswords);
                editConfirmPasswordField.addEventListener('input', validateEditPasswords);

                editForm.addEventListener('submit', function(e) {
                    if (!validateEditPasswords() || !this.checkValidity()) {
                        e.preventDefault();
                        showError('Mohon periksa kembali form Anda. Pastikan semua field required telah diisi dan password konfirmasi cocok.');
                        return false;
                    }
                    
                    return handleFormSubmit(this, {
                        loadingText: 'Memperbarui staff...',
                        successMessage: 'Staff berhasil diperbarui'
                    });
                });
            }

            // Delete form validation
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus staff ini?')) {
                        e.preventDefault();
                        return false;
                    }
                    
                    return handleFormSubmit(this, {
                        confirmMessage: 'Apakah Anda yakin ingin menghapus staff ini?',
                        loadingText: 'Menghapus staff...',
                        successMessage: 'Staff berhasil dihapus'
                    });
                });
            }
        });

        // Staff search filter with error handling
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('staffSearchInput');
            const tableBody = document.getElementById('staffTableBody');
            
            if (searchInput && tableBody) {
                searchInput.addEventListener('input', function() {
                    try {
                        const q = this.value.toLowerCase();
                        const rows = tableBody.querySelectorAll('tr');
                        
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(q) ? '' : 'none';
                        });
                    } catch (error) {
                        showError('Terjadi kesalahan saat melakukan pencarian');
                        console.error('Search error:', error);
                    }
                });
            }
        });
    </script>
@endsection
