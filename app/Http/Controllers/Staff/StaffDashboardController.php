<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    public function index()
    {
        try {
            // Get today's date
            $today = Carbon::today();
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Get monthly total purchases from purchase_order_items
            $monthlyTotal = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereBetween('purchase_orders.date', [$startOfMonth, $endOfMonth])
                ->sum('purchase_order_items.total');

            // Get today's total purchases from purchase_order_items
            $todayTotal = DB::table('purchase_order_items')
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->whereDate('purchase_orders.date', $today)
                ->sum('purchase_order_items.total');

            // Get total transactions
            $totalTransactions = PurchaseOrder::count();
            $todayTransactions = PurchaseOrder::whereDate('date', $today)->count();

            // Get total products and low stock count
            $totalProducts = Product::count();
            $lowStockProducts = Product::with('category')
                ->where('stock', '<', 5)
                ->orderBy('stock', 'asc')
                ->take(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'stock' => $product->stock,
                        'status' => $product->stock == 0 ? 'Habis' : 'Menipis',
                        'category' => $product->category->name
                    ];
                });
            $lowStockCount = $lowStockProducts->count();

            // Get recent transactions from purchase_orders with items
            $recentTransactions = DB::table('purchase_orders')
                ->join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->select(
                    'purchase_orders.date',
                    'purchase_order_items.product_name',
                    'purchase_order_items.stock',
                    'purchase_order_items.total'
                )
                ->orderBy('purchase_orders.date', 'desc')
                ->orderBy('purchase_orders.created_at', 'desc')
                ->limit(5)
                ->get();

            // Debug information
            \Log::info('Dashboard Data:', [
                'monthlyTotal' => $monthlyTotal,
                'todayTotal' => $todayTotal,
                'totalTransactions' => $totalTransactions,
                'todayTransactions' => $todayTransactions,
                'totalProducts' => $totalProducts,
                'lowStockCount' => $lowStockCount,
                'recentTransactions' => $recentTransactions->toArray()
            ]);

            return view('staff.dashboard', compact(
                'monthlyTotal',
                'todayTotal',
                'totalTransactions',
                'todayTransactions',
                'totalProducts',
                'lowStockProducts',
                'lowStockCount',
                'recentTransactions'
            ));
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return view('staff.dashboard', [
                'monthlyTotal' => 0,
                'todayTotal' => 0,
                'totalTransactions' => 0,
                'todayTransactions' => 0,
                'totalProducts' => 0,
                'lowStockProducts' => collect(),
                'lowStockCount' => 0,
                'recentTransactions' => collect(),
                'error' => 'Terjadi kesalahan saat memuat data dashboard: ' . $e->getMessage()
            ]);
        }
    }
}