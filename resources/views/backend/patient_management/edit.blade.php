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
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_field.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_location.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_recommend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_treatment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_investigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_field.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_remarks.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_photo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_preview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation.css') }}">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="patient-progress-card">
        <div class="progress-item active">
            <div class="step">
                <i class="fas fa-user"></i>
            </div>
            <span>Basic</span>
        </div>
        <div class="progress-line"></div>
        <div class="progress-item">
            <div class="step">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <span>Address</span>
        </div>
        <div class="progress-line"></div>
        <div class="progress-item">
            <div class="step">
                <i class="fas fa-notes-medical"></i>
            </div>
            <span>Medical</span>
        </div>
        <div class="progress-line"></div>
        <div class="progress-item">
            <div class="step">
                <i class="fas fa-procedures"></i>
            </div>
            <span>Treatment</span>
        </div>
        <div class="progress-line"></div>
        <div class="progress-item">
            <div class="step">
                <i class="fas fa-microscope"></i>
            </div>
            <span>Investigation</span>
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
        @include('backend.patient_management.modals.edit_page.patient_photo_validate_modal')
        <button class="btn btn-primary mt-2">Update</button>
    </form>
    <div style="height: 50px;"></div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_editor.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_location_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_recommend_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_investigation_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_treatment_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_edit_form.js') }}"></script>
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
@stop
