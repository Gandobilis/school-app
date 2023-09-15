<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response([
                'message' => "Credentials don't match"
            ], 422);
        }

        if (!auth()->user()->active) {
            return response([
                'message' => 'Your account is inactive. Please contact support.'
            ], 403);
        }

        return response([
            'access_token' => Auth::user()->createToken('API Token')->plainTextToken
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Successful Logout']);
    }
}
