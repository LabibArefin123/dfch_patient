<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserRole')) {
    function getUserRole()
    {
        return Auth::check() ? Auth::user()->role : null;
    }
}
