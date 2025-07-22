<?php

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
            'email' => 'required|string|email:rfc,dns|max:255|exists:users',
            'password' => 'required|string|min:8|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.string' => 'E-posta adresi geçerli bir metin olmalıdır.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi girin.',
            'email.max' => 'E-posta adresi en fazla 255 karakter olabilir.',
            'email.exists' => 'Bu e-posta adresine sahip bir kullanıcı bulunamadı.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.string' => 'Şifre geçerli bir metin olmalıdır.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.max' => 'Şifre en fazla 255 karakter olabilir.',
        ];
    }

}
