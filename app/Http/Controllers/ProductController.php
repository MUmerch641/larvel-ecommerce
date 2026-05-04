<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $categorySlug = trim((string) $request->query('category', ''));

        $categoryId = null;
        if ($categorySlug !== '') {
            $categoryId = Category::query()->where('slug', $categorySlug)->value('id');
        }

        $products = Product::query()
            ->where('is_active', true)
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub
                        ->where('name', 'like', '%' . $q . '%')
                        ->orWhere('description', 'like', '%' . $q . '%')
                        ->orWhere('sku', 'like', '%' . $q . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('products.index', [
            'products' => $products,
            'q' => $q,
            'category' => $categorySlug,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
