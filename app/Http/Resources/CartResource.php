<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'count' => $this->item_count,
            'subtotal' => number_format($this->subtotal, 2, ',', '.'),
            'subtotal_raw' => (float) $this->subtotal,
            'discount_amount' => number_format($this->discount_amount, 2, ',', '.'),
            'discount_amount_raw' => (float) $this->discount_amount,
            'total' => number_format($this->total, 2, ',', '.'),
            'total_raw' => (float) $this->total,
            'is_empty' => $this->is_empty,
            'coupon' => $this->coupon ? [
                'id' => $this->coupon->id,
                'code' => $this->coupon->code,
                'name' => $this->coupon->name,
                'formatted_value' => $this->coupon->formatted_value,
            ] : null,
        ];
    }
}
