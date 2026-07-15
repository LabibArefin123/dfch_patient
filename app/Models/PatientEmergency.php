<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEmergency extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'is_emergency',
        'reason',
        'emergency_date',
    ];

    protected $casts = [
        'is_emergency' => 'boolean',
        'emergency_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
