<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Repositories\OrderRepository;
use App\Repositories\RepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\WorkerRepository;
use App\Services\Controllers\UserControllerService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, UserRepository::class);

        $this->app->when(UserController::class)
            ->needs(RepositoryInterface::class)->give(function($app) {
                return $app->make(RepositoryInterface::class);
            });

        $this->app->bind(RepositoryInterface::class, OrderRepository::class);

        $this->app->when(OrderRepository::class)
            ->needs(RepositoryInterface::class)->give(function($app) {
                return $app->make(RepositoryInterface::class);
            });

        $this->app->bind(RepositoryInterface::class, WorkerRepository::class);

        $this->app->when(WorkerRepository::class)
            ->needs(RepositoryInterface::class)->give(function($app) {
                return $app->make(RepositoryInterface::class);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
