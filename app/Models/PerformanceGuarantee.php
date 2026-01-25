<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceGuarantee extends Model
{
    protected $fillable = ['tender_awarded_id', 'pg_no', 'issue_in_bank', 'issue_in_branch', 'issue_date', 'expiry_date', 'amount', 'attachment'];

}
