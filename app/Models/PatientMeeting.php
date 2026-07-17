<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMeeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'specialist_id',
        'title',
        'description',
        'meeting_date',
        'start_time',
        'end_time',
        'status',
        'meeting_type',
        'notes',
    ];


    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo( Patient::class);
    }


    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeScheduled(
        $query
    ) {

        return $query->where(
            'status',
            'scheduled'
        );
    }


    public function scopeToday(
        $query
    ) {

        return $query->whereDate(
            'meeting_date',
            today()
        );
    }


    public function scopeUpcoming(
        $query
    ) {

        return $query
            ->whereDate(
                'meeting_date',
                '>=',
                today()
            )
            ->whereNotIn(
                'status',
                [
                    'cancelled',
                    'completed',
                ]
            );
    }
}
