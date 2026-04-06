<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\Order;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_checkout_with_valid_cart(): void
    {
        $menu = Menu::factory()->create(['price' => 20000]);

        $response = $this->withSession([
            'cart' => [
                $menu->id => ['id' => $menu->id, 'name' => 'Test Coffee', 'price' => 20000, 'quantity' => 2]
            ]
        ])->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '1234567890',
            'table_number' => 5,
        ]);

        $order = Order::first();
        
        $this->assertNotNull($order);
        $response->assertRedirect('/checkout/success/' . $order->id);
        
        $this->assertEquals('John Doe', $order->customer_name);
        $this->assertEquals(40000, $order->total_price);
        $this->assertEquals('unpaid', $order->status);
    }
}
