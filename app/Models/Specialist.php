<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Specialist extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'degree',
        'details',
        'photo',
        'slug',
        'position',
        'is_active',
    ];

    public function meetings()
    {
        return $this->hasMany(PatientMeeting::class,'specialist_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
