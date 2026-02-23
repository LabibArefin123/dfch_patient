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
            const genderSelect = document.querySelector('select[name="gender"]');
            const recommendSelect = document.querySelector('select[name="is_recommend"]');

            function toggleDateFields() {
                if (weekFilter.value === 'custom') {
                    customDateRange.classList.remove('d-none');
                } else {
                    customDateRange.classList.add('d-none');
                    fromDate.value = '';
                    toDate.value = '';
                }
            }

            weekFilter.addEventListener('change', function() {

                toggleDateFields();

                const weekValue = weekFilter.value;
                const gender = genderSelect.value;
                const recommend = recommendSelect.value;

                // If week selected but no gender and no recommended
                if (
                    weekValue !== '' &&
                    weekValue !== 'custom' &&
                    gender === '' &&
                    recommend === ''
                ) {
                    const modal = new bootstrap.Modal(
                        document.getElementById('filterWarningModal')
                    );
                    modal.show();

                    // Reset week filter so query does not break
                    weekFilter.value = '';
                }
            });

            toggleDateFields();
        });
    </script>
@endpush
