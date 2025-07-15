@extends('layouts.staff')

@section('header-title', 'Dashboard')

@section('content')
@if(isset($error))
<div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg border border-red-400">
    {{ $error }}
</div>
@endif

<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
    <!-- Total Pembelian Card -->
    <div class="flex flex-col items-start p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between w-full mb-4">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mb-2 text-gray-500">Total Pembelian Bulan Ini</div>
        <div class="mb-1 text-2xl font-bold text-gray-800">Rp.{{ number_format($monthlyTotal ?? 0, 0, ',', '.') }}</div>
        <div class="text-sm text-green-500">Total Pembelian <span class="underline">hari ini</span>: Rp.{{ number_format($todayTotal ?? 0, 0, ',', '.') }}</div>
    </div>

    <!-- Jumlah Transaksi Card -->
    <div class="flex flex-col items-start p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between w-full mb-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <div class="mb-2 text-gray-500">Jumlah Transaksi</div>
        <div class="mb-1 text-2xl font-bold text-gray-800">{{ $totalTransactions ?? 0 }}</div>
        <div class="text-sm text-green-500">Transaksi <span class="underline">hari ini</span>: {{ $todayTransactions ?? 0 }}</div>
    </div>

    <!-- Total Produk Card -->
    <div class="flex flex-col items-start p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between w-full mb-4">
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>
        <div class="mb-2 text-gray-500">Total Produk</div>
        <div class="mb-1 text-2xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
        <div class="text-sm text-yellow-500">Stok Menipis: {{ $lowStockCount ?? 0 }}</div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <!-- Stok Menipis Table -->
    <div class="p-6 bg-white rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-lg font-semibold text-gray-800">Stok Menipis</h4>
            <div class="p-2 bg-yellow-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-xs text-left text-gray-500 uppercase bg-gray-50">
                        <th class="px-6 py-3 font-medium">ID Produk</th>
                        <th class="px-6 py-3 font-medium">Nama Produk</th>
                        <th class="px-6 py-3 font-medium">Stok</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($lowStockProducts as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ $product['name'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ $product['category'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ $product['stock'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product['status'] === 'Habis' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500">
                            Tidak ada produk dengan stok menipis
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Transaksi Terakhir Table -->
    <div class="p-6 bg-white rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-lg font-semibold text-gray-800">Transaksi Penjualan Terakhir</h4>
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-xs text-left text-gray-500 uppercase bg-gray-50">
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Produk</th>
                        <th class="px-6 py-3 font-medium">Jumlah</th>
                        <th class="px-6 py-3 font-medium">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentTransactions ?? [] as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ $transaction->product_name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            {{ $transaction->stock }} pcs
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                            Rp.{{ number_format($transaction->total ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
