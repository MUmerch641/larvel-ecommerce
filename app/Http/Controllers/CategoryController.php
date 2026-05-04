<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $products = Product::query()
            ->where('is_active', true)
            ->where('category_id', $category->id)
            ->orderByDesc('id')
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
