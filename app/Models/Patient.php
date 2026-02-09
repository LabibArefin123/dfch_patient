<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_code',
        'patient_name',
        'patient_f_name',
        'patient_m_name',
        'age',
        'gender',

        'location_type',
        'location_simple',
        'house_address',
        'city',
        'district',
        'post_code',
        'country',
        'passport_no',

        'phone_1',
        'phone_2',
        '   ',
        'phone_m_1',
        'patient_problem_description',
        'patient_drug_description',

        'is_recommend',
        'recommend_doctor_name',
        'recommend_note',

        'date_of_patient_added',
        'remarks',
    ];

    protected $casts = [
        'is_recommend' => 'boolean',
        'date_of_patient_added' => 'date',
    ];

    // Relationships (future-ready)
    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }
}
