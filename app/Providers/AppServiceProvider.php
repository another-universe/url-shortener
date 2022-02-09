<?php

declare(strict_types=1);

namespace App\Providers;

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
        $this->app->singleton(\App\Contracts\Services\UrlShortener\UrlShortenerService::class, static function ($app) {
            return $app->make(\App\Services\UrlShortener\UrlShortenerService::class, ['pathLength' => 5]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//
    }
}
