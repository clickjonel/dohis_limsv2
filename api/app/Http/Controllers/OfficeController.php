<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\OfficeTrait;
use App\UserTrait;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    use UserTrait,OfficeTrait;

    public function list()
    {
        $offices = Office::with('personnel')->select(['section_id', 'section_name'])->get();
    
        return response()->json([
            'offices' => $offices->map(function($office) {
                $office = [
                    'section_id' => $office->section_id,
                    'section_name' => $office->section_name,
                    'personnel' => $this->fetchOfficePersonnel($office->section_id)
                ];
                return $office;
            })
        ]);
    }

    // public function fetchOfficePersonnel(Request $request)
    // {
    //     $personnel = Office::find('');

    //     return response()->json([
    //         'office_personnel' => $personnel
    //     ]);
    // }
}
