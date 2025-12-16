<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductViewService
{
    public function findSelectedVariation(Product $product, array $selectedOptionIds): ?object
    {
        if (empty($selectedOptionIds)) {
            return null;
        }

        return $product->variations->first(function ($variation) use ($selectedOptionIds) {
            $variationOptions = $variation->variation_type_option_ids ?? [];

            if (!is_array($variationOptions)) {
                return false;
            }

            $variationOptions = array_map('intval', $variationOptions);
            sort($variationOptions);

            return $selectedOptionIds === $variationOptions;
        });
    }

    public function getDefaultOptionIds(?object $selectedVariation): array
    {
        if (!$selectedVariation) {
            return [];
        }

        $optionIds = $selectedVariation->variation_type_option_ids ?? [];

        return is_array($optionIds) ? array_map('intval', $optionIds) : [];
    }

    public function calculatePricingAndStock(Product $product, ?object $selectedVariation): array
    {
        $currentSellingPrice = $selectedVariation
            ? $selectedVariation->selling_price
            : $product->selling_price;

        $currentDiscountPrice = $selectedVariation
            ? $selectedVariation->discount_price
            : $product->discount_price;

        $currentStock = $selectedVariation
            ? $selectedVariation->stock_quantity
            : ($product->stock_quantity ?? 0);

        return [
            'currentSellingPrice' => $currentSellingPrice,
            'currentDiscountPrice' => $currentDiscountPrice,
            'currentStock' => $currentStock,
            'hasStock' => $currentStock > 0,
        ];
    }

    public function getGalleryImages(Product $product, array $selectedOptionIds): Collection
    {
        $galleryImages = $product->media;

        if (empty($selectedOptionIds)) {
            return $galleryImages;
        }

        $variantImages = collect();

        foreach ($product->variationTypes as $variationType) {
            foreach ($variationType->options as $option) {
                if (in_array($option->id, $selectedOptionIds) && $option->hasMedia('images')) {
                    $variantImages = $variantImages->merge($option->getMedia('images'));
                }
            }
        }

        return $variantImages->isNotEmpty() ? $variantImages : $galleryImages;
    }

    public function calculateAvailableOptionsByType(Product $product, array $selectedOptionIds): array
    {
        $availableOptionsByType = [];

        foreach ($product->variationTypes as $variationType) {
            $availableOptionsByType[$variationType->id] = [];

            $otherSelectedOptions = collect($selectedOptionIds)
                ->reject(fn($id) => $variationType->options->pluck('id')->contains($id))
                ->values()
                ->all();

            foreach ($variationType->options as $option) {
                $testCombination = array_merge($otherSelectedOptions, [$option->id]);
                sort($testCombination);

                $hasValidVariation = $product->variations->contains(function ($variation) use ($testCombination) {
                    $variationOptions = $variation->variation_type_option_ids ?? [];

                    if (!is_array($variationOptions)) {
                        return false;
                    }

                    $variationOptions = array_map('intval', $variationOptions);
                    sort($variationOptions);

                    return $testCombination === $variationOptions;
                });

                if ($hasValidVariation) {
                    $availableOptionsByType[$variationType->id][] = $option->id;
                }
            }
        }

        return $availableOptionsByType;
    }
}
