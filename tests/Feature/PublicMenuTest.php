<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;

class PublicMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_view_active_menu_items(): void
    {
        $menu = Menu::factory()->create(['is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($menu->name);
    }

    public function test_public_cannot_view_inactive_menu_items(): void
    {
        $menu = Menu::factory()->create(['is_active' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee($menu->name);
    }
}
