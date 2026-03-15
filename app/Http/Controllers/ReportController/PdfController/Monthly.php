<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Services\Reports\PdfService;

class Monthly extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function monthly_report_pdf($parent, Request $request)
    {
        if (!$parent->hasMonthlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyMonthlyFilters($query, $request);
        
        if ($request->filled('ids')) {
            $query->whereIn('id', $request->ids);
        }


        return $this->pdfService->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.monthly_report_pdf',
            'monthly_patient_report.pdf',
            'backend.report_management.patient.monthly_report_pdfLarge',
        );
    }
}
