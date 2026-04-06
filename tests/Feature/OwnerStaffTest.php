<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerStaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_staff_account(): void
    {
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)->post('/owner/staff', [
            'name' => 'New Staff',
            'email' => 'newstaff@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/owner/staff');
        $this->assertDatabaseHas('users', [
            'email' => 'newstaff@example.com',
            'role' => 'staff',
        ]);
    }

    public function test_staff_cannot_access_staff_account_creation(): void
    {
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)->get('/owner/staff/create');

        $response->assertRedirect('/staff/dashboard');
    }

    public function test_owner_account_cannot_be_deactivated(): void
    {
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)->patch("/owner/staff/{$owner->id}/toggle");

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertTrue($owner->fresh()->is_active);
    }
}
