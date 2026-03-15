<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class Yearly extends Controller
{
    public function yearly_report_pdf($parent, Request $request)
    {
        if (!$parent->hasYearlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyYearlyFilters($query, $request);

        return $parent->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.yearly_report_pdf',
            'yearly_patient_report.pdf',
            'backend.report_management.patient.yearly_report_pdfLarge'
        );
    }
}
