<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemProblem extends Model
{
    protected $fillable = [
        'problem_uid',
        'problem_title',
        'problem_description',
        'status',
        'problem_file',
    ];
}
