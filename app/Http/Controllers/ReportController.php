<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Patient;
use App\Models\Organization;

class ReportController extends Controller
{
    /* =======================
       DAILY REPORT 
       ======================= */

    public function daily_report(Request $request)
    {
        if ($request->ajax()) {

            // ❌ DO NOT load data without filters
            if (
                !$request->filled('gender') &&
                !$request->filled('is_recommend') &&
                !(
                    $request->filled('location_type') &&
                    $request->filled('location_value')
                ) &&
                !(
                    $request->filled('from_date') &&
                    $request->filled('to_date')
                )
            ) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();

            // Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            // Recommended
            if ($request->filled('is_recommend')) {
                $query->where('is_recommend', $request->is_recommend);
            }

            // Location filter
            if ($request->filled('location_type') && $request->filled('location_value')) {
                $query->where(
                    $request->location_type,
                    'like',
                    '%' . $request->location_value . '%'
                );
            }

            // Date range
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            }

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

                ->addColumn('date', fn($r) => $r->created_at->format('Y-m-d'))

                ->addColumn(
                    'action',
                    fn($r) =>
                    '<a href="' . route('patients.show', $r->id) . '" class="btn btn-sm btn-primary">View</a>'
                )

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.report_management.patient.daily_report');
    }


    /* =======================
       DAILY REPORT PDF
       ======================= */
    public function daily_report_pdf(Request $request)
    {
        // ❌ BLOCK PDF WITHOUT FILTER
        if (
            !$request->filled('gender') &&
            !$request->filled('is_recommend') &&
            !$request->filled('location_type') &&
            !$request->filled('from_date')
        ) {
            return redirect()->back()
                ->with('warning', 'Please apply at least one filter before downloading the report.');
        }

        $query = Patient::query();

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }

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

        $query->orderBy('id');

        $perPage = 300;
        $page = $request->get('page', 1);
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        if ($totalRecords === 0) {
            return redirect()->back()
                ->with('warning', 'No data found for the selected filters.');
        }

        // ❌ Show modal if > 300 and not confirmed
        if ($totalRecords > $perPage && !$request->filled('confirm')) {
            return redirect()->back()->with([
                'confirm_pdf'   => true,
                'totalRecords'  => $totalRecords,
                'perPage'       => $perPage,
                'gender'        => $request->gender ?? '',
                'is_recommend'  => $request->is_recommend ?? '',
                'location_type' => $request->location_type ?? '',
                'location_value' => $request->location_value ?? '',
                'from_date'     => $request->from_date ?? '',
                'to_date'       => $request->to_date ?? '',
            ]);
        }

        // ✅ Generate PDF
        $patients = $query->limit($perPage)->get();
        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.daily_report_pdf',
            compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('daily_patient_report.pdf');
    }


    /* =======================
       MONTHLY REPORT 
       ======================= */

    public function monthly_report(Request $request)
    {
        if ($request->ajax()) {

            // ❌ DO NOT load data without filters
            if (
                !$request->filled('year') &&
                !$request->filled('month') &&
                !$request->filled('gender') &&
                !$request->filled('is_recommend')
            ) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();

            // YEAR FILTER
            if ($request->filled('year')) {
                $query->whereYear('date_of_patient_added', $request->year);
            }

            // MONTH FILTER
            if ($request->filled('month')) {
                $query->whereMonth('date_of_patient_added', $request->month);
            }

            // Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            // Recommended
            if ($request->filled('is_recommend')) {
                $query->where('is_recommend', $request->is_recommend);
            }

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

                ->editColumn('is_recommend', function ($row) {
                    return $row->is_recommend ? 'Yes' : 'No';
                })

                ->addColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date_of_patient_added)->format('d-m-Y')
                        . ' (' .
                        \Carbon\Carbon::parse($row->date_of_patient_added)->format('d F Y')
                        . ')';
                })

                ->addColumn('action', function ($row) {
                    return '<a href="' . route('patients.show', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.report_management.patient.monthly_report');
    }

    public function monthly_report_pdf(Request $request)
    {
        // ❌ BLOCK PDF WITHOUT FILTER
        if (
            !$request->filled('year') &&
            !$request->filled('month') &&
            !$request->filled('gender') &&
            !$request->filled('is_recommend')
        ) {
            return redirect()->back()
                ->with('warning', 'Please apply at least one filter before downloading the report.');
        }

        $query = Patient::query();

        // Filters
        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date_of_patient_added', $request->month);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }

        $query->orderBy('id');

        $perPage = 300;
        $page = $request->get('page', 1);
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        if ($totalRecords === 0) {
            return redirect()->back()
                ->with('warning', 'No data found for the selected filters.');
        }

        // ❌ Show modal if > 300 and not confirmed
        if ($totalRecords > $perPage && !$request->filled('confirm')) {
            return redirect()->back()->with([
                'confirm_pdf'   => true,
                'totalRecords'  => $totalRecords,
                'perPage'       => $perPage,
                'year'          => $request->year ?? '',
                'month'         => $request->month ?? '',
                'gender'        => $request->gender ?? '',
                'is_recommend'  => $request->is_recommend ?? '',
            ]);
        }

        // ✅ Generate PDF
        $patients = $query->limit($perPage)->get();
        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.monthly_report_pdf',
            compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('monthly_patient_report.pdf');
    }



    /* =======================
       YEARLY REPORT 
       ======================= */

    public function yearly_report(Request $request)
    {
        if ($request->ajax()) {

            // ❌ DO NOT load data without filters
            if (
                !$request->filled('year') &&
                !$request->filled('gender') &&
                !$request->filled('is_recommend')
            ) {
                return DataTables::of(collect())->make(true);
            }

            $query = Patient::query();

            // Year filter
            if ($request->filled('year')) {
                $query->whereYear('date_of_patient_added', $request->year);
            }

            // Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            // Recommended
            if ($request->filled('is_recommend')) {
                $query->where('is_recommend', $request->is_recommend);
            }

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

                ->addColumn(
                    'date',
                    fn($r) =>
                    \Carbon\Carbon::parse($r->date_of_patient_added)->format('d-m-Y') .
                        ' (' .
                        \Carbon\Carbon::parse($r->date_of_patient_added)->format('d F Y') .
                        ')'
                )

                ->addColumn(
                    'action',
                    fn($r) =>
                    '<a href="' . route('patients.show', $r->id) . '" class="btn btn-sm btn-primary">View</a>'
                )

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.report_management.patient.yearly_report');
    }


    /* =======================
       YEARLY REPORT PDF
       ======================= */
    public function yearly_report_pdf(Request $request)
    {
        // ❌ Block PDF if no filter
        if (
            !$request->filled('year') &&
            !$request->filled('gender') &&
            !$request->filled('is_recommend')
        ) {
            return redirect()->back()
                ->with('warning', 'Please apply at least one filter before downloading the report.');
        }

        $query = Patient::query();

        // Filters
        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }

        $query->orderBy('id');
        $page = $request->get('page', 1);
        $perPage = 300;
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        if ($totalRecords === 0) {
            return redirect()->back()
                ->with('warning', 'No data found for the selected filters.');
        }

        // ❌ Show toast if > 300 and user has not confirmed
        if ($totalRecords > $perPage && !$request->filled('confirm')) {
            return redirect()->back()->with([
                'confirm_pdf' => true,
                'totalRecords' => $totalRecords,
                'perPage' => $perPage,
                'year' => $request->year ?? '',
                'gender' => $request->gender ?? '',
                'is_recommend' => $request->is_recommend ?? '',
            ]);
        }

        // ✅ User confirmed or <= 300 → generate PDF
        $patients = $query->limit($perPage)->get();
        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.yearly_report_pdf',
            compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('yearly_patient_report.pdf');
    }
}
