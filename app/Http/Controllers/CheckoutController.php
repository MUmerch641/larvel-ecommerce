<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->currentCart($request, createIfMissing: false);

        return view('checkout.index', [
            'cart' => $cart,
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $cart = $this->currentCart($request, createIfMissing: false);
        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart');
        }

        $user = Auth::user();
        $validated = $request->validated();

        $order = DB::transaction(function () use ($cart, $user, $validated) {
            $cart->refresh()->load(['items.product']);

            if ($cart->items->isEmpty()) {
                throw new \RuntimeException('Cart is empty.');
            }

            foreach ($cart->items as $item) {
                $productId = $item->product_id;
                $qty = $item->quantity;

                $affected = Product::query()
                    ->where('id', $productId)
                    ->where('is_active', true)
                    ->where('stock', '>=', $qty)
                    ->decrement('stock', $qty);

                if ($affected === 0) {
                    throw new \RuntimeException('Insufficient stock.');
                }
            }

            $subtotal = (int) $cart->items->sum(fn ($i) => $i->price_cents_snapshot * $i->quantity);
            $shipping = 0;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id' => $user?->id,
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'subtotal_cents' => $subtotal,
                'shipping_cents' => $shipping,
                'total_cents' => $total,
                'payment_method' => 'cod',
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_line1' => $validated['shipping_line1'],
                'shipping_line2' => $validated['shipping_line2'] ?? null,
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'shipping_country' => strtoupper($validated['shipping_country']),
                'placed_at' => now(),
            ]);

            foreach ($cart->items as $item) {
                $p = $item->product;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p?->id,
                    'name_snapshot' => $p?->name ?? 'Product',
                    'sku_snapshot' => $p?->sku,
                    'price_cents' => $item->price_cents_snapshot,
                    'quantity' => $item->quantity,
                ]);
            }

            $cart->items()->delete();
            $cart->update(['status' => 'ordered']);

            return $order;
        });

        return redirect("/orders/{$order->order_number}/thank-you");
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
    }

    private function currentCart(Request $request, bool $createIfMissing): ?Cart
    {
        $user = Auth::user();

        if ($user) {
            $query = Cart::query()
                ->where('user_id', $user->id)
                ->where('status', 'active');

            $cart = $createIfMissing
                ? $query->firstOrCreate(['user_id' => $user->id, 'status' => 'active'])
                : $query->first();
        } else {
            $sessionId = (string) $request->session()->get('cart_session_id');
            if ($sessionId === '') {
                $sessionId = (string) Str::uuid();
                $request->session()->put('cart_session_id', $sessionId);
            }
            $query = Cart::query()
                ->where('session_id', $sessionId)
                ->where('status', 'active');

            $cart = $createIfMissing
                ? $query->firstOrCreate(['session_id' => $sessionId, 'status' => 'active'])
                : $query->first();
        }

        if (!$cart) {
            return null;
        }

        $cart->load(['items.product']);

        return $cart;
    }
}
