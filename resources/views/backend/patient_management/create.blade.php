@extends('adminlte::page')

@section('title', 'Register Patient Information')

@section('content_header')
    <div class="patient-page-header">
        <div class="patient-header-left">
            <div class="patient-header-icon">
                <i class="fas fa-user-plus"></i>
            </div>

            <div>
                <h1 class="mb-1">Register New Patient</h1>
                <p class="mb-0"> Complete all required information before saving the patient.</p>
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
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_inputs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_treatment_upload.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_progress_stepper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_progress_animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_progress_responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_treatment/treatment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_refer/refer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_investigation/investigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/create_page/patient_form_footer.css') }}">

    <div class="patient-create-wrapper">
        {{-- Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Please fix the following errors</strong>
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Progress --}}
        <div class="patient-progress-card">
            <div class="progress-item">
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

        <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data" id="patientCreateForm">
            @csrf
            {{-- BASIC INFORMATION --}}
            @include('backend.patient_management.partial_pages.create_page.part_1')
            {{-- ADDRESS --}}
            @include('backend.patient_management.partial_pages.create_page.part_2')
            {{-- REGISTRATION --}}
            <div class="patient-section-card">
                <div class="section-header blue">
                    <div>
                        <h3><i class="fas fa-calendar-check mr-2"></i> Registration </h3>
                        <p> Registration and referred details.</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Date of Registration</label>
                            <input type="date" name="date_of_patient_added" class="form-control"
                                value="{{ old('date_of_patient_added', date('Y-m-d')) }}">
                        </div>
                        @include('backend.patient_management.partial_pages.create_page.part_3')
                    </div>
                </div>
            </div>
            {{-- MEDICAL --}}
            <div class="patient-section-card">
                <div class="section-header red">
                    <div>
                        <h3><i class="fas fa-heartbeat mr-2"></i> Medical Information</h3>
                        <p> Current condition and patient history.</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        @include('backend.patient_management.partial_pages.create_page.part_4')
                    </div>
                </div>
            </div>
            {{-- Treatment Part --}}
            @include('backend.patient_management.partial_pages.create_page.part_5')
            {{-- Investigation Part --}}
            @include('backend.patient_management.partial_pages.create_page.part_6')
            {{-- Footer Actions --}}
            <div class="patient-form-footer">
                <a href="{{ route('patients.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save Patient
                </button>
            </div>
        </form>
    </div>
    <div style="height:80px"></div>
@stop


@section('js')

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/patient_location_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/patient_recommend_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/patient_treatment_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/patient_investigation_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/patient_create_form.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/create_page/create_editor.js') }}"></script>

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
