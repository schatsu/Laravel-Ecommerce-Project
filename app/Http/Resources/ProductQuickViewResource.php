<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductQuickViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'price' => number_format($this->base_price, 2) . ' ₺',
            'description' => $this->short_description,
            'images' => $this->whenLoaded('media', function () {
               return  $this->getMedia('products')->map(fn ($media) => $media->getUrl());
            }),
            'variants' => $this->whenLoaded('variants', function () {
                return $this->variants
                    ->flatMap(function ($variant) {
                        return $variant->attributeVariants->map(function ($av) {
                            return [
                                'option' => $av->attribute->name,
                                'value' => $av->value->value,
                            ];
                        });
                    })
                    ->groupBy('option')
                    ->map(function ($items, $option) {
                        return [
                            'option' => $option,
                            'values' => $items->pluck('value')->unique()->values(),
                        ];
                    })
                    ->values(); // array olarak sıralı versiyonunu döndürmek için
            }),

        ];
    }
}
