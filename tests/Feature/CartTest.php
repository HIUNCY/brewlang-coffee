<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_to_cart_returns_json_and_updates_session(): void
    {
        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
            'price' => 25000,
        ]);

        $response = $this->postJson('/cart/add', [
            'menu_id' => $menu->id,
            'quantity' => 2,
        ]);

        $response->assertOk()
            ->assertJsonPath('count', 2)
            ->assertJsonPath('total', 50000);

        $this->assertEquals(2, session('cart.items.' . $menu->id . '.quantity'));
    }

    public function test_update_note_and_remove_item_work(): void
    {
        $menu = Menu::factory()->create([
            'category_id' => Category::factory(),
        ]);

        $this->withSession([
            'cart' => [
                'items' => [
                    $menu->id => [
                        'menu_id' => $menu->id,
                        'name' => $menu->name,
                        'price' => (float) $menu->price,
                        'quantity' => 1,
                        'note' => null,
                    ],
                ],
            ],
        ]);

        $noteResponse = $this->postJson('/cart/update-note', [
            'menu_id' => $menu->id,
            'note' => 'No sugar',
        ]);

        $noteResponse->assertOk()
            ->assertJsonPath('cart.items.' . $menu->id . '.note', 'No sugar');

        $removeResponse = $this->deleteJson("/cart/remove/{$menu->id}");

        $removeResponse->assertOk()
            ->assertJsonPath('count', 0);
    }
}
