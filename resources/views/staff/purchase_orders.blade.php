@extends('layouts.staff')

@section('header-title', 'Transaksi Pembelian')

@section('content')
    <div x-data="{
        open: false,
        detailOpen: false,
        selectedOrder: null,
        error: null,
        async showDetail(orderId) {
            try {
                this.error = null;
                const response = await fetch(`{{ url('staff/purchase-orders') }}/${orderId}`);
                if (!response.ok) {
                    throw new Error('Gagal mengambil detail pesanan');
                }
                const data = await response.json();
                if (data.error) {
                    throw new Error(data.error);
                }
                this.selectedOrder = data;
                this.detailOpen = true;
            } catch (error) {
                console.error('Error fetching order details:', error);
                this.error = error.message;
                alert(this.error);
            }
        }
    }">
        <div class="p-8 mb-10 bg-white rounded-xl shadow">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-5a2 2 0 00-2-2h-1V7a2 2 0 00-2-2h-2a2 2 0 00-2 2v7H7a2 2 0 00-2 2v5a2 2 0 002 2z" />
                    </svg>
                    <h1 class="text-xl font-semibold">Transaksi Pembelian</h1>
                </div>
                <button type="button" @click="open = true"
                    class="px-8 py-3 text-lg font-semibold text-white rounded-lg shadow transition"
                    style="background-color: #00B69B;" onmouseover="this.style.backgroundColor='#00997F'"
                    onmouseout="this.style.backgroundColor='#00B69B'">+ Bikin Transaksi Pembelian</button>
            </div>
            <form action="{{ route('staff.purchase-orders.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
                <div>
                    <label class="block mb-1 text-xs text-gray-500">Tanggal</label>
                    <div class="flex items-center space-x-2">
                        <select name="date_range"
                            class="pl-4 pr-12 py-3 w-40 text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                            <option value="">Pilih Periode</option>
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>Minggu
                                ini</option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>Bulan
                                ini</option>
                        </select>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-3 w-36 bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition">
                        <span class="mx-1">→</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-3 w-36 bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block mb-1 text-xs text-gray-500">Nama Barang</label>
                    <input type="text" name="product_name" value="{{ request('product_name') }}"
                        class="pl-4 pr-12 py-3 w-48 text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition"
                        placeholder="Cari nama barang">
                </div>
                <div>
                    <label class="block mb-1 text-xs text-gray-500">Kategori</label>
                    <select name="category"
                        class="pl-4 pr-12 py-3 w-48 text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-6 py-3 text-white bg-[#00B69B] rounded-lg shadow transition hover:bg-[#00997F]">
                        Filter
                    </button>
                    @if (request()->hasAny(['date_range', 'start_date', 'end_date', 'product_name', 'category']))
                        <a href="{{ route('staff.purchase-orders.index') }}"
                            class="px-6 py-3 ml-2 text-gray-600 bg-gray-100 rounded-lg shadow transition hover:bg-gray-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <div class="p-8 bg-white rounded-xl shadow">
            <h2 class="mb-4 text-lg font-bold">List Transaksi Pembelian</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase bg-gray-50">
                            <th class="px-4 py-2 w-1/12 text-left">ID Pesanan</th>
                            <th class="px-4 py-2 w-1/12 text-left">Tanggal</th>
                            <th class="px-4 py-2 w-4/12 text-left">Produk</th>
                            <th class="px-4 py-2 w-1/12 text-right">Jumlah Total Barang</th>
                            <th class="px-4 py-2 w-2/12 text-right">Total Harga Pesanan</th>
                            <th class="px-4 py-2 w-2/12 text-center">Aksi</th>
                            <th class="px-4 py-2 w-1/12 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-2 text-left whitespace-nowrap">#{{ $order->id }}</td>
                                <td class="px-4 py-2 text-left whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 w-4/12 text-left break-words">
                                    {{ $order->items->pluck('product_name')->join(', ') }}
                                </td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">{{ $order->items->sum('stock') }} Barang
                                </td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    Rp.{{ number_format($order->items->sum('total'), 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center whitespace-nowrap">
                                    <button @click="showDetail({{ $order->id }})"
                                        class="px-4 py-1 rounded-lg bg-[#00B69B] text-white font-semibold shadow transition hover:bg-[#00997F]">
                                        Lihat Detail
                                    </button>
                                </td>
                                <td class="px-4 py-2 text-center whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 rounded text-xs font-semibold {{ $order->status === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">Belum ada transaksi
                                    pembelian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="detailOpen" style="display: none;"
            class="flex fixed inset-0 z-50 justify-center items-center bg-black/30">
            <div class="relative p-8 w-full max-w-2xl bg-white rounded-2xl shadow-2xl">
                <button @click="detailOpen = false"
                    class="flex absolute top-6 right-6 justify-center items-center w-10 h-10 text-gray-400 rounded-full transition hover:text-gray-600 hover:bg-gray-100"
                    aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <template x-if="selectedOrder">
                    <div>
                        <h3 class="mb-6 text-2xl font-bold text-gray-900">Detail Transaksi Pembelian #<span
                                x-text="selectedOrder.id"></span></h3>

                        <div class="pb-4 mb-6 border-b">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-semibold" x-text="selectedOrder.date"></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Catatan:</span>
                                <span class="font-semibold text-right" x-text="selectedOrder.notes || '-'"></span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="mb-4 text-lg font-semibold">Item Pesanan</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-xs text-gray-500 uppercase bg-gray-50">
                                            <th class="px-4 py-2 text-left">Barang</th>
                                            <th class="px-4 py-2 text-left">Kategori</th>
                                            <th class="px-4 py-2 text-right">Jumlah</th>
                                            <th class="px-4 py-2 text-right">Harga</th>
                                            <th class="px-4 py-2 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        <template x-for="item in selectedOrder.items" :key="item.id">
                                            <tr>
                                                <td class="px-4 py-2" x-text="item.product_name"></td>
                                                <td class="px-4 py-2" x-text="item.category_name"></td>
                                                <td class="px-4 py-2 text-right" x-text="item.stock + ' Barang'"></td>
                                                <td class="px-4 py-2 text-right"
                                                    x-text="'Rp.' + new Intl.NumberFormat('id-ID').format(item.price)">
                                                </td>
                                                <td class="px-4 py-2 text-right"
                                                    x-text="'Rp.' + new Intl.NumberFormat('id-ID').format(item.total)">
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50">
                                            <td colspan="4" class="px-4 py-2 font-semibold text-right">Grand Total:
                                            </td>
                                            <td class="px-4 py-2 font-semibold text-right"
                                                x-text="'Rp.' + new Intl.NumberFormat('id-ID').format(selectedOrder.items.reduce((sum, item) => sum + item.total, 0))">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button @click="detailOpen = false"
                                class="px-6 py-2 text-white bg-gray-500 rounded-lg transition hover:bg-gray-600">
                                Tutup
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="open" style="display: none;"
            class="flex overflow-y-auto fixed inset-0 z-50 justify-center items-center bg-black/30">
            <form class="relative p-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl my-8 max-h-[90vh] overflow-y-auto"
                x-data="purchaseOrder" @submit.prevent="submitForm">
                <button type="button" @click="open = false"
                    class="flex absolute top-6 right-6 justify-center items-center w-10 h-10 text-gray-400 rounded-full transition hover:text-gray-600 hover:bg-gray-100"
                    aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="mb-2 text-3xl font-bold text-gray-900">Transaksi Pembelian</h3>
                <p class="mb-8 text-gray-500">Isi detail Transaksi Pembelian di bawah ini.</p>
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-base font-semibold">Nama Produk</label>
                        <div class="relative">
                            <select x-model="product_id" @change="onProductChange" x-ref="productInput"
                                class="pl-4 pr-12 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition appearance-none">
                                <option value="">Pilih Produk</option>
                                <template x-for="prod in products" :key="prod.id">
                                    <option :value="prod.id"
                                        x-text="prod.name + ' (' + prod.category + ')' + (prod.stock > 0 ? ' - Stok: ' + prod.stock : ' (Habis)')">
                                    </option>
                                </template>
                            </select>
                            <div class="flex absolute inset-y-0 right-4 items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-base font-semibold">Kategori</label>
                        <input type="text" x-model="category"
                            class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition"
                            placeholder="Kategori" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-base font-semibold">Harga Satuan</label>
                        <div class="relative">
                            <span class="absolute top-3 left-4 text-gray-500">Rp</span>
                            <input type="text" x-model="price"
                                class="pl-12 pr-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition"
                                placeholder="Masukkan Harga" @input="updateTotal" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-base font-semibold">Stok (max: <span
                                x-text="maxStock">0</span>)</label>
                        <input type="number" x-model.number="stock" @input="updateTotal"
                            class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition"
                            placeholder="Masukkan Stok" :max="maxStock">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-base font-semibold">Total Harga</label>
                    <input type="text" x-model="totalItemPriceDisplay"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition"
                        placeholder="Total Harga" readonly>
                </div>
                <div class="mb-8">
                    <label class="block mb-2 text-base font-semibold">Catatan Tambahan</label>
                    <textarea x-model="notes"
                        class="px-4 py-3 w-full text-base bg-gray-100 rounded-lg border-2 border-gray-200 focus:border-[#00B69B] focus:bg-white focus:outline-none transition resize-y"
                        rows="3" placeholder="Masukkan Catatan"></textarea>
                </div>
                <button type="button" @click="addItem" :disabled="!product_id || stock <= 0 || stock > maxStock"
                    class="flex gap-2 justify-center items-center py-3 w-full text-lg font-bold text-white rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    style="background-color: #00B69B;" onmouseover="this.style.backgroundColor='#00997F'"
                    onmouseout="this.style.backgroundColor='#00B69B'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambahkan
                </button>
                <div class="overflow-y-auto mt-8 mb-6 max-h-50">
                    <h4 class="mb-4 text-lg font-semibold">Barang yang Ditambahkan</h4>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex justify-between items-center p-4 mb-2 bg-gray-100 rounded-lg">
                            <div>
                                <div class="font-semibold" x-text="item.product_name"></div>
                                <div class="text-sm text-gray-600"
                                    x-text="'Harga Satuan: ' + formatRupiahDisplay(item.price) + ', Stok: ' + item.stock">
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold" x-text="'Total: ' + formatRupiahDisplay(item.total)"></div>
                                <span class="text-sm text-gray-600" x-text="item.category_name"></span>
                            </div>
                            <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <div x-show="items.length === 0" class="text-center text-gray-500">Belum ada barang ditambahkan</div>
                </div>
                <button type="submit" :disabled="items.length === 0"
                    class="flex gap-2 justify-center items-center py-3 w-full text-lg font-bold text-white rounded-xl shadow-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    style="background-color: #00B69B;" onmouseover="this.style.backgroundColor='#00997F'"
                    onmouseout="this.style.backgroundColor='#00B69B'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Pesanan
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('purchaseOrder', () => ({
                items: [],
                product_id: '',
                product: '',
                category: '',
                price: '',
                stock: '',
                error: '',
                notes: '',
                products: @json($products),
                loadingProducts: false,
                maxStock: 0,

                // Computed property for displaying total item price
                get totalItemPriceDisplay() {
                    const priceInt = parseInt(this.price.replace(/[^0-9]/g, '')) || 0;
                    const stockInt = parseInt(this.stock) || 0;
                    const total = priceInt * stockInt;
                    return this.formatRupiah(total);
                },

                // Method to update total on input change
                updateTotal() {
                    // This method is triggered by @input on price and stock.
                    // The totalItemPriceDisplay getter will automatically re-calculate.
                },

                // Helper to format currency
                formatRupiah(val) {
                    if (!val) return '';
                    return 'Rp. ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                },

                // Helper to format currency for display in table
                formatRupiahDisplay(val) {
                    if (!val) return 'Rp 0';
                    return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                },

                onProductChange() {
                    const selected = this.products.find(p => p.id == this.product_id);
                    if (selected) {
                        this.product = selected.name;
                        this.category = selected.category;
                        this.price = selected.price.toString();
                        this.stock = '';
                        this.maxStock = selected.stock;
                    } else {
                        this.product = '';
                        this.category = '';
                        this.price = '';
                        this.stock = '';
                        this.maxStock = 0;
                    }
                },
                resetFields() {
                    this.product_id = '';
                    this.product = '';
                    this.category = '';
                    this.price = '';
                    this.stock = '';
                    this.error = '';
                    this.maxStock = 0;
                    this.$nextTick(() => this.$refs.productInput.focus());
                },
                addItem() {
                    if (!this.product_id || !this.product || !this.category || this.price === '' || this
                        .price === null || this.stock === '' || this.stock === null || parseInt(this
                            .stock) <= 0) {
                        this.error = 'Semua field (Nama Produk, Stok, Harga) wajib diisi dengan benar.';
                        return;
                    }
                    if (parseInt(this.stock) > this.maxStock) {
                        this.error = 'Stok melebihi stok produk tersedia.';
                        return;
                    }

                    const priceInt = parseInt(this.price.replace(/[^0-9]/g, '')) || 0;
                    const stockInt = parseInt(this.stock) || 0;
                    const itemTotal = priceInt * stockInt;

                    this.items.push({
                        product_id: this.product_id,
                        product_name: this.product,
                        category_name: this.category,
                        price: priceInt,
                        stock: stockInt,
                        total: itemTotal
                    });
                    this.resetFields();
                    this.error = ''; // Clear error on success
                },
                removeItem(idx) {
                    this.items.splice(idx, 1);
                },
                async submitForm() {
                    if (this.items.length === 0) {
                        this.error = 'Minimal satu item harus ditambahkan.';
                        return;
                    }

                    try {
                        const response = await fetch(
                            '{{ route('staff.purchase-orders.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    notes: this.notes,
                                    items: this.items.map(item => ({
                                        product_id: item.product_id,
                                        product: item.product_name,
                                        category: item.category_name,
                                        price: item.price,
                                        stock: item.stock,
                                        total: item.total
                                    }))
                                })
                            });

                        const data = await response.json();
                        console.log('Response:', data);

                        if (data.success) {
                            window.location.reload();
                        } else {
                            this.error = data.message ||
                                'Terjadi kesalahan saat menyimpan pesanan.';
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.error = 'Terjadi kesalahan saat menyimpan pesanan.';
                    }
                }
            }));
        });

        // Handle date range selection
        document.querySelector('select[name="date_range"]').addEventListener('change', function() {
            const today = new Date();
            const startDate = document.querySelector('input[name="start_date"]');
            const endDate = document.querySelector('input[name="end_date"]');

            switch (this.value) {
                case 'this_week':
                    const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                    const endOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                    startDate.value = startOfWeek.toISOString().split('T')[0];
                    endDate.value = endOfWeek.toISOString().split('T')[0];
                    break;
                case 'this_month':
                    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    startDate.value = startOfMonth.toISOString().split('T')[0];
                    endDate.value = endOfMonth.toISOString().split('T')[0];
                    break;
                default:
                    startDate.value = '';
                    endDate.value = '';
            }
        });
    </script>
@endpush
