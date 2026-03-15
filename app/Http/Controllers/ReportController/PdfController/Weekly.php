<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class Weekly extends Controller
{
    public function weekly_report_pdf($parent, Request $request)
    {
        if (!$parent->hasWeeklyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyWeeklyFilters($query, $request);

        return $parent->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.weekly_report_pdf',
            'weekly_patient_report.pdf',
            'backend.report_management.patient.weekly_report_pdfLarge',
        );
    }
}
