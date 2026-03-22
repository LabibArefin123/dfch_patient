<?php

namespace App\Services;

use App\Models\User;
use App\Models\BanUser;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class AuthService
{
    // ==============================
    // 🔐 LOGIN FLOW
    // ==============================

    public function findUser($loginInput)
    {
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return User::where($field, $loginInput)->first();
    }

    public function checkMaintenance($user)
    {
        $globalMaintenance = User::where('is_maintenance', 1)->first();

        if ($globalMaintenance && (!$user || !$user->hasRole('admin'))) {
            return back()->with('maintenance', $globalMaintenance->maintenance_message);
        }

        return null;
    }

    public function failedLogin()
    {
        return back()->withErrors([
            'login' => trans('auth.failed'),
        ]);
    }

    public function checkUserBan($user)
    {
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

        return null;
    }

    public function validatePassword($password, $user)
    {
        return Hash::check($password, $user->password);
    }

    public function performLogin($request, $user)
    {
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // ✅ LOG LOGIN
        activity('User')
            ->causedBy($user)
            ->log('User logged in');

        $this->handleAuthenticated($request, $user);
    }

    // ==============================
    // ✅ AFTER LOGIN (AUTHENTICATED)
    // ==============================

    public function handleAuthenticated($request, $user)
    {
        $this->checkDeviceBan($request, $user);
        $this->trackUserDevice($request, $user);
        $this->setLoginSuccessMessage($user);
    }

    private function checkDeviceBan($request, $user)
    {
        $banned = UserDevice::where('user_id', $user->id)
            ->where('ip_address', $request->ip())
            ->where('user_agent', $request->userAgent())
            ->where('is_banned', true)
            ->first();

        if ($banned) {
            Auth::logout();
            abort(403, 'Your device is banned. Contact admin.');
        }
    }

    private function trackUserDevice($request, $user)
    {
        $agent = new Agent();

        UserDevice::updateOrCreate(
            [
                'user_id'    => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
            [
                'device_name'   => $agent->device() ?: 'Desktop',
                'device_type'   => $agent->platform() . ' - ' . $agent->browser(),
                'last_login_at' => now(),
            ]
        );
    }

    private function setLoginSuccessMessage($user)
    {
        session()->flash('login_success', 'Welcome back, ' . $user->name . '!');
    }
}
