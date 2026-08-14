<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCancerPhoto extends Model
{
    protected $fillable = [
        'patient_id',
        'xray_photo',
        'total_cancer',
        'xray_description',
        'cancer_remarks',
        'cancer_hashes',
    ];

    protected $casts = [
        'xray_photo' => 'array',
        'cancer_hashes' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
