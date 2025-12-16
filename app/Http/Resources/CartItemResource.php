<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'quantity' => $this->quantity,
            'unit_price' => number_format($this->unit_price, 2, ',', '.'),
            'total' => number_format($this->total, 2, ',', '.'),
            'image' => $this->image_url,
            'product_url' => route('product.show', $this->product->slug),
        ];
    }
}
