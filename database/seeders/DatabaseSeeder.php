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
        // User::factory(10)->create();

       \App\Models\User::factory()->create([
    'full_name' => 'Test User',
    'phone' => '96170000000',
    'address' => 'Beirut, Lebanon',
    'password' => bcrypt('password'),
    'role' => 'user',
]);
    }
}
