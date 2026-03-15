<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannedDevice extends Model
{
    protected $fillable = [
        'ip_address',
        'device_name',
        'device_type',
        'user_agent',
        'user_id',
        'reason',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
