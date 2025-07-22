<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegisterForm(): Factory|Application|\Illuminate\Contracts\View\View
    {
        return view('app.auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $attributes = collect($request->validated());

        $newUser = User::query()->create($attributes->toArray());

        if ($newUser) {
            auth()->login($newUser);

            return redirect()->route('account.index');
        }

        return redirect()->back();
    }
}
