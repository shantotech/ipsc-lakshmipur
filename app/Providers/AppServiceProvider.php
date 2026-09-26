<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default language for links built outside a /bn or /en page (e.g. error pages).
        // The SetLocale middleware overrides this on every public page.
        URL::defaults(['locale' => config('app.locale', 'bn')]);

        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
