<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\DeliveryReceipts;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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

    //     $car_provinces = DB::connection('dohis')->table('dohis_province')->where('region_id',14)->get(['province_name','province_id']);
        
    //     foreach($car_provinces as $province){
    //        $municipalities = DB::connection('dohis')->table('dohis_municipality')->where('province_id',$province->province_id)->get(['municipality_name']);
    //        $province->municipalities = $municipalities;
    //     }

    //     Storage::put('exports/CAR_barangays.json', json_encode($car_provinces,JSON_PRETTY_PRINT));

    //    echo json_encode($car_provinces[2],JSON_PRETTY_PRINT);
       
    }
}
