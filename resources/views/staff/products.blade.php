@extends('layouts.staff')

@section('header-title', 'PRODUK')

@section('content')
<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Inventory Product</h1>
        <div class="flex gap-2">
            <button id="openAddProductBtn" class="bg-green-400 hover:bg-green-500 text-white px-6 py-2 rounded-md font-semibold">Tambah Produk</button>
            <button id="openAddCategoryBtn" class="bg-green-400 hover:bg-green-500 text-white px-6 py-2 rounded-md font-semibold">Tambah Kategori</button>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Produk</h2>
            <input id="searchProductInput" type="text" placeholder="Search" class="border rounded px-4 py-2 bg-gray-100 focus:outline-none focus:ring w-64">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Item Name</th>
                        <th class="px-4 py-2">SKU</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2">Harga Satuan</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody" class="divide-y">
                    <!-- Products will be rendered here by JS -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Kategori</h2>
            <button id="openAddCategoryBtn2" class="bg-green-400 hover:bg-green-500 text-white px-6 py-2 rounded-md font-semibold">Tambah Kategori</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nama Kategori</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="categoriesTableBody" class="divide-y">
                    <!-- Categories will be rendered here by JS -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- Product Add Modal -->
    <div id="addProductModal" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <form id="addProductForm" class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Produk</h3>
            <div class="mb-2">
                <label class="block text-sm">Nama Produk</label>
                <input type="text" name="name" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="addProductErrorName"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">SKU</label>
                <input type="text" name="sku" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="addProductErrorSku"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Kategori</label>
                <select name="category_id" class="border rounded w-full px-3 py-2" id="addProductCategorySelect">
                    <option value="">Pilih Kategori</option>
                </select>
                <span class="text-red-500 text-xs" id="addProductErrorCategory"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Stok</label>
                <input type="number" name="stock" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="addProductErrorStock"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Harga Satuan</label>
                <input type="number" name="price" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="addProductErrorPrice"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Status</label>
                <select name="status" class="border rounded w-full px-3 py-2">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
                <span class="text-red-500 text-xs" id="addProductErrorStatus"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image">
                <span class="text-red-500 text-xs" id="addProductErrorImage"></span>
            </div>
            <div class="flex justify-end mt-4 gap-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
    <!-- Product Edit Modal -->
    <div id="editProductModal" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <form id="editProductForm" class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Produk</h3>
            <input type="hidden" name="id">
            <div class="mb-2">
                <label class="block text-sm">Nama Produk</label>
                <input type="text" name="name" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="editProductErrorName"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">SKU</label>
                <input type="text" name="sku" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="editProductErrorSku"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Kategori</label>
                <select name="category_id" class="border rounded w-full px-3 py-2" id="editProductCategorySelect">
                    <option value="">Pilih Kategori</option>
                </select>
                <span class="text-red-500 text-xs" id="editProductErrorCategory"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Stok</label>
                <input type="number" name="stock" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="editProductErrorStock"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Harga Satuan</label>
                <input type="number" name="price" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="editProductErrorPrice"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Status</label>
                <select name="status" class="border rounded w-full px-3 py-2">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
                <span class="text-red-500 text-xs" id="editProductErrorStatus"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image">
                <span class="text-red-500 text-xs" id="editProductErrorImage"></span>
            </div>
            <div class="flex justify-end mt-4 gap-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
    <!-- Product Delete Modal -->
    <div id="deleteProductModal" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Hapus Produk</h3>
            <p>Yakin ingin menghapus produk ini?</p>
            <div class="flex justify-end mt-4 gap-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded">Batal</button>
                <button type="button" id="confirmDeleteProductBtn" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
    <!-- Category Add Modal -->
    <div id="addCategoryModal" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <form id="addCategoryForm" class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Kategori</h3>
            <div class="mb-2">
                <label class="block text-sm">Nama Kategori</label>
                <input type="text" name="name" class="border rounded w-full px-3 py-2">
                <span class="text-red-500 text-xs" id="addCategoryErrorName"></span>
            </div>
            <div class="mb-2">
                <label class="block text-sm">Status</label>
                <select name="status" class="border rounded w-full px-3 py-2">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <span class="text-red-500 text-xs" id="addCategoryErrorStatus"></span>
            </div>
            <div class="flex justify-end mt-4 gap-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
    <!-- Category Delete Modal -->
    <div id="deleteCategoryModal" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Hapus Kategori</h3>
            <p>Yakin ingin menghapus kategori ini?</p>
            <div class="flex justify-end mt-4 gap-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded">Batal</button>
                <button type="button" id="confirmDeleteCategoryBtn" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// --- Data from backend ---
const products = @json($products->map(function($p) {
    $data = $p->toArray();
    $data['category'] = $p->category ? $p->category->toArray() : null;
    $data['image_url'] = $p->image ? asset('storage/'.$p->image) : null;
    return $data;
}));
let categories = @json($categories);
let filteredProducts = [...products];
let selectedProductId = null;
let selectedCategoryId = null;

// --- Modal logic (already vanilla) ---
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
const openAddProductBtn = document.getElementById('openAddProductBtn');
const openAddCategoryBtn = document.getElementById('openAddCategoryBtn');
const openAddCategoryBtn2 = document.getElementById('openAddCategoryBtn2');
openAddProductBtn.addEventListener('click', () => openModal('addProductModal'));
openAddCategoryBtn.addEventListener('click', () => openModal('addCategoryModal'));
openAddCategoryBtn2.addEventListener('click', () => openModal('addCategoryModal'));
const closeModalBtns = document.querySelectorAll('.close-modal');
closeModalBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const modal = this.closest('.modal');
        if (modal) closeModal(modal.id);
    });
});
const modals = document.querySelectorAll('.modal');
modals.forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal(modal.id);
    });
});

// --- Render functions ---
function renderProductsTable() {
    const tbody = document.getElementById('productsTableBody');
    tbody.innerHTML = '';
    filteredProducts.forEach((product, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-2">${idx + 1}</td>
            <td class="px-4 py-2 flex items-center">
                <img src="${product.image_url || 'https://via.placeholder.com/32'}" class="w-8 h-8 rounded mr-2"/>
                <span>${product.name}</span>
            </td>
            <td class="px-4 py-2">${product.sku}</td>
            <td class="px-4 py-2">${product.category ? product.category.name : '-'}</td>
            <td class="px-4 py-2">${product.stock}</td>
            <td class="px-4 py-2">${product.price}</td>
            <td class="px-4 py-2">
                <span class="px-3 py-1 rounded text-xs ${product.status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                    ${product.status.charAt(0).toUpperCase() + product.status.slice(1)}
                </span>
            </td>
            <td class="px-4 py-2 flex space-x-2">
                <button class="text-gray-600 hover:text-blue-600 edit-product-btn" data-id="${product.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3h3z" /></svg>
                </button>
                <button class="text-red-500 hover:text-red-700 delete-product-btn" data-id="${product.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
    // Add event listeners for edit/delete buttons
    document.querySelectorAll('.edit-product-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            openEditProductModal(id);
        });
    });
    document.querySelectorAll('.delete-product-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            openDeleteProductModal(id);
        });
    });
}
function renderCategoriesTable() {
    const tbody = document.getElementById('categoriesTableBody');
    tbody.innerHTML = '';
    categories.forEach((category, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-2">${idx + 1}</td>
            <td class="px-4 py-2">${category.name}</td>
            <td class="px-4 py-2">
                <span class="px-3 py-1 rounded text-xs ${category.status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                    ${category.status.charAt(0).toUpperCase() + category.status.slice(1)}
                </span>
            </td>
            <td class="px-4 py-2 flex space-x-2">
                <button class="text-red-500 hover:text-red-700 delete-category-btn" data-id="${category.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
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
function renderCategoryOptions(selectId, selectedId = null) {
    const select = document.getElementById(selectId);
    select.innerHTML = '<option value="">Pilih Kategori</option>';
    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat.id;
        option.textContent = cat.name;
        if (selectedId && cat.id == selectedId) option.selected = true;
        select.appendChild(option);
    });
}

// --- Search ---
document.getElementById('searchProductInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    filteredProducts = products.filter(p =>
        p.name.toLowerCase().includes(q) ||
        p.sku.toLowerCase().includes(q) ||
        (p.category && p.category.name.toLowerCase().includes(q))
    );
    renderProductsTable();
});

// --- Add Product ---
document.getElementById('addProductForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearAddProductErrors();
    const form = e.target;
    const formData = new FormData(form);
    try {
        const res = await fetch('/staff/products', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
            body: formData
        });
        const data = await res.json();
        if (!res.ok) {
            if (data.errors) showAddProductErrors(data.errors);
            else alert('Gagal menambah produk.');
            return;
        }
        products.push(data.product);
        filteredProducts = [...products];
        renderProductsTable();
        closeModal('addProductModal');
        form.reset();
    } catch (err) {
        alert('Gagal menambah produk.');
    }
});
function clearAddProductErrors() {
    document.getElementById('addProductErrorName').textContent = '';
    document.getElementById('addProductErrorSku').textContent = '';
    document.getElementById('addProductErrorCategory').textContent = '';
    document.getElementById('addProductErrorStock').textContent = '';
    document.getElementById('addProductErrorPrice').textContent = '';
    document.getElementById('addProductErrorStatus').textContent = '';
    document.getElementById('addProductErrorImage').textContent = '';
}
function showAddProductErrors(errors) {
    if (errors.name) document.getElementById('addProductErrorName').textContent = errors.name[0];
    if (errors.sku) document.getElementById('addProductErrorSku').textContent = errors.sku[0];
    if (errors.category_id) document.getElementById('addProductErrorCategory').textContent = errors.category_id[0];
    if (errors.stock) document.getElementById('addProductErrorStock').textContent = errors.stock[0];
    if (errors.price) document.getElementById('addProductErrorPrice').textContent = errors.price[0];
    if (errors.status) document.getElementById('addProductErrorStatus').textContent = errors.status[0];
    if (errors.image) document.getElementById('addProductErrorImage').textContent = errors.image[0];
}

// --- Edit Product ---
function openEditProductModal(id) {
    const product = products.find(p => p.id == id);
    if (!product) return;
    selectedProductId = id;
    const form = document.getElementById('editProductForm');
    form.elements['id'].value = product.id;
    form.elements['name'].value = product.name;
    form.elements['sku'].value = product.sku;
    renderCategoryOptions('editProductCategorySelect', product.category_id);
    form.elements['stock'].value = product.stock;
    form.elements['price'].value = product.price;
    form.elements['status'].value = product.status;
    // image left blank
    clearEditProductErrors();
    openModal('editProductModal');
}
document.getElementById('editProductForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearEditProductErrors();
    const form = e.target;
    const id = form.elements['id'].value;
    const formData = new FormData(form);
    formData.append('_method', 'PUT');
    try {
        const res = await fetch(`/staff/products/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
            body: formData
        });
        const data = await res.json();
        if (!res.ok) {
            if (data.errors) showEditProductErrors(data.errors);
            else alert('Gagal mengedit produk.');
            return;
        }
        // Update product in products array
        const idx = products.findIndex(p => p.id == data.product.id);
        if (idx !== -1) products[idx] = data.product;
        filteredProducts = [...products];
        renderProductsTable();
        closeModal('editProductModal');
    } catch (err) {
        alert('Gagal mengedit produk.');
    }
});
function clearEditProductErrors() {
    document.getElementById('editProductErrorName').textContent = '';
    document.getElementById('editProductErrorSku').textContent = '';
    document.getElementById('editProductErrorCategory').textContent = '';
    document.getElementById('editProductErrorStock').textContent = '';
    document.getElementById('editProductErrorPrice').textContent = '';
    document.getElementById('editProductErrorStatus').textContent = '';
    document.getElementById('editProductErrorImage').textContent = '';
}
function showEditProductErrors(errors) {
    if (errors.name) document.getElementById('editProductErrorName').textContent = errors.name[0];
    if (errors.sku) document.getElementById('editProductErrorSku').textContent = errors.sku[0];
    if (errors.category_id) document.getElementById('editProductErrorCategory').textContent = errors.category_id[0];
    if (errors.stock) document.getElementById('editProductErrorStock').textContent = errors.stock[0];
    if (errors.price) document.getElementById('editProductErrorPrice').textContent = errors.price[0];
    if (errors.status) document.getElementById('editProductErrorStatus').textContent = errors.status[0];
    if (errors.image) document.getElementById('editProductErrorImage').textContent = errors.image[0];
}

// --- Delete Product ---
function openDeleteProductModal(id) {
    selectedProductId = id;
    openModal('deleteProductModal');
}
document.getElementById('confirmDeleteProductBtn').addEventListener('click', async function() {
    if (!selectedProductId) return;
    try {
        const res = await fetch(`/staff/products/${selectedProductId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
        });
        if (!res.ok) {
            alert('Gagal menghapus produk.');
            return;
        }
        const idx = products.findIndex(p => p.id == selectedProductId);
        if (idx !== -1) products.splice(idx, 1);
        filteredProducts = [...products];
        renderProductsTable();
        closeModal('deleteProductModal');
    } catch (err) {
        alert('Gagal menghapus produk.');
    }
});

// --- Add Category ---
document.getElementById('addCategoryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearAddCategoryErrors();
    const form = e.target;
    const formData = new FormData(form);
    try {
        const res = await fetch('/staff/categories', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: formData
        });
        const data = await res.json();
        if (!res.ok) {
            if (data.errors) showAddCategoryErrors(data.errors);
            else alert('Gagal menambah kategori.');
            return;
        }
        categories.push(data.category);
        renderCategoriesTable();
        renderCategoryOptions('addProductCategorySelect');
        renderCategoryOptions('editProductCategorySelect');
        closeModal('addCategoryModal');
        form.reset();
    } catch (err) {
        alert('Gagal menambah kategori.');
    }
});
function clearAddCategoryErrors() {
    document.getElementById('addCategoryErrorName').textContent = '';
    document.getElementById('addCategoryErrorStatus').textContent = '';
}
function showAddCategoryErrors(errors) {
    if (errors.name) document.getElementById('addCategoryErrorName').textContent = errors.name[0];
    if (errors.status) document.getElementById('addCategoryErrorStatus').textContent = errors.status[0];
}

// --- Delete Category ---
function openDeleteCategoryModal(id) {
    selectedCategoryId = id;
    openModal('deleteCategoryModal');
}
document.getElementById('confirmDeleteCategoryBtn').addEventListener('click', async function() {
    if (!selectedCategoryId) return;
    try {
        const res = await fetch(`/staff/categories/${selectedCategoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
        });
        if (!res.ok) {
            alert('Gagal menghapus kategori.');
            return;
        }
        const idx = categories.findIndex(c => c.id == selectedCategoryId);
        if (idx !== -1) categories.splice(idx, 1);
        renderCategoriesTable();
        renderCategoryOptions('addProductCategorySelect');
        renderCategoryOptions('editProductCategorySelect');
        closeModal('deleteCategoryModal');
    } catch (err) {
        alert('Gagal menghapus kategori.');
    }
});

// --- Initial render ---
renderProductsTable();
renderCategoriesTable();
renderCategoryOptions('addProductCategorySelect');
renderCategoryOptions('editProductCategorySelect');
</script>
@endpush 