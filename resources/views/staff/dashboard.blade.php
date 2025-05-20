@extends('layouts.staff')

@section('header-title', 'DASHBOARD')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-start">
        <div class="text-gray-500 mb-2">Keuntungan Bulan ini</div>
        <div class="text-2xl font-bold mb-1">Rp.23.560.000</div>
        <div class="text-green-500 text-sm">Keuntungan <span class="underline">hari ini</span></div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-start">
        <div class="text-gray-500 mb-2">Total Transaksi</div>
        <div class="text-2xl font-bold mb-1">54</div>
        <div class="text-green-500 text-sm">Total Transaksi <span class="underline">hari ini</span></div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-start">
        <div class="text-gray-500 mb-2">Total staff</div>
        <div class="text-2xl font-bold mb-1">53</div>
        <div class="text-green-500 text-sm">Total Staff <span class="underline">hari ini</span></div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="font-semibold mb-4">Produk Terlaris</h4>
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-xs text-gray-500 uppercase">
                    <th class="py-2">Price ID</th>
                    <th class="py-2">Item Name</th>
                    <th class="py-2">Barang Terjual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2">SKU 123</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Baju Panjang</td>
                    <td class="py-2">14 Pcs</td>
                </tr>
                <tr>
                    <td class="py-2">SKU 123</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Baju Gamis</td>
                    <td class="py-2">14 Pcs</td>
                </tr>
                <tr>
                    <td class="py-2">SKU 123</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Baju Piyama</td>
                    <td class="py-2">12 Pcs</td>
                </tr>
                <tr>
                    <td class="py-2">SKU 123</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Celana pendek</td>
                    <td class="py-2">41 Pcs</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="font-semibold mb-4">Stok Produk</h4>
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-xs text-gray-500 uppercase">
                    <th class="py-2">Id</th>
                    <th class="py-2">Item Name</th>
                    <th class="py-2">Event</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2">PRDK212</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Baju gamis</td>
                    <td class="py-2"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Tersedia</span></td>
                </tr>
                <tr>
                    <td class="py-2">PRDK212</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Asus X541U</td>
                    <td class="py-2"><span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Habis</span></td>
                </tr>
                <tr>
                    <td class="py-2">PRDK212</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Iphone 17 Projo</td>
                    <td class="py-2"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Tersedia</span></td>
                </tr>
                <tr>
                    <td class="py-2">PRDK212</td>
                    <td class="py-2 flex items-center"><img src="https://via.placeholder.com/24" class="mr-2 rounded"/>Samsung Belsayur</td>
                    <td class="py-2"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Tersedia</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
