<?php

namespace App\Http\Requests\Front;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'variation_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'integer|min:1|max:99',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Ürün seçilmelidir.',
            'product_id.exists' => 'Seçilen ürün bulunamadı.',
            'variation_id.exists' => 'Seçilen varyasyon bulunamadı.',
            'quantity.integer' => 'Miktar bir sayı olmalıdır.',
            'quantity.min' => 'Miktar en az 1 olmalıdır.',
            'quantity.max' => 'Miktar en fazla 99 olabilir.',
        ];
    }


    public function getProduct(): Product
    {
        return Product::query()->findOrFail($this->product_id);
    }

    public function getVariation(): ?ProductVariation
    {
        return $this->variation_id
            ? ProductVariation::query()->find($this->variation_id)
            : null;
    }

    public function getQuantity(): int
    {
        return $this->input('quantity', 1);
    }

    public function getAvailableStock(): int
    {
        $variation = $this->getVariation();
        $product = $this->getProduct();

        return $variation
            ? $variation->stock_quantity
            : ($product->stock_quantity ?? 0);
    }
}
