<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePropertyRequest;
use App\Models\Measurement;
use App\Models\Property;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    use UserTrait;
    public function list(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        $offset = ($page - 1) * 15;
        $search_keyword = $request->keyword ?? '';

        $properties = Property::with('user')->orderBy('id','DESC')->offset($offset)->limit(15)->get();
        $properties = $properties->map(function($property){
            $property['measurement_unit'] = Measurement::find($property['measurement_unit'])->name;
            //$property['user_name'] = $property['user']['user_id'];
            $property['user_name'] = $property['user']['user_id'] === 0 ? '' : $this->getUserFullName($property['user']['user_id']);
            return $property;
        });

        $total = Property::count();

        return response()->json([
            'properties' => $properties,
            'total' => $total
        ]);
    }

    public function create(CreatePropertyRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $property = Property::create([
                'property_no'       => trim($validated['property_no']),
                'measurement_unit'  => (integer) $validated['measurement_unit'],
                'particulars'       => $validated['particulars'],
                'unit_cost'         => (float) $validated['unit_cost'],
                'status'            => $validated['status'],
                'remarks'           => $validated['remarks']
            ]);

            if($validated['end_user']){
                DB::connection('lims')->table('property_user')->insert([
                    'property_id'    => $property->id,
                    'user_id'        => (int) $validated['end_user'],
                    'issuance_date'  => $validated['acquisition_date'] ?? null
                ]);
            
                DB::connection('lims')->table('property_user_history')->insert([
                    'property_id'       => $property->id,
                    'user_id'           => (int) $validated['end_user'],
                    'acquisition_date'  => $validated['acquisition_date'] ?? null,
                    'return_date'       => null
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Property created successfully', 'property' => $property], 201);
        } 

        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
