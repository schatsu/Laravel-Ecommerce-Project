<?php

namespace App\Http\Controllers\Front;

use App\Enums\Admin\CategoryStatusEnum;
use App\Enums\Admin\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

    }

    public function show(string $slug): Factory|Application|View
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('slug', $slug)
            ->where('status', CategoryStatusEnum::ACTIVE)
            ->firstOrFail();

        $products = $category->products()
            ->where('status', true)
            ->with([
                'media',
                'variants.attributeValues'
            ])
            ->latest()
            ->paginate(12);

        return view('app.category.show', compact('category', 'products'));
    }
}
