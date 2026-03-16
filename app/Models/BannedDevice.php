<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BannedDevice extends Model
{
    use LogsActivity; 

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Banned Device')
            ->setDescriptionForEvent(fn(string $eventName) => "Device {$eventName}");
    }
}
