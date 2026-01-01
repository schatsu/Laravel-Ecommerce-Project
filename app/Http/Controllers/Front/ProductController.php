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

        $shareUrl = route('product.show', ['slug' => $product?->slug]);
        $shareTitle = $product->name;
        $shareText = $product->short_description ?? $product->name;

        // Reviews data
        $reviews = $product->approvedReviews()
            ->with('user')
            ->latest()
            ->get();

        $averageRating = $product->average_rating;
        $reviewsCount = $product->reviews_count;
        $ratingDistribution = $product->rating_distribution;

        // Check if current user has already reviewed and if they have purchased
        $userReview = null;
        $hasPurchased = false;

        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();

            // Check if user has purchased this product (delivered orders only)
            $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                ->where('status', \App\Enums\Admin\OrderStatusEnum::DELIVERED)
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->exists();
        }

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
            'shareUrl' => $shareUrl,
            'shareTitle' => $shareTitle,
            'shareText' => $shareText,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'reviewsCount' => $reviewsCount,
            'ratingDistribution' => $ratingDistribution,
            'userReview' => $userReview,
            'hasPurchased' => $hasPurchased,
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
