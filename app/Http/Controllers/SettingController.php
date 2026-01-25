<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.setting_management.setting_menu.index');
    }

    public function show2FA()
    {
        $user = auth()->user();
        return view('backend.setting_management.setting_menu.security_setting.2fa', compact('user'));
    }

    // Toggle 2FA on/off
    public function toggle2FA()
    {
        $user = auth()->user();

        // Only allow disabling if 2FA is verified
        $twoFactorVerified = !$user->two_factor_code; // null means verified

        if ($user->two_factor_enabled && !$twoFactorVerified) {
            return back()->with('error', 'You must verify 2FA before disabling it.');
        }

        $user->two_factor_enabled = !$user->two_factor_enabled;

        if ($user->two_factor_enabled) {
            // Generate new code when enabling
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
        } else {
            // Reset fields when disabling
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
        }

        $user->save();

        return back()->with('success', 'Two-Factor Authentication updated successfully.');
    }

    // Verify 2FA code
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = auth()->user();

        if ($request->code != $user->two_factor_code) {
            return back()->with('error', 'Invalid 2FA code.');
        }

        // Mark verified by clearing code
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        return back()->with('success', '2FA verified successfully. You can now disable it if you want.');
    }

    // Resend 2FA code
    public function resend()
    {
        $user = auth()->user();

        if (!$user->two_factor_enabled) {
            return back()->with('error', '2FA is not enabled.');
        }

        $user->two_factor_code = rand(100000, 999999);
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        return back()->with('success', 'A new 2FA code has been sent.');
    }

    public function password_policy()
    {
        return view('backend.setting_management.setting_menu.security_setting.password_policy');
    }

    // Show timeout settings page
    public function showTimeout()
    {
        // Get current timeout from config or database; default 15 sec
        $timeout = config('session.lifetime') ?? 0.25;

        return view('backend.setting_management.setting_menu.security_setting.timeout', compact('timeout'));
    }

    // Update timeout
    // Update session timeout
    public function updateTimeout(Request $request)
    {
        $request->validate([
            'timeout' => 'required|numeric|min:0.25', // 15s minimum
        ]);

        $timeout = $request->timeout;

        // Save in DB for future reference (optional)
        $user = auth()->user();
        $user->session_timeout = $timeout; // add this column in users table if you want per-user timeout
        $user->save();

        // Update current session lifetime dynamically
        config(['session.lifetime' => $timeout * 60]); // session.lifetime is in MINUTES
        session()->put('session_lifetime', $timeout * 60); // store in session for JS tracking if needed

        return back()->with('success', 'Session timeout updated successfully.');
    }

    public function databaseBackup()
    {
        return view('backend.setting_management.setting_menu.backup_setting.database_backup');
    }

    public function downloadDatabase()
    {
        try {
            // DB Credentials
            $db   = env('DB_DATABASE', 'tot_pos');
            $user = env('DB_USERNAME', 'root');
            $pass = env('DB_PASSWORD', '');
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');

            // File name
            $fileName = $db . '_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            $backupPath = storage_path('app/' . $fileName);

            // Laragon mysqldump full path
            $mysqldump = 'E:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe';

            // Build safe command
            $command = "\"{$mysqldump}\" "
                . "--host=\"{$host}\" "
                . "--port=\"{$port}\" "
                . "--user=\"{$user}\" ";

            if (!empty($pass)) {
                $command .= "--password=\"{$pass}\" ";
            }

            $command .= "\"{$db}\" > \"{$backupPath}\"";

            // Execute command
            shell_exec($command);

            // Check file is created correctly
            if (!file_exists($backupPath) || filesize($backupPath) < 50) {
                return back()->with('error', '❌ Database backup failed. File is empty or not created.');
            }

            // Download SQL file
            return response()->download($backupPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function logs(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $allLines = file($logFile);
            $filtered = [];

            // Determine range
            $range = $request->range ?? 'today';
            $start = null;
            $end   = null;

            switch ($range) {
                case 'yesterday':
                    $start = Carbon::yesterday()->startOfDay();
                    $end   = Carbon::yesterday()->endOfDay();
                    break;
                case '7days':
                    $start = now()->subDays(7);
                    $end   = now();
                    break;
                case '1month':
                    $start = now()->subMonth();
                    $end   = now();
                    break;
                case '2months':
                    $start = now()->subMonths(2);
                    $end   = now();
                    break;
                case '3months':
                    $start = now()->subMonths(3);
                    $end   = now();
                    break;
                case '6months':
                    $start = now()->subMonths(6);
                    $end   = now();
                    break;
                case '1year':
                    $start = now()->subYear();
                    $end   = now();
                    break;
                case 'today':
                default:
                    $start = now()->startOfDay();
                    $end   = now()->endOfDay();
            }

            $lineBuffer = '';
            $lineDate   = null;
            $lineLevel  = null;
            $serial = 1;

            foreach ($allLines as $line) {
                preg_match('/\[(.*?)\]\s(\w+)\.([A-Z]+):\s(.*)/', $line, $match);

                if (isset($match[1])) {
                    // Save previous buffered line
                    if ($lineBuffer) {
                        $filtered[] = [
                            'serial' => $serial++,
                            'timestamp' => $lineDate,
                            'level' => $lineLevel,
                            'message' => $lineBuffer
                        ];
                    }

                    // New line
                    try {
                        $lineDate = Carbon::parse($match[1]);
                    } catch (\Exception $e) {
                        $lineDate = null;
                    }

                    $lineLevel  = $match[3] ?? 'INFO';
                    $lineBuffer = $match[4] ?? '';
                } else {
                    // Stacktrace or multiline continuation
                    $lineBuffer .= "\n" . trim($line);
                }

                // Add last line
            }

            if ($lineBuffer) {
                $filtered[] = [
                    'serial' => $serial++,
                    'timestamp' => $lineDate,
                    'level' => $lineLevel,
                    'message' => $lineBuffer
                ];
            }

            // Filter by date range
            $logs = array_filter($filtered, function ($log) use ($start, $end) {
                if (!$log['timestamp']) return true;
                return $log['timestamp']->between($start, $end);
            });

            // Sort newest first
            $logs = array_reverse($logs);
        }

        return view('backend.setting_management.setting_menu.log_setting.log', compact('logs', 'range'));
    }

    public function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        try {
            if (file_exists($logFile)) {
                file_put_contents($logFile, ''); // Clear the log file
            }

            return redirect()->route('settings.logs')
                ->with('success', 'Logs cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->route('settings.logs')
                ->with('error', 'Failed to clear logs: ' . $e->getMessage());
        }
    }

    public function maintenance()
    {
        $user = User::first(); // assuming one main record to store settings
        return view('backend.setting_management.setting_menu.backup_setting.maintenance', compact('user'));
    }

    // Update maintenance mode
    public function maintenanceUpdate(Request $request)
    {
        $request->validate([
            'maintenance_message' => 'nullable|string|max:255',
        ]);

        $user = User::first(); // single global maintenance record

        $user->is_maintenance = $request->has('is_maintenance'); // TRUE / FALSE
        $user->maintenance_message = $request->maintenance_message;

        $user->save();

        return back()->with('success', 'Maintenance mode updated successfully.');
    }


    public function language()
    {
        return view('backend.setting_management.setting_menu.language_setting.language');
    }

    public function updateLanguage(Request $request)
    {
        $request->validate([
            'app_language' => 'required|in:en,bn',
        ]);

        session(['app_locale' => $request->app_language]);

        return back()->with('success', 'Language updated successfully!');
    }

    public function dateTime()
    {
        return view('backend.setting_management.setting_menu.system_setting.date_time');
    }

    public function updateDateTime(Request $request)
    {
        // Save timezone
        config(['app.timezone' => $request->timezone]);
        date_default_timezone_set($request->timezone);

        // Save formats
        setting(['date_format' => $request->date_format])->save();
        setting(['time_format' => $request->time_format])->save();

        return back()->with('success', 'Date & Time settings updated successfully.');
    }

    public function theme()
    {
        return view('backend.setting_management.setting_menu.ui_setting.theme');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_mode' => 'required|in:light,dark',
        ]);

        // Store dark/light preference in session
        Session::put('theme_mode', $request->theme_mode);

        return back()->with('success', 'Theme updated successfully!');
    }
}
