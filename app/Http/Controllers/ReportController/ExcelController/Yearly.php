<?php

namespace App\Http\Controllers\ReportController\ExcelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientReportExport;

class Yearly extends Controller
{
    public function yearly_report_excel($parent, Request $request)
    {
        if (!$parent->hasYearlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyYearlyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Yearly Patient Report'
            ),
            'yearly_patient_report.xlsx'
        );
    }
}
