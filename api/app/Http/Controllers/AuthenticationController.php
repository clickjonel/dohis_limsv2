<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use App\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use UserTrait;

    public function login(LoginRequest $request): JsonResponse
    {
        $validated_fields = $request->validated();

        $user = User::where('username',$validated_fields['username'])->where('password',md5($validated_fields['password']))->first();

        if($user){
            $token = $user->createToken($user->user_id)->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => [
                    'user_id' => $user->user_id,
                    'full_name' => $this->getUserFullName($user->user_id),
                    'nickname' => $user->nickname,
                ],
                'roles' => $this->getUserRoles($user->user_id),
                'status' => true
            ]);
        }

        else{
            return response()->json([
                'status' => false
            ]);
        }
        
    }


    public function logout(Request $request):JsonResponse
    {
       $user = $request->user();

       $user->tokens()->delete();

       return response()->json([
           'message' => 'You have successfully logged out of LIMS',
           'status' => true
       ]);
    }
}
