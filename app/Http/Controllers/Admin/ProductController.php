<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->with('category')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sku' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = (string) ($validated['slug'] ?? '');
        $slug = $slug !== '' ? $slug : Str::slug($validated['name']);

        $priceCents = (int) round(((float) $validated['price']) * 100);

        Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'price_cents' => $priceCents,
            'stock' => (int) $validated['stock'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect('/admin/products');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sku' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = (string) ($validated['slug'] ?? '');
        $slug = $slug !== '' ? $slug : Str::slug($validated['name']);

        $priceCents = (int) round(((float) $validated['price']) * 100);

        $product->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'price_cents' => $priceCents,
            'stock' => (int) $validated['stock'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $product->delete();

        return redirect('/admin/products');
    }
}
