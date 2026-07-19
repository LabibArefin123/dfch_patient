<?php

namespace App\Services\Reports;

use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public function response(
        $query,
        $dateColumn = 'date_of_patient_added'
    ) {
        return DataTables::of($query)

            ->addIndexColumn()

            ->addColumn('select', function ($row) {

                return '
                    <input
                        type="checkbox"
                        class="row-checkbox"
                        value="' . $row->id . '"
                    >
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            ->addColumn('location', function ($row) {

                return $row->full_location ?? 'N/A';
            })

            /*
            |--------------------------------------------------------------------------
            | Recommendation
            |--------------------------------------------------------------------------
            */

            ->editColumn(
                'is_recommend',
                function ($row) {

                    return $row->is_recommend
                        ? 'Yes'
                        : 'No';
                }
            )

            /*
            |--------------------------------------------------------------------------
            | Date Of Patient Added
            |--------------------------------------------------------------------------
            */

            ->editColumn(
                $dateColumn,
                function ($row) use ($dateColumn) {

                    if (empty($row->$dateColumn)) {
                        return '-';
                    }

                    return Carbon::parse(
                        $row->$dateColumn
                    )->format('d F Y');
                }
            )

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */

            ->addColumn(
                'action',
                function ($row) {

                    return '
                        <a
                            href="' .
                        route(
                            'patients.show',
                            $row->id
                        ) .
                        '"
                            class="btn btn-sm btn-primary"
                        >
                            <i class="fas fa-eye mr-1"></i>
                            View
                        </a>
                    ';
                }
            )

            ->rawColumns([
                'select',
                'action',
            ])

            ->make(true);
    }
}
