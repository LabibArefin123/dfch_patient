<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpecialistCard extends Model
{
    protected $fillable = [
        'specialist_id',
        'name',
        'slug',
        'card_type',
        'card_theme',
        'background_image',
        'show_logo',
        'show_degree',
        'show_designation',
        'show_details',
        'position',
        'is_active',
    ];

    protected $casts = [
        'show_logo' => 'boolean',
        'show_degree' => 'boolean',
        'show_designation' => 'boolean',
        'show_details' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }
}
