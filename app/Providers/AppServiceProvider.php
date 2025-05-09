<?php

namespace App\Providers;

use App\Models\Configuration;
use App\Services\ConfigService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


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
        //

        $this->app->singleton(ConfigService::class, function ($app) {
            return new ConfigService();
        });

        // $config = Configuration::pluck('valor', 'clave')->toArray();
        // View::share('config', $config);
    }
}
