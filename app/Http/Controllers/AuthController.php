<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginForm(): View {
        return view("auth.login");
    }

    public function login(LoginRequest $request): RedirectResponse {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            return to_route("home");
        }

        return back()->withErrors([
            "password" => "Invalid credentials",
        ]);
    }

    public function registerForm(): View {
        return view("auth.register");
    }

    public function register(RegisterRequest $request): RedirectResponse {
        $data = $request->validated();
        $user = User::create($data);
        Auth::login($user);

        return to_route("home");
    }
}
