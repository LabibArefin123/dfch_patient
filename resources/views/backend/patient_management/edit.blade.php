@extends('adminlte::page')

@section('title', 'Edit Patient Information')

@section('content_header')
    <div class="patient-page-header">
        <div class="patient-header-left">
            <div>
                <h1 class="mb-1">Edit Patient</h1>
                <p class="mb-0">
                    Update the patient's information and save your changes.
                </p>
            </div>
        </div>

        <div class="patient-header-right">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Patients
            </a>
        </div>
    </div>
@stop


@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_progress_stepper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_progress_animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_progress_responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_field.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_location.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_recommend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_treatment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_investigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_field.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_remarks.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_photo.css') }}">
    {{-- ========================= Layout ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_responsive.css') }}">

    {{-- ========================= Form ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_group.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_inputs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_controls.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_form_validation.css') }}">

    {{-- ========================= Input Components ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_input_group.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_input_helpers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_input_states.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_inputs_focus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_preview.css') }}">

    {{-- ========================= Patient Refer ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_preview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_progress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer_status.css') }}">

    {{-- ========================= Patient Treatment ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment_preview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment_progress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment_status.css') }}">

    {{-- ========================= Investigation ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation_progress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation_preview.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_investigation/investigation_animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation_status.css') }}">

    {{-- ========================= Cancer ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_progress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/cancer_status.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/patient_cancer_form.css') }}">

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_global_upload.css') }}">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Progress --}}
    <div class="patient-progress-card">

        <div class="progress-item" data-target="part_1_general">
            <div class="step">
                <i class="fas fa-user"></i>
            </div>
            <span>Basic</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_2_address">
            <div class="step">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <span>Address</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_3_medical">
            <div class="step">
                <i class="fas fa-notes-medical"></i>
            </div>
            <span>Medical</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_4_treatment">
            <div class="step">
                <i class="fas fa-procedures"></i>
            </div>
            <span>Treatment</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_5_investigation">
            <div class="step">
                <i class="fas fa-microscope"></i>
            </div>
            <span>Investigation</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_6_emergency">
            <div class="step">
                <i class="fas fa-ambulance"></i>
            </div>
            <span>Emergency</span>
        </div>

        <div class="progress-line"></div>

        <div class="progress-item" data-target="part_7_cancer">
            <div class="step">
                <i class="fas fa-ribbon"></i>
            </div>
            <span>Cancer</span>
        </div>

    </div>

    @include('backend.patient_management.modals.edit_page.patient_image_info')
    <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data"
        data-confirm="edit">
        @csrf
        @method('PUT')
        @include('backend.patient_management.partial_pages.edit_page.part_1')
        @include('backend.patient_management.partial_pages.edit_page.part_2')
        @include('backend.patient_management.partial_pages.edit_page.part_3')
        @include('backend.patient_management.partial_pages.edit_page.part_6')
        @include('backend.patient_management.partial_pages.edit_page.part_4')
        @include('backend.patient_management.partial_pages.edit_page.part_5')
        @include('backend.patient_management.partial_pages.edit_page.part_7')
        @include('backend.patient_management.partial_pages.edit_page.part_8')
        @include('backend.patient_management.partial_pages.edit_page.part_9')
        @include('backend.patient_management.modals.edit_page.patient_photo_validate_modal')
        <button class="btn btn-primary mt-2">Update</button>
    </form>
    <div style="height: 50px;"></div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_editor.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_location_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_emergency_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_recommend_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_investigation_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_treatment_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_cancer_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_edit_form.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_icon_jump.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_1_basic.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_2_address.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_3_medical.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_4_treatment.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_5_investigate.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_6_emergency.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/progress_7_cancer.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_photo_edit_modal.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_referred/patient_refer_card.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_referred/patient_refer_validation.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_referred/patient_refer_progress.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_referred/patient_refer_preview.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_referred/patient_refer_manager.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_treatment/patient_treatment_card.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_treatment/patient_treatment_validation.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_treatment/patient_treatment_progress.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_treatment/patient_treatment_preview.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_treatment/patient_treatment_manager.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_investigation/patient_investigation_card.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_investigation/patient_investigation_validation.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_investigation/patient_investigation_progress.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_investigation/patient_investigation_preview.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_investigation/patient_investigation_manager.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/patient_cancer_card.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/patient_cancer_validation.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/patient_cancer_progress.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/patient_cancer_preview.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/patient_cancer_manager.js') }}"></script>
@stop
