<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PatientReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as SPDF;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Organization;
use App\Services\Reports\DataTableService;
use App\Services\Reports\PdfService;

//Start of Daily Part
use App\Http\Controllers\ReportController\DailyController;
use App\Http\Controllers\ReportController\ExcelController\Daily as DailyExcel;
use App\Http\Controllers\ReportController\PdfController\Daily as DailyPdf;
//End of Daily Part

//Start of Weekly Part
use App\Http\Controllers\ReportController\WeeklyController;
use App\Http\Controllers\ReportController\ExcelController\Weekly as WeeklyExcel;
use App\Http\Controllers\ReportController\PdfController\Weekly as WeeklyPdf;
//End of Weekly Part

//Start of Month Part
use App\Http\Controllers\ReportController\MonthlyController;
use App\Http\Controllers\ReportController\ExcelController\Monthly as MonthlyExcel;
use App\Http\Controllers\ReportController\PdfController\Monthly as MonthlyPdf;
//End of Month Part

class ReportController extends Controller
{
    /* =========================================================
       ===================== DAILY REPORT ======================
       ========================================================= */

    public function daily_report(Request $request)
    {
        return (new DailyController)->daily_report($this, $request);
    }

    public function daily_report_pdf(Request $request)
    {
        return (new DailyPdf)->daily_report_pdf($this, $request);
    }

    public function daily_report_excel(Request $request)
    {
        return (new DailyExcel)->daily_report_excel($this, $request);
    }
    /* =========================================================
   ===================== WEEKLY REPORT =====================
   ========================================================= */
    public function weekly_report(Request $request)
    {
        return (new WeeklyController)->weekly_report($this, $request);
    }

    public function weekly_report_pdf(Request $request)
    {
        return (new WeeklyPdf)->weekly_report_pdf($this, $request);
    }

    public function weekly_report_excel(Request $request)
    {
        return (new WeeklyExcel)->weekly_report_excel($this, $request);
    }

    /* =========================================================
       ===================== MONTHLY REPORT ====================
       ========================================================= */
    public function monthly_report(Request $request)
    {
        return (new MonthlyController)->monthly_report($this, $request);
    }

    public function monthly_report_pdf(Request $request)
    {
        return (new MonthlyPdf)->monthly_report_pdf($this, $request);
    }

    public function monthly_report_excel(Request $request)
    {
        return (new MonthlyExcel)->monthly_report_excel($this, $request);
    }

    /* =========================================================
       ===================== YEARLY REPORT =====================
       ========================================================= */

    /* Start of Filter Logic  */
    public function hasDailyFilters(Request $request)
    {
        return $request->has('day_filter')
            || $request->filled('gender')
            || $request->filled('is_recommend')
            || ($request->filled('location_type') && $request->filled('location_value'))
            || ($request->filled('from_date') && $request->filled('to_date'));
    }

    public function hasWeeklyFilters(Request $request)
    {
        return $request->filled('from_date') && $request->filled('to_date')
            || $request->filled('gender')
            || $request->filled('is_recommend');
    }

    public function hasMonthlyFilters(Request $request)
    {
        return $request->filled('year')
            || $request->filled('month')
            || $request->filled('gender')
            || $request->filled('is_recommend');
    }

    private function hasYearlyFilters(Request $request)
    {
        return $request->filled('year')
            || $request->filled('gender')
            || $request->filled('is_recommend');
    }


    public function applyDailyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        if ($request->filled('location_type') && $request->filled('location_value')) {
            $query->where(
                $request->location_type,
                'like',
                '%' . $request->location_value . '%'
            );
        }

        $dayFilter = $request->day_filter ?? 'today';

        switch ($dayFilter) {

            case 'past_1_day':
                $start = Carbon::now()->subDay()->startOfDay();
                $end   = Carbon::now()->subDay()->endOfDay();
                break;

            case 'past_2_days':
                $start = Carbon::now()->subDays(2)->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;

            case 'past_3_days':
                $start = Carbon::now()->subDays(3)->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $start = Carbon::parse($request->from_date)->startOfDay();
                    $end   = Carbon::parse($request->to_date)->endOfDay();
                } else {
                    $start = Carbon::now()->startOfDay();
                    $end   = Carbon::now()->endOfDay();
                }
                break;

            case 'today':
            default:
                $start = Carbon::now()->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;
        }

        $query->whereBetween('date_of_patient_added', [$start, $end]);
    }

    public function applyWeeklyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        $weekFilter = $request->week_filter ?? 'current_week';

        switch ($weekFilter) {

            case 'current_week':
                // Last 7 days including today
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;

            case 'past_week':
                // 8–14 days ago
                $start = Carbon::now()->subDays(14)->startOfDay();
                $end   = Carbon::now()->subDays(7)->endOfDay();
                break;

            case 'past_2_weeks':
                // 15–21 days ago
                $start = Carbon::now()->subDays(21)->startOfDay();
                $end   = Carbon::now()->subDays(14)->endOfDay();
                break;

            case 'past_3_weeks':
                // 22–28 days ago
                $start = Carbon::now()->subDays(28)->startOfDay();
                $end   = Carbon::now()->subDays(21)->endOfDay();
                break;

            case 'past_4_weeks':
                // 29–35 days ago
                $start = Carbon::now()->subDays(35)->startOfDay();
                $end   = Carbon::now()->subDays(28)->endOfDay();
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $start = Carbon::parse($request->from_date)->startOfDay();
                    $end   = Carbon::parse($request->to_date)->endOfDay();
                } else {
                    $start = Carbon::now()->subDays(7)->startOfDay();
                    $end   = Carbon::now()->endOfDay();
                }
                break;

            default:
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;
        }

        $query->whereBetween('date_of_patient_added', [$start, $end]);
    }

    public function applyMonthlyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date_of_patient_added', $request->month);
        }
    }

    private function applyYearlyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }
    }

    private function applyCommonFilters($query, Request $request)
    {
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }
    }
    /* End of Filter Logic  */
    
    protected $dataTableService;
    protected $pdfService;

    public function __construct(
        DataTableService $dataTableService,
        PdfService $pdfService
    ) {
        $this->dataTableService = $dataTableService;
        $this->pdfService = $pdfService;
    }

    
}
