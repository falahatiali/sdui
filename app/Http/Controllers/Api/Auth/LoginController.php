<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password')])) {
            $user = Auth::user();

            return response()->json([
                'user' => $user->name,
                'token' => $user->createToken('MyApp')->plainTextToken
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'login failed'
        ], 401);

    }
}
