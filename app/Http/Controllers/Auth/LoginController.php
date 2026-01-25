<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\BanUser;

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

        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $user = User::where($field, $loginInput)->first();
        
        // -----------------------------
        // 1. Maintenance Mode Check
        // -----------------------------
        $globalMaintenance = User::where('is_maintenance', 1)->first();

        if ($globalMaintenance) {
            if (!$user || !$user->hasRole('admin')) {
                return back()->with('maintenance', $globalMaintenance->maintenance_message);
            }
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
        // 4. Crypt password check
        // -----------------------------
        try {
            $decryptedPassword = Crypt::decryptString($user->password);
        } catch (\Exception $e) {
            return back()->withErrors([
                'password' => 'Invalid password format.',
            ]);
        }

        if ($password !== $decryptedPassword) {
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
        // SweetAlert / toast message
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
