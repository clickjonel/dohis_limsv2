<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyInspection\CreatePropertyInspectionRequest;
use App\Http\Requests\PropertyInspection\SetPropertyInspectionRequest;
use App\Http\Requests\PropertyInspection\UpdatePropertyInspectionRequest;
use App\Models\Office;
use App\Models\Property;
use App\Models\PropertyInspectionRequest;
use App\Models\User;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyInspectionRequestController extends Controller
{
    use UserTrait;
    public function create(CreatePropertyInspectionRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $request = PropertyInspectionRequest::create($validated);
        $property = Property::find($request->property_id)->update(['status' => 'Inspection']);

        return response()->json([
            'message' => 'Property inspection request created successfully',
            'request' => $request
        ], 200);

    }

    public function list(Request $request):JsonResponse
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $requestObject = PropertyInspectionRequest::with('property')
                            ->when($request->user_id,function ($query) use ($request) {
                                $query->where('requested_by', $request->user_id);
                            })
                            ->when($request->section_id,function ($query) use ($request) {
                                $query->where('inspection_section', $request->section_id);
                            })
                            ->orderBy('id','DESC');

        $total = $requestObject->count();
        $requests = $requestObject->offset(($page - 1) * $perPage)->limit($perPage)->get();                 

        $requests = $requests->map(function ($request){
                        $request['inspection_section'] = Office::find($request->inspection_section)->name;
                        $request['requested_by'] = $this->getUserFullName($request->requested_by);
                        return $request;
                    });

                    

        return response()->json([
            'requests' => $requests,
            'total' => $total
        ], 200);

    }

    public function inspect(SetPropertyInspectionRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $request = PropertyInspectionRequest::find($validated['request_id'])->update($validated);

        return response()->json([
            'message' => 'Property inspection request inspection details saved successfully',
            'request' => $request
        ], 200);

    }

    public function setWMRStatus(Request $request):JsonResponse
    {
        $requestObject = PropertyInspectionRequest::find($request->request_id)->update(['status'=>'WMR']);
        $property = Property::find($requestObject->property_id)->update(['status'=>'For Waste']);

        return response()->json([
            'message' => 'Property inspection request status updated successfully',
        ], 200);

    }

    public function setRequestsAsFinished(Request $request):JsonResponse
    {
        $data = [];

        foreach($request->all() as $property_request){
            $requestObject = PropertyInspectionRequest::find($property_request);
            $property = Property::find($requestObject->property_id)->update(['status'=>'Wasted']);

            $requestObject->update(['status'=>'Finished']);
        }



        return response()->json([
            'message' => 'Property inspection request status updated successfully',
        ], 200);

    }

}
