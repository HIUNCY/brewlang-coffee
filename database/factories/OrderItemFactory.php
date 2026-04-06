<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'quantity' => fake()->numberBetween(1, 5),
            'price' => fake()->numberBetween(10000, 50000),
        ];
    }
}
