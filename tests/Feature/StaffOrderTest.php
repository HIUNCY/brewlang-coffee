<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class StaffOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_advance_order_status(): void
    {
        $staff = User::factory()->staff()->create();
        $order = Order::factory()->unpaid()->create();

        $response = $this->actingAs($staff)->post("/staff/order/{$order->id}/advance", [
            'status' => 'paid'
        ]);

        $response->assertRedirect('/staff/dashboard');
        $this->assertEquals('paid', $order->fresh()->status);
    }

    public function test_staff_cannot_revert_order_status(): void
    {
        $staff = User::factory()->staff()->create();
        $order = Order::factory()->paid()->create();

        $response = $this->actingAs($staff)->post("/staff/order/{$order->id}/advance", [
            'status' => 'unpaid'
        ]);

        $response->assertSessionHasErrors('status');
        $this->assertEquals('paid', $order->fresh()->status);
    }
}
