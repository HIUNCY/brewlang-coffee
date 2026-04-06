<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $expenses = [
                ['description' => 'Coffee Beans - 5kg', 'amount' => 750000, 'date' => now()->subDays(2)],
                ['description' => 'Milk - 20 liters', 'amount' => 360000, 'date' => now()->subDay()],
                ['description' => 'Sugar & Syrups', 'amount' => 150000, 'date' => now()],
                ['description' => 'Electricity Bill', 'amount' => 800000, 'date' => now()->subDays(5)],
            ];

            foreach ($expenses as $expense) {
                Expense::create($expense);
            }
        } catch (\Exception $e) {
            // Ignore if already seeded
        }
    }
}
