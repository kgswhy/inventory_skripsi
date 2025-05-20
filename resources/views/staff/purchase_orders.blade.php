@extends('layouts.staff')

@section('header-title', 'PURCHASE ORDER')

@section('content')
<div x-data="{ open: false }">
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-5a2 2 0 00-2-2h-1V7a2 2 0 00-2-2h-2a2 2 0 00-2 2v7H7a2 2 0 00-2 2v5a2 2 0 002 2z" /></svg>
                <h1 class="text-lg font-semibold">Pesanan Pembelian</h1>
            </div>
            <button @click="open = true" class="bg-green-400 hover:bg-green-500 text-white px-6 py-2 rounded-md font-semibold">+ Bikin pesanan pembelian</button>
        </div>
        <div class="flex flex-wrap gap-4 mb-6">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                <div class="flex items-center space-x-2">
                    <select class="border rounded px-3 py-2 bg-gray-100 text-sm">
                        <option>Minggu ini</option>
                        <option>Bulan ini</option>
                    </select>
                    <input type="date" class="border rounded px-3 py-2 bg-gray-100 text-sm" value="2025-05-15">
                    <span class="mx-1">→</span>
                    <input type="date" class="border rounded px-3 py-2 bg-gray-100 text-sm" value="2025-05-21">
                </div>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Barang</label>
                <select class="border rounded px-3 py-2 bg-gray-100 text-sm">
                    <option>nama Barang</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Kategori</label>
                <select class="border rounded px-3 py-2 bg-gray-100 text-sm">
                    <option>Select</option>
                </select>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">List Barang</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-4 py-2">ID Item</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">SKU / Kode Produk</th>
                        <th class="px-4 py-2">Jumlah Barang</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Total Harga</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="px-4 py-2">#22314644</td>
                        <td class="px-4 py-2">15 May 2025</td>
                        <td class="px-4 py-2">Baju Panjang</td>
                        <td class="px-4 py-2">Pakaian Wanita</td>
                        <td class="px-4 py-2">SKU12345</td>
                        <td class="px-4 py-2">43 Barang</td>
                        <td class="px-4 py-2">Rp.34.000</td>
                        <td class="px-4 py-2">Rp.1.462.000</td>
                        <td class="px-4 py-2"><button class="bg-green-200 text-green-800 px-4 py-1 rounded">Download</button></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">#22314644</td>
                        <td class="px-4 py-2">15 May 2025</td>
                        <td class="px-4 py-2">Celana Panjang</td>
                        <td class="px-4 py-2">Pakaian Pria</td>
                        <td class="px-4 py-2">SKU12345</td>
                        <td class="px-4 py-2">23 Barang</td>
                        <td class="px-4 py-2">Rp.14.000</td>
                        <td class="px-4 py-2">Rp.322.000</td>
                        <td class="px-4 py-2"><button class="bg-green-200 text-green-800 px-4 py-1 rounded">Download</button></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">#22314644</td>
                        <td class="px-4 py-2">15 May 2025</td>
                        <td class="px-4 py-2">Baju Piyama</td>
                        <td class="px-4 py-2">Pakaian Wanita</td>
                        <td class="px-4 py-2">SKU12345</td>
                        <td class="px-4 py-2">76 Barang</td>
                        <td class="px-4 py-2">Rp.23.000</td>
                        <td class="px-4 py-2">Rp.1.748.000</td>
                        <td class="px-4 py-2"><button class="bg-green-200 text-green-800 px-4 py-1 rounded">Download</button></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">#22314644</td>
                        <td class="px-4 py-2">15 May 2025</td>
                        <td class="px-4 py-2">Baju Koko</td>
                        <td class="px-4 py-2">Pakaian Pria</td>
                        <td class="px-4 py-2">SKU12345</td>
                        <td class="px-4 py-2">16 Barang</td>
                        <td class="px-4 py-2">Rp.13.000</td>
                        <td class="px-4 py-2">Rp.208.000</td>
                        <td class="px-4 py-2"><button class="bg-green-200 text-green-800 px-4 py-1 rounded">Download</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-8 relative">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold mb-6">Pesanan Pembelian</h2>
            <form>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold mb-1">Nama Produk</label>
                        <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="Masukkan Nama">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Kategori</label>
                        <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="Masukkan Nama">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">SKU / Kode Barang</label>
                    <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="Masukkan Nama">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold mb-1">Harga Satuan</label>
                        <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="Masukkan Harga">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Stok</label>
                        <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="Masukkan Stok">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Total Harga</label>
                    <input type="text" class="w-full bg-gray-100 rounded-md px-4 py-2" placeholder="">
                </div>
                <div class="mb-6">
                    <label class="block font-semibold mb-1">Catatan Tambahan</label>
                    <textarea class="w-full bg-gray-100 rounded-md px-4 py-2" rows="3" placeholder="Masukkan Catatan"></textarea>
                </div>
                <button type="button" class="w-full bg-green-400 hover:bg-green-500 text-white py-3 rounded-md font-semibold">Tambahkan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush 