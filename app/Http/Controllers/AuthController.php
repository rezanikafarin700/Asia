<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use http\Env\Response;
use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if(auth()->check()) {
            $user = auth()->user()->generateToken();

            return $user;
        }
        else{
            return response()->json([
                'error' => 'اطلاعات کاربری اشتباه وارد شده است'
            ],401);
        }

// کدهای بالا کدهای بهتری هستند ولی این کدها قابل فهم تر هستند
//        $user = User::
//        where('email',$request->email)->first();
//        if(!empty($user)) {
//            $check = Hash::check($request->password,$user->password);
//            dd($check);
//            $user->api_token = str_random(50);
//            $user->save();
//            return response()->json($user, 200);
//        }
//        return response()->json([
//            'error' => 'Not Found'
//        ]);
//



    }

    public function logout()
    {
       $user =  auth()->guard('api')->user();
       $user->logout();
       return response()->json($user,200);
    }
}
