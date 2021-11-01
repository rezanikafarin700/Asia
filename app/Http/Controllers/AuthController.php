<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::
        where([
            'email' => $request->email,
            'password' => $request->password
        ])->first();
        $user->api_token = str_random(50);
        $user->save();
        return response()->json($user, 200);

    }

    public function logout()
    {
       $user =  auth()->guard('api')->user();
       $user->logout();
       return response()->json($user,200);
    }
}
