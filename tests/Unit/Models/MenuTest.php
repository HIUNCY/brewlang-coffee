<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_photo_url_accessor_returns_correct_asset_path(): void
    {
        $menu = new Menu([
            'photo' => 'espresso.png'
        ]);

        $this->assertEquals(asset('images/menu/espresso.png'), $menu->photo_url);
    }

    public function test_photo_url_accessor_returns_null_when_photo_is_missing(): void
    {
        $menu = new Menu([
            'photo' => null
        ]);

        $this->assertNull($menu->photo_url);
    }
}
