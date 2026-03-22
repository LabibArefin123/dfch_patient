<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $user = Auth::user();
            $cacheKey = 'user-last-seen-' . $user->id;

            // ✅ Update only every 2 minutes (performance boost)
            if (!Cache::has($cacheKey)) {

                // ❌ no model events, no activity log
                $user->forceFill([
                    'last_seen' => now()
                ])->saveQuietly();

                // remember for 2 minutes
                Cache::put($cacheKey, true, now()->addMinutes(2));
            }
        }

        return $next($request);
    }
}
