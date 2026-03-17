<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'device_name',
        'device_type',
        'user_agent',
        'last_login_at',
        'is_banned'
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'is_banned'     => 'boolean',
    ];

    /**
     * The user that owns this device
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
