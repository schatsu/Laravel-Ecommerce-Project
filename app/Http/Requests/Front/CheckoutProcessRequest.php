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
            'delivery_address_id' => ['required', 'exists:invoices,id'],
            'billing_address_id' => ['nullable', 'exists:invoices,id'],
            'same_as_delivery_hidden' => ['nullable', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_address_id.required' => 'Lütfen bir teslimat adresi seçin.',
            'delivery_address_id.exists' => 'Seçilen teslimat adresi bulunamadı.',
            'billing_address_id.exists' => 'Seçilen fatura adresi bulunamadı.',
        ];
    }
}
