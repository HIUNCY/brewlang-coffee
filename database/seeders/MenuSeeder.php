<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['category_id' => 1, 'name' => 'Espresso', 'price' => 25000, 'photo' => 'espresso.png', 'is_active' => true],
            ['category_id' => 1, 'name' => 'Americano', 'price' => 30000, 'photo' => 'americano.png', 'is_active' => true],
            ['category_id' => 1, 'name' => 'Cappuccino', 'price' => 35000, 'photo' => 'cappuccino.png', 'is_active' => true],

            ['category_id' => 2, 'name' => 'Matcha Latte', 'price' => 40000, 'photo' => 'matcha_latte.png', 'is_active' => true],
            ['category_id' => 2, 'name' => 'Chocolate Milk', 'price' => 35000, 'photo' => 'chocolate_milk.png', 'is_active' => true],
            ['category_id' => 2, 'name' => 'Lychee Tea', 'price' => 30000, 'photo' => 'lychee_tea.png', 'is_active' => true],

            ['category_id' => 3, 'name' => 'Croissant', 'price' => 25000, 'photo' => 'croissant.png', 'is_active' => true],
            ['category_id' => 3, 'name' => 'Avocado Toast', 'price' => 45000, 'photo' => 'avocado_toast.png', 'is_active' => true],
            ['category_id' => 3, 'name' => 'Banana Cake', 'price' => 30000, 'photo' => 'banana_cake.png', 'is_active' => true],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(['name' => $menu['name']], $menu);
        }
    }
}
