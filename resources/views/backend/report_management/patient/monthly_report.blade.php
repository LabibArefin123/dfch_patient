@extends('backend.report_management.patient.layouts.report_layout')

@php
    $title = 'Monthly Patient Report';
    $ajaxRoute = route('report.monthly');
    $pdfRoute = route('report.monthly.pdf');
    $excelRoute = route('report.monthly.excel');
    $reportType = 'monthly';
    $columns = json_encode([
        ['data' => 'select', 'orderable' => false, 'searchable' => false],
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
        ['data' => 'is_referred'],
        ['data' => 'is_emergency'],
        ['data' => 'is_treatment'],
        ['data' => 'is_investigated'],
        ['data' => 'date_of_patient_added'],
        ['data' => 'action', 'orderable' => false, 'searchable' => false],
    ]);
@endphp

@section('filters')
    <div class="row">
        {{-- Date Filter Section --}}
        <div class="col-12 mb-3">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header py-2">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt text-warning mr-2"></i>
                        Monthly Date Filter
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-warning">
                            Report Period
                        </span>
                    </div>
                </div>

                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="far fa-calendar text-primary mr-1"></i>
                                Year
                            </label>

                            <select name="year" class="form-control">
                                <option value=""> All Years </option>
                                @for ($y = now()->year; $y >= 2015; $y--)
                                    <option value="{{ $y }}">
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-3" <label class="font-weight-bold">
                            <i class="fas fa-calendar-day text-success mr-1"></i>
                            Month
                            </label>

                            <select name="month" class="form-control">
                                <option value=""> All Months</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}">
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Patient Filter Section --}}
        <div class="col-12">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header py-2">
                    <h3 class="card-title">
                        <i class="fas fa-user-injured text-success mr-2"></i>
                        Patient Filters
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-success">
                            Advanced Search
                        </span>
                    </div>
                </div>

                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-venus-mars text-info mr-1"></i>
                                Gender
                            </label>

                            <select name="gender" class="form-control">
                                <option value="">All Patients</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-thumbs-up text-primary mr-1"></i>
                                Referred Patient
                            </label>

                            <select name="is_referred" class="form-control">
                                <option value="">All</option>
                                <option value="1">Referred</option>
                                <option value="0">Not Referred</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-ambulance text-danger mr-1"></i>
                                Emergency Patient
                            </label>

                            <select name="is_emergency" class="form-control">
                                <option value="">All</option>
                                <option value="1">Emergency</option>
                                <option value="0">Normal</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-procedures text-warning mr-1"></i>
                                Treatment Status
                            </label>
                            <select name="is_treatment" class="form-control">
                                <option value="">All</option>
                                <option value="1">Under Treatment</option>
                                <option value="0">Not Under Treatment</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-microscope text-secondary mr-1"></i>
                                Investigation Status
                            </label>

                            <select name="is_investigated" class="form-control">
                                <option value="">All</option>
                                <option value="1">Investigated</option>
                                <option value="0">Not Investigated</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('table_header')
    <tr>
        <th>
            <input type="checkbox" id="selectAll">
        </th>
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
        <th>Referred Patient</th>
        <th>Emergency Patient</th>
        <th>Is Treatment?</th>
        <th>Is Investigated?</th>
        <th>Date Added</th>
        <th>Action</th>
    </tr>
@endsection

@push('js')
    <script>
        window.reportConfig = {
            pdfRoute: "{{ $pdfRoute }}",
            excelRoute: "{{ $excelRoute }}"
        };
    </script>

    <script src="{{ asset('js/backend/report_management/monthly-report/monthly-selection.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/monthly-report/monthly-export.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/monthly-report/monthly-report.js') }}"></script>
@endpush
