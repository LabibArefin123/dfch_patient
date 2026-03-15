<?php

namespace App\Http\Controllers\ReportController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;

class WeeklyController extends Controller
{
    public function weekly_report($parent, Request $request)
    {
        if ($request->ajax()) {

            if (!$parent->hasWeeklyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $parent->applyWeeklyFilters($query, $request);

            return $parent->dataTableResponse($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.weekly_report');
    }
}
