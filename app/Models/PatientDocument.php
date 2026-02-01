<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDocument extends Model
{
    use HasFactory;

    protected $table = 'patient_documents';

    protected $fillable = [
        'patient_id',
        'document_name',
        'file_path',
        'document_type',
    ];

    /**
     * Relationship: Document belongs to a Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
