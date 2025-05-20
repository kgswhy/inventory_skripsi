<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('staff.products', compact('products', 'categories'));
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
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        $product = Product::create($validated);
        return response()->json(['success' => true, 'product' => $product->load('category')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('category'));
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
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($validated);
        return response()->json(['success' => true, 'product' => $product->load('category')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['success' => true]);
    }
}
