<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
           'created_at'=> '2025-05-21 21:11:34'
        ]);

        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
