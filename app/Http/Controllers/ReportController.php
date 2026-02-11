<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Patient;
use App\Models\Organization;

class ReportController extends Controller
{
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

    // PDF
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
}
