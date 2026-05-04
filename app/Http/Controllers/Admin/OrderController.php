<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->orderByDesc('id')
            ->paginate(30);

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipped,delivered,cancelled'],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect("/admin/orders/{$order->id}");
    }
}
