<?php

namespace App\ViewComposers;

use App\Enums\Admin\CategoryStatusEnum;
use App\Enums\Admin\ProductStatusEnum;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HeaderCategoriesComposer
{
    public function compose(View $view): void
    {
        $headerCategories = Cache::remember('header_categories', 3600, function () {
            return Category::query()
                ->where('status', CategoryStatusEnum::ACTIVE)
                ->where('parent_id', null)
                ->orderBy('order')
                ->limit(10)
                ->with(['products' => function ($query) {
                    $query->where('status', true);
                    $query->with('images');
                }])
                ->get();
        });

        $view->with('headerCategories', $headerCategories);
    }
}
