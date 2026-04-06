<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Order 1: Completed
            $order1 = Order::create([
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => 'John Doe',
                'status' => 'all_done',
                'total_price' => 55000,
            ]);
            OrderItem::create(['order_id' => $order1->id, 'menu_id' => 1, 'quantity' => 1, 'price' => 25000]); // Espresso
            OrderItem::create(['order_id' => $order1->id, 'menu_id' => 9, 'quantity' => 1, 'price' => 30000]); // Banana Cake

            // Order 2: Pending
            $order2 = Order::create([
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => 'Jane Smith',
                'status' => 'unpaid',
                'total_price' => 40000,
            ]);
            OrderItem::create(['order_id' => $order2->id, 'menu_id' => 4, 'quantity' => 1, 'price' => 40000]); // Matcha Latte

            // Order 3: Preparing
            $order3 = Order::create([
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => 'Bob',
                'status' => 'in_progress',
                'total_price' => 35000,
            ]);
            OrderItem::create(['order_id' => $order3->id, 'menu_id' => 3, 'quantity' => 1, 'price' => 35000]); // Cappuccino
        } catch (\Exception $e) {
            // Ignore if already seeded
        }
    }
}
