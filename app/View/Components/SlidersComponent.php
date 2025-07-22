<?php

namespace App\View\Components;

use App\Enums\Admin\SliderStatusEnum;
use App\Models\Slider;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SlidersComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public Collection $sliders;
    public function __construct()
    {
        $this->sliders = Cache::remember('sliders', 3600, function () {
           return Slider::query()
                ->where('status', SliderStatusEnum::ACTIVE)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sliders-component');
    }
}
