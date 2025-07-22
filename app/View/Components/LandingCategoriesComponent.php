<?php

namespace App\View\Components;

use App\Enums\Admin\CategoryStatusEnum;
use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LandingCategoriesComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public Collection $categories;
    public function __construct()
    {
        $this->categories = Cache::remember('landing_categories', 3600, function () {
           return Category::query()
                ->select('id', 'name', 'slug','landing_cover_image','collection_cover_image')
                ->where('status', CategoryStatusEnum::ACTIVE)
                ->where('is_landing', true)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.landing-categories-component');
    }
}
