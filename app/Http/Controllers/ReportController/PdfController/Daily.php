<?php

namespace App\Http\Controllers\ReportController\PdfController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Services\Reports\PdfService;

class Daily extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function daily_report_pdf($parent, Request $request)
    {
        if (!$parent->hasDailyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }
     
        $query = Patient::query();

        if ($request->filled('ids')) {
            $query->whereIn('id', $request->ids);
        }

        $parent->applyDailyFilters($query, $request);

        return $this->pdfService->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.daily_report_pdf',
            'daily_patient_report.pdf',
            'backend.report_management.patient.daily_report_pdfLarge'
        );
    }
}
