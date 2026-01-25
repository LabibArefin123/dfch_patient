<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenderCompleted extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_progress_id',
        'publication_date',
        'submission_date',
        'workorder_no',
        'workorder_date',
        'awarded_date',
        'delivery_type',
        'is_warranty_complete',
        'warranty_complete_date',
        'is_service_warranty',
        'service_warranty_duration',
    ];

    public function tenderProgress()
    {
        return $this->belongsTo(TenderProgress::class, 'tender_progress_id');
    }

    public function singleDelivery()
    {
        return $this->hasOne(TenderAwardedSingle::class, 'tender_awarded_id');
    }

    public function partialDeliveries()
    {
        return $this->hasMany(TenderAwardedMultiple::class, 'tender_awarded_id');
    }
}
