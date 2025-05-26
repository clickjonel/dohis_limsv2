<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreinspectionRequest\CreatePreinspectionRequest;
use App\Http\Resources\PreinspectionResource;
use App\Models\PreinspectionRequest;
use App\Models\User;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PreinspectionRequestController extends Controller
{
    use UserTrait;

    public function list(Request $request):JsonResponse
    {
        $requests = PreinspectionRequest::
                    when($request->user()->assignment->section_id === 22 || 
                        $request->user()->assignment->section_id === 25 &&
                        $request->user()->assignment->section_id !== 582,function($query) use ($request){
                            $query->where('inspection_section',$request->user()->assignment->section_id);
                    })
                    ->orderByDesc('created_at')
                    ->get();

        return response()->json([
            'requests' => PreinspectionResource::collection($requests),
            'user' => $request->user()->assignment->user_id
        ]);
    }

    public function createRequest(CreatePreinspectionRequest $request):JsonResponse
    {
        $validated = $request->validated();

        $request = PreinspectionRequest::create([
            'equipment' => $validated['equipment'],
            'model' => $validated['model'],
            'property_no' => $validated['property_no'],
            'acquisition_cost' => $validated['acquisition_cost'],
            'acquisition_date' => $validated['acquisition_date'],
            'defects' => $validated['defects'],
            'requestor' => $validated['requestor'],
            'inspection_section' => $validated['equipment_type'] === 'ICT Equipments' ? 25 : 22,
            'date' => $validated['date']
        ]);

        return response()->json([
            'request' => $request
        ]);
    }

    public function listUserRequests(Request $request):JsonResponse
    {
        $user_requests = PreinspectionRequest::where('requestor',$request->user()->user_id)->orderByDesc('created_at')->get();

        return response()->json([
            'requests' => PreinspectionResource::collection($user_requests)
        ]);
    }

    public function actionPreinspectionRequest(Request $request):JsonResponse
    {
        $preinspection_request = PreinspectionRequest::find($request->id)->update([
            'findings' => $request->findings,
            'inspection_result' => $request->inspection_result,
            'inspection_date' => $request->inspection_date
        ]);

        return response()->json([
            'message' => 'Successfully Updated Inspection Findings',
            'preinspection_request' => $preinspection_request
        ]);
    }

    public function fetchPreinspectionRequestsforPreinspectionListPage(Request $request):JsonResponse
    {
       $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $preinspectionRequestObject = PreinspectionRequest::when($search_keyword, function ($query) use ($search_keyword) {
                                $query->where('property_no', 'like', '%' . $search_keyword . '%');
                            })->orderBy('id','DESC');
        
                        
        $total = $preinspectionRequestObject->count();  
        $preinspection_requests = $preinspectionRequestObject->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $preinspection_requests = $preinspection_requests->map(function (PreinspectionRequest $request): PreinspectionRequest{
            $request['requestor'] = $this->getUserFullName($request['requestor']);
            return $request;
        });

        return response()->json([
            'preinspection_requests' => $preinspection_requests,
            'total' => $total
        ]);
    }

    public function fetchUserPreinspectionRequestsforPreinspectionListPage(Request $request):JsonResponse
    {
       $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $preinspectionRequestObject = PreinspectionRequest::where('requestor',$request->user_id)
                                        ->when($search_keyword, function ($query) use ($search_keyword) {
                                            $query->where('property_no', 'like', '%' . $search_keyword . '%');
                                        })->orderBy('id','DESC');
        
                        
        $total = $preinspectionRequestObject->count();  
        $preinspection_requests = $preinspectionRequestObject->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $preinspection_requests = $preinspection_requests->map(function (PreinspectionRequest $request): PreinspectionRequest{
            $request['requestor'] = $this->getUserFullName($request['requestor']);
            return $request;
        });

        return response()->json([
            'preinspection_requests' => $preinspection_requests,
            'total' => $total
        ]);
    }

}
