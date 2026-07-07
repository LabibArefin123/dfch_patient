@extends('adminlte::page')

@section('title', 'Patients List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Patients</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Patient
            </a>

            <button type="button" class="btn btn-primary btn-sm" id="openPatientSummaryModal" data-toggle="modal"
                data-target="#patientSummaryModal">

                <i class="fas fa-comments-medical mr-1"></i>

                Patient Summary

            </button>

            <button id="delete-selected" class="btn btn-danger btn-sm d-none">
                <i class="fas fa-trash"></i> Delete Selected
            </button>

            <button class="export-excel d-none" href="{{ route('patients.export.excel') }}">
                <i class="fas fa-file-excel text-success"></i> Export Excel
            </button>

            <button class="export-pdf d-none" href="{{ route('patients.export.pdf') }}">
                <i class="fas fa-file-pdf text-danger"></i> Export PDF
            </button>

            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">
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
    @include('backend.patient_management.modals.patient_photo_modal')
    @include('backend.patient_management.modals.patient_summary_modal')
    @include('backend.patient_management.modals.patient_view_modal')
    <style>
        .patient-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 8px;
            /* change to 50% if you want circle */
            border: 2px solid #dee2e6;
            transition: 0.3s;
        }

        .patient-img:hover {
            transform: scale(1.2);
            border-color: #007bff;
        }
    </style>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap w-100" id="patientsTable">
                <thead class="table-dark">
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Old Cancer</th>
                        <th>Cancer Report</th>
                        <th>Date Added</th>
                        <th width="170">Actions</th>
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
    <script>
        const patientSummarySearchUrl = "{{ route('patients.summary.search') }}";
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_photo_search.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_load_modal_info.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_info_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patients.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/importFile.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/exportExcelFile.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/exportPDFFile.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/ajaxFile.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/selectFile.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_date_info.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_date_validator.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_search.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_chat.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_state.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_typing.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_scroll.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_result.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_close_action.js') }}">
    </script>
@endsection
