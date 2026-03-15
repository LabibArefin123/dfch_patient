<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class Monthly extends Controller
{
    public function monthly_report_pdf($parent, Request $request)
    {
        if (!$parent->hasMonthlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyMonthlyFilters($query, $request);

        return $parent->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.monthly_report_pdf',
            'monthly_patient_report.pdf',
            'backend.report_management.patient.monthly_report_pdfLarge',
        );
    }
}
