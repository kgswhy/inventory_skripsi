<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesErrors;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use HandlesErrors;

    public function index()
    {
        return $this->executeWithErrorHandling(function () {
            // Count only staff users (excluding admin)
            $totalStaff = User::where('role', 'staff')->count();
            $activeStaff = User::where('role', 'staff')->count();
            
            // Get today's date and month range
            $today = Carbon::today();
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Get monthly total from purchase_order_items
            $monthlyTotal = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startOfMonth, $endOfMonth])
                ->where('purchase_orders.status', 'berhasil')
                ->sum('purchase_order_items.total');

            // Get today's total from purchase_order_items
            $todayTotal = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereDate('purchase_orders.date', $today)
                ->where('purchase_orders.status', 'berhasil')
                ->sum('purchase_order_items.total');

            // Get total transactions (all time)
            $totalTransactions = PurchaseOrder::count();
            
            // Get today's transactions
            $todayTransactions = PurchaseOrder::whereDate('date', $today)->count();

            // Get latest transactions for the table (limit to 4 as shown in the view)
            $latestTransactions = PurchaseOrder::with(['items' => function($query) {
                    $query->select('purchase_order_id', 'product_name', 'stock', 'total');
                }])
                ->select('id', 'date', 'status', 'notes')
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get()
                ->map(function($order) {
                    $totalItems = $order->items->sum('stock');
                    $totalPrice = $order->items->sum('total');
                    $firstProduct = $order->items->first();
                    
                    return [
                        'id' => 'T' . str_pad($order->id, 7, '0', STR_PAD_LEFT),
                        'items_count' => $totalItems . ' Barang',
                        'date' => Carbon::parse($order->date)->format('d M Y H:i'),
                        'status' => ucfirst($order->status),
                        'status_class' => $order->status === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                        'product_name' => $firstProduct ? $firstProduct->product_name : 'No Items',
                        'total_price' => 'Rp. ' . number_format($totalPrice, 0, ',', '.'),
                        'unit_price' => $firstProduct ? 'Rp. ' . number_format($firstProduct->total / $firstProduct->stock, 0, ',', '.') : 'Rp. 0',
                        'stock' => $firstProduct ? $firstProduct->stock : 0,
                        'quantity' => $totalItems,
                        'payment_method' => $order->status === 'berhasil' ? 'Transfer Bank' : 'E-Wallet', // Default values
                        'notes' => $order->notes ?: ($order->status === 'berhasil' ? 'Pembayaran diterima dengan baik. Barang siap dikirim.' : 'Pembayaran gagal diproses. Silakan coba lagi atau hubungi customer service.')
                    ];
                });
            
            $this->logOperation('view', 'Dashboard', null, ['context' => 'admin_dashboard']);
            
            return view('admin.dashboard', compact(
                'totalStaff',
                'activeStaff',
                'monthlyTotal',
                'todayTotal',
                'totalTransactions',
                'todayTransactions',
                'latestTransactions'
            ));
        }, 'memuat dashboard admin');
    }
    
    public function getTransactionDetail($id)
    {
        return $this->executeWithErrorHandling(function () use ($id) {
            $order = PurchaseOrder::with(['items' => function($query) {
                $query->select('purchase_order_id', 'product_name', 'category_name', 'price', 'stock', 'total');
            }])
            ->select('id', 'date', 'status', 'notes')
            ->findOrFail($id);

            $this->logOperation('view', 'Transaction', $id, ['context' => 'transaction_detail']);

            return response()->json([
                'id' => 'T' . str_pad($order->id, 7, '0', STR_PAD_LEFT),
                'date' => Carbon::parse($order->date)->format('d M Y'),
                'status' => ucfirst($order->status),
                'notes' => $order->notes,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product_name,
                        'category_name' => $item->category_name,
                        'price' => $item->price,
                        'stock' => $item->stock,
                        'total' => $item->total
                    ];
                })
            ]);
        }, 'mengambil detail transaksi');
    }

    public function printReport(Request $request)
    {
        return $this->executeWithErrorHandling(function () use ($request) {
            // Validate and get date range from request or default to current month
            $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::now()->startOfMonth();
            $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::now()->endOfMonth();
            
            // Validate date range
            if ($startDate > $endDate) {
                return redirect()->back()->with('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
            }
            
            // Get statistics for the date range
            $monthlyTotal = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startDate, $endDate])
                ->where('purchase_orders.status', 'berhasil')
                ->sum('purchase_order_items.total');

            $totalTransactions = PurchaseOrder::whereBetween('date', [$startDate, $endDate])->count();
            $successfulTransactions = PurchaseOrder::whereBetween('date', [$startDate, $endDate])->where('status', 'berhasil')->count();
            
            // Get all transactions in the date range
            $transactions = PurchaseOrder::with(['items' => function($query) {
                    $query->select('purchase_order_id', 'product_name', 'category_name', 'price', 'stock', 'total');
                }])
                ->select('id', 'date', 'status', 'notes')
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'desc')
                ->get()
                ->map(function($order) {
                    $totalItems = $order->items->sum('stock');
                    $totalPrice = $order->items->sum('total');
                    
                    return [
                        'id' => 'T' . str_pad($order->id, 7, '0', STR_PAD_LEFT),
                        'date' => Carbon::parse($order->date)->format('d/m/Y'),
                        'status' => ucfirst($order->status),
                        'items_count' => $totalItems,
                        'total_price' => $totalPrice,
                        'formatted_total' => 'Rp. ' . number_format($totalPrice, 0, ',', '.'),
                        'items' => $order->items
                    ];
                });

            // Get product statistics
            $productStats = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startDate, $endDate])
                ->where('purchase_orders.status', 'berhasil')
                ->select('product_name', 
                    DB::raw('SUM(stock) as total_sold'),
                    DB::raw('SUM(total) as total_revenue'),
                    DB::raw('COUNT(*) as transaction_count'))
                ->groupBy('product_name')
                ->orderBy('total_revenue', 'desc')
                ->get();

            $totalStaff = User::where('role', 'staff')->count();
            $totalProducts = Product::count();

            $this->logOperation('generate', 'Report', null, [
                'date_range' => [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')],
                'transactions_count' => $transactions->count()
            ]);

            return view('admin.report', compact(
                'startDate',
                'endDate',
                'monthlyTotal',
                'totalTransactions',
                'successfulTransactions',
                'transactions',
                'productStats',
                'totalStaff',
                'totalProducts'
            ));
        }, 'mencetak laporan', $request);
    }

    public function getReportData(Request $request)
    {
        return $this->executeWithErrorHandling(function () use ($request) {
            $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::now()->startOfMonth();
            $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::now()->endOfMonth();
            
            // Validate date range
            if ($startDate > $endDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                ], 422);
            }
            
            // Get sales data grouped by date
            $salesData = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startDate, $endDate])
                ->where('purchase_orders.status', 'berhasil')
                ->select(
                    DB::raw('DATE(purchase_orders.date) as date'),
                    DB::raw('SUM(purchase_order_items.total) as total_sales'),
                    DB::raw('COUNT(DISTINCT purchase_orders.id) as transaction_count')
                )
                ->groupBy(DB::raw('DATE(purchase_orders.date)'))
                ->orderBy('date')
                ->get();

            // Get product performance
            $productPerformance = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startDate, $endDate])
                ->where('purchase_orders.status', 'berhasil')
                ->select(
                    'product_name',
                    DB::raw('SUM(stock) as total_quantity'),
                    DB::raw('SUM(total) as total_revenue')
                )
                ->groupBy('product_name')
                ->orderBy('total_revenue', 'desc')
                ->limit(10)
                ->get();

            $this->logOperation('view', 'ReportData', null, [
                'date_range' => [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')],
                'data_type' => 'chart_data'
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'sales_data' => $salesData,
                    'product_performance' => $productPerformance,
                    'date_range' => [
                        'start' => $startDate->format('Y-m-d'),
                        'end' => $endDate->format('Y-m-d')
                    ]
                ]
            ]);
        }, 'mengambil data laporan', $request);
    }
} 