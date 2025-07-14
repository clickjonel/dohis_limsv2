<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePropertyRequest;
use App\Http\Requests\CreatePropertyRequestTransferRequest;
use App\Http\Requests\Property\TransferPropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\UserResource;
use App\Models\Measurement;
use App\Models\Property;
use App\Models\PropertyInspectionRequest;
use App\Models\User;
use App\UserTrait;
use Illuminate\Database\Eloquent\Casts\Json;
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
                'remarks'           => $validated['remarks'],
                'main_category_id' => $validated['main_category_id'] ?? 0
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
        $property = Property::with(['user'])->where('property_no',$request->property_no)->first();
        $property['currentInspection'] = $property->preInspection()->latest('created_at')->first();

        return response()->json([
            'property' => $property
        ]);
    }

    public function transferProperties(TransferPropertyRequest $request):JsonResponse
    {
        $validated = $request->validated();

        foreach($validated['properties'] as $property){
            $property = Property::find($property['id']);
            $property->userHistory()->create([
                'property_id' => $property['id'],
                'user_id' => $validated['transfer_to'],
                'acquisition_date' => $validated['transfer_date'],
                'return_date' => null,
                'remarks' => null
            ]);
            $property->user()->update([
                'user_id' => $validated['transfer_to'],
                'issuance_date' => $validated['transfer_date'],
            ]);

        }

        return response()->json([
            'message' => 'Properties Successfully Transfered',
            'property' => $property
        ]);
    }

    public function fetchInventoryUserPropertyReport(Request $request):JsonResponse
    {
        $users = User::with(['properties.property.measurement'])->findMany($request->user_ids)
                    ->map(function($user){
                        $user['full_name'] = $this->getUserFullName($user['user_id']);
                        $user['position'] = $this->getUserPosition($user['user_id']);
                       $user['property_total_cost'] = $user->properties->sum(function ($property) {
                            return $property->property->unit_cost;
                        });
                        return $user;
                    });

        // $total = $properties->sum('unit_cost');

         return response()->json([
            'message' => 'Properties Successfully Fetched',
            'users' => $users,
            // 'user' => $user,
            // 'total' => $total
        ]);

    }

    public function fetchPropertiesForPropertiesPage(Request $request):JsonResponse
    {
       $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $propertyObject = Property::where('status' , 'Active')
                            ->when($search_keyword, function ($query) use ($search_keyword) {
                                $query->where('property_no', 'like', '%' . $search_keyword . '%');
                                $query->orWhere('particulars', 'like', '%' . $search_keyword . '%');
                            })->orderBy('id','DESC');
        
                        
        $total = $propertyObject->count();  
        $properties = $propertyObject->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $properties = $properties->map(function (Property $property): Property{
            $property['end_user'] = $this->getUserFullName(User::find($property->user->user_id)->user_id);
            return $property;
        });

        return response()->json([
            'properties' => $properties,
            'total' => $total
        ]);
    }
    
    public function fetchPropertiesUserForPropertiesPage(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

       $propertyObject = Property::where('status' , 'Active')
                            ->when($search_keyword, function ($query) use ($search_keyword) {
                                $query->where('property_no', 'like', '%' . $search_keyword . '%');
                                $query->orWhere('particulars', 'like', '%' . $search_keyword . '%');
                            })->orderBy('id','DESC');

        $total = $propertyObject->count();  
        $properties = $propertyObject->offset(($page - 1) * $perPage)->limit($perPage)->get();  
        
        $properties = $properties->map(function (Property $property): Property{
            $property['end_user'] = $this->getUserFullName(User::find($property->user->user_id)->user_id);
            return $property;
        });

        return response()->json([
            'properties' => $properties,
            'total' => $total
        ]);
    }

    public function findPropertyThroughPN(Request $request): JsonResponse
    {
        $property = Property::where('property_no', $request->property_no)
                    ->with(['user'])
                    ->first();
        
        return response()->json([
            'property' => $property,
        ]);
    }

    public function searchPropertyNoForAutocompleteSelection(Request $request):JsonResponse
    {
        $search_keyword = $request->keyword;

        $properties = Property::with('user')->where('property_no', 'like', '%' . $search_keyword . '%')
                        ->orderBy('id','DESC')
                        ->get(['id', 'property_no','particulars','unit_cost'])
                        ->map(function($property){
                            $property['user']['full_name'] = $this->getUserFullName($property['user']['user_id']);
                            return $property;
                        });

        return response()->json([
            'properties' => $properties,
        ]);
    }

    public function fetchPropertiesforWMRCreatePage(Request $request):JsonResponse
    {
        // $properties = Property::with(['user'])->whereIn('id',$request->ids)->get();
        $requests = PropertyInspectionRequest::with(['property.measurement','property.user'])->whereIn('id',$request->ids)->get();
        $requests = $requests->map(function($request){
            $request['requested_by'] = $this->getUserFullName($request['requested_by']);
            $request['inspected_by'] = $this->getUserFullName($request['inspection_section'] === 25 ? 15 : 65);
            return $request;
        });

        return response()->json([
            // 'properties' => $properties,
            'requests' => $requests
        ]);
    }

    public function fetchPropertyforViewPage(Request $request):JsonResponse
    {
        $property = Property::with(['user'])->find($request->id);
        $property['user']['full_name'] = $this->getUserFullName($property['user']->user_id);
        $property['user_history'] = $property->userHistory->map(function($history) {
            $history['full_name'] = $this->getUserFullName($history->user_id);
            return $history;
        });
        $property['acquisition_date'] = $property['user_history'][0]->acquisition_date;

        return response()->json([
            'property' => $property,
        ]);
    }

    public function fetchPropertiesForCategorizePage(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $propertyObject = Property::when($search_keyword, function ($query) use ($search_keyword) {
                                $query->where('property_no', 'like', '%' . $search_keyword . '%');
                                $query->orWhere('particulars', 'like', '%' . $search_keyword . '%');
                            })->where('main_category_id',0)->orderBy('id','DESC');
        
                        
        $total = $propertyObject->count();  
        $properties = $propertyObject->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $properties = $properties->map(function (Property $property): Property{
            $property['end_user'] = $this->getUserFullName(User::find($property->user->user_id)->user_id);
            return $property;
        });

        return response()->json([
            'properties' => $properties,
            'total' => $total
        ]);
    }

    public function updatePropertiesCategory(Request $request):JsonResponse
    {
        $properties = $request->all();

        foreach($properties as $property){
            Property::find($property['id'])->update(['main_category_id'=>$property['main_category_id']]);
        }

        return response()->json('Updated Successfully');
    }

    public function wmrProperty(Request $request):JsonResponse
    {
        $property = Property::find($request->id)->update([
            'status' => 'Wasted',
        ]);

        return response()->json([
            'message' => 'Property marked as Wasted successfully',
        ],200);
    }
}
