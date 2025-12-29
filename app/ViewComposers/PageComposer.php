<?php

namespace App\ViewComposers;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PageComposer
{
    public function compose(View $view): void
    {
        $shippingPage = Cache::rememberForever('shipping_page', function () {
            return Page::query()
                ->where('is_active', true)
                ->where('slug', 'teslimat-kargo')
                ->first();
        });

        $returnPage = Cache::rememberForever('return_page', function () {
            return Page::query()
                ->where('is_active', true)
                ->where('slug', 'iade-degisim-kosullari')
                ->first();
        });

        $view->with('shippingPage', $shippingPage);
        $view->with('returnPage', $returnPage);
    }
}
