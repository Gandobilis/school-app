<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        if (!Auth::attempt($request->validated())) {
            return response([
                'message' => "Credentials don't match"
            ], 422);
        }

        return response([
            'access_token' => Auth::user()->createToken('API Token')->plainTextToken
        ], 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Successful Logout'
        ], 200);
    }
}
