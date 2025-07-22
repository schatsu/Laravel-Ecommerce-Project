<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\loginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(): Factory|Application|View
    {
        return view('app.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $attributes = collect($request->validated());

        if (Auth::attempt($attributes->toArray())) {
            $request->session()->regenerate();
            return redirect()->route('account.index');
        }

        return redirect()->back()->withErrors(['email' => 'Geçersiz kimlik bilgileri.']);
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('home');
    }
}
