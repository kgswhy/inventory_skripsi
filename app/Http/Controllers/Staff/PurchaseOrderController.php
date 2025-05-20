<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = PurchaseOrder::with(['items.product'])->orderByDesc('date')->get();
        return view('staff.purchase_orders', compact('orders'));
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
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'items.*.total' => 'required|integer|min:0',
        ]);
        DB::beginTransaction();
        $order = PurchaseOrder::create([
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
        ]);
        foreach ($validated['items'] as $item) {
            $order->items()->create($item);
        }
        DB::commit();
        return response()->json(['success' => true, 'order' => $order->load('items.product')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchase_order)
    {
        return response()->json($purchase_order->load('items.product'));
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
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'items.*.total' => 'required|integer|min:0',
        ]);
        DB::beginTransaction();
        $purchase_order->update([
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
        ]);
        $purchase_order->items()->delete();
        foreach ($validated['items'] as $item) {
            $purchase_order->items()->create($item);
        }
        DB::commit();
        return response()->json(['success' => true, 'order' => $purchase_order->load('items.product')]);
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
