<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        set_time_limit(0);
        Http::macro('microsite', function () {
            return Http::withHeaders([
                'X-Example' => 'example',
            ])->baseUrl(config('app.api_base_url'));
        });
    }
}
