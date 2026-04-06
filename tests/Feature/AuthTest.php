<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_staff_can_login(): void
    {
        $staff = User::factory()->staff()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => $staff->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($staff);
        $response->assertRedirect('/staff/dashboard');
    }

    public function test_inactive_staff_cannot_login(): void
    {
        $staff = User::factory()->staff()->inactive()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => $staff->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_owner_redirected_to_owner_dashboard(): void
    {
        $owner = User::factory()->owner()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => $owner->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($owner);
        $response->assertRedirect('/owner/dashboard');
    }
}
