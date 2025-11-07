<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductQuickViewResource;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug): Factory|Application|View
    {
        $product = Product::query()
            ->with(['media', 'category', 'variations', 'variationTypes' => function ($query) {
                $query->with('options');
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('app.product.show', compact('product'));
    }

    public function quickView(string $hashId): ProductQuickViewResource
    {
        $product = Product::query()
            ->with([
                'media',
                'variants.attributeVariants.attribute',
                'variants.attributeVariants.value',
            ])
            ->findByHashidOrFail($hashId);

        return ProductQuickViewResource::make($product);
    }

}
