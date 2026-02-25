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

        // Seeder akun HRD untuk login
        User::factory()->create([
            'name' => 'HRD',
            'email' => 'hrd@example.com',
            'password' => bcrypt('password123'), // Ganti password sesuai kebutuhan
        ]);
    }
}
