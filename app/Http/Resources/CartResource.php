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
            'is_empty' => $this->is_empty,
        ];
    }
}
