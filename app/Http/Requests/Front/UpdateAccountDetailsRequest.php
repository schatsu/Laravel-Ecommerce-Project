<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAccountDetailsRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'surname' => 'nullable|string|max:60',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:6|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'name.min' => 'Ad en az :min karakter olmalıdır.',
            'name.max' => 'Ad en fazla :max karakter olabilir.',
            'surname.max' => 'Soyad en fazla :max karakter olabilir.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmaktadır.',
            'phone.max' => 'Telefon en fazla :max karakter olabilir.',
            'current_password.required_with' => 'Şifre değiştirmek için mevcut şifrenizi girmelisiniz.',
            'current_password.current_password' => 'Mevcut şifreniz yanlış.',
            'password.min' => 'Yeni şifre en az :min karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ];
    }
}
