<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_decrements_stock(): void
    {
        $product = Product::factory()->create([
            'stock' => 5,
            'price_cents' => 1000,
            'is_active' => true,
        ]);

        $this->post('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertRedirect('/cart');

        $this->post('/checkout', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '123456789',
            'shipping_line1' => '123 Street',
            'shipping_line2' => null,
            'shipping_city' => 'City',
            'shipping_postal_code' => '12345',
            'shipping_country' => 'US',
        ])->assertRedirect();

        $this->assertDatabaseCount('orders', 1);
        $order = Order::query()->firstOrFail();

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'quantity' => 2,
            'price_cents' => 1000,
        ]);

        $product->refresh();
        $this->assertSame(3, $product->stock);

        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_cannot_checkout_if_insufficient_stock(): void
    {
        $product = Product::factory()->create([
            'stock' => 1,
            'price_cents' => 1000,
            'is_active' => true,
        ]);

        $this->post('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertRedirect('/cart');

        // Try to update to a quantity above stock.
        $cartItemId = CartItem::query()->value('id');
        $this->from('/cart')->patch("/cart/items/{$cartItemId}", [
            'quantity' => 2,
        ])->assertSessionHasErrors('quantity');
    }
}
