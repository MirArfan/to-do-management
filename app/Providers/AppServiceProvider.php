<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Cookie;

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
        // View composer: all views will get $theme variable
        View::composer('*', function ($view) {
            $theme = Cookie::get('theme', 'light'); // default light
            $view->with('theme', $theme);
        });
    }
}
