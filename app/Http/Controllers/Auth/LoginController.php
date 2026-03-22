<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

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

    public function login(LoginRequest $request, AuthService $authService)
    {
        $request->ensureIsNotRateLimited();

        $user = $authService->findUser($request->input('login'));

        if ($response = $authService->checkMaintenance($user)) {
            return $response;
        }

        if (!$user) {
            return $authService->failedLogin();
        }

        if ($response = $authService->checkUserBan($user)) {
            return $response;
        }

        if (!$authService->validatePassword($request->input('password'), $user)) {
            return $authService->failedLogin();
        }

        $authService->performLogin($request, $user);

        return redirect()->intended($this->redirectTo);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            activity('User')
                ->causedBy($user)
                ->log('User logged out');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
