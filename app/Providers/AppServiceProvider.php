<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
        Http::macro('inventory', function () {
            return Http::withHeaders([
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . config('services.inventory.token'),
                'User-Agent'    => 'Shop',
                'App-Environment' => app()->environment(),
            ])->baseUrl(config('services.inventory.inventory_url'));
        });
    }
}
