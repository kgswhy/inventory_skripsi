@extends('layouts.app')
@section('title', 'Dashboard')
@section('header-title', 'Dashboard')
@section('content')
<div class="space-y-6">
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
                                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                T2131321
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
                                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                T2131321
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
                                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                T2131321
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
                                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-md">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection