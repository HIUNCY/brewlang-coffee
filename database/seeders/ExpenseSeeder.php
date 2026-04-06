<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        if (Expense::exists()) {
            return;
        }

        $owner = User::where('role', 'owner')->first();

        if (!$owner) {
            return;
        }

        $expenses = [
            [
                'title' => 'Milk Supply',
                'description' => 'Fresh whole milk restock for espresso-based drinks.',
                'amount' => 360000,
                'expense_date' => now()->subDays(2)->toDateString(),
            ],
            [
                'title' => 'Coffee Beans',
                'description' => 'Monthly arabica and house blend bean purchase.',
                'amount' => 750000,
                'expense_date' => now()->subDays(7)->toDateString(),
            ],
            [
                'title' => 'Cups & Lids',
                'description' => 'Takeaway cups, lids, and sleeves restock.',
                'amount' => 220000,
                'expense_date' => now()->subDays(12)->toDateString(),
            ],
            [
                'title' => 'Cleaning Supplies',
                'description' => 'Sanitizer, detergent, and bar cleaning materials.',
                'amount' => 185000,
                'expense_date' => now()->subDays(18)->toDateString(),
            ],
            [
                'title' => 'Staff Meal',
                'description' => 'Team meal during weekend closing shift.',
                'amount' => 140000,
                'expense_date' => now()->subDays(24)->toDateString(),
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::create([
                'user_id' => $owner->id,
                ...$expense,
            ]);
        }
    }
}
