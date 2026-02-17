@extends('backend.report_management.patient.layouts.report_layout')

@php
    $title = 'Weekly Patient Report';
    $ajaxRoute = route('report.weekly');
    $pdfRoute = route('report.weekly.pdf');
    $excelRoute = route('report.weekly.excel');
    $reportType = 'weekly';
    $columns = json_encode([
        ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
        ['data' => 'patient_code'],
        ['data' => 'patient_name'],
        ['data' => 'age'],
        ['data' => 'gender'],
        ['data' => 'phone_1'],
        ['data' => 'phone_2'],
        ['data' => 'phone_f_1'],
        ['data' => 'phone_m_1'],
        ['data' => 'location'],
        ['data' => 'is_recommend'],
        ['data' => 'date'],
        ['data' => 'action', 'orderable' => false, 'searchable' => false],
    ]);
@endphp

@section('filters')
    <div class="row">

        {{-- Week Filter --}}
        <div class="col-md-3">
            <label>Week Filter</label>
            <select name="week_filter" id="week_filter" class="form-control">
                <option value="current_week">Current Week</option>
                <option value="past_week">Past Week</option>
                <option value="past_2_weeks">Past 2 Weeks</option>
                <option value="past_3_weeks">Past 3 Weeks</option>
                <option value="past_4_weeks">Past 4 Weeks</option>
                <option value="custom">Custom Date</option>
            </select>
        </div>

        {{-- Custom Date Range (Hidden Initially) --}}
        <div id="custom_date_range" class="col-md-6 d-none">
            <div class="row">
                <div class="col-md-6">
                    <label>From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">All</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Recommended</label>
            <select name="is_recommend" class="form-control">
                <option value="">All</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>
@endsection


@section('table_header')
    <tr>
        <th>#</th>
        <th>Patient Code</th>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Alt Phone</th>
        <th>Father</th>
        <th>Mother</th>
        <th>Location</th>
        <th>Recommended</th>
        <th>Date Added</th>
        <th>Action</th>
    </tr>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const weekFilter = document.getElementById('week_filter');
            const customDateRange = document.getElementById('custom_date_range');
            const fromDate = document.getElementById('from_date');
            const toDate = document.getElementById('to_date');

            function toggleDateFields() {
                if (weekFilter.value === 'custom') {
                    customDateRange.classList.remove('d-none');
                } else {
                    customDateRange.classList.add('d-none');
                    fromDate.value = '';
                    toDate.value = '';
                }
            }

            weekFilter.addEventListener('change', toggleDateFields);

            toggleDateFields(); // ensure correct state on page load
        });
    </script>
@endpush
