<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePropertyRequest;
use App\Http\Requests\CreatePropertyRequestTransferRequest;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\UserResource;
use App\Models\Measurement;
use App\Models\Property;
use App\Models\User;
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
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $baseQuery =  Property::with('user')
                        ->when($search_keyword, function ($query) use ($search_keyword) {
                            $query->where('property_no', 'like', '%' . $search_keyword . '%')->orWhere('particulars', 'like', '%' . $search_keyword . '%');
                        })->orderBy('id','DESC');

        $properties = $baseQuery->clone()
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get();

        $properties = $properties->map(function($property){
            $property['measurement_unit'] = Measurement::find($property['measurement_unit'])->name;
            //$property['user_name'] = $property['user']['user_id'];
            $property['user_name'] = $property['user']['user_id'] === 0 ? '' : $this->getUserFullName($property['user']['user_id']);
            return $property;
        });

        $total = $baseQuery->count();

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

    public function fetchUserProperties(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $baseQuery =  Property::with(['user'])
                        ->whereHas('user', function($query) use ($request) {
                            $query->where('user_id', $request->user()->user_id);
                        })
                        ->when($search_keyword, function ($query) use ($search_keyword) {
                            $query->where(function ($q) use ($search_keyword) {
                                $q->where('property_no', 'like', '%' . $search_keyword . '%')
                                ->orWhere('particulars', 'like', '%' . $search_keyword . '%');
                            });
                        })
                        ->orderBy('id', 'DESC');

        $properties = $baseQuery->clone()
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get();

        $properties = $properties->map(function($property){
            $property['measurement_unit'] = Measurement::find($property['measurement_unit'])->name;
            $property['user_name'] = $property['user']['user_id'] === 0 ? '' : $this->getUserFullName($property['user']['user_id']);
            return $property;
        });

        $total = $baseQuery->count();

        return response()->json([
            'properties' => $properties,
            'total' => $total
        ]);
    }

    public function fetchProperty(Request $request): JsonResponse
    {
        $property = Property::with(['user','userHistory'])->find($request->id);

        return response()->json([
            'property' => PropertyResource::make($property),
        ]);
    }

    public function fetchPropertyStatuses(): JsonResponse
    {
        return response()->json([
            'statuses' => Property::STATUSES
        ]);
    }

    public function updateProperty(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_no' => 'required|string|max:255',
            'measurement_unit' => 'required|integer',
            'particulars' => 'required|string|max:255',
            'unit_cost' => 'required|numeric',
            'status' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'id' => 'required|integer|exists:lims_properties,id',
        ]);

        $property = Property::find($validated['id'])->update([
            'property_no' => $validated['property_no'],
            'measurement_unit' => $validated['measurement_unit'],
            'particulars' => $validated['particulars'],
            'unit_cost' => $validated['unit_cost'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks']
        ]);

        return response()->json([
            'message' => $property,
        ]);
    }

    public function fetchUserPropertiesSelection(Request $request):JsonResponse
    {
        $properties =  Property::with(['user'])
                        ->whereHas('user', function($query) use ($request){
                            $query->where('user_id', $request->user()->user_id);
                        })
                        ->get();

        return response()->json([
            'properties' => $properties,
        ]);
    }

    public function findProperties(Request $request): JsonResponse
    {

        $properties = Property::whereIn('id', $request->ids)->get();

        return response()->json([
            'properties' => PropertyResource::collection($properties),
        ]);
    }

    public function findPropertyByPropertyNumber(Request $request): JsonResponse
    {
        $property = Property::with('user')->where('property_no',$request->property_no)->first();

        return response()->json([
            'property' => $property
        ]);
    }
    

}
