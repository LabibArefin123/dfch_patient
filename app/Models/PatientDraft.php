<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'draft_token',
        'form_data',
        'current_step',
        'last_saved_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'last_saved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
