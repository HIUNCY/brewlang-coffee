<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class OwnerStaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_staff(): void
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

    public function test_owner_can_toggle_staff_status(): void
    {
        $owner = User::factory()->owner()->create();
        $staff = User::factory()->staff()->create(['is_active' => true]);

        $response = $this->actingAs($owner)->patch("/owner/staff/{$staff->id}/toggle");

        $response->assertRedirect();
        $this->assertFalse($staff->fresh()->is_active);
    }
}
