<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreinspectionRequest\CreatePreinspectionRequest;
use App\Models\PreinspectionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PreinspectionRequestController extends Controller
{
    public function list(Request $request):JsonResponse
    {
        $requests = PreinspectionRequest::all();

        return response()->json([
            'requests' => $requests
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
        $user_requests = PreinspectionRequest::where('requestor',$request->user()->user_id)->get();

        return response()->json([
            'requests' => $user_requests
        ]);
    }
}
