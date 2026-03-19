<?php

namespace App\Http\Controllers\ReportController\ExcelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientReportExport;

class Daily extends Controller
{
    public function daily_report_excel($parent, Request $request)
    {
        if (!$parent->hasDailyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();

        // ✅ FIX: Add this (same as PDF)
        if ($request->filled('ids')) {
            $query->whereIn('id', $request->ids);
        }

        $parent->applyDailyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Daily Patient Report'
            ),
            'daily_patient_report.xlsx'
        );
    }
}
