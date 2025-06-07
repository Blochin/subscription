<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Route::middleware([])
        ->group(base_path('routes/webhooks.php'));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
