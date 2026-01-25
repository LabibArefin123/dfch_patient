<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderLetter extends Model
{
    protected $fillable = [
        'tender_id',
        'reference_no',
        'type',
        'remarks',
        'date',
        'document',
        'value',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }
}
