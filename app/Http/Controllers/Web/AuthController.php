<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        return view('auth/login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);
        $credentials = $request->only(["email", "password"]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Usuário ou senha incorretos.',
        ])->onlyInput('email');
    }
}
