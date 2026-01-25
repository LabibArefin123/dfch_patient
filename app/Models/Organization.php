<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name'
    ];

    public function enlistments()
    {
        return $this->hasMany(OrganizationEnlistment::class, 'org_id');
    }

    public function documents()
    {
        return $this->hasMany(OrganizationDocument::class, 'org_id');
    }
}
