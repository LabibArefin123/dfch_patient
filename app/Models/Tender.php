<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_no',
        'title',
        'publication_date',
        'submission_date',
        'submission_time',
        'procuring_authority',
        'end_user',
        'financial_year',
        'items',
        'tender_type',
        'spec_file',
        'notice_file',
        'archived',
        'is_participate',
        'is_bg',
        'is_awarded',
        'is_completed',
        'status'
    ];

    protected $casts = [
        'archived' => 'boolean',
        'items' => 'array', // cast JSON to array
    ];

    // Relation
    public function tenderParticipates()
    {
        return $this->belongsTo(TenderParticipates::class, 'tender_id', 'id');
    }

    public function bg()
    {
        return $this->hasOne(BigGuarantee::class);
    }

    // Scope for Archived Tenders
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('is_participate', 1)
                ->orWhere(function ($q2) {
                    $q2->where('is_participate', 0)
                        ->whereRaw("TIMESTAMP(submission_date, submission_time) >= ?", [now()->subHours(72)]);
                });
        });
    }

    public function scopeArchived($query)
    {
        return $query->where('is_participate', 0)
            ->whereRaw("TIMESTAMP(submission_date, submission_time) < ?", [now()->subHours(72)]);
    }

    public function getIsArchivedAttribute()
    {
        if (!$this->submission_date || !$this->submission_time) {
            return false;
        }

        if ($this->is_participate == 1) {
            return false; // User participated, don't archive
        }

        $submissionDateTime = \Carbon\Carbon::parse($this->submission_date . ' ' . $this->submission_time);
        return now()->greaterThan($submissionDateTime->addHours(72));
    }
}
