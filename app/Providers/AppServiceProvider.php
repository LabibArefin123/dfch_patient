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

        $org = Organization::select(
            'name',
            'organization_logo_name',
            'organization_picture'
        )->first();

        View::share('orgName', $org?->name ?? 'Organization Name');
        View::share('orgLogo', $org?->organization_logo_name ?? 'ORG');
        View::share('orgPicture', $org?->organization_picture);
    }
}
