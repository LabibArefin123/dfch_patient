<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'attack_type',
        'payload',
        'url',
        'method',
        'user_id',
    ];

    // Optional: relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
