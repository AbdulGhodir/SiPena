<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_tlp' => '081234567890',
            'role' => 'admin',
            'password' => 'admin123',
        ]);

        User::create([
            'nama' => 'Member',
            'email' => 'user@gmail.com',
            'no_tlp' => '081111111111',
            'role' => 'user',
            'password' => 'user123',
        ]);
    }
}
