<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Tender;
use App\Models\TenderParticipate;
use App\Models\TenderAwarded;

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
