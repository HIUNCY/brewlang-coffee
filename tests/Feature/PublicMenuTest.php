<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_page_loads_successfully(): void
    {
        $response = $this->get('/menu');

        $response->assertStatus(200);
    }

    public function test_inactive_menu_items_are_not_shown_publicly(): void
    {
        $category = Category::factory()->create(['name' => 'Coffee']);
        $inactiveMenu = Menu::factory()->inactive()->create([
            'category_id' => $category->id,
            'name' => 'Hidden Coffee',
        ]);

        $response = $this->get('/menu');

        $response->assertStatus(200);
        $response->assertDontSee($inactiveMenu->name);
    }

    public function test_category_filter_works(): void
    {
        $coffee = Category::factory()->create(['name' => 'Coffee']);
        $food = Category::factory()->create(['name' => 'Food']);

        $coffeeMenu = Menu::factory()->create([
            'category_id' => $coffee->id,
            'name' => 'Espresso',
        ]);

        $foodMenu = Menu::factory()->create([
            'category_id' => $food->id,
            'name' => 'Banana Cake',
        ]);

        $response = $this->get('/menu/coffee');

        $response->assertStatus(200);
        $response->assertSee($coffeeMenu->name);
        $response->assertDontSee($foodMenu->name);
    }
}
