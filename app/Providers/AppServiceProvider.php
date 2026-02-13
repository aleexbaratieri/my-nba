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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
