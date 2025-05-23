@extends('layouts.staff')

@section('header-title', 'PRODUK')

@section('content')
    <div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">Daftar Produk</h1>
            <button id="openAddProductBtn"
                class="px-8 py-3 text-lg font-semibold text-white rounded-lg shadow"
                style="background-color: #00B69B;"
                onmouseover="this.style.backgroundColor='#00997F'" onmouseout="this.style.backgroundColor='#00B69B'">
                Tambah Produk
            </button>
        </div>
        <div class="p-8 mb-10 bg-white rounded-xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold">Produk</h2>
                <div class="relative">
                    <input id="searchProductInput" type="text" placeholder="Cari produk..."
                        class="pl-10 pr-4 py-2 w-64 bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-2.5 left-3 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase">
                            <th class="px-4 py-2 text-left">No.</th>
                            <th class="px-4 py-2 text-left">Nama Produk</th>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Stok</th>
                            <th class="px-4 py-2 text-left">Harga Satuan</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @foreach($products as $index => $product)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="flex gap-2 items-center px-4 py-2">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/32' }}" class="mr-2 w-8 h-8 rounded"/>
                                <span>{{ $product->name }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $product->category ? $product->category->name : '-' }}</td>
                            <td class="px-4 py-2">{{ $product->stock }}</td>
                            <td class="px-4 py-2">Rp.{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded text-xs font-semibold {{ $product->status === 'tersedia' ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->status === 'tersedia' ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td class="flex px-4 py-2 space-x-2">
                                <button type="button" class="text-gray-600 edit-product-btn hover:text-blue-600" data-id="{{ $product->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3h3z" />
                                    </svg>
                                </button>
                                <button type="button" class="p-1 text-red-500 rounded-full transition-colors delete-product-btn hover:text-red-700 hover:bg-red-50" data-id="{{ $product->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-8 mt-10 bg-white rounded-xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold">Kategori</h2>
                <div class="flex gap-4">
                    <div class="relative">
                        <input id="searchCategoryInput" type="text" placeholder="Cari kategori..."
                            class="pl-10 pr-4 py-2 w-64 bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-2.5 left-3 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button id="openAddCategoryBtn2"
                        class="px-8 py-3 text-lg font-semibold text-white rounded-lg shadow"
                        style="background-color: #00B69B;"
                        onmouseover="this.style.backgroundColor='#00997F'" onmouseout="this.style.backgroundColor='#00B69B'">
                        Tambah Kategori
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase">
                            <th class="px-4 py-2 text-left">No.</th>
                            <th class="px-4 py-2 text-left">Nama Kategori</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <!-- Categories will be rendered here by JS -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Tambah Produk Baru -->
        <div id="addProductModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black/30">
            <form id="addProductForm" class="relative p-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl">
                <button type="button" class="flex absolute top-6 right-6 justify-center items-center w-10 h-10 text-gray-400 rounded-full transition hover:text-gray-600 hover:bg-gray-100 close-modal" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="mb-2 text-3xl font-bold text-gray-900">Tambah Produk</h3>
                <p class="mb-8 text-gray-500">Isi detail produk di bawah ini untuk menambah ke inventori.</p>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Gambar</label>
                    <label for="addProductImageInput" class="block flex relative flex-col justify-center items-center h-56 bg-gray-100 rounded-xl border-2 border-gray-300 border-dashed transition cursor-pointer hover:bg-gray-200">
                        <img id="addProductImagePreview" class="hidden object-contain w-full h-full rounded-xl border border-gray-300" />
                        <div id="addProductImagePlaceholder" class="flex flex-col justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 4.553a1.5 1.5 0 01-2.121 2.121L13 12.121l-2.121 2.121a1.5 1.5 0 01-2.121-2.121L9 10" />
                            </svg>
                            <span class="text-gray-400">Tambahkan Gambar</span>
                        </div>
                        <input id="addProductImageInput" type="file" name="image" class="hidden" accept="image/*">
                    </label>
                    <span class="block mt-2 text-xs text-red-500" id="addProductErrorImage"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Nama Produk</label>
                    <input type="text" name="name" id="addProductNameInput" placeholder="Masukkan Nama"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <span class="block mt-2 text-xs text-red-500" id="addProductErrorName"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Kategori</label>
                    <div class="relative">
                        <select name="category_id" id="addProductCategorySelect"
                            class="pl-4 pr-12 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                            <option value="">Pilih Kategori</option>
                            <!-- Opsi kategori diisi via JS -->
                        </select>
                        <!-- Custom arrow icon -->
                        <div class="flex absolute inset-y-0 right-4 items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <span class="block mt-2 text-xs text-red-500" id="addProductErrorCategory"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Harga Satuan</label>
                    <div class="relative">
                        <span class="absolute top-3 left-4 text-gray-500">Rp</span>
                        <input type="text" name="price" id="addProductPriceInput" placeholder="Masukkan Harga"
                            class="pl-12 pr-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    </div>
                    <span class="block mt-2 text-xs text-red-500" id="addProductErrorPrice"></span>
                </div>
                <div class="mb-8">
                    <label class="block mb-2 text-base font-semibold">Stok</label>
                    <input type="number" name="stock" id="addProductStockInput" placeholder="Masukkan Stok"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <span class="block mt-2 text-xs text-red-500" id="addProductErrorStock"></span>
                </div>
                <input type="hidden" name="status" value="tersedia">
                <button type="submit" id="addProductSubmitBtn"
                    class="flex gap-2 justify-center items-center py-3 w-full text-lg font-bold text-white rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    style="background-color: #00B69B;"
                    onmouseover="this.style.backgroundColor='#00997F'" onmouseout="this.style.backgroundColor='#00B69B'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span id="addProductSubmitText">Tambahkan</span>
                </button>
            </form>
        </div>
        <!-- Modal Edit Produk -->
        <div id="editProductModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black/30">
            <form id="editProductForm" class="relative p-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl">
                <button type="button" class="flex absolute top-6 right-6 justify-center items-center w-10 h-10 text-gray-400 rounded-full transition hover:text-gray-600 hover:bg-gray-100 close-modal" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="mb-2 text-3xl font-bold text-gray-900">Edit Produk</h3>
                <p class="mb-8 text-gray-500">Ubah detail produk di bawah ini.</p>
                <input type="hidden" name="id">
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Gambar</label>
                    <label for="editProductImageInput" class="block flex relative flex-col justify-center items-center h-56 bg-gray-100 rounded-xl border-2 border-gray-300 border-dashed transition cursor-pointer hover:bg-gray-200">
                        <img id="editProductImagePreview" class="object-contain w-full h-full rounded-xl border border-gray-300" src="" />
                        <div id="editProductImagePlaceholder" class="flex flex-col justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 4.553a1.5 1.5 0 01-2.121 2.121L13 12.121l-2.121 2.121a1.5 1.5 0 01-2.121-2.121L9 10" />
                            </svg>
                            <span class="text-gray-400">Klik untuk mengubah gambar</span>
                        </div>
                        <input id="editProductImageInput" type="file" name="image" class="hidden" accept="image/*">
                    </label>
                    <span class="block mt-2 text-xs text-red-500" id="editProductErrorImage"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Nama Produk</label>
                    <input type="text" name="name" id="editProductNameInput" placeholder="Masukkan Nama"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <span class="block mt-2 text-xs text-red-500" id="editProductErrorName"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Kategori</label>
                    <div class="relative">
                        <select name="category_id" id="editProductCategorySelect"
                            class="pl-4 pr-12 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                            <option value="">Pilih Kategori</option>
                        </select>
                        <div class="flex absolute inset-y-0 right-4 items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <span class="block mt-2 text-xs text-red-500" id="editProductErrorCategory"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Harga Satuan</label>
                    <div class="relative">
                        <span class="absolute top-3 left-4 text-gray-500">Rp</span>
                        <input type="text" name="price" id="editProductPriceInput" placeholder="Masukkan Harga"
                            class="pl-12 pr-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    </div>
                    <span class="block mt-2 text-xs text-red-500" id="editProductErrorPrice"></span>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Stok</label>
                    <input type="number" name="stock" id="editProductStockInput" placeholder="Masukkan Stok"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <span class="block mt-2 text-xs text-red-500" id="editProductErrorStock"></span>
                </div>
                <button type="submit" id="editProductSubmitBtn"
                    class="flex gap-2 justify-center items-center py-3 w-full text-lg font-bold text-white rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    style="background-color: #00B69B;"
                    onmouseover="this.style.backgroundColor='#00997F'" onmouseout="this.style.backgroundColor='#00B69B'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="editProductSubmitText">Simpan Perubahan</span>
                </button>
            </form>
        </div>
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black/30">
            <div class="relative mx-4 w-full max-w-md bg-white rounded-2xl shadow-2xl">
                <button type="button" onclick="DeleteHandler.hideModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="p-8">
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Hapus Produk?</h3>
                    <p class="mb-8 text-gray-500">Menghapus produk akan menghilangkannya dari daftar produk. Apakah Anda yakin ingin melanjutkan?</p>
                    <div class="flex gap-4 justify-center">
                        <button type="button" onclick="DeleteHandler.hideModal()" class="px-8 py-2 font-semibold text-gray-800 bg-white rounded-lg border border-gray-400 transition hover:bg-gray-50">Batal</button>
                        <button type="button" onclick="DeleteHandler.delete()" class="px-8 py-2 font-semibold text-white bg-red-400 rounded-lg transition hover:bg-red-500">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Kategori -->
        <div id="addCategoryModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black/30">
            <form id="addCategoryForm" class="relative p-10 w-full max-w-md bg-white rounded-2xl shadow-2xl">
                <button type="button" class="flex absolute top-6 right-6 justify-center items-center w-10 h-10 text-gray-400 rounded-full transition hover:text-gray-600 hover:bg-gray-100 close-modal" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="mb-2 text-3xl font-bold text-gray-900">Tambah Kategori</h3>
                <p class="mb-8 text-gray-500">Isi detail kategori di bawah ini.</p>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Nama Kategori</label>
                    <input type="text" name="name" id="addCategoryNameInput" placeholder="Masukkan Nama Kategori"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition" />
                    <span class="block mt-2 text-xs text-red-500" id="addCategoryErrorName"></span>
                </div>
                <div class="mb-8">
                    <label class="block mb-2 text-base font-semibold">Status</label>
                    <div class="relative">
                        <select name="status" id="addCategoryStatusInput"
                            class="pl-4 pr-12 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        <div class="flex absolute inset-y-0 right-4 items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <span class="block mt-2 text-xs text-red-500" id="addCategoryErrorStatus"></span>
                </div>
                <button type="submit" id="addCategorySubmitBtn"
                    class="flex gap-2 justify-center items-center py-3 w-full text-lg font-bold text-white rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    style="background-color: #00B69B;"
                    onmouseover="this.style.backgroundColor='#00997F'" onmouseout="this.style.backgroundColor='#00B69B'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span id="addCategorySubmitText">Tambahkan</span>
                </button>
            </form>
        </div>
        <!-- Modal Konfirmasi Hapus Kategori -->
        <div id="deleteCategoryModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black/30">
            <div class="relative mx-4 w-full max-w-md bg-white rounded-2xl shadow-2xl">
                <button type="button" onclick="closeModal('deleteCategoryModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="p-8">
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Hapus Kategori?</h3>
                    <p class="mb-8 text-gray-500">Menghapus kategori akan menghilangkannya dari daftar kategori. Apakah Anda yakin ingin melanjutkan?</p>
                    <div class="flex gap-4 justify-center">
                        <button type="button" onclick="closeModal('deleteCategoryModal')" class="px-8 py-2 font-semibold text-gray-800 bg-white rounded-lg border border-gray-400 transition hover:bg-gray-50">Batal</button>
                        <button type="button" id="confirmDeleteCategoryBtn" class="px-8 py-2 font-semibold text-white bg-red-400 rounded-lg transition hover:bg-red-500">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Toast notifications -->
        <div id="toast" class="hidden fixed top-4 right-4 z-50">
            <div class="flex items-center p-4 mb-4 text-white rounded-lg shadow-lg transition-all duration-300 transform translate-x-full">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg">
                    <svg id="toast-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div id="toast-message" class="ml-3 text-sm font-normal"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add this at the beginning of your script
        const Toast = {
            show(message, type = 'success') {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');
                const toastIcon = document.getElementById('toast-icon');
                const toastBox = toast.querySelector('.rounded-lg');

                // Reset background color
                toastBox.classList.remove('bg-green-500', 'bg-red-500');
                toastBox.style.backgroundColor = '';

                // Set message
                toastMessage.textContent = message;

                // Set icon and colors based on type
                if (type === 'success') {
                    toastBox.style.backgroundColor = '#00B69B';
                    toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                } else {
                    toastBox.classList.add('bg-red-500');
                    toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                }

                // Show toast
                toast.classList.remove('hidden');
                toastBox.classList.remove('translate-x-full');

                // Hide after 3 seconds
                setTimeout(() => {
                    toastBox.classList.add('translate-x-full');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 300);
                }, 3000);
            }
        };

        // Delete functionality
        const DeleteHandler = {
            selectedProductId: null,

            showModal(productId) {
                this.selectedProductId = productId;
                const modal = document.getElementById('deleteModal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            },

            hideModal() {
                const modal = document.getElementById('deleteModal');
                if (modal) {
                    modal.classList.add('hidden');
                }
                this.selectedProductId = null;
            },

            async delete() {
                if (!this.selectedProductId) return;
                
                const deleteBtn = document.querySelector('#deleteModal button[onclick="DeleteHandler.delete()"]');
                if (!deleteBtn) {
                    console.error('Delete button not found');
                    return;
                }
                
                const originalText = deleteBtn.innerHTML;
                const originalDisabled = deleteBtn.disabled;
                
                try {
                    // Show loading state
                    deleteBtn.disabled = true;
                    deleteBtn.innerHTML = `
                        <svg class="inline-block mr-3 -ml-1 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghapus...
                    `;

                    const response = await fetch(`/staff/products/${this.selectedProductId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to delete product');
                    }

                    const productRow = document.querySelector(`.delete-product-btn[data-id="${this.selectedProductId}"]`)?.closest('tr');
                    if (productRow) {
                        productRow.remove();
                    }

                    // Show success toast instead of alert
                    Toast.show('Produk berhasil dihapus', 'success');
                    this.hideModal();

                } catch (error) {
                    console.error('Error deleting product:', error);
                    // Show error toast instead of alert
                    Toast.show('Gagal menghapus produk: ' + error.message, 'error');
                } finally {
                    if (deleteBtn) {
                        deleteBtn.disabled = originalDisabled;
                        deleteBtn.innerHTML = originalText;
                    }
                }
            }
        };

        // --- Data from backend ---
        const products = {!! json_encode($products->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'image' => $p->image,
                'image_url' => $p->image ? asset('storage/'.$p->image) : null,
                'category_id' => $p->category_id,
                'stock' => $p->stock,
                'price' => $p->price,
                'status' => $p->status,
                'category' => $p->category ? [
                    'id' => $p->category->id,
                    'name' => $p->category->name,
                    'status' => $p->category->status
                ] : null
            ];
        })) !!};

        let categories = {!! json_encode($categories->map(function($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'status' => $c->status
            ];
        })) !!};

        let filteredProducts = [...products];
        let filteredCategories = [...categories];
        let selectedProductId = null;
        let selectedCategoryId = null;

        // --- Render functions ---
        function formatRupiah(angka) {
            if (!angka) return '';
            angka = angka.toString().replace(/[^0-9]/g, '');
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function unformatRupiah(angka) {
            if (!angka) return '';
            return angka.toString().replace(/[^0-9]/g, '');
        }

        function formatRupiahDisplay(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + formatRupiah(angka);
        }

        function renderCategoryOptions(selectId, selectedId = null) {
            const select = document.getElementById(selectId);
            if (!select) return;

            select.innerHTML = '<option value="">Pilih Kategori</option>';
            filteredCategories.forEach(cat => {
                if (cat.status === 'aktif') { // Only show active categories
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    if (selectedId && cat.id == selectedId) option.selected = true;
                    select.appendChild(option);
                }
            });
        }

        function renderProductsTable() {
            const tbody = document.getElementById('productsTableBody');
            if (!tbody) return;

            tbody.innerHTML = '';
            filteredProducts.forEach((product, idx) => {
                // Logic status
                let statusLabel = '';
                let statusClass = '';
                if (product.stock == 0) {
                    statusLabel = 'Habis';
                    statusClass = 'bg-red-100 text-red-700';
                } else if (product.status === 'tersedia') {
                    statusLabel = 'Tersedia';
                    statusClass = 'bg-teal-100 text-teal-700';
                } else {
                    statusLabel = 'Habis';
                    statusClass = 'bg-red-100 text-red-700';
                }
                const tr = document.createElement('tr');
                tr.className = idx % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                tr.innerHTML = `
            <td class="px-4 py-2">${idx + 1}</td>
            <td class="flex gap-2 items-center px-4 py-2">
                <img src="${product.image_url || 'https://via.placeholder.com/32'}" class="mr-2 w-8 h-8 rounded"/>
                <span>${product.name}</span>
            </td>
            <td class="px-4 py-2">${product.category ? product.category.name : '-'}</td>
            <td class="px-4 py-2">${product.stock}</td>
            <td class="px-4 py-2">${formatRupiahDisplay(product.price)}</td>
            <td class="px-4 py-2">
                <span class="px-3 py-1 rounded text-xs font-semibold ${statusClass}">
                    ${statusLabel}
                </span>
            </td>
            <td class="flex px-4 py-2 space-x-2">
                <button type="button" class="text-gray-600 edit-product-btn hover:text-blue-600" data-id="${product.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3h3z" />
                    </svg>
                </button>
                <button type="button" class="p-1 text-red-500 rounded-full transition-colors delete-product-btn hover:text-red-700 hover:bg-red-50" data-id="${product.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        `;
                tbody.appendChild(tr);
            });

            // Add event listeners to edit buttons
            document.querySelectorAll('.edit-product-btn').forEach(btn => {
                btn.onclick = function() {
                    const productId = this.getAttribute('data-id');
                    if (productId) {
                        openEditProductModal(productId);
                    }
                };
            });

            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-product-btn').forEach(btn => {
                btn.onclick = function() {
                    const productId = this.getAttribute('data-id');
                    if (productId) {
                        DeleteHandler.showModal(productId);
                    }
                };
            });
        }

        function renderCategoriesTable() {
            const tbody = document.getElementById('categoriesTableBody');
            if (!tbody) return;

            tbody.innerHTML = '';
            filteredCategories.forEach((category, idx) => {
                const tr = document.createElement('tr');
                tr.className = idx % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                tr.innerHTML = `
            <td class="px-4 py-2">${idx + 1}</td>
            <td class="px-4 py-2">${category.name}</td>
            <td class="px-4 py-2">
                <span class="px-3 py-1 rounded text-xs font-semibold ${category.status === 'aktif' ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700'}">
                    ${category.status === 'aktif' ? 'Aktif' : 'Nonaktif'}
                </span>
            </td>
            <td class="flex px-4 py-2 space-x-2">
                <button class="text-red-500 hover:text-red-700 delete-category-btn" data-id="${category.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        `;
                tbody.appendChild(tr);
            });

            document.querySelectorAll('.delete-category-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    openDeleteCategoryModal(id);
                });
            });
        }

        // --- Search ---
        function filterProducts(query) {
            query = query.toLowerCase();
            filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(query) ||
                (product.category && product.category.name.toLowerCase().includes(query)) ||
                product.price.toString().includes(query) ||
                product.stock.toString().includes(query)
            );
            renderProductsTable();
        }

        function filterCategories(query) {
            query = query.toLowerCase();
            filteredCategories = categories.filter(category =>
                category.name.toLowerCase().includes(query) ||
                category.status.toLowerCase().includes(query)
            );
            renderCategoriesTable();
        }

        // Add search event listeners
        const searchProductInput = document.getElementById('searchProductInput');
        if (searchProductInput) {
            searchProductInput.addEventListener('input', function() {
                filterProducts(this.value);
            });
        }

        const searchCategoryInput = document.getElementById('searchCategoryInput');
        if (searchCategoryInput) {
            searchCategoryInput.addEventListener('input', function() {
                filterCategories(this.value);
            });
        }

        // --- Modal functions ---
        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) {
                console.error('Modal not found:', id);
                return;
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                const input = document.getElementById(id === 'addProductModal' ? 'addProductNameInput' :
                    id === 'addCategoryModal' ? 'addCategoryNameInput' : null);
                if (input) input.focus();
            }, 100);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) {
                console.error('Modal not found:', id);
                return;
            }

            modal.classList.add('hidden');
            if (id === 'addProductModal') {
                const form = document.getElementById('addProductForm');
                if (form) form.reset();
                const preview = document.getElementById('addProductImagePreview');
                const placeholder = document.getElementById('addProductImagePlaceholder');
                if (preview) preview.classList.add('hidden');
                if (placeholder) placeholder.classList.remove('hidden');
                clearAddProductErrors();
            } else if (id === 'addCategoryModal') {
                const form = document.getElementById('addCategoryForm');
                if (form) form.reset();
                clearAddCategoryErrors();
            }
        }

        // --- Validasi real-time ---
        function validateAddProductField(name, value) {
            let error = '';
            if (name === 'name') {
                if (!value.trim()) {
                    error = 'Nama produk wajib diisi';
                } else if (value.length < 3) {
                    error = 'Nama produk minimal 3 karakter';
                }
            }
            if (name === 'category_id' && !value) {
                error = 'Kategori wajib dipilih';
            }
            if (name === 'price') {
                const numericValue = unformatRupiah(value);
                if (!numericValue) {
                    error = 'Harga wajib diisi';
                } else if (isNaN(numericValue) || parseInt(numericValue) <= 0) {
                    error = 'Harga harus berupa angka positif';
                }
            }
            if (name === 'stock') {
                if (!value && value !== 0) {
                    error = 'Stok wajib diisi';
                } else if (isNaN(value) || value < 0) {
                    error = 'Stok harus berupa angka positif';
                }
            }
            const errEl = document.getElementById('addProductError' + name.charAt(0).toUpperCase() + name.slice(1));
            if (errEl) errEl.textContent = error;
            return !error;
        }

        function clearAddProductErrors() {
            ['Name', 'Category', 'Price', 'Stock', 'Image'].forEach(field => {
                const errEl = document.getElementById('addProductError' + field);
                if (errEl) errEl.textContent = '';
            });
        }

        function clearAddCategoryErrors() {
            ['Name', 'Status'].forEach(field => {
                const errEl = document.getElementById('addCategoryError' + field);
                if (errEl) errEl.textContent = '';
            });
        }

        // --- Event Listeners ---
        document.addEventListener('DOMContentLoaded', function() {
            // Add product form
            const addProductForm = document.getElementById('addProductForm');
            if (addProductForm) {
                addProductForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    clearAddProductErrors();

                    // Get form data
                    const formData = new FormData(this);

                    // Convert formatted price to integer value
                    const priceInput = document.getElementById('addProductPriceInput');
                    if (priceInput) {
                        const intPrice = parseInt(unformatRupiah(priceInput.value) || '0', 10);
                        formData.set('price', intPrice);
                        console.log('Harga yang dikirim (add):', formData.get('price'), typeof formData.get('price'));
                    }

                    // Validasi manual sebelum submit
                    let valid = true;
                    ['name', 'category_id', 'price', 'stock'].forEach(name => {
                        const el = document.querySelector(`[name="${name}"]`);
                        if (!validateAddProductField(name, el.value)) valid = false;
                    });

                    if (!valid) return false;

                    // Loading state
                    const btn = document.getElementById('addProductSubmitBtn');
                    const text = document.getElementById('addProductSubmitText');
                    btn.disabled = true;
                    text.textContent = 'Menyimpan...';

                    try {
                        const res = await fetch('/staff/products', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: formData
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            if (data.errors) {
                                Object.entries(data.errors).forEach(([key, val]) => {
                                    const errEl = document.getElementById('addProductError' +
                                        key.charAt(0).toUpperCase() + key.slice(1));
                                    if (errEl) errEl.textContent = val[0];
                                });
                            } else {
                                alert('Gagal menambah produk: ' + (data.message || 'Unknown error'));
                            }
                            btn.disabled = false;
                            text.textContent = 'Tambahkan';
                            return;
                        }

                        // Tambahkan produk baru ke array dan render ulang
                        if (data.product) {
                            products.push(data.product);
                            filteredProducts = [...products];
                            renderProductsTable();

                            // Reset form dan tutup modal
                            this.reset();
                            const preview = document.getElementById('addProductImagePreview');
                            const placeholder = document.getElementById('addProductImagePlaceholder');
                            if (preview) preview.classList.add('hidden');
                            if (placeholder) placeholder.classList.remove('hidden');
                            closeModal('addProductModal');

                            // Show success toast
                            Toast.show('Produk berhasil ditambahkan!', 'success');
                        } else {
                            throw new Error('Invalid response format'); 
                        }

                    } catch (err) {
                        Toast.show('Gagal menambah produk: ' + err.message, 'error');
                    }

                    btn.disabled = false;
                    text.textContent = 'Tambahkan';
                });
            }

            // Add category form
            const addCategoryForm = document.getElementById('addCategoryForm');
            if (addCategoryForm) {
                addCategoryForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const btn = document.getElementById('addCategorySubmitBtn');
                    const text = document.getElementById('addCategorySubmitText');
                    btn.disabled = true;
                    text.textContent = 'Menyimpan...';

                    try {
                        const formData = new FormData(this);
                        const res = await fetch('/staff/categories', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            if (data.errors) {
                                Object.entries(data.errors).forEach(([key, val]) => {
                                    const errEl = document.getElementById('addCategoryError' + 
                                        key.charAt(0).toUpperCase() + key.slice(1));
                                    if (errEl) errEl.textContent = val[0];
                                });
                            } else {
                                Toast.show('Gagal menambah kategori: ' + (data.message || 'Unknown error'), 'error');
                            }
                            btn.disabled = false;
                            text.textContent = 'Tambahkan';
                            return;
                        }

                        // Tambahkan kategori baru ke array dan render ulang
                        categories.push(data.category);
                        filteredCategories = [...categories];
                        renderCategoriesTable();
                        renderCategoryOptions('addProductCategorySelect');
                        renderCategoryOptions('editProductCategorySelect');

                        // Reset form dan tutup modal
                        this.reset();
                        closeModal('addCategoryModal');
                        Toast.show('Kategori berhasil ditambahkan', 'success');

                    } catch (err) {
                        Toast.show('Gagal menambah kategori: ' + err.message, 'error');
                    }

                    btn.disabled = false;
                    text.textContent = 'Tambahkan';
                });
            }

            // Modal close buttons
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modal = this.closest('[id$="Modal"]');
                    if (modal) closeModal(modal.id);
                });
            });

            // Modal backdrop clicks
            document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) closeModal(this.id);
                });
            });

            // Open modal buttons
            const openAddProductBtn = document.getElementById('openAddProductBtn');
            if (openAddProductBtn) {
                openAddProductBtn.addEventListener('click', function() {
                    openModal('addProductModal');
                    renderCategoryOptions('addProductCategorySelect');
                });
            }

            const openAddCategoryBtn = document.getElementById('openAddCategoryBtn2');
            if (openAddCategoryBtn) {
                openAddCategoryBtn.addEventListener('click', function() {
                    openModal('addCategoryModal');
                });
            }

            // Image preview
            const imageInput = document.getElementById('addProductImageInput');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const preview = document.getElementById('addProductImagePreview');
                    const placeholder = document.getElementById('addProductImagePlaceholder');
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            preview.src = ev.target.result;
                            preview.classList.remove('hidden');
                            placeholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                    }
                });
            }

            // Edit Product Modal & AJAX
            window.openEditProductModal = function(id) {
                const product = products.find(p => p.id == id);
                if (!product) return;
                selectedProductId = id;
                const form = document.getElementById('editProductForm');
                if (!form) return;
                
                // Clear previous errors
                clearEditProductErrors();
                
                // Set form values
                form.elements['id'].value = product.id;
                form.elements['name'].value = product.name;
                renderCategoryOptions('editProductCategorySelect', product.category_id);
                form.elements['price'].value = formatRupiah(product.price);
                form.elements['stock'].value = product.stock;
                
                // Set image preview
                const preview = document.getElementById('editProductImagePreview');
                const placeholder = document.getElementById('editProductImagePlaceholder');
                if (product.image_url) {
                    preview.src = product.image_url;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                } else {
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
                
                // Show modal
                const modal = document.getElementById('editProductModal');
                if (modal) modal.classList.remove('hidden');
            };

            function clearEditProductErrors() {
                ['Name', 'Category', 'Price', 'Stock', 'Image'].forEach(field => {
                    const errEl = document.getElementById('editProductError' + field);
                    if (errEl) errEl.textContent = '';
                });
            }

            function validateEditProductField(name, value) {
                let error = '';
                if (name === 'name') {
                    if (!value.trim()) {
                        error = 'Nama produk wajib diisi';
                    } else if (value.length < 3) {
                        error = 'Nama produk minimal 3 karakter';
                    }
                }
                if (name === 'category_id' && !value) {
                    error = 'Kategori wajib dipilih';
                }
                if (name === 'price') {
                    const numericValue = unformatRupiah(value);
                    if (!numericValue) {
                        error = 'Harga wajib diisi';
                    } else if (isNaN(numericValue) || parseInt(numericValue) <= 0) {
                        error = 'Harga harus berupa angka positif';
                    }
                }
                if (name === 'stock') {
                    if (!value && value !== 0) {
                        error = 'Stok wajib diisi';
                    } else if (isNaN(value) || value < 0) {
                        error = 'Stok harus berupa angka positif';
                    }
                }
                const errEl = document.getElementById('editProductError' + name.charAt(0).toUpperCase() + name.slice(1));
                if (errEl) errEl.textContent = error;
                return !error;
            }

            const editProductForm = document.getElementById('editProductForm');
            if (editProductForm) {
                // Add image preview functionality
                const imageInput = document.getElementById('editProductImageInput');
                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        const preview = document.getElementById('editProductImagePreview');
                        const placeholder = document.getElementById('editProductImagePlaceholder');
                        
                        if (file) {
                            // Validate file type
                            if (!file.type.startsWith('image/')) {
                                const errEl = document.getElementById('editProductErrorImage');
                                if (errEl) errEl.textContent = 'File harus berupa gambar';
                                this.value = '';
                                return;
                            }
                            
                            // Validate file size (max 2MB)
                            if (file.size > 2 * 1024 * 1024) {
                                const errEl = document.getElementById('editProductErrorImage');
                                if (errEl) errEl.textContent = 'Ukuran file maksimal 2MB';
                                this.value = '';
                                return;
                            }
                            
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                preview.src = ev.target.result;
                                preview.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                        }
                    });
                }

                // Add input validation on change
                ['name', 'price', 'stock'].forEach(fieldName => {
                    const input = editProductForm.querySelector(`[name="${fieldName}"]`);
                    if (input) {
                        input.addEventListener('input', function() {
                            validateEditProductField(fieldName, this.value);
                        });
                    }
                });

                // Add select validation on change
                const categorySelect = editProductForm.querySelector('[name="category_id"]');
                if (categorySelect) {
                    categorySelect.addEventListener('change', function() {
                        validateEditProductField('category_id', this.value);
                    });
                }

                editProductForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    clearEditProductErrors();
                    
                    // Validate form
                    let valid = true;
                    ['name', 'category_id', 'price', 'stock'].forEach(name => {
                        const el = document.querySelector(`#editProductForm [name="${name}"]`);
                        if (!validateEditProductField(name, el.value)) valid = false;
                    });
                    
                    if (!valid) return false;

                    const form = e.target;
                    const id = form.elements['id'].value;
                    const formData = new FormData(form);
                    formData.append('_method', 'PUT');
                    
                    // Convert formatted price to integer value
                    const priceInput = document.getElementById('editProductPriceInput');
                    if (priceInput) {
                        const intPrice = parseInt(unformatRupiah(priceInput.value) || '0', 10);
                        formData.set('price', intPrice);
                    }
                    
                    // Set status based on stock
                    const stockInput = form.elements['stock'];
                    if (stockInput) {
                        formData.set('status', parseInt(stockInput.value) > 0 ? 'tersedia' : 'habis');
                    }
                    
                    const btn = document.getElementById('editProductSubmitBtn');
                    const text = document.getElementById('editProductSubmitText');
                    btn.disabled = true;
                    text.textContent = 'Menyimpan...';

                    try {
                        const res = await fetch(`/staff/products/${id}`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        
                        const data = await res.json();
                        
                        if (!res.ok) {
                            if (data.errors) {
                                Object.entries(data.errors).forEach(([key, val]) => {
                                    const errEl = document.getElementById('editProductError' + 
                                        key.charAt(0).toUpperCase() + key.slice(1));
                                    if (errEl) errEl.textContent = val[0];
                                });
                            } else {
                                Toast.show('Gagal mengedit produk: ' + (data.message || 'Unknown error'), 'error');
                            }
                            btn.disabled = false;
                            text.textContent = 'Simpan Perubahan';
                            return;
                        }

                        // Update product in products array
                        const idx = products.findIndex(p => p.id == data.product.id);
                        if (idx !== -1) products[idx] = data.product;
                        filteredProducts = [...products];
                        renderProductsTable();
                        closeModal('editProductModal');
                        Toast.show('Produk berhasil diperbarui', 'success');
                    } catch (err) {
                        Toast.show('Gagal mengedit produk: ' + err.message, 'error');
                    }
                    
                    btn.disabled = false;
                    text.textContent = 'Simpan Perubahan';
                });
            }

            // Delete Category Modal & AJAX
            window.openDeleteCategoryModal = function(id) {
                const category = categories.find(c => c.id == id);
                if (!category) return;
                selectedCategoryId = id;
                const modal = document.getElementById('deleteCategoryModal');
                if (modal) modal.classList.remove('hidden');
            };

            const confirmDeleteCategoryBtn = document.getElementById('confirmDeleteCategoryBtn');
            if (confirmDeleteCategoryBtn) {
                confirmDeleteCategoryBtn.addEventListener('click', async function() {
                    if (!selectedCategoryId) return;
                    
                    const btn = this;
                    const originalText = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = `
                        <svg class="inline-block mr-3 -ml-1 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghapus...
                    `;

                    try {
                        const res = await fetch(`/staff/categories/${selectedCategoryId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            throw new Error(data.message || 'Failed to delete category');
                        }

                        // Remove category from array
                        categories = categories.filter(c => c.id != selectedCategoryId);
                        filteredCategories = [...categories];
                        renderCategoriesTable();
                        renderCategoryOptions('addProductCategorySelect');
                        renderCategoryOptions('editProductCategorySelect');

                        closeModal('deleteCategoryModal');
                        Toast.show('Kategori berhasil dihapus', 'success');

                    } catch (err) {
                        Toast.show('Gagal menghapus kategori: ' + err.message, 'error');
                    }

                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
            }

            // Initial render
            renderProductsTable();
            renderCategoriesTable();
            renderCategoryOptions('addProductCategorySelect');
            renderCategoryOptions('editProductCategorySelect');

            // Add price formatting for add product form
            const addProductPriceInput = document.getElementById('addProductPriceInput');
            if (addProductPriceInput) {
                addProductPriceInput.addEventListener('input', function(e) {
                    const value = unformatRupiah(e.target.value);
                    const formatted = formatRupiah(value);
                    e.target.value = formatted;
                    validateAddProductField('price', value);
                });
                // Format initial value if exists
                if (addProductPriceInput.value) {
                    addProductPriceInput.value = formatRupiah(addProductPriceInput.value);
                }
            }

            // Add price formatting for edit product form
            const editProductPriceInput = document.getElementById('editProductPriceInput');
            if (editProductPriceInput) {
                editProductPriceInput.addEventListener('input', function(e) {
                    const value = unformatRupiah(e.target.value);
                    const formatted = formatRupiah(value);
                    e.target.value = formatted;
                    validateEditProductField('price', value);
                });
                // Format initial value if exists
                if (editProductPriceInput.value) {
                    editProductPriceInput.value = formatRupiah(editProductPriceInput.value);
                }
            }
        });
    </script>
@endpush
