<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Log;

class AuthController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $remember = $request->filled('remember');
        if (Auth::attempt($request->only(['name', 'password']), $remember)) {
            session()->regenerateToken();
            Log::info('User '.Auth::user()->name.' logged in');

            return to_route('projects.index');
        }

        return back()->withErrors([
            'password' => 'Invalid credentials',
        ]);
    }

    public function registerForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $remember = $request->filled('remember');
        /** @var User $user */
        $user = User::create($request->validated());

        Auth::login($user, $remember);
        session()->regenerateToken();

        Log::info('User '.Auth::user()->name.' registered');

        return to_route('projects.create');
    }

    public function logout(): RedirectResponse
    {
        Log::info('User '.Auth::user()->name.' logged out');
        Auth::logout();
        session()->regenerateToken();

        return to_route('login');
    }
}
