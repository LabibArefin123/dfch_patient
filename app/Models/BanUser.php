<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanUser extends Model
{
    protected $fillable = [
        'user_id',
        'is_banned',
        'banned_at',
        'ban_reason',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
