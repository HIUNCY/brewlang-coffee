<?php

namespace Tests\Feature;

use App\Mail\OrderConfirmationMail;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_with_correct_total(): void
    {
        Mail::fake();

        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
            'name' => 'Test Coffee',
            'price' => 20000,
        ]);

        $response = $this->withSession([
            'cart' => [
                'items' => [
                    $menu->id => [
                        'menu_id' => $menu->id,
                        'name' => $menu->name,
                        'price' => 20000,
                        'quantity' => 2,
                        'note' => 'Less sugar',
                    ],
                ],
            ],
        ])->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_phone' => '08123456789',
            'customer_email' => 'john@example.com',
            'table_number' => '5',
        ]);

        $order = Order::with('items')->first();

        $this->assertNotNull($order);
        $response->assertRedirect('/checkout/success');
        $response->assertSessionHas('order_code', $order->order_code);
        $this->assertEquals('40000.00', $order->total_price);
        $this->assertCount(1, $order->items);
        $this->assertEquals('Test Coffee', $order->items->first()->menu_name_snapshot);
        $this->assertEquals('40000.00', $order->items->first()->subtotal);

        Mail::assertSent(OrderConfirmationMail::class);
    }

    public function test_checkout_with_empty_cart_fails(): void
    {
        $response = $this->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_phone' => '08123456789',
            'customer_email' => 'john@example.com',
            'table_number' => '5',
        ]);

        $response->assertSessionHasErrors('cart');
    }

    public function test_checkout_with_missing_fields_fails(): void
    {
        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
        ]);

        $response = $this->withSession([
            'cart' => [
                'items' => [
                    $menu->id => [
                        'menu_id' => $menu->id,
                        'name' => $menu->name,
                        'price' => (float) $menu->price,
                        'quantity' => 1,
                        'note' => null,
                    ],
                ],
            ],
        ])->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_phone' => '08123456789',
            'table_number' => '5',
        ]);

        $response->assertSessionHasErrors('customer_email');
    }

    public function test_checkout_clears_cart_after_success(): void
    {
        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
        ]);

        $response = $this->withSession([
            'cart' => [
                'items' => [
                    $menu->id => [
                        'menu_id' => $menu->id,
                        'name' => $menu->name,
                        'price' => (float) $menu->price,
                        'quantity' => 1,
                        'note' => null,
                    ],
                ],
            ],
        ])->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_phone' => '08123456789',
            'customer_email' => 'john@example.com',
            'table_number' => '5',
        ]);

        $response->assertRedirect('/checkout/success');
        $this->assertEquals([], session('cart', []));
    }
}
