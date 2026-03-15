<?php

namespace App\Http\Controllers\ReportController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;

class MonthlyController extends Controller
{
    public function monthly_report($parent, Request $request)
    {
        if ($request->ajax()) {

            if (!$parent->hasMonthlyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $parent->applyMonthlyFilters($query, $request);

            return $parent->dataTableResponse($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.monthly_report');
    }

}
