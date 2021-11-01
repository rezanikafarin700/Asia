<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\User;
use Illuminate\Foundation\Auth\Verifies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function index(){
        $users = User::all();
        return $users;
    }


    public function store(UserRequest $request)
    {
        $user =  User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'api_token' => str_random(50)
        ]);

        return response($user,201);
    }


}
