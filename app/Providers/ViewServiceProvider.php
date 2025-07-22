<?php

namespace App\Providers;

use App\ViewComposers\HeaderCategoriesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        View::composer('app.layouts.header', HeaderCategoriesComposer::class);
    }
}
