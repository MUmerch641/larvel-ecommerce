<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featured = Product::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return view('home', [
            'featured' => $featured,
        ]);
    }
}
