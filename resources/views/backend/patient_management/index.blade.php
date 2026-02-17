@extends('adminlte::page')

@section('title', 'Patients')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Patients</h1>

        <div class="d-flex gap-2">
            {{-- Add Patient (Primary Action) --}}
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Patient
            </a>

            <button id="delete-selected" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Delete Selected
            </button>

            {{-- More Actions Dropdown --}}
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

                    <a class="dropdown-item import-word" href="{{ route('patients.import.word') }}">
                        <i class="fas fa-upload"></i> Import Word
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop


@section('content')
    {{-- Filter Form --}}
    @include('backend.patient_management.filter.filter')

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap w-100" id="patientsTable">
                <thead class="table-dark">
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('backend.patient_management.modals.import_file_modal')
    @include('backend.patient_management.modals.no_filter_modal')
    @include('backend.patient_management.modals.progress_modal')
    @include('backend.patient_management.modals.select_modal')

    <iframe id="downloadFrame" style="display:none;"></iframe>

    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script>
        window.patientRoutes = {
            index: "{{ route('patients.index') }}"
        };
    </script>

    <script src="{{ asset('js/patient_management/patients.js') }}"></script>
    <script src="{{ asset('js/patient_management/importFile.js') }}"></script>
    <script src="{{ asset('js/patient_management/exportFile.js') }}"></script>
    <script src="{{ asset('js/patient_management/ajaxFile.js') }}"></script>
    <script src="{{ asset('js/patient_management/selectFile.js') }}"></script>
@endsection
