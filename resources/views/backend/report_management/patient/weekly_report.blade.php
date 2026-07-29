@extends('backend.report_management.patient.layouts.report_layout')

@php
    $title = 'Weekly Patient Report';
    $ajaxRoute = route('report.weekly');
    $pdfRoute = route('report.weekly.pdf');
    $excelRoute = route('report.weekly.excel');
    $reportType = 'weekly';
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
            Date Filter Section
        ========================================== --}}
        <div class="col-12 mb-3">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header py-2">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-week text-primary mr-2"></i>
                        Weekly Date Filter
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-primary">
                            Report Period
                        </span>
                    </div>
                </div>

                <div class="card-body pb-2">

                    <div class="row">

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-filter text-primary mr-1"></i>
                                Week Range
                            </label>

                            <select name="week_filter" id="week_filter" class="form-control">

                                <option value="current_week" selected>
                                    Current Week
                                </option>

                                <option value="past_week">
                                    Previous Week
                                </option>

                                <option value="past_2_weeks">
                                    Last 2 Weeks
                                </option>

                                <option value="past_3_weeks">
                                    Last 3 Weeks
                                </option>

                                <option value="past_4_weeks">
                                    Last 4 Weeks
                                </option>

                                <option value="custom">
                                    Custom Date Range
                                </option>

                            </select>
                        </div>

                        <div id="custom_date_range" class="col-lg-8 d-none">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">
                                        <i class="far fa-calendar-alt text-success mr-1"></i>
                                        From Date
                                    </label>

                                    <input type="date" name="from_date" id="from_date" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">
                                        <i class="far fa-calendar-check text-danger mr-1"></i>
                                        To Date
                                    </label>

                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- =========================================
            Patient Filter Section
        ========================================== --}}
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

                                <option value="">
                                    All Patients
                                </option>

                                <option value="Male">
                                    Male
                                </option>

                                <option value="Female">
                                    Female
                                </option>

                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-thumbs-up text-primary mr-1"></i>
                                Referred
                            </label>

                            <select name="is_referred" class="form-control">

                                <option value="">
                                    All
                                </option>

                                <option value="1">
                                    Referred
                                </option>

                                <option value="0">
                                    Not Referred
                                </option>

                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-ambulance text-danger mr-1"></i>
                                Emergency
                            </label>

                            <select name="is_emergency" class="form-control">

                                <option value="">
                                    All
                                </option>

                                <option value="1">
                                    Emergency
                                </option>

                                <option value="0">
                                    Normal
                                </option>

                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-procedures text-warning mr-1"></i>
                                Treatment Status
                            </label>

                            <select name="is_treatment" class="form-control">

                                <option value="">
                                    All
                                </option>

                                <option value="1">
                                    Under Treatment
                                </option>

                                <option value="0">
                                    Not Under Treatment
                                </option>

                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-microscope text-secondary mr-1"></i>
                                Investigation Status
                            </label>

                            <select name="is_investigated" class="form-control">

                                <option value="">
                                    All
                                </option>

                                <option value="1">
                                    Investigated
                                </option>

                                <option value="0">
                                    Not Investigated
                                </option>

                            </select>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
<!-- Filter Validation Modal -->
<div class="modal fade" id="filterWarningModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">⚠ Filter Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center py-4">
                <p class="mb-0">
                    If you select a <strong>Week Filter</strong>,
                    you must also choose <strong>Gender</strong> or <strong>Recommended</strong>.
                </p>
            </div>

        </div>
    </div>
</div>
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
    <script src="{{ asset('js/backend/report_management/weekly-report/weekly-selection.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/weekly-report/weekly-export.js') }}"></script>
    <script src="{{ asset('js/backend/report_management/weekly-report/weekly-report.js') }}"></script>
@endpush
