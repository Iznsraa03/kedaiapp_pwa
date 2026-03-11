<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kedaiapp.com'],
            [
                'name' => 'Admin KedaiApp',
                'nra' => 'KDA-001',
                'role' => 'admin',
                'password' => bcrypt('admin@kedai2026')
            ]
        );
    }
}
