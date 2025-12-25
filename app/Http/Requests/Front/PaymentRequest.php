<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'card_number' => ['required', 'string', 'min:15', 'max:19'],
            'holder_name' => ['required', 'string', 'max:100'],
            'expire_date' => ['required', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'cvc' => ['required', 'string', 'min:3', 'max:4'],
            'installment' => ['nullable', 'integer', 'min:1', 'max:12'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Sipariş bulunamadı.',
            'order_id.exists' => 'Geçersiz sipariş.',
            'card_number.required' => 'Kart numarası zorunludur.',
            'card_number.min' => 'Geçersiz kart numarası.',
            'holder_name.required' => 'Kart sahibi adı zorunludur.',
            'expire_date.required' => 'Son kullanma tarihi zorunludur.',
            'expire_date.regex' => 'Son kullanma tarihi AA/YY formatında olmalıdır.',
            'cvc.required' => 'CVV zorunludur.',
            'cvc.min' => 'CVV en az 3 karakter olmalıdır.',
        ];
    }
}
