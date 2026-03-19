<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

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
        // Check if the request is coming through an HTTPS proxy
        if (request()->header('X-Forwarded-Proto') === 'https' || 
            str_contains(request()->getHost(), 'ngrok-free')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
