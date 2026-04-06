<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->owner(),
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'amount' => fake()->numberBetween(10000, 500000),
            'expense_date' => fake()->date(),
        ];
    }
}
