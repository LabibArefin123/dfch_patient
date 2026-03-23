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
        'multiple_images',
        'multiple_pdfs',
        'status_email',
        'remarks',
    ];

    protected $casts = [
        'multiple_images' => 'array',
        'multiple_pdfs' => 'array',
    ];
}
