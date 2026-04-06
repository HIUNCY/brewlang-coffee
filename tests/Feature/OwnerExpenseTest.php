<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_expense(): void
    {
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)->post('/owner/expenses', [
            'title' => 'Milk Supply',
            'description' => 'Daily dairy restock',
            'amount' => 50000,
            'expense_date' => now()->toDateString(),
        ]);

        $response->assertRedirect('/owner/expenses');
        $this->assertDatabaseHas('expenses', [
            'user_id' => $owner->id,
            'title' => 'Milk Supply',
            'amount' => 50000,
        ]);
    }

    public function test_staff_cannot_access_expense_creation(): void
    {
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)->get('/owner/expenses/create');

        $response->assertRedirect('/staff/dashboard');
    }
}
