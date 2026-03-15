<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BannedDevice;

class CheckBannedDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    

    public function handle($request, Closure $next)
    {
        $ip = $request->ip();

        $banned = BannedDevice::where('ip_address', $ip)
            ->where('is_active', true)
            ->first();

        if ($banned) {

            abort(403, 'Your device or IP has been blocked.');
        }

        return $next($request);
    }
}
