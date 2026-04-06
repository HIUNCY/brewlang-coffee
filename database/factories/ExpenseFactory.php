<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Expense;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'amount' => fake()->numberBetween(10000, 500000),
            'expense_date' => fake()->date(),
        ];
    }
}
