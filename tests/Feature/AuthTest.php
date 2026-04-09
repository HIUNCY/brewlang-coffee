<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_protected_pages_redirect_guests(): void
    {
        $response = $this->get('/staff/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_owner_only_pages_redirect_staff(): void
    {
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)->get('/owner/dashboard');

        $response->assertRedirect('/staff/dashboard');
    }

    public function test_staff_pages_redirect_owner_to_owner_dashboard(): void
    {
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)->get('/staff/dashboard');

        $response->assertRedirect('/owner/dashboard');
    }

    public function test_inactive_user_cannot_login(): void
    {
        $staff = User::factory()->staff()->inactive()->create([
            'password' => 'password123',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $staff->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_valid_staff_can_login(): void
    {
        $staff = User::factory()->staff()->create([
            'password' => 'password123',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $staff->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($staff);
        $response->assertRedirect('/staff/dashboard');
    }
}
