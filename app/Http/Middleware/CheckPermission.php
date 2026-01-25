<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1️⃣ Must be logged in
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // 2️⃣ ADMIN ROLE → ACCESS EVERYTHING
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // 3️⃣ Get route name
        $routeName = $request->route()?->getName();

        // If route has no name, allow it
        if (!$routeName) {
            return $next($request);
        }

        // 4️⃣ Permission must exist
        if (!Permission::where('name', $routeName)->where('guard_name', 'web')->exists()) {
            abort(403, "Permission '{$routeName}' does not exist.");
        }

        // 5️⃣ Check permission for non-admin users
        if (!$user->can($routeName)) {
            throw UnauthorizedException::forPermissions([$routeName]);
        }

        return $next($request);
    }
}
