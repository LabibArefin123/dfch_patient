<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedBidder extends Model
{
    use HasFactory;

    protected $fillable = [
        'participated_bidder_id',
        'company_name',
        'company_members',
        'reason',
        'tender_id',
    ];

    // Relation with Tender
    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
}
