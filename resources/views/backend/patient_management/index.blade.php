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

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#patientEmergencyModal">

                        <i class="fas fa-ambulance text-danger"></i>

                        Emergency Status

                    </a>
                </div>

            </div>
        </div>
    </div>
@stop

@section('content')
    {{-- Filter Form --}}
    @include('backend.patient_management.filter.filter')
    @include('backend.patient_management.modals.index_page.patient_photo_info_modal')
    @include('backend.patient_management.modals.index_page.patient_summary_modal')
    @include('backend.patient_management.modals.index_page.patient_summary_document_overlay')
    @include('backend.patient_management.modals.index_page.patient_summary_cancer_overlay')
    @include('backend.patient_management.modals.index_page.patient_view_modal')
    @include('backend.patient_management.modals.index_page.patient_view_modal_animation')
    @include('backend.patient_management.modals.index_page.patient_close_modal')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/index_page/patient_image.css') }}">
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
                        <th width="90">Emergency </th>
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
    @include('backend.patient_management.modals.index_page.patient_emergency_modal')
    @include('backend.patient_management.modals.index_page.import_file_modal')
    @include('backend.patient_management.modals.index_page.no_filter_modal')
    @include('backend.patient_management.modals.index_page.progress_modal')
    @include('backend.patient_management.modals.index_page.select_modal')

    <iframe id="downloadFrame" style="display:none;"></iframe>

    <div style="height: 50px;"></div>
@stop

@section('js')
    <script>
        /*
        |--------------------------------------------------------------------------
        | Global Routes
        |--------------------------------------------------------------------------
        */
        window.patientRoutes = {
            index: "{{ route('patients.index') }}"
        };

        const patientEmergencyUrl = "{{ route('patients.emergency') }}";
        const patientSummarySearchUrl = "{{ route('patients.summary.search') }}";
        const patientSummaryAnimationSearchUrl = "{{ url('patients/summary/animation') }}";
        const patientDocumentSearchUrl = "{{ route('patients.document.search') }}";
        const patientDocumentContentsUrl = "{{ route('patients.document.contents', ':id') }}";
        const patientCancerPhotoContentsUrl = "{{ route('patients.cancer.photo.contents', ':id') }}";
        const patientPhotoSearchUrl = "{{ route('patients.photo.search') }}";
    </script>

    <script src="{{ asset('js/backend/patient_management/zoom.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_ajax_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_all.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_emergency_form.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_export_excel_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_export_pdf_file.js') }}"></script>
    {{-- ========================================================================= --}}
    {{-- Patient Summary Core --}}
    {{-- ========================================================================= --}}

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary.js') }}"></script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_state.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_search.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_result.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_preview.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_chat_validator.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_photo_search.js') }}"></script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_document_search.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_document_content.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_cancer_content.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_close_action.js') }}">
    </script>

    {{-- ========================================================================= --}}
    {{-- Patient Summary Helpers --}}
    {{-- ========================================================================= --}}

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_chat.js') }}"></script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_helper.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_typing.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_scroll.js') }}">
    </script>

    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_date_info.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_date_validator.js') }}">
    </script>

    {{-- ========================================================================= --}}
    {{-- Patient AI Animation :: Photo --}}
    {{-- ========================================================================= --}}

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_init.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_template.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_render.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_animation.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_effect.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/photo_section/patient_photo_public.js') }}">
    </script>

    {{-- ========================================================================= --}}
    {{-- Patient AI Animation :: Information --}}
    {{-- ========================================================================= --}}

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_init.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_template.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_render.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_animation.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_effect.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/information_section/patient_information_public.js') }}">
    </script>

    {{-- ========================================================================= --}}
    {{-- Patient AI Animation :: Recommendation Documents --}}
    {{-- ========================================================================= --}}

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_init.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_render.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_animate.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_effect.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_events.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/document_section/patient_document_public.js') }}">
    </script>

    {{-- ========================================================================= --}}
    {{-- Patient AI Animation :: Cancer --}}
    {{-- ========================================================================= --}}

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/cancer_section/patient_cancer_init.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/cancer_section/patient_cancer_render.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/cancer_section/patient_cancer_template.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/cancer_section/patient_cancer_animation.js') }}">
    </script>

    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_animation/cancer_section/patient_cancer_effect.js') }}">
    </script>
@endsection
