<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $page = $request->page ?? 1;
        // $offset = ($page - 1) * 15;
        $perPage = $request->per_page ?? 15;
        $search_keyword = trim($request->keyword ?? '');

        $baseQuery = Measurement::query()
            ->when($search_keyword, function ($query) use ($search_keyword) {
                $query->where('name', 'like', '%' . $search_keyword . '%');
            })
            ->orderByDesc('id');

        // Get paginated results
        $measurements = $baseQuery->clone()
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        // Get total count from the original query
        $total = $baseQuery->count();

        return response()->json([
            'measurements' => $measurements,
            'total' => $total,
            'data' => $search_keyword,
        ]);
    }

    public function measurementSelectionList():JsonResponse
    {

        $measurements = Measurement::orderBy('id','asc')->get();

        return response()->json([
            'measurements' => $measurements,
        ]);
    }

    public function updateOrCreate(Request $request):JsonResponse
    {
        $measurement = Measurement::updateOrCreate(
            [ 'id'=> $request->id ] ,
            ['name' => $request->name]
        );

        return response()->json([
            'measurement' => $measurement
        ]);
    }
    
}
