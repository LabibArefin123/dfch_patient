<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PatientReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as SPDF;
use Carbon\Carbon;

use App\Models\Patient;
use App\Models\Organization;

class ReportController extends Controller
{
    /* =========================================================
       ===================== DAILY REPORT ======================
       ========================================================= */

    public function daily_report(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->hasDailyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $this->applyDailyFilters($query, $request);

            return $this->dataTableResponse($query, 'created_at');
        }

        return view('backend.report_management.patient.daily_report');
    }

    public function daily_report_pdf(Request $request)
    {
        if (!$this->hasDailyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyDailyFilters($query, $request);

        return $this->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.daily_report_pdf',
            'daily_patient_report.pdf'
        );
    }

    public function daily_report_excel(Request $request)
    {
        if (!$this->hasDailyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyDailyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Daily Patient Report'
            ),
            'daily_patient_report.xlsx'
        );
    }

    /* =========================================================
   ===================== WEEKLY REPORT =====================
   ========================================================= */

    public function weekly_report(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->hasWeeklyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $this->applyWeeklyFilters($query, $request);

            return $this->dataTableResponse($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.weekly_report');
    }

    public function weekly_report_pdf(Request $request)
    {
        if (!$this->hasWeeklyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyWeeklyFilters($query, $request);

        return $this->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.weekly_report_pdf',
            'weekly_patient_report.pdf'
        );
    }

    public function weekly_report_excel(Request $request)
    {
        if (!$this->hasWeeklyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyWeeklyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Weekly Patient Report'
            ),
            'weekly_patient_report.xlsx'
        );
    }

    /* =========================================================
       ===================== MONTHLY REPORT ====================
       ========================================================= */

    public function monthly_report(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->hasMonthlyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $this->applyMonthlyFilters($query, $request);

            return $this->dataTableResponse($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.monthly_report');
    }

    public function monthly_report_pdf(Request $request)
    {
        if (!$this->hasMonthlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyMonthlyFilters($query, $request);

        return $this->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.monthly_report_pdf',
            'monthly_patient_report.pdf'
        );
    }

    public function monthly_report_excel(Request $request)
    {
        if (!$this->hasMonthlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyMonthlyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Monthly Patient Report'
            ),
            'monthly_patient_report.xlsx'
        );
    }

    /* =========================================================
       ===================== YEARLY REPORT =====================
       ========================================================= */

    public function yearly_report(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->hasYearlyFilters($request)) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();
            $this->applyYearlyFilters($query, $request);

            return $this->dataTableResponse($query, 'date_of_patient_added');
        }

        return view('backend.report_management.patient.yearly_report');
    }

    public function yearly_report_pdf(Request $request)
    {
        if (!$this->hasYearlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyYearlyFilters($query, $request);

        return $this->generatePdf(
            $query,
            $request,
            'backend.report_management.patient.yearly_report_pdf',
            'yearly_patient_report.pdf',
            'backend.report_management.patient.yearly_report_pdfLarge'
        );
    }

    public function yearly_report_excel(Request $request)
    {
        if (!$this->hasYearlyFilters($request)) {
            return back()->with('warning', 'Please apply at least one filter.');
        }

        $query = Patient::query();
        $this->applyYearlyFilters($query, $request);

        return Excel::download(
            new PatientReportExport(
                $query->get(),
                $request,
                'Yearly Patient Report'
            ),
            'yearly_patient_report.xlsx'
        );
    }

    /* =========================================================
       ===================== FILTER LOGIC ======================
       ========================================================= */

    private function hasDailyFilters(Request $request)
    {
        return $request->filled('gender')
            || $request->filled('is_recommend')
            || ($request->filled('location_type') && $request->filled('location_value'))
            || ($request->filled('from_date') && $request->filled('to_date'));
    }

    private function hasWeeklyFilters(Request $request)
    {
        return $request->filled('from_date') && $request->filled('to_date')
            || $request->filled('gender')
            || $request->filled('is_recommend');
    }

    private function hasMonthlyFilters(Request $request)
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


    private function applyDailyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        if ($request->filled('location_type') && $request->filled('location_value')) {
            $query->where(
                $request->location_type,
                'like',
                '%' . $request->location_value . '%'
            );
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        }
    }

    private function applyWeeklyFilters($query, Request $request)
    {
        $this->applyCommonFilters($query, $request);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date_of_patient_added', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        } else {
            // Default: current week (Monday → Sunday)
            $query->whereBetween('date_of_patient_added', [
                now()->startOfWeek()->format('Y-m-d 00:00:00'),
                now()->endOfWeek()->format('Y-m-d 23:59:59'),
            ]);
        }
    }

    private function applyMonthlyFilters($query, Request $request)
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


    /* =========================================================
       ===================== DATATABLE ==========================
       ========================================================= */

    private function dataTableResponse($query, $dateColumn)
    {
        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('location', function ($row) {
                if ($row->location_type == 1) {
                    return $row->location_simple;
                } elseif ($row->location_type == 2) {
                    return $row->house_address . ', ' .
                        $row->city . ', ' .
                        $row->district . ' - ' .
                        $row->post_code;
                }
                return $row->country . ' (Passport: ' . $row->passport_no . ')';
            })

            ->editColumn('is_recommend', fn($r) => $r->is_recommend ? 'Yes' : 'No')

            ->addColumn('date', function ($row) use ($dateColumn) {
                return \Carbon\Carbon::parse($row->$dateColumn)
                    ->format('d-m-Y') . ' (' .
                    \Carbon\Carbon::parse($row->$dateColumn)
                    ->format('d F Y') . ')';
            })

            ->addColumn(
                'action',
                fn($r) =>
                '<a href="' . route('patients.show', $r->id) . '" class="btn btn-sm btn-primary">View</a>'
            )

            ->rawColumns(['action'])
            ->make(true);
    }


    /* =========================================================
       ===================== PDF GENERATOR =====================
       ========================================================= */

    /* =========================================================
   ===================== PDF GENERATOR =====================
   ========================================================= */

    private function generatePdf(
        $query,
        Request $request,
        $smallView,
        $filename,
        $largeView = null // 👈 make optional
    ) {
        $query->orderBy('id');

        $perPage = 500;
        $page = $request->get('page', 1);
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        if ($totalRecords === 0) {
            return back()->with('warning', 'No data found.');
        }

        if ($totalRecords > $perPage && !$request->filled('confirm')) {
            return back()->with(array_merge(
                [
                    'confirm_pdf'  => true,
                    'totalRecords' => $totalRecords,
                    'perPage'      => $perPage,
                ],
                $request->all()
            ));
        }

        // If largeView not provided, use smallView for both
        $largeView = $largeView ?? $smallView;

        // SMALL PDF
        if ($totalRecords <= 500) {
            return $this->generateSmallPdf(
                $query,
                $smallView,
                $filename,
                $page,
                $perPage,
                $totalPages,
                $totalRecords
            );
        }

        // LARGE PDF
        return $this->generateLargePdf(
            $query,
            $largeView,
            $filename,
            $page,
            $perPage,
            $totalPages,
            $totalRecords
        );
    }

    private function generateSmallPdf(
        $query,
        $view,
        $filename,
        $page,
        $perPage,
        $totalPages,
        $totalRecords
    ) {
        $patients = $query->limit($perPage)->get();
        $organization = Organization::first();

        $pdf = Pdf::loadView(
            $view,
            compact('patients', 'organization', 'page', 'perPage', 'totalPages', 'totalRecords')
        )->setPaper('a4', 'landscape');

        return $pdf->stream($filename);
    }

    private function generateLargePdf(
        $query,
        $view,
        $filename,
        $page,
        $perPage,
        $totalPages,
        $totalRecords
    ) {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        $patients = $query->get();
        $organization = Organization::first();

        $pdf = SPDF::loadView(
            $view,
            compact('patients', 'organization', 'page', 'perPage', 'totalPages', 'totalRecords')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('enable-local-file-access', true);

        return $pdf->stream($filename);
    }
}
