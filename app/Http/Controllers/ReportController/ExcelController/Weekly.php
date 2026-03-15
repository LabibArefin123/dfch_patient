<?php

namespace App\Http\Controllers\ReportController\ExcelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientReportExport;

class Weekly extends Controller
{
    public function weekly_report_excel($parent, Request $request)
    {
        if (!$parent->hasWeeklyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $parent->applyWeeklyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Weekly Patient Report'
            ),
            'weekly_patient_report.xlsx'
        );
    }
}
