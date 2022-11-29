<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function view(Request $request) {
        return view("register.register");
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5'
        ]);
        $input = $request->only(['name', 'email', 'password']);
        $credentials = $request->only(["email", "password"]);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Usuário ou senha incorretos.',
        ])->onlyInput('email');
    }
}
