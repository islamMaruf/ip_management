<?php

namespace App\Providers;

use App\Services\ActivityLoggerService;
use App\Services\APIResponseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('api_response', function () {
            return new APIResponseService();
        });
        $this->app->bind('activity_logger', function () {
            return new ActivityLoggerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
