<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesErrors;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use HandlesErrors;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->executeWithErrorHandling(function () {
            $products = Product::with('category')->get();
            $categories = Category::all();

            $this->logOperation('view', 'Product');

            return view('staff.products', compact('products', 'categories'));
        }, 'mengambil daftar produk', $request);
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
        return $this->executeWithErrorHandling(function () use ($request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|integer|min:0',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:tersedia,habis',
                'image' => 'nullable|image|max:2048',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
                'category_id.required' => 'Kategori produk wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'price.required' => 'Harga produk wajib diisi.',
                'price.integer' => 'Harga produk harus berupa angka.',
                'price.min' => 'Harga produk tidak boleh negatif.',
                'stock.required' => 'Stok produk wajib diisi.',
                'stock.integer' => 'Stok produk harus berupa angka.',
                'stock.min' => 'Stok produk tidak boleh negatif.',
                'status.required' => 'Status produk wajib dipilih.',
                'status.in' => 'Status produk harus tersedia atau habis.',
                'image.image' => 'File harus berupa gambar.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($validated);

            $this->logOperation('create', 'Product', $product->id, $validated);

            return $this->successResponse('Produk berhasil ditambahkan', $product->load('category'), 201);
        }, 'menambahkan produk', $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->executeWithErrorHandling(function () use ($product) {
            $this->logOperation('view', 'Product', $product->id);
            return response()->json($product->load('category'));
        }, 'mengambil detail produk');
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
        return $this->executeWithErrorHandling(function () use ($request, $product) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|integer|min:0',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:tersedia,habis',
                'image' => 'nullable|image|max:2048',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
                'category_id.required' => 'Kategori produk wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'price.required' => 'Harga produk wajib diisi.',
                'price.integer' => 'Harga produk harus berupa angka.',
                'price.min' => 'Harga produk tidak boleh negatif.',
                'stock.required' => 'Stok produk wajib diisi.',
                'stock.integer' => 'Stok produk harus berupa angka.',
                'stock.min' => 'Stok produk tidak boleh negatif.',
                'status.required' => 'Status produk wajib dipilih.',
                'status.in' => 'Status produk harus tersedia atau habis.',
                'image.image' => 'File harus berupa gambar.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $oldData = $product->toArray();
            $product->update($validated);

            $this->logOperation('update', 'Product', $product->id, [
                'old' => $oldData,
                'new' => $validated
            ]);

            return $this->successResponse('Produk berhasil diperbarui', $product->load('category'));
        }, 'memperbarui produk', $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return $this->executeWithErrorHandling(function () use ($product) {
            $productData = $product->toArray();

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            $this->logOperation('delete', 'Product', $product->id, $productData);

            return $this->successResponse('Produk berhasil dihapus');
        }, 'menghapus produk');
    }

    /**
     * Return a list of products for purchase order dropdown.
     */
    public function list()
    {
        return $this->executeWithErrorHandling(function () {
            $products = Product::with('category')
                ->where('status', 'tersedia')
                ->get();

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

            $this->logOperation('view', 'Product', null, ['context' => 'purchase_order_list']);

            return response()->json($mappedProducts, 200, [], JSON_UNESCAPED_UNICODE);
        }, 'mengambil daftar produk untuk pesanan');
    }
}
