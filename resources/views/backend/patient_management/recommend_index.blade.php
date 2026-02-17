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

            {{-- Back to All Patients --}}
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> All Patients
            </a>
            {{-- Add Patient --}}
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Patient
            </a>

            <button id="delete-selected" class="btn btn-danger btn-sm d-none">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            {{-- More Actions --}}
            {{-- <div class="dropdown">
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
            </div> --}}

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
    @include('backend.patient_management.modals.select_modal')
@stop

@section('js')
    <script>
        window.recommendRoutes = {
            recommend: "{{ route('patients.recommend') }}"
        };
    </script>
    <script src="{{ asset('js/patient_management/recommendAjax.js') }}"></script>
    <script src="{{ asset('js/patient_management/selectFile.js') }}"></script>
@stop
