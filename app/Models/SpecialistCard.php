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

        'logo_position',
        'photo_position',

        'show_logo',
        'show_degree',
        'show_designation',
        'show_details',
        'show_qr',

        'primary_color',
        'secondary_color',
        'accent_color',

        'position',

        'is_active',

    ];

    protected $casts = [

        'show_logo' => 'boolean',
        'show_degree' => 'boolean',
        'show_designation' => 'boolean',
        'show_details' => 'boolean',
        'show_qr' => 'boolean',
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
