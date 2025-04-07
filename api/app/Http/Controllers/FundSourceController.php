<?php

namespace App\Http\Controllers;

use App\Models\FundSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FundSourceController extends Controller
{
    public function list():JsonResponse
    {
        $fund_sources = FundSource::get();

        return response()->json(['fund_sources'=>$fund_sources]);
    }
}
