<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app('router')->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
    }
}
