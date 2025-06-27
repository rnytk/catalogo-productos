<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Hogar',
             'description' => 'Categoria hogar',
             'color' => 'Blue',
             'status' => 1,
             'created_at'=> '2025-05-21 21:11:34'
            ],
            ['name' => 'Consumo',
             'description' => 'Categoria consumo',
             'color' => 'Amber',
             'status' => 1,
             'created_at'=> '2025-05-21 21:11:34'
            ],
            ['name' => 'Confiteria',
             'description' => 'Categoria confiteria',
             'color' => 'Green',
             'status' => 0,
             'created_at'=> '2025-05-21 21:11:34'
            ],

        ]);
    }
}
