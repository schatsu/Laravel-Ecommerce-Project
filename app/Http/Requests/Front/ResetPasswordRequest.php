<?php

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required',Password::defaults(), 'confirmed']
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'Parola sıfırlama tokenı gereklidir.',

            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi girin.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az :min karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarları uyuşmuyor.',
            'password.letters' => 'Şifrede en az bir harf olmalıdır.',
            'password.numbers' => 'Şifrede en az bir rakam olmalıdır.',
            'password.symbols' => 'Şifrede en az bir özel karakter olmalıdır.',
            'password.mixed' => 'Şifrede hem büyük hem küçük harf bulunmalıdır.',
            'password.uncompromised' => 'Bu şifre güvenlik ihlallerinde yer almış. Lütfen farklı bir şifre kullanın.',
        ];
    }

}
