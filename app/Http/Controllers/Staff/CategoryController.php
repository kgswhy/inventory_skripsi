<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesErrors;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    use HandlesErrors;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->executeWithErrorHandling(function () {
            $categories = Category::all();
            $this->logOperation('view', 'Category');
            return response()->json($categories);
        }, 'mengambil daftar kategori', $request);
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
                'name' => 'required|string|max:255|unique:categories,name',
                'status' => 'required|in:aktif,nonaktif',
            ], [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.unique' => 'Nama kategori sudah ada.',
                'status.required' => 'Status kategori wajib dipilih.',
                'status.in' => 'Status kategori harus aktif atau nonaktif.',
            ]);

            $category = Category::create($validated);
            
            $this->logOperation('create', 'Category', $category->id, $validated);
            
            return $this->successResponse('Kategori berhasil ditambahkan', $category, 201);
        }, 'menambahkan kategori', $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->executeWithErrorHandling(function () use ($category) {
            $this->logOperation('view', 'Category', $category->id);
            return response()->json($category);
        }, 'mengambil detail kategori');
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
    public function update(Request $request, Category $category)
    {
        return $this->executeWithErrorHandling(function () use ($request, $category) {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'status' => 'required|in:aktif,nonaktif',
            ], [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.unique' => 'Nama kategori sudah ada.',
                'status.required' => 'Status kategori wajib dipilih.',
                'status.in' => 'Status kategori harus aktif atau nonaktif.',
            ]);

            $oldData = $category->toArray();
            $category->update($validated);
            
            $this->logOperation('update', 'Category', $category->id, [
                'old' => $oldData,
                'new' => $validated
            ]);
            
            return $this->successResponse('Kategori berhasil diperbarui', $category);
        }, 'memperbarui kategori', $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return $this->executeWithErrorHandling(function () use ($category) {
            // Check if category is being used by products
            if ($category->products()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
                ], 422);
            }

            $categoryData = $category->toArray();
            $category->delete();
            
            $this->logOperation('delete', 'Category', $category->id, $categoryData);
            
            return $this->successResponse('Kategori berhasil dihapus');
        }, 'menghapus kategori');
    }
}
