<?php

namespace App\Http\Controllers\Front;

use App\Enums\Admin\CategoryStatusEnum;
use App\Enums\Admin\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\ModelFilters\ProductFilter;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('status', CategoryStatusEnum::ACTIVE)
            ->where('parent_id', null)
            ->orderBy('order')
            ->paginate(12);

        return view('app.category.index', compact('categories'));
    }

    public function show(Request $request, string $slug): View
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('slug', $slug)
            ->where('status', CategoryStatusEnum::ACTIVE)
            ->with('children')
            ->firstOrFail();

        $products = $category->products()
            ->where('status', ProductStatusEnum::PUBLISHED)
            ->with([
                'media',
                'variations',
            ])
            ->filter($request->all(), ProductFilter::class)
            ->paginate(12)
            ->withQueryString();

        return view('app.category.show', compact('category', 'products'));
    }
}
