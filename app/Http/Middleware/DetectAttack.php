<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SecurityLog;
use Stevebauman\Location\Facades\Location; // GeoIP package

class DetectAttack
{
    protected $whitelistIps = [
        '127.0.0.1',      // localhost
        'YOUR_PUBLIC_IP', // your dev machine
    ];

    public function handle(Request $request, Closure $next)
    {
        // Skip dev IPs
        if (in_array($request->ip(), $this->whitelistIps)) {
            return $next($request);
        }

        $input = json_encode($request->all()) . $request->getQueryString();

        $patterns = [
            'SQL_INJECTION'    => '/(union|select|insert|drop|--|;)/i',
            'XSS'              => '/(<script>|<\/script>|javascript:)/i',
            'PATH_TRAVERSAL'   => '/(\.\.\/|\.\.\\\)/',
            'COMMAND_INJECTION' => '/(exec|shell_exec|system\()/i',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $input)) {

                // Get country via GeoIP (if fails, set Unknown)
                $location = Location::get($request->ip());
                $country = $location->countryName ?? 'Unknown';

                // Log the attack
                SecurityLog::create([
                    'ip_address'  => $request->ip(),
                    'user_agent'  => $request->userAgent(),
                    'attack_type' => $type,
                    'payload'     => $input,
                    'url'         => $request->fullUrl(),
                    'user_id'     => auth()->id(),
                    'country'     => $country,
                ]);

                // Count previous attacks from this IP
                $attempts = SecurityLog::where('ip_address', $request->ip())
                    ->where('attack_type', $type)
                    ->count();

                if ($attempts >= 3) {
                    // Hard block on 3+ attempts
                    abort(403, 'Your IP has been blocked due to repeated suspicious activity.');
                } else {
                    // Soft warning for first 1–2 attempts
                    return response()->json([
                        'message' => '⚠️ Suspicious activity detected. This is warning #' . $attempts,
                        'warning_level' => $attempts,
                        'type' => $type,
                        'ip' => $request->ip(),
                    ], 200);
                }
            }
        }

        return $next($request);
    }
}
