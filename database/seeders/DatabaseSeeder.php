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
        $admin = User::factory()->dummyAdmin()->raw();
        User::firstOrCreate(['email' => $admin['email']], $admin);

        $user = User::factory()->dummyUser()->raw();
        User::firstOrCreate(['email' => $user['email']], $user);
    }
}
