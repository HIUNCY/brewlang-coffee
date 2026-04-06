<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;

class OwnerExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_record_expense(): void
    {
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)->post('/owner/expenses', [
            'title' => 'Test Expense',
            'amount' => 50000,
            'expense_date' => now()->toDateString(),
        ]);

        $response->assertRedirect('/owner/expenses');
        $this->assertDatabaseHas('expenses', [
            'title' => 'Test Expense',
            'amount' => 50000,
        ]);
    }

    public function test_staff_cannot_record_expense(): void
    {
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)->post('/owner/expenses', [
            'title' => 'Test Expense',
            'amount' => 50000,
            'expense_date' => now()->toDateString(),
        ]);

        $response->assertForbidden();
    }
}
