<?php

namespace App\View\Components;

use App\Enums\Admin\CategoryStatusEnum;
use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class CategoriesComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public Collection $categories;

    public function __construct()
    {
        $this->categories = Cache::remember('featured_categories', 3600, function () {
            return Category::query()
                ->where('status', CategoryStatusEnum::ACTIVE)
                ->where('is_featured', true)
                ->orderBy('order')
                ->with('media')
                ->limit(6)
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.categories-component');
    }
}
