<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
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
}
