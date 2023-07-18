<?php

namespace App\Providers;

use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
