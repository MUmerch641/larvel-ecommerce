<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw', 1);
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search.value', '');
            
            $query = Product::query();
            
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('sku', 'like', '%' . $search . '%');
                });
            }
            
            $totalRecords = Product::count();
            $totalFiltered = $query->count();
            
            $products = $query->with('category')->offset($start)->limit($length)->get();
            
            $data = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price_formatted,
                    'quantity' => $product->stock,
                    'category' => $product->category?->name ?? '—',
                    'status' => $product->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>',
                    'actions' => '
                        <a href="/admin/products/' . $product->id . '/edit" class="btn btn-sm btn-primary">Edit</a>
                        <form action="/admin/products/' . $product->id . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ',
                ];
            });
            
            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        }

        return view('admin.products.table');
    }
}
