<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        $validation = $request->validated();
        $validation['password'] = bcrypt($request->password);
        $user = User::create($validation);
        return response(['success'=>true , 'data'=>$user]);
    }
    
    public function login(UserRequest $request)
    {
        if (!Auth::attempt($request->only(['email' , 'password' , 'phone'])))
        return response(['message'=>'Unauthorized','code'=>401]);
        
        $user= User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = ['user'=>$user , 'token'=>$token , 'code'=>200];
        return response(['success'=>true , 'data'=>$response]);
    }
}