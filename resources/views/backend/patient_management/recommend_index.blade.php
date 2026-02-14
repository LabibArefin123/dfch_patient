@extends('adminlte::page')

@section('title', 'Recommended Patients')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-0 text-success">
                <i class="fas fa-star"></i> Recommended Patients
            </h1>
            <small class="text-muted">
                Patients marked as recommended
            </small>
        </div>

        <div class="d-flex gap-2">

            {{-- Add Patient --}}
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Patient
            </a>

            {{-- Back to All Patients --}}
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> All Patients
            </a>

            {{-- More Actions --}}
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item export-excel" href="{{ route('patients.export.excel') }}">
                        <i class="fas fa-file-excel text-success"></i> Export Excel
                    </a>

                    <a class="dropdown-item export-pdf" href="{{ route('patients.export.pdf') }}">
                        <i class="fas fa-file-pdf text-danger"></i> Export PDF
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item import-excel" href="{{ route('patients.import.excel') }}">
                        <i class="fas fa-upload"></i> Import Excel
                    </a>

                    <a class="dropdown-item" href="{{ route('patients.print') }}">
                        <i class="fas fa-print"></i> Print
                    </a>

                </div>
            </div>

        </div>
    </div>
@stop


@section('content')

    {{-- Filter --}}
    @include('backend.patient_management.filter.filter')

    {{-- Table --}}
    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <strong>Recommended Patients List</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap w-100" id="patientsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>

    <iframe id="downloadFrame" style="display:none;"></iframe>

@stop


@section('js')
    <script>
        $(function() {

            var table = $('#patientsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('patients.recommend') }}",
                    data: function(d) {
                        d.gender = $('select[name=gender]').val();
                        d.location_type = $('select[name=location_type]').val();
                        d.location_value = $('input[name=location_value]').val();
                        d.date_filter = $('select[name=date_filter]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    },
                    dataSrc: function(json) {
                        $('#childCount').text(json.childPatients ?? 0);
                        $('#adultCount').text(json.adultPatients ?? 0);
                        $('#seniorCount').text(json.seniorPatients ?? 0);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'patient_code',
                        name: 'patient_code'
                    },
                    {
                        data: 'name',
                        name: 'patient_name'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'phone',
                        name: 'phone_1'
                    },
                    {
                        data: 'location',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'is_recommend',
                        name: 'is_recommend'
                    },
                    {
                        data: 'date',
                        name: 'date_of_patient_added'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Filter submit
            $('form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

        });
    </script>
@stop
