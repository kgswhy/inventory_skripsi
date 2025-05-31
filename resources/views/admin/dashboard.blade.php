@extends('layouts.app')
@section('title', 'Dashboard')
@section('header-title', 'Dashboard')
@section('content')
    <div class="container mx-auto px-4 py-8" x-data="dashboardData()">
        <div class="space-y-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                @if(isset($error))
                    <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $error }}
                    </div>
                @endif
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Monthly Profit Card -->
                <div class="bg-white rounded-lg shadow p-6 relative">
                    <div class="flex flex-col">
                        <h2 class="text-gray-600 text-sm">Keuntungan Bulan ini</h2>
                        <p class="text-2xl font-semibold text-gray-800">Rp. {{ number_format($monthlyTotal ?? 0, 0, ',', '.') }}</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Keuntungan <span class="text-green-500">hari ini: Rp. {{ number_format($todayTotal ?? 0, 0, ',', '.') }}</span></span>
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
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalTransactions ?? 0 }}</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Transaksi <span class="text-green-500">hari ini: {{ $todayTransactions ?? 0 }}</span></span>
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
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalStaff ?? 0 }}</p>
                        <div class="flex items-center mt-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            <span class="text-sm text-gray-600 ml-1">Total <span class="text-green-500">staff terdaftar</span></span>
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
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Periode Laporan:</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="date" id="startDate" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" 
                               class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <span class="text-gray-400">s/d</span>
                        <input type="date" id="endDate" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                               class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md flex items-center space-x-2" onclick="printReport()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <span>Cetak Laporan</span>
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
                                        ID Pesanan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
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
                                @forelse($latestTransactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $transaction['id'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction['items_count'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction['date'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction['status_class'] }}">
                                                {{ $transaction['status'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button 
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md"
                                                @click="showDetail('{{ $transaction['id'] }}')">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada transaksi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function dashboardData() {
            return {
                detailOpen: false,
                selectedOrder: null,
                error: null,

                async showDetail(transactionId) {
                    try {
                        this.error = null;
                        // Extract numeric ID from formatted ID (e.g., "T0000001" -> "1")
                        const numericId = transactionId.replace(/^T0*/, '');
                        
                        const response = await fetch(`/admin/transactions/${numericId}/detail`);
                        
                        if (!response.ok) {
                            throw new Error('Gagal mengambil detail transaksi');
                        }
                        
                        const data = await response.json();
                        
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        this.selectedOrder = data;
                        this.detailOpen = true;
                    } catch (error) {
                        console.error('Error fetching transaction details:', error);
                        this.error = error.message;
                        alert(this.error);
                    }
                }
            }
        }

        // Function to handle print report
        async function printReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate || !endDate) {
                alert('Silakan pilih tanggal mulai dan tanggal akhir terlebih dahulu.');
                return;
            }
            
            if (startDate > endDate) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
                return;
            }
            
            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Memproses...</span>';
            button.disabled = true;
            
            try {
                // Fetch report data via AJAX
                const response = await fetch(`{{ route('admin.report.data') }}?start_date=${startDate}&end_date=${endDate}`);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Gagal mengambil data laporan');
                }
                
                const data = result.data;
                
                // Generate print HTML
                const printHTML = generatePrintHTML(data);
                
                // Create hidden iframe for printing
                const iframe = document.createElement('iframe');
                iframe.style.position = 'absolute';
                iframe.style.width = '0px';
                iframe.style.height = '0px';
                iframe.style.left = '-99999px';
                document.body.appendChild(iframe);
                
                // Write content to iframe
                iframe.contentDocument.open();
                iframe.contentDocument.write(printHTML);
                iframe.contentDocument.close();
                
                // Wait for content to load then print
                iframe.onload = function() {
                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                        
                        // Remove iframe after printing
                        setTimeout(() => {
                            document.body.removeChild(iframe);
                        }, 1000);
                    }, 500);
                };
                
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }
        
        // Function to generate print HTML
        function generatePrintHTML(data) {
            let transactionsHTML = '';
            let grandTotal = 0;
            
            if (data.transactions.length > 0) {
                data.transactions.forEach((transaction, index) => {
                    if (transaction.status === 'Berhasil') {
                        grandTotal += transaction.total_price;
                    }
                    
                    transactionsHTML += `
                        <tr>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${index + 1}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${transaction.id}</td>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${transaction.date}</td>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">
                                <span style="color: ${transaction.status === 'Berhasil' ? '#16a34a' : '#dc2626'}; font-weight: bold;">
                                    ${transaction.status}
                                </span>
                            </td>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${transaction.items_count} items</td>
                            <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">${transaction.formatted_total}</td>
                        </tr>
                    `;
                });
                
                transactionsHTML += `
                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                        <td colspan="5" style="text-align: right; padding: 8px; border: 1px solid #ddd;"><strong>GRAND TOTAL:</strong></td>
                        <td style="text-align: right; padding: 8px; border: 1px solid #ddd;"><strong>Rp ${grandTotal.toLocaleString('id-ID')}</strong></td>
                    </tr>
                `;
            } else {
                transactionsHTML = '<tr><td colspan="6" style="text-align: center; padding: 8px; border: 1px solid #ddd;">Tidak ada transaksi dalam periode ini</td></tr>';
            }
            
            let productStatsHTML = '';
            if (data.product_stats.length > 0) {
                data.product_stats.forEach((product, index) => {
                    productStatsHTML += `
                        <tr>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${index + 1}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${product.product_name}</td>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${product.total_sold} pcs</td>
                            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">${product.transaction_count}x</td>
                            <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">${product.formatted_revenue}</td>
                        </tr>
                    `;
                });
            }
            
            return `
                <!DOCTYPE html>
                <html lang="id">
                <head>
                    <meta charset="UTF-8">
                    <title>Laporan Transaksi - ${data.start_date} s/d ${data.end_date}</title>
                    <style>
                        @media print {
                            body { margin: 0; }
                            .page-break { page-break-before: always; }
                        }
                        
                        body { 
                            font-family: Arial, sans-serif; 
                            margin: 20px;
                            font-size: 12px;
                            line-height: 1.4;
                        }
                        
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #333;
                            padding-bottom: 20px;
                        }
                        
                        .company-name {
                            font-size: 24px;
                            font-weight: bold;
                            margin-bottom: 5px;
                        }
                        
                        .report-title {
                            font-size: 18px;
                            margin: 10px 0;
                        }
                        
                        .date-range {
                            font-size: 14px;
                            color: #666;
                        }
                        
                        .summary-grid {
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                            gap: 15px;
                            margin: 20px 0;
                        }
                        
                        .summary-card {
                            border: 1px solid #ddd;
                            padding: 15px;
                            text-align: center;
                            border-radius: 5px;
                        }
                        
                        .summary-value {
                            font-size: 20px;
                            font-weight: bold;
                            color: #2563eb;
                        }
                        
                        .summary-label {
                            font-size: 11px;
                            color: #666;
                            margin-top: 5px;
                        }
                        
                        .section-title {
                            font-size: 16px;
                            font-weight: bold;
                            margin: 30px 0 15px 0;
                            padding-bottom: 5px;
                            border-bottom: 1px solid #ccc;
                        }
                        
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                            font-size: 11px;
                        }
                        
                        th {
                            background-color: #f5f5f5;
                            font-weight: bold;
                            padding: 8px;
                            border: 1px solid #ddd;
                        }
                        
                        .print-info {
                            margin-top: 30px;
                            font-size: 10px;
                            color: #666;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <!-- Header -->
                    <div class="header">
                        <div class="report-title">LAPORAN TRANSAKSI</div>
                        <div class="date-range">Periode: ${data.start_date} s/d ${data.end_date}</div>
                    </div>

                    <!-- Summary Statistics -->
                    <div class="summary-grid">
                        <div class="summary-card">
                            <div class="summary-value">${data.total_transactions}</div>
                            <div class="summary-label">Total Transaksi</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value">${data.successful_transactions}</div>
                            <div class="summary-label">Transaksi Berhasil</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value">${data.formatted_monthly_total}</div>
                            <div class="summary-label">Total Pendapatan</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value">${data.total_products}</div>
                            <div class="summary-label">Total Produk</div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="section-title">📋 Detail Transaksi</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th>ID Transaksi</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Jumlah Item</th>
                                <th style="text-align: right;">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${transactionsHTML}
                        </tbody>
                    </table>

                    ${data.product_stats.length > 0 ? `
                    <!-- Product Statistics -->
                    <div class="section-title page-break">📊 Statistik Produk Terlaris</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th>Nama Produk</th>
                                <th style="text-align: center;">Total Terjual</th>
                                <th style="text-align: center;">Jumlah Transaksi</th>
                                <th style="text-align: right;">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${productStatsHTML}
                        </tbody>
                    </table>
                    ` : ''}

                    <!-- Print Info -->
                    <div class="print-info">
                        <p>Laporan dicetak pada: ${data.printed_at}</p>
                        <p>Dicetak oleh: ${data.printed_by} (${data.user_role})</p>
                        <p>{{ config('app.name') }}</p>
                    </div>
                </body>
                </html>
            `;
        }
    </script>
@endsection