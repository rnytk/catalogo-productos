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
            ['name' => 'Inicio',
             'description' => 'Portada',
             'color' => 'Blue',
             'status' => 1,
             'created_at'=> now(),
            ],
            ['name' => 'Hogar',
             'description' => 'Categoria hogar',
             'color' => 'Blue',
             'status' => 1,
             'created_at'=> now(),
            ],
            ['name' => 'Consumo',
             'description' => 'Categoria consumo',
             'color' => 'Amber',
             'status' => 1,
             'created_at'=> now(),
            ],
            ['name' => 'Confitería',
             'description' => 'Categoria confiteria',
             'color' => 'Green',
             'status' => 1,
             'created_at'=> now(),
            ],

        ]);
    }
}
