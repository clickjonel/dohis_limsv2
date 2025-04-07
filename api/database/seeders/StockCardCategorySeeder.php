<?php

namespace Database\Seeders;

use App\Models\StockCardCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockCardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Drugs and Medicines',
                'description' => 'Drugs and Medicines',
            ],
            [
                'name' => 'Medical Equipments',
                'description' => 'Medical Equipments',
            ],
            [
                'name' => 'ICT Equipments',
                'description' => 'ICT Equipments',
            ],
            [
                'name' => 'Tokens',
                'description' => 'Tokens',
            ],
            [
                'name' => 'IEC',
                'description' => 'IEC',
            ],
            [
                'name' => 'Medical Dental and Laboratory Supplies',
                'description' => 'Medical Dental and Laboratory Supplies',
            ],
            [
                'name' => 'ICT Supplies',
                'description' => 'ICT Supplies',
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Office Supplies',
            ]
        ];

        foreach ($categories as $category) {
            StockCardCategory::create($category);
        }
    }
}
