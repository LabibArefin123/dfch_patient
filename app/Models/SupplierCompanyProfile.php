<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierCompanyProfile extends Model
{
    protected $fillable = [
        // 'supplier_name',
        'procuring_authority',
        'end_user',
    ];
}
