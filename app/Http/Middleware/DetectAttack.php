<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SecurityLog;

class DetectAttack
{
    // Add your dev IP(s) here
    protected $whitelistIps = [
        '127.0.0.1',        // localhost
        'YOUR_PUBLIC_IP',   // your dev machine
    ];

    public function handle(Request $request, Closure $next)
    {
        // Skip middleware for whitelisted IPs (you)
        if (in_array($request->ip(), $this->whitelistIps)) {
            return $next($request);
        }

        $input = json_encode($request->all()) . $request->getQueryString();

        $patterns = [
            'SQL_INJECTION' => '/(union|select|insert|drop|--|;)/i',
            'XSS' => '/(<script>|<\/script>|javascript:)/i',
            'PATH_TRAVERSAL' => '/(\.\.\/|\.\.\\\)/',
            'COMMAND_INJECTION' => '/(exec|shell_exec|system\()/i',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $input)) {

                // Log the attack
                SecurityLog::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'attack_type' => $type,
                    'payload' => $input,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_id' => auth()->id(),
                ]);

                // Optional: count previous attacks from this IP
                $attempts = SecurityLog::where('ip_address', $request->ip())
                    ->where('attack_type', $type)
                    ->count();

                if ($attempts >= 3) { // 🔥 auto-block after 3 attempts
                    abort(403, 'Your IP has been blocked due to suspicious activity.');
                } else {
                    // just log first 2 attempts without blocking
                    // you can also return a soft warning message instead of abort
                }
            }
        }

        return $next($request);
    }
}
