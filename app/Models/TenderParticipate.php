<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderParticipate extends Model
{
    protected $table = 'tender_participates';

    protected $fillable = ['tender_id', 'offer_no', 'offered_price', 'offer_date', 'offer_validity', 'offer_doc'];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany(TenderParticipateCompany::class, 'tender_participate_id', 'id');
    }

    public function bg()
    {
        return $this->hasOne(BigGuarantee::class, 'tender_participate_id', 'id');
    }
}
