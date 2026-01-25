<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ViewPermission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Define model => policy mappings here if needed
        // Example: \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();


        // Gate::define('view-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'manager', 'demo']));
        // Gate::define('create-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'user', 'manager', 'demo']));
        // Gate::define('view-participated-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'manager', 'demo']));
        // Gate::define('view-archived-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'manager', 'demo']));
        // Gate::define('view-awarded-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'manager', 'demo']));
        // Gate::define('view-completed-tenders', fn(User $user) => $user->role && in_array($user->role->name, ['admin', 'manager', 'demo']));
    }
}
