<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function daily_report(Request $request)
    {
        if ($request->ajax()) {

            $query = Patient::query();

            // Filters (same as PDF)
            if ($request->gender) {
                $query->where('gender', $request->gender);
            }

            if (!is_null($request->is_recommend)) {
                $query->where('is_recommend', $request->is_recommend);
            }

            if ($request->location_type && $request->location_value) {
                $query->where($request->location_type, 'like', '%' . $request->location_value . '%');
            }

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('is_recommend', fn($row) => $row->is_recommend ? 'Yes' : 'No')
                ->editColumn('date', fn($row) => $row->created_at->format('Y-m-d'))
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('patients.show', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.report_management.patient.daily_report');
    }

    // ✅ PDF
    public function daily_report_pdf(Request $request)
    {
        $query = Patient::query();

        // Same filters as table
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if (!is_null($request->is_recommend)) {
            $query->where('is_recommend', $request->is_recommend);
        }

        if ($request->location_type && $request->location_value) {
            $query->where($request->location_type, 'like', '%' . $request->location_value . '%');
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $patients = $query->get();

        $pdf = Pdf::loadView(
            'backend.report_management.patient.daily_report_pdf',
            compact('patients')
        )->setPaper('a4', 'landscape');

        return $pdf->download('daily_patient_report_' . now()->format('Y_m_d') . '.pdf');
    }
}
