<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductQuickViewResource;
use App\Models\Product;
use App\Services\ProductViewService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductViewService $productViewService
    ) {}

    public function show(Request $request, string $slug)
    {
        $product = Product::query()
            ->active()
            ->where('slug', $slug)
            ->with([
                'media',
                'category',
                'variationTypes.options.media',
                'variations' => fn($query) => $query->active()
            ])
            ->firstOrFail();

        $selectedOptionIds = array_map('intval', (array) $request->input('options', []));
        sort($selectedOptionIds);

        $selectedVariation = $this->productViewService->findSelectedVariation($product, $selectedOptionIds);

        if (!$selectedVariation) {
            $selectedVariation = $product->variations->first();
            $selectedOptionIds = $this->productViewService->getDefaultOptionIds($selectedVariation);
        }

        $pricing = $this->productViewService->calculatePricingAndStock($product, $selectedVariation);

        $galleryImages = $this->productViewService->getGalleryImages($product, $selectedOptionIds);

        $availableOptionsByType = $this->productViewService->calculateAvailableOptionsByType($product, $selectedOptionIds);

        return view('app.product.show', [
            'product' => $product,
            'selectedVariation' => $selectedVariation,
            'selectedOptionIds' => $selectedOptionIds,
            'currentSellingPrice' => $pricing['currentSellingPrice'],
            'currentDiscountPrice' => $pricing['currentDiscountPrice'],
            'currentStock' => $pricing['currentStock'],
            'hasStock' => $pricing['hasStock'],
            'galleryImages' => $galleryImages,
            'availableOptionsByType' => $availableOptionsByType,
        ]);
    }

    public function quickView(string $slug): ProductQuickViewResource
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->with([
                'media',
                'variations',
                'variationTypes.options',
            ])
            ->firstOrFail();

        return ProductQuickViewResource::make($product);
    }
}
