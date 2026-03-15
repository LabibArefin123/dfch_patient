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
        ['data' => 'is_recommend'],
        ['data' => 'date'],
        ['data' => 'action', 'orderable' => false, 'searchable' => false],
    ]);
@endphp

@section('filters')
    <div class="row">

        <div class="col-md-3">
            <label>Year</label>
            <select name="year" class="form-control">
                <option value="">All</option>
                @for ($y = now()->year; $y >= 2015; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-3">
            <label>Month</label>
            <select name="month" class="form-control">
                <option value="">All</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}">
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endforeach
            </select>
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
        <th>Recommended</th>
        <th>Date Added</th>
        <th>Action</th>
    </tr>
@endsection

@push('js')
    <script>
        let selectedRows = [];
        let lastChecked = null;

        function updateSelectedArray() {
            selectedRows = [];

            $('.row-checkbox:checked').each(function() {
                selectedRows.push($(this).val());
            });

            toggleSelectedButtons();
        }

        $(document).on('click', '.row-checkbox', function(e) {

            let checkboxes = $('.row-checkbox');
            let currentIndex = checkboxes.index(this);

            if (!lastChecked) {
                lastChecked = this;
            }

            if (e.shiftKey) {

                let lastIndex = checkboxes.index(lastChecked);
                let start = Math.min(lastIndex, currentIndex);
                let end = Math.max(lastIndex, currentIndex);

                checkboxes.slice(start, end + 1).prop('checked', lastChecked.checked);

            }

            lastChecked = this;

            updateSelectedArray();
        });

        $('#selectAll').on('change', function() {

            $('.row-checkbox').prop('checked', this.checked);

            updateSelectedArray();

        });

        function toggleSelectedButtons() {

            if (selectedRows.length > 0) {

                $('#downloadSelectedPdf').removeClass('d-none');
                $('#downloadSelectedExcel').removeClass('d-none');

            } else {

                $('#downloadSelectedPdf').addClass('d-none');
                $('#downloadSelectedExcel').addClass('d-none');

            }
        }

        $('#downloadSelectedPdf').on('click', function(e) {

            e.preventDefault();

            if (selectedRows.length === 0) {
                alert('Please select rows');
                return;
            }

            let params = new URLSearchParams($('#filterForm').serialize());

            selectedRows.forEach(id => {
                params.append('ids[]', id);
            });

            window.open("{{ $pdfRoute }}?" + params.toString(), '_blank');

        });

        $('#downloadSelectedExcel').on('click', function(e) {

            e.preventDefault();

            if (selectedRows.length === 0) {
                alert('Please select rows');
                return;
            }

            let params = new URLSearchParams($('#filterForm').serialize());

            selectedRows.forEach(id => {
                params.append('ids[]', id);
            });

            window.location.href = "{{ $excelRoute }}?" + params.toString();

        });
    </script>
@endpush
