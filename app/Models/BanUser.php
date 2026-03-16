<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BanUser extends Model
{
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Banned User')
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}");
    }
}
