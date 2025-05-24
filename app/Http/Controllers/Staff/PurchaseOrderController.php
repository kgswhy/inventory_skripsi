<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::with('items');

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by product name
        if ($request->filled('product_name')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->product_name . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('category_name', $request->category);
            });
        }

        $orders = $query->get();

        // Get unique categories for filter dropdown
        $categories = PurchaseOrderItem::select('category_name')
            ->distinct()
            ->pluck('category_name');

        $products = Product::with('category')
            ->where('status', 'tersedia')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category ? $product->category->name : null,
                    'category_id' => $product->category_id,
                    'price' => (int)$product->price,
                    'stock' => (int)$product->stock,
                ];
            });

        return view('staff.purchase_orders', compact('orders', 'products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.product' => 'required|string',
            'items.*.category' => 'required|string',
            'items.*.price' => 'required|integer|min:0',
            'items.*.stock' => 'required|integer|min:1',
            'items.*.total' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();
            
            $order = PurchaseOrder::create([
                'date' => $validated['date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product'],
                    'category_name' => $item['category'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'total' => $item['total'],
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['stock']);
                    $product->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Pesanan berhasil disimpan',
                'order' => $order->load('items')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in PurchaseOrderController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $order = PurchaseOrder::with(['items' => function($query) {
                $query->select('id', 'purchase_order_id', 'product_name', 'category_name', 'stock', 'price', 'total');
            }])->findOrFail($id);

            return response()->json([
                'id' => $order->id,
                'date' => $order->date,
                'notes' => $order->notes,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product_name,
                        'category_name' => $item->category_name,
                        'stock' => $item->stock,
                        'price' => $item->price,
                        'total' => $item->total
                    ];
                })
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in PurchaseOrderController@show: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil detail pesanan'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchase_order)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product' => 'required|string',
            'items.*.category' => 'required|string',
            'items.*.price' => 'required|integer|min:0',
            'items.*.stock' => 'required|integer|min:1',
            'items.*.total' => 'required|integer|min:0',
        ]);
        DB::beginTransaction();
        $purchase_order->update([
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
        ]);
        $purchase_order->items()->delete();
        foreach ($validated['items'] as $item) {
            $purchase_order->items()->create([
                'product_name' => $item['product'],
                'category_name' => $item['category'],
                'price' => $item['price'],
                'stock' => $item['stock'],
                'total' => $item['total'],
            ]);
        }
        DB::commit();
        return response()->json(['success' => true, 'order' => $purchase_order->load('items')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchase_order)
    {
        $purchase_order->items()->delete();
        $purchase_order->delete();
        return response()->json(['success' => true]);
    }
}
