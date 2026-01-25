<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   ParticipatedTender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'financial_year',
        'company_name',
        'deno',
        'qty',
        'offered_price',
        'security_price',
        'offer_validity',
        'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
