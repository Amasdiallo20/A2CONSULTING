<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $helpers = app_path('helpers.php');
        if (is_file($helpers)) {
            require_once $helpers;
        }
    }

    public function boot(): void
    {
        Paginator::defaultView('pagination.theme');
        Paginator::defaultSimpleView('pagination.simple-theme');

        if (str_starts_with((string) config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            static $site = false;
            if ($site === false) {
                $site = \Illuminate\Support\Facades\Schema::hasTable('site_settings')
                    ? SiteSetting::current()
                    : null;
            }
            if (! $view->offsetExists('site')) {
                $view->with('site', $site);
            }
        });

        View::composer(['layouts.app', 'admin.layouts.app'], function ($view) {
            $view->with('cartCount', \App\Services\Cart::count());
        });
    }
}
