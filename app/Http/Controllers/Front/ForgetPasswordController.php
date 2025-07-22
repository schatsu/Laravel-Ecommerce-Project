<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CheckEmailRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    public function sendResetLinkEmail(CheckEmailRequest $request): RedirectResponse
    {
        $attributes = collect($request->validated());

        $status = Password::sendResetLink($attributes->toArray());

        if ($status === Password::RESET_LINK_SENT )
        {
            return redirect()->back()->with('status', 'Şifre sıfırlama maili gönderildi');
        }

        return redirect()->back()->withErrors(['email' => 'Girdiğiniz e-posta kayıtlarımızla eşleşmedi.']);
    }
}
