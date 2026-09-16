<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (str_starts_with((string) config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer(['layouts.app', 'admin.layouts.app'], function ($view) {
            $site = \Illuminate\Support\Facades\Schema::hasTable('site_settings')
                ? SiteSetting::current()
                : null;
            $view->with('site', $site);
            $view->with('cartCount', \App\Services\Cart::count());
        });
    }
}
