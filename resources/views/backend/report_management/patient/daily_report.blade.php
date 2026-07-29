@extends('backend.report_management.patient.layouts.report_layout')

@php
    $title = 'Daily Patient Report';
    $ajaxRoute = route('report.daily');
    $pdfRoute = route('report.daily.pdf');
    $excelRoute = route('report.daily.excel');
    $reportType = 'daily';
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

        {{-- =========================================
            Daily Date Filter
        ========================================== --}}
        <div class="col-12 mb-3">

            <div class="card card-outline card-success shadow-sm">

                <div class="card-header py-2">

                    <h3 class="card-title">
                        <i class="fas fa-calendar-day text-success mr-2"></i>
                        Daily Date Filter
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-success">
                            Report Period
                        </span>
                    </div>

                </div>

                <div class="card-body pb-2">

                    <div class="row">

                        <div class="col-lg-4 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-filter text-success mr-1"></i>
                                Day Range
                            </label>

                            <select name="day_filter" id="day_filter" class="form-control">

                                <option value="today" selected>
                                    Current Day
                                </option>

                                <option value="past_1_day">
                                    Previous Day
                                </option>

                                <option value="past_2_days">
                                    Last 2 Days
                                </option>

                                <option value="past_3_days">
                                    Last 3 Days
                                </option>

                                <option value="custom">
                                    Custom Date Range
                                </option>

                            </select>

                        </div>

                        <div id="daily_custom_range" class="col-lg-8 d-none">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="font-weight-bold">
                                        <i class="far fa-calendar-alt text-primary mr-1"></i>
                                        From Date
                                    </label>

                                    <input type="date" name="from_date" id="daily_from_date" class="form-control">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="font-weight-bold">
                                        <i class="far fa-calendar-check text-danger mr-1"></i>
                                        To Date
                                    </label>

                                    <input type="date" name="to_date" id="daily_to_date" class="form-control">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================
            Patient Filters
        ========================================== --}}
        <div class="col-12">

            <div class="card card-outline card-info shadow-sm">

                <div class="card-header py-2">

                    <h3 class="card-title">
                        <i class="fas fa-user-injured text-info mr-2"></i>
                        Patient Filters
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-info">
                            Advanced Search
                        </span>
                    </div>

                </div>

                <div class="card-body pb-2">

                    <div class="row">

                        <div class="col-lg-3 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-venus-mars text-primary mr-1"></i>
                                Gender
                            </label>

                            <select name="gender" class="form-control">
                                <option value="">All Patients</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-thumbs-up text-success mr-1"></i>
                                Referred Patients
                            </label>

                            <select name="is_referred" class="form-control">
                                <option value="">All</option>
                                <option value="1">Referred</option>
                                <option value="0">Not Referred</option>
                            </select>

                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-ambulance text-danger mr-1"></i>
                                Emergency
                            </label>

                            <select name="is_emergency" class="form-control">
                                <option value="">All</option>
                                <option value="1">Emergency</option>
                                <option value="0">Normal</option>
                            </select>

                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-procedures text-warning mr-1"></i>
                                Treatment
                            </label>

                            <select name="is_treatment" class="form-control">
                                <option value="">All</option>
                                <option value="1">Under Treatment</option>
                                <option value="0">Not Under Treatment</option>
                            </select>

                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">

                            <label class="font-weight-bold">
                                <i class="fas fa-microscope text-secondary mr-1"></i>
                                Investigation
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
        <th>Father's Phone</th>
        <th>Mother's Phone</th>
        <th>Location</th>
        <th>Referred Patient</th>
        <th>Emergency Patient</th>
        <th>Is Treatment?</th>
        <th>Is Investigated?</th>
        <th>Date Added</th>
        <th>Actions</th>
    </tr>
@endsection

@push('js')
    <script>
        window.dailyReportRoutes = {
            pdf: @json($pdfRoute),
            excel: @json($excelRoute)
        };
    </script>
    <script src="{{ asset('js/backend/report_management/daily_report/daily-report-date-filter.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/daily_report/daily-report-selection-state.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/daily_report/daily-report-selection-events.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/daily_report/daily-report-download-actions.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/daily_report/daily-report-init.js') }}"></script>
@endpush
