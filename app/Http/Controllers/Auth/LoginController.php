<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\SystemProblem;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\BanUser;
use Jenssegers\Agent\Agent;
use App\Models\UserDevice;


class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show login page
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login (Crypt-based)
     */

    public function login(LoginRequest $request)
    {
        $request->ensureIsNotRateLimited();

        $loginInput = $request->input('login');
        $password   = $request->input('password');

        // Determine if login is email or username
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $loginInput)->first();

        // -----------------------------
        // 1. Maintenance Mode Check
        // -----------------------------
        $globalMaintenance = User::where('is_maintenance', 1)->first();

        if ($globalMaintenance && (!$user || !$user->hasRole('admin'))) {
            return back()->with('maintenance', $globalMaintenance->maintenance_message);
        }

        // -----------------------------
        // 2. User Exists Check
        // -----------------------------
        if (!$user) {
            return back()->withErrors([
                'login' => trans('auth.failed'),
            ]);
        }

        // -----------------------------
        // 3. BANNED USER CHECK ✅
        // -----------------------------
        if ($user->is_banned) {
            $ban = BanUser::where('user_id', $user->id)
                ->where('is_banned', true)
                ->latest('banned_at')
                ->first();

            return back()->with(
                'banned',
                $ban?->ban_reason ?? 'Your account has been banned. Please contact support.'
            );
        }

        // -----------------------------
        // 4. Password check using Hash
        // -----------------------------
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'login' => trans('auth.failed'),
            ]);
        }

        // -----------------------------
        // 5. Manual login
        // -----------------------------
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Call authenticated hook
        $this->authenticated($request, $user);

        return redirect()->intended($this->redirectTo);
    }


    /**
     * Handle actions after successful login
     */
    protected function authenticated(Request $request, $user)
    {
        $agent = new Agent();

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // 🔴 BLOCK banned device
        $banned = UserDevice::where('user_id', $user->id)
            ->where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->where('is_banned', true)
            ->first();

        if ($banned) {
            auth()->logout();
            abort(403, 'Your device is banned. Contact admin.');
        }

        // ✅ Track / Update device
        UserDevice::updateOrCreate(
            [
                'user_id'    => $user->id,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ],
            [
                'device_name'   => $agent->device() ?: 'Desktop',
                'device_type'   => $agent->platform() . ' - ' . $agent->browser(),
                'last_login_at' => now(),
            ]
        );

        // ✅ Success message
        session()->flash('login_success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
