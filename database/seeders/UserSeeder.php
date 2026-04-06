<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'owner@brewlang.test'], [
            'role' => 'owner',
            'name' => 'Owner Brewlang',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        User::firstOrCreate(['email' => 'staff1@brewlang.test'], [
            'role' => 'staff',
            'name' => 'Staff One',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        User::firstOrCreate(['email' => 'staff2@brewlang.test'], [
            'role' => 'staff',
            'name' => 'Staff Two',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }
}
