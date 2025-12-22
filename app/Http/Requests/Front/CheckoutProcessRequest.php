<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:invoices,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_id.required' => 'Lütfen bir teslimat adresi seçin.',
            'address_id.exists' => 'Seçilen adres bulunamadı.',
        ];
    }
}
