<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderParticipateCompany extends Model
{
    protected $fillable = ['tender_participate_id', 'company_name', 'offered_price'];

    public function tenderParticipate()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
}
