<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Organization extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'organization_logo_name',
        'organization_picture',
        'organization_location',
        'organization_slogan',
        'phone_1',
        'phone_2',
        'land_phone_1',
        'land_phone_2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Organization')
            ->setDescriptionForEvent(fn(string $eventName) => "Organization {$eventName}");
    }
}
