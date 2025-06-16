<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BorrowerController extends Controller
{
    use UserTrait;

    public function create(Request $request):JsonResponse
    {
        foreach($request->properties as $property){
            Borrower::create([
                'property_id' => $property['id'],
                'borrower_id' => $request->borrower_id,
                'borrow_date' => $request->borrow_date,
            ]);
        }

        return response()->json([
            'message' => 'Borrower Saved',
        ]);
    }

    public function return(Request $request):JsonResponse
    {
        Borrower::find($request->id)->update([
            'return_date' => $request->return_date
        ]);

        return response()->json([
            'message' => 'Item Returned',
        ]);
    }

    public function list():JsonResponse
    {
        $borrowers = Borrower::with(['property','borrower'])->where('return_date',null)->get();

        return response()->json([
            'borrowers' => $borrowers->map(function($borrower){
                $borrower['borrower']['full_name'] = $this->getUserFullName($borrower['borrower_id']);
                return $borrower;
            })
        ]);
    }
}
