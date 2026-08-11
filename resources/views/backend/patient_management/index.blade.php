@extends('adminlte::page')

@section('title', 'Patients List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Patients Records</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-user-plus mr-1"></i>
                New Patient
            </a>

            <button type="button" class="btn btn-primary btn-sm" id="openPatientSummaryModal" data-toggle="modal"
                data-target="#patientSummaryModal">
                <i class="fas fa-notes-medical mr-1"></i>
                Patient Overview
            </button>

            <button id="delete-selected" class="btn btn-danger btn-sm d-none">
                <i class="fas fa-trash-alt mr-1"></i>
                Delete Selected
            </button>

            <button class="export-excel d-none" href="{{ route('patients.export.excel') }}">
                <i class="fas fa-file-excel text-success mr-1"></i>
                Export to Excel
            </button>

            <button class="export-pdf d-none" href="{{ route('patients.export.pdf') }}">
                <i class="fas fa-file-pdf text-danger mr-1"></i>
                Export to PDF
            </button>

            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-h mr-1"></i>
                    More
                </button>

                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item import-excel" href="{{ route('patients.import.excel') }}">
                        <i class="fas fa-file-import mr-2 text-success"></i>
                        Import from Excel
                    </a>

                    <a class="dropdown-item import-word" href="{{ route('patients.import.word') }}">
                        <i class="fas fa-file-word mr-2 text-primary"></i>
                        Import from Word
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="{{ route('patients.card.list.index') }}" class="dropdown-item">
                        <i class="fas fa-id-card mr-2 text-primary"></i>
                        Patient Cards
                    </a>

                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#patientEmergencyModal">
                        <i class="fas fa-ambulance mr-2 text-danger"></i>
                        Emergency Patients
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    {{-- Filter Form --}}
    @include('backend.patient_management.filter.filter')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/index_page/patient_lost_data.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/index_page/patient_image.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/index_page/patient_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/index_page/patient_age.css') }}">
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
                        <th width="90">Status</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Referred</th>
                        <th>Treatment</th>
                        <th>Investigation</th>
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
    @include('backend.patient_management.modals.index_page.patient_photo_info_modal')
    @include('backend.patient_management.modals.index_page.patient_summary_modal')
    @include('backend.patient_management.modals.index_page.patient_summary_document_overlay')
    @include('backend.patient_management.modals.index_page.patient_summary_cancer_overlay')
    @include('backend.patient_management.modals.index_page.patient_view_modal')
    @include('backend.patient_management.modals.index_page.patient_view_modal_animation')
    @include('backend.patient_management.modals.index_page.patient_notification_modal')
    @include('backend.patient_management.modals.index_page.patient_close_modal')
    <iframe id="downloadFrame" style="display:none;"></iframe>
    <div style="height: 50px;"></div>
@stop

@section('js')
    {{-- Patient Route Core --}}
    <script>
        window.patientRoutes = {
            index: "{{ route('patients.index') }}",
            emergency: "{{ route('patients.emergency') }}",
            summarySearch: "{{ route('patients.summary.search') }}",
            summaryAnimation: "{{ url('patients/summary/animation') }}",
            documentSearch: "{{ route('patients.document.search') }}",
            documentContents: "{{ route('patients.document.contents', ':id') }}",
            cancerPhotoContents: "{{ route('patients.cancer.photo.contents', ':id') }}",
            photoSearch: "{{ route('patients.photo.search') }}",
            draftSave: "{{ route('patients.drafts.save') }}",
            draftPending: "{{ route('patients.drafts.pending') }}",
            draftShow: "{{ route('patients.drafts.show', ':id') }}",
            draftDestroy: "{{ route('patients.drafts.destroy', ':id') }}"
        };
    </script>
    <script src="{{ asset('js/backend/patient_management/zoom.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_filter_age.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_ajax_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_ajax_filter.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_ajax_tb_search.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_ajax_tb_highlight.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_shared_filter.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_all.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_import_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_export_excel_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_export_pdf_file.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_progress_percent.js') }}"></script>


    {{-- Start of Patient Lost Notification --}}
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_core.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_display.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_check.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_actions.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_init.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_notif/patient_lost_data_notification_start.js') }}">
    </script>
    {{-- End of Patient Lost Notification --}}

    {{-- Start of Patient Recover Data --}}
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_ckeditor.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_form.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_step.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_success.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_request.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_recover/patient_recover_data_init.js') }}">
    </script>
    {{-- End of Patient Recover Data --}}

    {{-- Start of Patient Temporary Save --}}
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_save/patient_temporary_save_init.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_save/patient_temporary_save_request.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_save/patient_temporary_save_collect.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_save/patient_temporary_save_storage.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_lost_data/patient_save/patient_temporary_save_cleanup.js') }}">
    </script>
    {{-- End of Patient Temporary Save --}}

    {{-- Patient Emergency Core --}}
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_emergency_ajax.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_emergency_form.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_emergency_validator.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_emergency_success.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_submit_animation.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/patient_emergency.js') }}"></script>

    {{-- Patient Summary Core --}}
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_state.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_search.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_result.js') }}">
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

    {{-- Patient Summary Detail Core --}}
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_detail.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_modal.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_info.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_profile.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_refer_doc.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_treatment.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_investigation.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/index_page/patient_summary/patient_summary_detail/patient_summary_cancer.js') }}">
    </script>

    {{-- Patient Summary Helpers --}}
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

    {{-- Patient AI Animation :: Photo --}}
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

    {{-- Patient AI Animation :: Information --}}
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

    {{-- Patient AI Animation :: Referred Documents --}}

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

    {{-- Patient AI Animation :: Cancer --}}
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
