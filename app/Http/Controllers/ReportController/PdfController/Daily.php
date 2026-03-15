<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class Daily extends Controller
{
    public function daily_report_pdf($parent, Request $request)
    {
        if (!$parent->hasDailyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyDailyFilters($query, $request);

        return $parent->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.daily_report_pdf',
            'daily_patient_report.pdf',
            'backend.report_management.patient.daily_report_pdfLarge',
        );
    }
}
