<?php

namespace Database\Seeders;

use App\Models\Measurement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lims_measurements = array(
            array('id' => '1','name' => 'ampoule'),
            array('id' => '2','name' => 'bottle'),
            array('id' => '3','name' => 'bowl'),
            array('id' => '4','name' => 'box'),
            array('id' => '5','name' => 'canister'),
            array('id' => '6','name' => 'capsule'),
            array('id' => '7','name' => 'carton'),
            array('id' => '8','name' => 'cartridge'),
            array('id' => '9','name' => 'cycle'),
            array('id' => '10','name' => 'gallon'),
            array('id' => '11','name' => 'jar'),
            array('id' => '12','name' => 'kit'),
            array('id' => '13','name' => 'nebule'),
            array('id' => '14','name' => 'net'),
            array('id' => '15','name' => 'pack'),
            array('id' => '16','name' => 'pair'),
            array('id' => '17','name' => 'piece'),
            array('id' => '18','name' => 'pouch'),
            array('id' => '19','name' => 'pre-filled syringe'),
            array('id' => '20','name' => 'rod'),
            array('id' => '21','name' => 'roll'),
            array('id' => '22','name' => 'sachet'),
            array('id' => '23','name' => 'set'),
            array('id' => '24','name' => 'tablet'),
            array('id' => '25','name' => 'test'),
            array('id' => '26','name' => 'test card'),
            array('id' => '27','name' => 'test kit'),
            array('id' => '28','name' => 'treatment pack'),
            array('id' => '29','name' => 'tube'),
            array('id' => '30','name' => 'unit'),
            array('id' => '31','name' => 'vial'),
            array('id' => '32','name' => 'blister pack'),
            array('id' => '33','name' => 'sub'),
            array('id' => '34','name' => 'license'),
            array('id' => '35','name' => 'job'),
            array('id' => '36','name' => 'copy'),
            array('id' => '37','name' => 'ream'),
            array('id' => '38','name' => 'liter'),
            array('id' => '39','name' => 'drum'),
            array('id' => '40','name' => 'can'),
            array('id' => '41','name' => 'books'),
            array('id' => '42','name' => 'dozen')
          );


       DB::connection('lims')->table('lims_measurements')->insert($lims_measurements);
        
    }
}
