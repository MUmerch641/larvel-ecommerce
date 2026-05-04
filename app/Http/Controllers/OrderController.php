<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function thankYou(string $order_number)
    {
        $order = Order::query()
            ->where('order_number', $order_number)
            ->with('items')
            ->firstOrFail();

        return view('orders.thank-you', [
            'order' => $order,
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(20);

        return view('account.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(string $order_number)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $order = Order::query()
            ->where('order_number', $order_number)
            ->where('user_id', $user->id)
            ->with('items')
            ->firstOrFail();

        return view('account.orders.show', [
            'order' => $order,
        ]);
    }
}
