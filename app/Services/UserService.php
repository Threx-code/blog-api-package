<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function login($request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;

            return response()->json([
                'status' => 'success',
                'success' => true,
                'token' => $token,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'success' => false,
                'message' => 'Invalid credentials entered'
            ]);
        }
    }


    public function register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 201,
            'success' => true,
            'data' => $user
        ]);
    }
}
