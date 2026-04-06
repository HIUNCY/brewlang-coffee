<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $price = fake()->numberBetween(10000, 50000);
        $quantity = fake()->numberBetween(1, 5);

        return [
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'menu_name_snapshot' => fake()->words(2, true),
            'price_snapshot' => $price,
            'quantity' => $quantity,
            'item_note' => fake()->optional()->sentence(),
            'subtotal' => $price * $quantity,
        ];
    }
}
