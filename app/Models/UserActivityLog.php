<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action', 'details', 'ip_address', 'wifi_name', 'device'
    ];

    /**
     * Get the user associated with the activity log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter logs by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }

        return $query;
    }

    /**
     * Scope to filter logs by a specific action.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $action
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAction($query, $action = null)
    {
        if ($action) {
            return $query->where('action', 'like', "%$action%");
        }

        return $query;
    }
}
