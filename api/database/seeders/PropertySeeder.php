<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyUser;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $properties = Property::with(['user'])->get();

        foreach($properties as $property){
           DB::connection('lims')->table('property_user_history')->insert([
                'property_id' => $property->id,
                'user_id' => $property->user->user_id,
                'acquisition_date' => $property->user->issuance_date,
                'return_date' => null,
                'remarks' => null
            ]);
        }
    }
}
