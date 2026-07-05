<?php

namespace App\Services\Reports;

use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public function response($query, $dateColumn = 'date_of_patient_added')
    {
        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('select', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })

            ->addColumn('location', function ($p) {

                if ($p->location_type == 1) {

                    $location = $p->location_simple ?? 'N/A';
                } elseif ($p->location_type == 2) {

                    $location = collect([
                        $p->house_address,
                        $p->city,
                        $p->district,
                    ])->filter()->implode('<br>');
                } else {

                    $location = collect([
                        $p->country,
                        $p->passport_no ? 'Passport: ' . $p->passport_no : null,
                    ])->filter()->implode('<br>');
                }

                return '<a href="' . route('patients.show', $p->id) . '" class="hover-box">'
                    . $location .
                    '</a>';
            })

            ->editColumn('is_recommend', function ($row) {
                return $row->is_recommend ? 'Yes' : 'No';
            })

            ->addColumn('date', function ($row) use ($dateColumn) {

                if (empty($row->$dateColumn)) {
                    return '-';
                }

                return Carbon::parse($row->$dateColumn)->format('d M Y');
            })

            ->addColumn('action', function ($row) {
                return '<a href="' . route('patients.show', $row->id) . '" class="btn btn-sm btn-primary">
                            View
                        </a>';
            })

            ->rawColumns([
                'select',
                'location',
                'action',
            ])

            ->make(true);
    }
}
