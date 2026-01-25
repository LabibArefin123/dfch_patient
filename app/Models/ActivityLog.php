<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Specify the table name (optional if the table name follows conventions)
    protected $table = 'activity_logs';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'action',
        'entity',
        'details',
    ];

    // Cast the 'details' field to an array for easier access
    protected $casts = [
        'details' => 'array',
    ];

    // Define the relationship to the User model (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
