@extends('layouts.app')

@section('title', 'Manajemen Staff')

@section('header-title', 'Manajemen Staff')

@section('content')
<div class="h-full w-full bg-white rounded-lg shadow">
    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Manajemen Staff</h3>
            <button type="button" onclick="openAddModal()" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                Tambah Staff
            </button>
        </div>

        <div class="mb-4">
            <input type="text" id="staffSearchInput" placeholder="Search" class="shadow appearance-none border rounded w-64 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody" class="bg-white divide-y divide-gray-200">
                    @foreach($staff as $index => $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openDetailModal({{ $member->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                </svg>
                            </button>
                            <button onclick="openEditModal({{ $member->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal({{ $member->id }})" class="text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
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
<div id="addModal" class="fixed inset-0 bg-gray-600/50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-50 m-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Tambah Staff</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" id="username" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomer Telepon</label>
                        <input type="text" name="phone" id="phone"
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date"
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                              class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-teal-500 hover:bg-teal-600 py-2 rounded-md text-white font-semibold">
                        Tambahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600/50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-50 mx-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Staff</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="edit_username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" id="edit_username" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" required
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="edit_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomer Telepon</label>
                        <input type="text" name="phone" id="edit_phone"
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="edit_birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="edit_birth_date"
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                    <div>
                        <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (optional)</label>
                        <input type="password" name="password" id="edit_password"
                               class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900">
                    </div>
                </div>
                <div>
                    <label for="edit_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" id="edit_address" rows="3"
                              class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-teal-500 hover:bg-teal-600 py-2 rounded-md text-white font-semibold">
                        Update Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600/50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-70 mx-auto p-5 w-[500px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Hapus Staff?</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-gray-500 mb-4">Menghapus Staff akan menghilangkannya dari toko Anda. Yakin ingin melanjutkan?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()"
                            class="border border-gray-400 text-gray-700 px-4 py-2 rounded-md">Tidak Jadi</button>
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Iya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Staff Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-gray-600/50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-50 m-auto p-5 w-[600px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Detail Staff</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div id="detail_name" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div id="detail_username" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div id="detail_email" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomer Telepon</label>
                        <div id="detail_phone" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <div id="detail_birth_date" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <div id="detail_role" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900 capitalize"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <div id="detail_address" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900" style="min-height: 84px;"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                        <div id="detail_created_at" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                        <div id="detail_updated_at" class="w-full bg-gray-100 rounded-md py-2 px-3 text-gray-900"></div>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="button" onclick="closeDetailModal()"
                            class="w-full bg-gray-500 hover:bg-gray-600 py-2 rounded-md text-white font-semibold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
        
        // Fetch staff data
        fetch(`/admin/staff/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_username').value = data.username;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_phone').value = data.phone || '';
                document.getElementById('edit_birth_date').value = data.birth_date || '';
                document.getElementById('edit_address').value = data.address || '';
                document.getElementById('edit_password').value = ''; // Clear password field
            });
        
        modal.classList.remove('hidden');
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
        
        // Fetch staff data
        fetch(`/admin/staff/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detail_name').textContent = data.name || '-';
                document.getElementById('detail_username').textContent = data.username || '-';
                document.getElementById('detail_email').textContent = data.email || '-';
                document.getElementById('detail_phone').textContent = data.phone || '-';
                document.getElementById('detail_birth_date').textContent = data.birth_date ? new Date(data.birth_date).toLocaleDateString('id-ID') : '-';
                document.getElementById('detail_role').textContent = data.role || '-';
                document.getElementById('detail_address').textContent = data.address || '-';
                document.getElementById('detail_created_at').textContent = data.created_at || '-';
                document.getElementById('detail_updated_at').textContent = data.updated_at || '-';
            })
            .catch(error => {
                console.error('Error fetching staff details:', error);
                alert('Gagal mengambil detail staff');
            });
        
        modal.classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Add error handling for forms
    document.addEventListener('DOMContentLoaded', function() {
        const addForm = document.querySelector('form[action="{{ route('admin.staff.store') }}"]');
        const editForm = document.getElementById('editForm');
        const deleteForm = document.getElementById('deleteForm');

        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                }
            });
        }

        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                }
            });
        }

        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this staff member?')) {
                    e.preventDefault();
                }
            });
        }
    });

    // Staff search filter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('staffSearchInput');
        const tableBody = document.getElementById('staffTableBody');
        if (searchInput && tableBody) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(q) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
@endsection