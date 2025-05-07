<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function selection()
    {
        $divisions = Division::select(['division_id', 'division_name'])->get();
    
        return response()->json([
            'divisions' => $divisions
        ]);
    }
}
