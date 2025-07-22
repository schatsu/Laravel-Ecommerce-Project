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
            ->with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $sizeValues = $product->productAttributeValues()
            ->whereHas('attribute', fn($q) => $q->where('type', \App\Enums\AttributeType::SIZE))
            ->with('attributeValue', 'attribute')
            ->get();

        return view('app.product.show', compact('product', 'sizeValues'));
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
