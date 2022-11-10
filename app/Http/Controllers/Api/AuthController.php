<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{
    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
            'device_name' => 'required'
        ]);
        $credentials = $request->only(['email', 'password', 'device_name']);
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Usuário ou senha incorretos.'],
            ]);
        }

        $token = $user->createToken($credentials['device_name']);

        return response()->json([
            'access_token' => $token->plainTextToken,
            'name' => $token->accessToken->name,
            'expires_at' => now()->addDays(180)
        ]);
    }
}
