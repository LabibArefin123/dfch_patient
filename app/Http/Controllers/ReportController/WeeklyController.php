<?php

namespace App\Http\Controllers\ReportController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;
use App\Services\Reports\DataTableService;

class WeeklyController extends Controller
{
    protected $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }

    public function weekly_report($parent, Request $request)
    {
        if ($request->ajax()) {

            if (!$parent->hasWeeklyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $parent->applyWeeklyFilters($query, $request);

            return $this->dataTableService->response($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.weekly_report');
    }
}
