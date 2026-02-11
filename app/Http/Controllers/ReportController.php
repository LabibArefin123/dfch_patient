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

            $query = Patient::query();

            // Filters
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            if ($request->filled('is_recommend')) {
                $query->where('is_recommend', $request->is_recommend);
            }

            if ($request->filled('location_type') && $request->filled('location_value')) {
                $query->where($request->location_type, 'like', '%' . $request->location_value . '%');
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
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
                    } else {
                        return $row->country .
                            ' (Passport: ' . $row->passport_no . ')';
                    }
                })
                ->editColumn('is_recommend', function ($row) {
                    return $row->is_recommend ? 'Yes' : 'No';
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('patients.show', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                })
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
        $query = Patient::query();

        // Same Filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }

        if ($request->filled('location_type') && $request->filled('location_value')) {
            $query->where($request->location_type, 'like', '%' . $request->location_value . '%');
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }
        $organization = Organization::first();
        $patients = $query->get();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.daily_report_pdf',
            compact('patients', 'organization')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('daily_patient_report.pdf'); // open in new tab
    }

    /* =======================
       MONTHLY REPORT 
       ======================= */

    public function monthly_report(Request $request)
    {
        if ($request->ajax()) {

            $query = Patient::query();

            // ✅ YEAR FILTER (date_of_patient_added)
            if ($request->filled('year')) {
                $query->whereYear('date_of_patient_added', $request->year);
            }

            // ✅ MONTH FILTER (date_of_patient_added)
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

                // ✅ LOCATION LOGIC (UNCHANGED)
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

                // Recommended Text
                ->editColumn('is_recommend', function ($row) {
                    return $row->is_recommend ? 'Yes' : 'No';
                })

                // ✅ DATE COLUMN (USING date_of_patient_added)
                ->addColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date_of_patient_added)->format('d-m-Y')
                        . ' (' .
                        \Carbon\Carbon::parse($row->date_of_patient_added)->format('d F Y')
                        . ')';
                })

                // Action
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
        $query = Patient::query();

        // Year filter
        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }

        // Month filter
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

        $query->orderBy('id'); // VERY IMPORTANT

        $perPage = 250;
        $page = $request->get('page', 1);

        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        $patients = $query->forPage($page, $perPage)->get();

        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.monthly_report_pdf',
            compact(
                'patients',
                'organization',
                'page',
                'totalPages',
                'perPage',
                'totalRecords'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('monthly_patient_report_page_' . $page . '.pdf');
    }

    /* =======================
       YEARLY REPORT 
       ======================= */

    public function yearly_report(Request $request)
    {
        if ($request->ajax()) {
            $query = Patient::query();

            // Filter by year
            if ($request->filled('year')) {
                $query->whereYear('date_of_patient_added', $request->year);
            }

            // Gender filter
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            // Recommended filter
            if ($request->filled('is_recommend')) {
                $query->where('is_recommend', $request->is_recommend);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('location', function ($row) {
                    if ($row->location_type == 1) return $row->location_simple;
                    if ($row->location_type == 2) {
                        return $row->house_address . ', ' . $row->city . ', ' . $row->district . ' - ' . $row->post_code;
                    }
                    return $row->country . ' (Passport: ' . $row->passport_no . ')';
                })
                ->editColumn('is_recommend', fn($r) => $r->is_recommend ? 'Yes' : 'No')
                ->addColumn('date', fn($r) => \Carbon\Carbon::parse($r->date_of_patient_added)->format('d-m-Y') . ' (' . \Carbon\Carbon::parse($r->date_of_patient_added)->format('d F Y') . ')')
                ->addColumn('action', fn($r) => '<a href="' . route('patients.show', $r->id) . '" class="btn btn-sm btn-primary">View</a>')
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
        $query = Patient::query();

        if ($request->filled('year')) {
            $query->whereYear('date_of_patient_added', $request->year);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('is_recommend')) {
            $query->where('is_recommend', $request->is_recommend);
        }

        // Get current page from request
        $page = $request->get('page', 1);

        // Limit 250 per page
        $patients = $query->forPage($page, 250)->get();

        $organization = Organization::first();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.yearly_report_pdf',
            compact('patients', 'organization')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('yearly_patient_report_page_' . $page . '.pdf');
    }
}
