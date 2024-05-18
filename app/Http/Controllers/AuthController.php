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
    public function loginForm(): View
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $remember = $request->filled("remember");
        if (Auth::attempt($request->only(["name", "password"]), $remember)) {
            session()->regenerateToken();

            return to_route("home");
        }

        return back()->withErrors([
            "password" => "Invalid credentials",
        ]);
    }

    public function registerForm(): View
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $remember = $request->filled("remember");
        $user = User::create($request->only(["name", "password"]));

        Auth::login($user, $remember);
        session()->regenerateToken();

        return to_route("home");
    }
}
