<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['category_id' => 1, 'name' => 'Espresso', 'price' => 25000, 'is_active' => true],
            ['category_id' => 1, 'name' => 'Americano', 'price' => 30000, 'is_active' => true],
            ['category_id' => 1, 'name' => 'Cappuccino', 'price' => 35000, 'is_active' => true],
            
            ['category_id' => 2, 'name' => 'Matcha Latte', 'price' => 40000, 'is_active' => true],
            ['category_id' => 2, 'name' => 'Chocolate Milk', 'price' => 35000, 'is_active' => true],
            ['category_id' => 2, 'name' => 'Lychee Tea', 'price' => 30000, 'is_active' => true],
            
            ['category_id' => 3, 'name' => 'Croissant', 'price' => 25000, 'is_active' => true],
            ['category_id' => 3, 'name' => 'Avocado Toast', 'price' => 45000, 'is_active' => true],
            ['category_id' => 3, 'name' => 'Banana Cake', 'price' => 30000, 'is_active' => true],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(['name' => $menu['name']], $menu);
        }
    }
}
