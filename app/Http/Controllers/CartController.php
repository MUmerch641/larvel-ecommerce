<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->currentCart($request, createIfMissing: false);

        return view('cart.index', [
            'cart' => $cart,
        ]);
    }

    public function store(AddCartItemRequest $request)
    {
        $validated = $request->validated();
        $product = Product::query()->where('is_active', true)->findOrFail($validated['product_id']);

        $quantity = (int) $validated['quantity'];
        if ($quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $cart = $this->currentCart($request, createIfMissing: true);

        $item = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $quantity;
            if ($newQty > $product->stock) {
                return back()->withErrors(['quantity' => 'Not enough stock available.']);
            }

            $item->update([
                'quantity' => $newQty,
                'price_cents_snapshot' => $product->price_cents,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price_cents_snapshot' => $product->price_cents,
            ]);
        }

        return redirect('/cart');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cart = $this->currentCart($request, createIfMissing: false);
        if (!$cart || $cartItem->cart_id !== $cart->id) {
            abort(404);
        }

        $product = Product::query()->where('is_active', true)->findOrFail($cartItem->product_id);

        $quantity = (int) $request->validated()['quantity'];
        if ($quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $cartItem->update([
            'quantity' => $quantity,
            'price_cents_snapshot' => $product->price_cents,
        ]);

        return redirect('/cart');
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        $cart = $this->currentCart($request, createIfMissing: false);
        if (!$cart || $cartItem->cart_id !== $cart->id) {
            abort(404);
        }

        $cartItem->delete();

        return redirect('/cart');
    }

    private function currentCart(Request $request, bool $createIfMissing): ?Cart
    {
        $user = Auth::user();

        if ($user) {
            $query = Cart::query()
                ->where('user_id', $user->id)
                ->where('status', 'active');

            if ($createIfMissing) {
                $cart = $query->first();
                if (!$cart) {
                    $cart = Cart::create([
                        'user_id' => $user->id,
                        'status' => 'active',
                    ]);
                }
            } else {
                $cart = $query->first();
            }
        } else {
            $sessionId = (string) $request->session()->get('cart_session_id');
            if ($sessionId === '') {
                $sessionId = (string) Str::uuid();
                $request->session()->put('cart_session_id', $sessionId);
            }
            $query = Cart::query()
                ->where('session_id', $sessionId)
                ->where('status', 'active');

            if ($createIfMissing) {
                $cart = $query->first();
                if (!$cart) {
                    $cart = Cart::create([
                        'session_id' => $sessionId,
                        'status' => 'active',
                    ]);
                }
            } else {
                $cart = $query->first();
            }
        }

        if (!$cart) {
            return null;
        }

        $cart->load(['items.product']);

        return $cart;
    }
}
