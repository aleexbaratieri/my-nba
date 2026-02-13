<?php

namespace App\Providers;

use App\Repositories\Contracts;
use App\Repositories\Eloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            Contracts\UserRepositoryInterface::class,
            Eloquent\UserRepository::class
        );

        $this->app->bind(
            Contracts\TeamRepositoryInterface::class,
            Eloquent\TeamRepository::class
        );

        $this->app->bind(
            Contracts\PlayerRepositoryInterface::class,
            Eloquent\PlayerRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
