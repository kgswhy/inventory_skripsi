<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - {{ $startDate->format('d/m/Y') }} s/d {{ $endDate->format('d/m/Y') }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
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
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .status-berhasil { color: #16a34a; font-weight: bold; }
        .status-gagal { color: #dc2626; font-weight: bold; }
        
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        
        .print-info {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        
        .actions {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <!-- Print Actions -->
    <div class="actions no-print">
        <div class="text-center mb-4">
            <p class="text-gray-600 text-sm">Dialog print akan terbuka otomatis. Jika tidak, klik tombol di bawah:</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Laporan</button>
        <button onclick="window.close() || window.history.back()" class="btn btn-secondary">← Tutup</button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="company-name">SISTEM INVENTORY MANAGEMENT</div>
        <div class="report-title">LAPORAN TRANSAKSI</div>
        <div class="date-range">Periode: {{ $startDate->format('d/m/Y') }} s/d {{ $endDate->format('d/m/Y') }}</div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-value">{{ $totalTransactions }}</div>
            <div class="summary-label">Total Transaksi</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $successfulTransactions }}</div>
            <div class="summary-label">Transaksi Berhasil</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">Rp {{ number_format($monthlyTotal, 0, ',', '.') }}</div>
            <div class="summary-label">Total Pendapatan</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $totalProducts }}</div>
            <div class="summary-label">Total Produk</div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="section-title">📋 Detail Transaksi</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>ID Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Jumlah Item</th>
                <th class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $grandTotal = 0; @endphp
            @forelse($transactions as $transaction)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $transaction['id'] }}</td>
                <td class="text-center">{{ $transaction['date'] }}</td>
                <td class="text-center">
                    <span class="status-{{ strtolower($transaction['status']) }}">
                        {{ $transaction['status'] }}
                    </span>
                </td>
                <td class="text-center">{{ $transaction['items_count'] }} items</td>
                <td class="text-right">{{ $transaction['formatted_total'] }}</td>
            </tr>
            @php if($transaction['status'] === 'Berhasil') $grandTotal += $transaction['total_price']; @endphp
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi dalam periode ini</td>
            </tr>
            @endforelse
            @if($transactions->count() > 0)
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>GRAND TOTAL:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>

    @if($productStats->count() > 0)
    <!-- Product Statistics -->
    <div class="section-title page-break">📊 Statistik Produk Terlaris</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Produk</th>
                <th class="text-center">Total Terjual</th>
                <th class="text-center">Jumlah Transaksi</th>
                <th class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($productStats as $product)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $product->product_name }}</td>
                <td class="text-center">{{ $product->total_sold }} pcs</td>
                <td class="text-center">{{ $product->transaction_count }}x</td>
                <td class="text-right">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Print Info -->
    <div class="print-info">
        <p>Laporan dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Dicetak oleh: {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>
        <p>Sistem Inventory Management - {{ config('app.name') }}</p>
    </div>

    <script>
        // Auto print on load
        window.onload = function() { 
            // Small delay to ensure page is fully loaded
            setTimeout(function() {
                window.print();
            }, 500);
        }
        
        // Handle print completion - close tab after printing
        window.onafterprint = function() {
            // Try to close the tab
            try {
                window.close();
            } catch (e) {
                console.log('Cannot close window automatically');
            }
            
            // If window.close() doesn't work, show message and provide manual close option
            setTimeout(function() {
                if (!window.closed) {
                    const actionDiv = document.querySelector('.actions');
                    if (actionDiv) {
                        actionDiv.innerHTML = `
                            <div class="text-center">
                                <p class="text-green-600 font-semibold mb-4">✅ Laporan telah dicetak!</p>
                                <p class="text-gray-600 text-sm mb-4">Tab ini dapat ditutup secara manual.</p>
                                <button onclick="window.close() || window.history.back()" class="btn btn-primary">← Tutup Tab</button>
                            </div>
                        `;
                    }
                }
            }, 1000);
        }
        
        // Handle if user cancels print dialog
        window.onbeforeprint = function() {
            // This runs before print dialog opens
            console.log('Print dialog opening...');
        }
    </script>
</body>
</html> 