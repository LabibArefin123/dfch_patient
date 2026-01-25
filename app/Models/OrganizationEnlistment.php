<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationEnlistment extends Model
{
    protected $fillable = [
        'org_id',
        'customer_name',
        'validity',
        'security_deposit',
        'financial_year',
        'document',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
