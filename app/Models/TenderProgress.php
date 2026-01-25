<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderProgress extends Model
{
    protected $fillable = [
        'tender_awarded_id',
        'is_delivered',
        'challan_no',
        'challan_date',
        'challan_doc',
        'is_inspection_completed',
        'inspection_complete_date',
        'is_inspection_accepted',
        'inspection_accept_date',
        'warranty_expiry_date',
        'is_bill_submitted',
        'bill_no',
        'bill_submit_date',
        'bill_doc',
        'is_bill_received',
        'bill_cheque_no',
        'bill_receive_date',
        'bill_amount',
        'bill_bank_name',
        'status',

    ];

    public function tenderAwarded()
    {
        return $this->belongsTo(TenderAwarded::class, 'tender_awarded_id');
    }
}
