<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ResetPasswordRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null): View|Application|Factory
    {
        return view('app.auth.password-reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $attributes = collect($request->validated());

        $status = Password::reset($attributes->toArray(), function ($user) use ($request) {
            $user->password = Hash::make($request->password);
            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login');
        }

        return redirect();
    }
}
