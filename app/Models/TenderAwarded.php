<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderAwarded extends Model
{
    protected $fillable = [
        'tender_participate_id',
        'offer_no',
        'offer_date',
        'publication_date',
        'submission_date',
        'workorder_no',
        'workorder_date',
        'workorder_doc',
        'awarded_date',
        'delivery_type',
    ];

    public function tenderProgresses()
    {
        return $this->hasMany(TenderProgress::class, 'tender_awarded_id');
    }

    public function tenderParticipate()
    {
        return $this->belongsTo(TenderParticipate::class, 'tender_participate_id');
    }

    public function singleDelivery()
    {
        return $this->hasOne(TenderAwardedSingle::class, 'tender_awarded_id');
    }

    public function partialDeliveries()
    {
        return $this->hasMany(TenderAwardedMultiple::class, 'tender_awarded_id');
    }

    public function pg()
    {
        return $this->hasOne(PerformanceGuarantee::class, 'tender_awarded_id', 'id');
    }
}
