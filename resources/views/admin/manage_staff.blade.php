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
            <input type="text" placeholder="Search" class="shadow appearance-none border rounded w-64 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($staff as $index => $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-50 m-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
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
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-30 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
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
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-50 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white">
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
</script>
@endpush
@endsection