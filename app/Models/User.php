<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'phone_2',
        'profile_picture',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
        'session_timeout',
        'is_maintenance',
        'is_banned',
        'maintenance_message',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /* =========================
       Two Factor Helpers
    ========================== */

    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(60);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /* =========================
       Profile Image Helpers
    ========================== */

    public function getProfilePictureUrl()
    {
        return $this->profile_picture
            ? asset('images/' . $this->profile_picture)
            : asset('uploads/images/default.jpg');
    }

    public function getProfileImageAttribute()
    {
        return $this->profile_picture
            ? Storage::url($this->profile_picture)
            : asset('uploads/images/default.jpg');
    }

    public function adminlte_image()
    {
        return $this->profile_picture
            ? Storage::url($this->profile_picture)
            : asset('uploads/images/default.jpg');
    }

    /* =========================
       Password Decryption
    ========================== */

    public function getDecryptedPasswordAttribute()
    {
        try {
            return Crypt::decryptString($this->password);
        } catch (\Exception $e) {
            return null;
        }
    }
}
