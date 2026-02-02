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
    ];
}
