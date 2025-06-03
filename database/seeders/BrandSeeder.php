<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            ['name' => 'Favora',
             'description' => 'Marca favaorita de GT',
             'Status' => 1,
             'created_at'=> '2025-05-21 21:11:34'
            ],
            ['name'=> 'Ani',
             'description' => 'Marca de variedad Ani',
             'Status' => 1,
             'created_at'=> '2025-05-21 21:11:34'
        ],
            ['name'=> 'Delicia',
             'description' => 'Variedad en pastas',
             'Status' => 1,
             'created_at'=> '2025-05-21 21:11:34'
            ]
        ]);
    }
}
