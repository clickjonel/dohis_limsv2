<?php

namespace App\Http\Controllers;

use App\Models\StockCardCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockCardCategoryController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $categories = StockCardCategory::get();
    
        return response()->json([
            'categories' => $categories
        ]);
    }
}
