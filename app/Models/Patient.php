<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use HasFactory, LogsActivity;

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
        'phone_f_1',
        'phone_m_1',
        'patient_problem_description',
        'patient_drug_description',
        
        'is_recommend',
        'is_emergency',
        'recommend_doctor_name',
        'recommend_note',
        
        'date_of_patient_added',
        'remarks',
        'is_old_cancer',
        'patient_photo',
        'photo_hash',

        // Treatment
        'is_treatment',
        'treatment_information',
        'treatment_images',
        'treatment_type',

        // Investigation
        'is_investigated',
        'investigation_information',
        'investigation_images',
    ];

    protected $casts = [

        'is_recommend' => 'boolean',
        'is_old_cancer' => 'boolean',
        'is_emergency' => 'boolean',

        'is_treatment' => 'boolean',
        'is_investigated' => 'boolean',

        'date_of_patient_added' => 'date',

        'treatment_information' => 'array',
        'treatment_images' => 'array',
        'treatment_type' => 'array',

        'investigation_information' => 'array',
        'investigation_images' => 'array',
    ];

    public function getFullLocationAttribute()
    {
        if ($this->location_type == 1) {

            return $this->location_simple;
        }

        if ($this->location_type == 2) {

            return collect([

                $this->house_address,
                $this->city,
                $this->district,
                $this->post_code,

            ])
                ->filter()
                ->implode(', ');
        }

        if ($this->location_type == 3) {

            return collect([

                $this->country,

                $this->passport_no
                    ? 'Passport: ' .
                    $this->passport_no
                    : null,

            ])
                ->filter()
                ->implode(', ');
        }

        return 'N/A';
    }

    // Relationships (future-ready)
    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }

    public function meetings()
    {
        return $this->hasMany(
            PatientMeeting::class,
            'patient_id'
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('patient')
            ->setDescriptionForEvent(fn(string $eventName) => "Patient {$eventName}");
    }

    public function cancerPhotos()
    {
        return $this->hasMany(PatientCancerPhoto::class);
    }

    public function emergencies()
    {
        return $this->hasMany(PatientEmergency::class);
    }

    public function latestEmergency()
    {
        return $this->hasOne(PatientEmergency::class)
            ->latestOfMany();
    }
}
