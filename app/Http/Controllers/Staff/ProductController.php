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
        try {
            $products = Product::with('category')->get();
            $categories = Category::all();

            if (config('app.debug')) {
                \Log::info('Products data:', ['products' => $products->toArray()]);
                \Log::info('Categories data:', ['categories' => $categories->toArray()]);
            }

            return view('staff.products', compact('products', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Error in ProductController@index: ' . $e->getMessage());
            return view('staff.products', ['products' => collect([]), 'categories' => collect([])]);
        }
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
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
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product->load('category')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e instanceof \Illuminate\Validation\ValidationException ? $e->errors() : null
            ], 422);
        }
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

    /**
     * Return a list of products for purchase order dropdown.
     */
    public function list()
    {
        try {
            \Log::info('Fetching products for purchase order - Request received');
            \Log::info('Request details:', [
                'url' => request()->url(),
                'method' => request()->method(),
                'headers' => request()->headers->all(),
                'authenticated' => auth()->check(),
                'user' => auth()->user() ? [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                    'role' => auth()->user()->role ?? 'unknown'
                ] : null
            ]);

            if (!auth()->check()) {
                \Log::warning('Unauthenticated request to products/list');
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $products = Product::with('category')
                ->where('status', 'tersedia')
                ->get();

            \Log::info('Raw products query result:', ['count' => $products->count()]);

            $mappedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category ? $product->category->name : null,
                    'category_id' => $product->category_id,
                    'price' => (int) $product->price,
                    'stock' => (int) $product->stock,
                ];
            })->values();

            \Log::info('Mapped products:', ['products' => $mappedProducts->toArray()]);

            return response()->json($mappedProducts, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            \Log::error('Error in ProductController@list: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch products: ' . $e->getMessage()], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
