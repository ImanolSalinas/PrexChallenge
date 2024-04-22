<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login($credentials)
    {
        if (!Auth::attempt($credentials)) {
            return ['error' => 'Invalid credentials'];
        }

        $user = User::where('email', $credentials['email'])->first();
        
        $token = $user->createToken('MyApp')->accessToken;

        return ['token' => $token];
    }
}