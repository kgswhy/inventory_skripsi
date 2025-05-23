@extends('layouts.app')
@section('title', 'Dashboard')
@section('header-title', 'Dashboard')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="space-y-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Monthly Profit Card -->
                <div class="bg-white rounded-lg shadow p-6 relative">
                    <div class="flex flex-col">
                        <h2 class="text-gray-600 text-sm">Keuntungan Bulan ini</h2>
                        <p class="text-2xl font-semibold text-gray-800">Rp.23.560.000</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Keuntungan <span class="text-green-500">hari ini</span></span>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 bg-gray-200 rounded-lg p-3 opacity-50">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Total Transactions Card -->
                <div class="bg-white rounded-lg shadow p-6 relative">
                    <div class="flex flex-col">
                        <h2 class="text-gray-600 text-sm">Total Transaksi</h2>
                        <p class="text-2xl font-semibold text-gray-800">54</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Total Transaksi <span class="text-green-500">hari ini</span></span>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 bg-green-200 rounded-lg p-3 opacity-50">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Total Staff Card -->
                <div class="bg-white rounded-lg shadow p-6 relative">
                    <div class="flex flex-col">
                        <h2 class="text-gray-600 text-sm">Total staff</h2>
                        <p class="text-2xl font-semibold text-gray-800">53</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Total Staff <span class="text-green-500">hari ini</span></span>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 bg-red-200 rounded-lg p-3 opacity-50">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Date Range and Print Button -->
            <div class="flex justify-end space-x-4 items-center">
                <div class="flex items-center text-gray-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>01/04/2024 - 08/04/2024</span>
                    </div>
                </div>
                <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md">
                    Cetak laporan
                </button>
            </div>
            
            <!-- Recent Transactions Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Latest Transaction</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Transaction ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Detail
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        T2131321
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        4 Barang
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        13 May 2025 18:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Berhasil
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button 
                                            class="detail-btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md"
                                            data-id="T2131321"
                                            data-barang="Sepatu Bola"
                                            data-date="13 May 2025"
                                            data-status="Berhasil"
                                            data-price="Rp. 221.000"
                                            data-unit-price="Rp. 13000"
                                            data-stock="17"
                                            data-quantity="17"
                                            data-payment="Transfer Bank"
                                            data-note="Pembayaran diterima dengan baik. Barang siap dikirim.">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        T2131322
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        5 Barang
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        8 May 2025 12:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Gagal
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button 
                                            class="detail-btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md"
                                            data-id="T2131322"
                                            data-barang="Baju Olahraga"
                                            data-date="8 May 2025"
                                            data-status="Gagal"
                                            data-price="Rp. 1.750.000"
                                            data-unit-price="Rp. 350.000"
                                            data-stock="12"
                                            data-quantity="5"
                                            data-payment="E-Wallet"
                                            data-note="Pembayaran gagal diproses. Silakan coba lagi atau hubungi customer service.">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        T2131323
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        6 Barang
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        4 May 2025 16:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Berhasil
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button 
                                            class="detail-btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md"
                                            data-id="T2131323"
                                            data-barang="Celana Training"
                                            data-date="4 May 2025"
                                            data-status="Berhasil"
                                            data-price="Rp. 3.200.000"
                                            data-unit-price="Rp. 533.333"
                                            data-stock="24"
                                            data-quantity="6"
                                            data-payment="Cash"
                                            data-note="Transaksi berhasil. Terima kasih atas kepercayaan Anda.">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        T2131324
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        3 Barang
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        3 May 2025 11:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Berhasil
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button 
                                            class="detail-btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md"
                                            data-id="T2131324"
                                            data-barang="Jaket Olahraga"
                                            data-date="3 May 2025"
                                            data-status="Berhasil"
                                            data-price="Rp. 1.890.000"
                                            data-unit-price="Rp. 630.000"
                                            data-stock="8"
                                            data-quantity="3"
                                            data-payment="Credit Card"
                                            data-note="Pembayaran berhasil diverifikasi. Pesanan dalam proses pengiriman.">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transaction Detail Modal -->
            <div id="transactionModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 transform scale-95 transition-all duration-200" id="modalContent">
                    <!-- Header -->
                    <div class="bg-gray-50 px-6 py-4 rounded-t-lg">
                        <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
                        <p class="text-sm text-gray-500 mt-1">ini adalah detail transaksi</p>
                    </div>

                    <!-- Main Content -->
                    <div class="p-6">
                        <!-- Barang Section (Expandable) -->
                        <div class="border border-teal-300 rounded-lg mb-4">
                            <button class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 rounded-lg transition-colors" id="barangToggle">
                                <span class="font-semibold text-gray-800">Barang</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" id="barangChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="px-4 pb-4" id="barangContent">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">ID Transaksi</label>
                                        <div class="bg-gray-100 rounded-md px-3 py-2">
                                            <span class="text-gray-800 text-sm" id="modalId">-</span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Produk</label>
                                            <div class="bg-gray-100 rounded-md px-3 py-2">
                                                <span class="text-gray-800 text-xs" id="modalBarang">-</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal</label>
                                            <div class="bg-gray-100 rounded-md px-3 py-2">
                                                <span class="text-gray-800 text-xs" id="modalDate">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Harga Satuan</label>
                                            <div class="bg-gray-100 rounded-md px-3 py-2">
                                                <span class="text-gray-800 text-xs" id="modalUnitPrice">-</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Stok</label>
                                            <div class="bg-gray-100 rounded-md px-3 py-2">
                                                <span class="text-gray-800 text-xs" id="modalStock">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Total Harga</label>
                                        <div class="bg-gray-100 rounded-md px-3 py-2">
                                            <span class="text-gray-800 text-sm font-semibold" id="modalPrice">-</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-md font-medium transition-colors">
                                            Tambahkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Detail Section (Expandable) -->
                        <div class="border border-teal-300 rounded-lg">
                            <button class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 rounded-lg transition-colors" id="productToggle">
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-800" id="modalProductName">Sepatu Bola</span>
                                    <div class="text-xs text-gray-500 mt-1" id="modalQuantity">17pc</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" id="productChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 14l5-5 5 5"></path>
                                </svg>
                            </button>
                            <div class="px-4 pb-4 hidden" id="productContent">
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium" id="modalStatus">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Metode Pembayaran:</span>
                                        <span class="text-gray-800" id="modalPayment">-</span>
                                    </div>
                                    <div class="border-t pt-3">
                                        <span class="text-gray-600">Keterangan:</span>
                                        <p class="text-gray-800 mt-1" id="modalNote">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('transactionModal');
            const modalContent = document.getElementById('modalContent');
            const detailButtons = document.querySelectorAll('.detail-btn');
            const barangToggle = document.getElementById('barangToggle');
            const barangContent = document.getElementById('barangContent');
            const barangChevron = document.getElementById('barangChevron');
            const productToggle = document.getElementById('productToggle');
            const productContent = document.getElementById('productContent');
            const productChevron = document.getElementById('productChevron');

            // Function to open modal
            function openModal(transactionData) {
                // Populate modal with data
                document.getElementById('modalId').textContent = transactionData.id;
                document.getElementById('modalBarang').textContent = transactionData.barang;
                document.getElementById('modalDate').textContent = transactionData.date;
                document.getElementById('modalStatus').textContent = transactionData.status;
                document.getElementById('modalPrice').textContent = transactionData.price;
                document.getElementById('modalUnitPrice').textContent = transactionData.unitPrice;
                document.getElementById('modalStock').textContent = transactionData.stock;
                document.getElementById('modalPayment').textContent = transactionData.payment;
                document.getElementById('modalNote').textContent = transactionData.note || 'Tidak ada keterangan';
                document.getElementById('modalProductName').textContent = transactionData.barang;
                document.getElementById('modalQuantity').textContent = transactionData.quantity + 'pc';

                // Set status color
                const statusElement = document.getElementById('modalStatus');
                if (transactionData.status === 'Berhasil') {
                    statusElement.className = 'font-medium text-green-600';
                } else {
                    statusElement.className = 'font-medium text-red-600';
                }

                // Show modal with animation
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);

                currentModal = modal;
            }

            // Function to close modal
            function closeModalFunc() {
                if (currentModal) {
                    modalContent.classList.remove('scale-100');
                    modalContent.classList.add('scale-95');
                    setTimeout(() => {
                        currentModal.classList.add('hidden');
                        currentModal = null;
                    }, 200);
                }
            }

            // Toggle Barang section
            barangToggle.addEventListener('click', function() {
                barangContent.classList.toggle('hidden');
                barangChevron.classList.toggle('rotate-180');
            });

            // Toggle Product section
            productToggle.addEventListener('click', function() {
                productContent.classList.toggle('hidden');
                productChevron.classList.toggle('rotate-180');
            });

            // Add click event to all detail buttons
            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const transactionData = {
                        id: this.getAttribute('data-id'),
                        barang: this.getAttribute('data-barang'),
                        date: this.getAttribute('data-date'),
                        status: this.getAttribute('data-status'),
                        price: this.getAttribute('data-price'),
                        unitPrice: this.getAttribute('data-unit-price'),
                        stock: this.getAttribute('data-stock'),
                        quantity: this.getAttribute('data-quantity'),
                        payment: this.getAttribute('data-payment'),
                        note: this.getAttribute('data-note')
                    };
                    openModal(transactionData);
                });
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModalFunc();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && currentModal && !currentModal.classList.contains('hidden')) {
                    closeModalFunc();
                }
            });
        });
    </script>
@endsection