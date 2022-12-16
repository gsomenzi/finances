<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'device_name' => 'required'
        ]);
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $token = $user->createToken($request->device_name);
        return response()->json([
            'user_data' => $user,
            'auth_data' => [
                'access_token' => $token->plainTextToken,
                'name' => $token->accessToken->name,
                'expires_at' => now()->addDays(180)
            ]
        ]);
    }
}
