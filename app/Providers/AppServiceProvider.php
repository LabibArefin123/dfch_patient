<?php

namespace App\Providers;
use App\Models\Organization;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app('router')->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
        $org = Organization::select('name')->first();
        $orgLogo = Organization::select('organization_logo_name')->first();

        View::share('orgName', $org?->name ?? 'Organization Name');
        View::share('orgLogo', $orgLogo?->organization_logo_name ?? 'Organization Logo');
    }
}
