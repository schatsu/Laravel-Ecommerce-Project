<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:0|max:99',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Miktar belirtilmelidir.',
            'quantity.integer' => 'Miktar bir sayı olmalıdır.',
            'quantity.min' => 'Miktar en az 0 olmalıdır.',
            'quantity.max' => 'Miktar en fazla 99 olabilir.',
        ];
    }

    public function getQuantity(): int
    {
        return $this->input('quantity');
    }
}
