<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UserTrait;
    public function getUserData(Request $request): JsonResponse
    {
        $user = $request->user();
        $user['full_name'] = $this->getUserFullName($user->user_id);
        $roles = $this->getUserRoles($user->user_id);

       return response()->json([
            // 'full_name' => $this->getUserFullName($user->user_id),
            'user' => $user,
            'assignment' => $user->assignment,
            'roles' => $roles,
        ]);
    }

    public function userSelectionList():JsonResponse
    {
       $users = User::where('user_id','!=',1)->get()->map(function($user){
            $user['full_name'] = $this->getUserFullName($user->user_id);
            return $user;
       }); 

       return response()->json([
            'users' => $users
       ]);
    }
}
