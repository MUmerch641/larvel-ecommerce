<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw', 1);
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search.value', '');
            
            $query = Order::query()->with('user');
            
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                      });
                });
            }
            
            $totalRecords = Order::count();
            $totalFiltered = $query->count();
            
            $orders = $query->offset($start)->limit($length)->get();
            
            $data = $orders->map(function ($order) {
                $statusColor = match($order->status) {
                    'pending' => 'warning',
                    'processing' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary'
                };
                
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user->name ?? 'N/A',
                    'customer_email' => $order->user->email ?? 'N/A',
                    'total' => '$' . number_format($order->total, 2),
                    'status' => '<span class="badge bg-' . $statusColor . '">' . ucfirst($order->status) . '</span>',
                    'created_at' => $order->created_at->format('M d, Y'),
                    'actions' => '<a href="/admin/orders/' . $order->id . '" class="btn btn-sm btn-info">View</a>',
                ];
            });
            
            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        }

        return view('admin.orders.table');
    }
}
