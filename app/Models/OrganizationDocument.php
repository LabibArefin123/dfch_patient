<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationDocument extends Model
{
    protected $fillable = [
        'org_id',
        'type',
        'number',
        'validity',
        'financial_year',
        'document',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
