<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\DeliveryReceipts;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Main Warehouse',
                'address' => 'BGHMC Compound, BGHMC, Baguio City'
            ],
            [
                'name' => 'Magsaysay Warehouse',
                'address' => 'Magsaysay, Baguio City'
            ],
            [
                'name' => 'Loakan Warehouse',
                'address' => 'Loakan, Baguio City'
            ],
            [
                'name' => 'Marcos Warehouse',
                'address' => 'Marcos, Baguio City'
            ],
        ];

        foreach($warehouses as $warehouse){
            Warehouse::create([
                'name' => $warehouse['name'],
                'address' => $warehouse['address']
            ]);
        }
       
    }
}
