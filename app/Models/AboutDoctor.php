<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutDoctor extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'degree',
        'designation',
        'about',
        'image',
        'youtube',
        'status'
    ];
}
