<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigGuarantee extends Model
{
    protected $fillable = ['tender_participate_id', 'bg_no', 'issue_in_bank', 'issue_in_branch', 'issue_date', 'expiry_date', 'amount', 'attachment'];
}
