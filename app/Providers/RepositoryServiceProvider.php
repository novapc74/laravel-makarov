<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Repositories\RepositoryInterface;
use App\Repositories\UserRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
