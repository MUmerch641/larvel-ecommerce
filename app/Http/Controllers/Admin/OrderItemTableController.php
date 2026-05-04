<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw', 1);
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search.value', '');
            
            $query = OrderItem::query()->with('product', 'order');
            
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('product', function ($pq) use ($search) {
                        $pq->where('name', 'like', '%' . $search . '%');
                    })
                      ->orWhereHas('order', function ($oq) use ($search) {
                          $oq->where('order_number', 'like', '%' . $search . '%');
                      });
                });
            }
            
            $totalRecords = OrderItem::count();
            $totalFiltered = $query->count();
            
            $orderItems = $query->offset($start)->limit($length)->get();
            
            $data = $orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'order_number' => $item->order->order_number ?? 'N/A',
                    'product_name' => $item->product->name ?? 'N/A',
                    'quantity' => $item->quantity,
                    'price' => '$' . number_format($item->price, 2),
                    'total_price' => '$' . number_format($item->quantity * $item->price, 2),
                ];
            });
            
            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        }

        return view('admin.order-items.table');
    }
}
