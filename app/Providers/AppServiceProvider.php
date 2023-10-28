<?php

namespace App\Providers;

use App\Interfaces\IPRepositoryInterface;
use App\Models\IP;
use App\Observers\IPObserver;
use App\Repositories\IPRepository;
use App\Services\ActivityTrackerService;
use App\Services\APIResponseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('api_response', APIResponseService::class);
        $this->app->bind('activity_logger', ActivityTrackerService::class);
        $this->app->bind(IPRepositoryInterface::class, IPRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        IP::observe(IPObserver::class);
    }
}
