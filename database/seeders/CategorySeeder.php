<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(['id' => 1], ['name' => 'Coffee']);
        Category::firstOrCreate(['id' => 2], ['name' => 'Non Coffee']);
        Category::firstOrCreate(['id' => 3], ['name' => 'Food']);
    }
}
