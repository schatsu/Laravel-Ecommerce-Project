<?php

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => ['required', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'name.string' => 'Ad alanı metinsel olmalıdır.',
            'name.min' => 'Ad alanı en az 2 karakter olmalıdır.',
            'name.max' => 'Ad alanı en fazla 255 karakter olabilir.',

            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.string' => 'Soyad alanı metinsel olmalıdır.',
            'surname.max' => 'Soyad alanı en fazla 255 karakter olabilir.',

            'email.required' => 'E-posta alanı zorunludur.',
            'email.string' => 'E-posta alanı metinsel olmalıdır.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta alanı en fazla 255 karakter olabilir.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlıdır.',

            'password.required' => 'Şifre alanı zorunludur.',
        ];
    }
}
