<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductQuickViewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $defaultVariation = $this->variations->first();

        // En düşük fiyat hesaplaması (modeldeki accessor ile aynı mantık)
        $displayPrice = $this->display_price;
        $displayOriginalPrice = $this->display_original_price;
        $hasDiscount = $this->has_discount;

        $selectedOptionIds = $defaultVariation?->variation_type_option_ids ?? [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'is_favorited' => auth()->check() && auth()->user()->hasFavorited($this->resource),
            'price' => number_format($displayPrice, 2, ',', '.') . ' ₺',
            'raw_price' => (float) $displayPrice,
            'original_price' => $hasDiscount ? number_format($displayOriginalPrice, 2, ',', '.') . ' ₺' : null,
            'raw_original_price' => $hasDiscount ? (float) $displayOriginalPrice : null,
            'has_discount' => $hasDiscount,
            'url' => route('product.show', $this->slug),
            'description' => $this->short_description ?? '',
            'default_variation_id' => $defaultVariation?->id,
            'images' => $this->getMedia('images')
                ->map(fn ($media) => $media->getUrl())
                ->values(),
            'variants' => $this->variationTypes->map(function ($type) use ($selectedOptionIds) {

                $values = $type->options->map(fn ($opt) => [
                    'name' => $opt->name,
                    'image' => $opt->getFirstMediaUrl('images', 'large') ?: null,
                ]);

                $selectedOption = $type->options
                    ->whereIn('id', $selectedOptionIds)
                    ->first();

                $selected = $selectedOption?->name ?? $values->first()['name'] ?? null;

                return [
                    'option' => $type->name,
                    'values' => $values->values(),
                    'selected' => $selected,
                ];
            })->values(),
            'variations' => $this->variations->map(function ($variation) {
                $options = $variation->selectedOptions();
                $discountPrice = (float) $variation->discount_price;
                $sellingPrice = (float) $variation->selling_price;
                $hasVariationDiscount = $discountPrice > 0 && $discountPrice < $sellingPrice;
                $effectivePrice = $hasVariationDiscount ? $discountPrice : $sellingPrice;

                return [
                    'id' => $variation->id,
                    'selling_price' => (float) ($variation->selling_price ?? $this->selling_price ?? 0),
                    'discount_price' => (float) ($variation->discount_price ?? 0),
                    'effective_price' => (float) $effectivePrice,
                    'has_discount' => $hasVariationDiscount,
                    'stock_quantity' => $variation->stock_quantity ?? 0,
                    'options' => $options->map(function ($option) {
                        $variationType = $this->variationTypes->firstWhere('id', $option->variation_type_id);
                        return [
                            'type_name' => $variationType?->name ?? '',
                            'option_name' => $option->name,
                        ];
                    })->values(),
                ];
            })->values(),
        ];
    }
}
