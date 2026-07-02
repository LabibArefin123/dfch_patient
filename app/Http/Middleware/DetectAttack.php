<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SecurityLog;
use Stevebauman\Location\Facades\Location;

class DetectAttack
{
    /**
     * Trusted IPs
     */
    protected array $whitelistIps = [
        '127.0.0.1',
        '::1',
        // 'YOUR_PUBLIC_IP',
    ];

    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | Skip Trusted IPs
        |--------------------------------------------------------------------------
        */
        if (in_array($request->ip(), $this->whitelistIps)) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Skip DataTables AJAX Requests
        |--------------------------------------------------------------------------
        */
        if (
            $request->ajax() &&
            $request->has('draw') &&
            $request->has('columns') &&
            $request->has('start') &&
            $request->has('length')
        ) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Remove framework/DataTables fields before scanning
        |--------------------------------------------------------------------------
        */
        $data = $request->except([
            '_token',
            '_method',
            'draw',
            'columns',
            'order',
            'search',
            'start',
            'length',
            '_',
        ]);

        $input = json_encode($data) . ' ' . $request->getQueryString();

        /*
        |--------------------------------------------------------------------------
        | Attack Detection Patterns
        |--------------------------------------------------------------------------
        */
        $patterns = [
            'SQL_INJECTION' => '/(\bunion\s+select\b|\bdrop\s+table\b|\binsert\s+into\b|\bdelete\s+from\b|\bupdate\s+\w+\s+set\b|\bor\s+1=1\b|--|#)/i',

            'XSS' => '/(<script\b[^>]*>|<\/script>|javascript:|onerror=|onload=)/i',

            'PATH_TRAVERSAL' => '/(\.\.\/|\.\.\\\\)/',

            'COMMAND_INJECTION' => '/(\b(exec|system|shell_exec|passthru|proc_open|popen)\s*\()/i',
        ];

        foreach ($patterns as $type => $pattern) {

            if (!preg_match($pattern, $input)) {
                continue;
            }

            $location = Location::get($request->ip());

            SecurityLog::create([
                'ip_address'  => $request->ip(),
                'user_agent'  => substr($request->userAgent() ?? '', 0, 500),
                'attack_type' => $type,
                'payload'     => substr($input, 0, 60000),
                'url'         => $request->url(),
                'user_id'     => auth()->id(),
                'country'     => $location->countryName ?? 'Unknown',
            ]);

            $attempts = SecurityLog::where('ip_address', $request->ip())
                ->where('attack_type', $type)
                ->count();

            if ($attempts >= 3) {
                abort(403, 'Your IP has been blocked due to repeated suspicious activity.');
            }

            return response()->json([
                'success' => false,
                'message' => "⚠️ Suspicious activity detected. Warning #{$attempts}",
                'warning_level' => $attempts,
                'attack_type' => $type,
            ], 200);
        }

        return $next($request);
    }
}
