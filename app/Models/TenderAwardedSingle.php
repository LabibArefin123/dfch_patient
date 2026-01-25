<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderAwardedSingle extends Model
{
    protected $fillable = [
        'tender_awarded_id',
        'delivery_item',
        'delivery_date',
        'warranty',
    ];

    public function awardedTender()
    {
        return $this->belongsTo(TenderAwarded::class, 'tender_awarded_id');
    }
}
