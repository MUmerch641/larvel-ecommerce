<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_update_and_remove_cart_item(): void
    {
        $product = Product::factory()->create([
            'stock' => 10,
            'price_cents' => 1299,
            'is_active' => true,
        ]);

        $this->post('/cart/items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertRedirect('/cart');

        $cartPage = $this->get('/cart');
        $cartPage->assertOk();
        $cartPage->assertSee($product->name);

        $cartItemId = \App\Models\CartItem::query()->value('id');
        $this->patch("/cart/items/{$cartItemId}", [
            'quantity' => 3,
        ])->assertRedirect('/cart');

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItemId,
            'quantity' => 3,
        ]);

        $this->delete("/cart/items/{$cartItemId}")
            ->assertRedirect('/cart');

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItemId,
        ]);
    }
}
