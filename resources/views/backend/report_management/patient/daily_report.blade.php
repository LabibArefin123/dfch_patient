@extends('backend.report_management.patient.layouts.report_layout')

@php
    $title = 'Daily Patient Report';
    $ajaxRoute = route('report.daily');
    $pdfRoute = route('report.daily.pdf');
    $excelRoute = route('report.daily.excel'); 
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

        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control">
        </div>

        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control">
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
        <th>Father's Phone</th>
        <th>Mother's Phone</th>
        <th>Location</th>
        <th>Recommended</th>
        <th>Date Added</th>
        <th>Actions</th>
    </tr>
@endsection
