<?php

namespace App\Http\Requests\Front;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi girin.',
            'email.exists' => 'Bu e-posta adresine sahip bir kullanıcı bulunamadı.',
        ];
    }

}
