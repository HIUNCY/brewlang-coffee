<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_create_menu_item(): void
    {
        $staff = User::factory()->staff()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($staff)->post('/staff/menus', [
            'category_id' => $category->id,
            'name' => 'Iced Latte',
            'description' => 'Cold milk coffee',
            'price' => 32000,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/staff/menus');
        $this->assertDatabaseHas('menus', [
            'name' => 'Iced Latte',
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }

    public function test_staff_can_toggle_menu_active_status(): void
    {
        $staff = User::factory()->staff()->create();
        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
            'is_active' => true,
        ]);

        $response = $this->actingAs($staff)->patch("/staff/menus/{$menu->id}/toggle");

        $response->assertRedirect();
        $this->assertFalse($menu->fresh()->is_active);
    }
}
