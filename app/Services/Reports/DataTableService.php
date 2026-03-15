<?php

namespace App\Services\Reports;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DataTableService
{
    public function response($query, $dateColumn)
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
                return Carbon::parse($row->$dateColumn)
                    ->format('d-m-Y') . ' (' .
                    Carbon::parse($row->$dateColumn)
                    ->format('d F Y') . ')';
            })

            ->addColumn('action', function ($r) {
                return '<a href="' . route('patients.show', $r->id) . '" class="btn btn-sm btn-primary">View</a>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}
