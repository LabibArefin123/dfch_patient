@extends('adminlte::page')

@section('title', 'Patient Details')

@section('content_header')
    <div class="patient-page-header">

        <div>
            <div class="d-flex align-items-center mb-1">
                <div class="patient-header-icon">
                    <i class="fas fa-user-injured"></i>
                </div>

                <div>
                    <h1 class="mb-0 font-weight-bold">Patient Details</h1>
                    <small class="text-muted">Complete patient medical profile and records</small>
                </div>
            </div>
        </div>

        <div class="patient-header-actions">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary patient-action-btn">
                <i class="fas fa-edit mr-1"></i>
                Edit Patient
            </a>

            <a href="{{ route('patients.index') }}" class="btn btn-light border patient-action-btn">
                <i class="fas fa-arrow-left mr-1"></i>
                Back
            </a>
        </div>
    </div>
@stop


@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/zoom-modal.css') }}">
    <div class="patient-show-page">
        {{-- PATIENT PROFILE HEADER --}}
        <div class="card patient-profile-card shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    {{-- PATIENT PHOTO --}}
                    <div class="col-md-2 col-lg-1 text-center mb-3 mb-md-0">
                        <div class="patient-profile-photo-wrapper">
                            <img src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                                ? asset($patient->patient_photo)
                                : asset('uploads/images/default.jpg') }}"
                                alt="Patient Photo" class="patient-profile-photo zoomable" data-action="zoom">
                        </div>
                    </div>
                    
                    {{-- PATIENT INFORMATION --}}
                    <div class="col-md-7 col-lg-8">
                        <div class="patient-profile-info">
                            <div>
                                <div class="d-flex align-items-center flex-wrap">
                                    <h2 class="patient-name mb-1 mr-3">
                                        {{ $patient->patient_name }}
                                    </h2>

                                    @if ($patient->is_recommend)
                                        <span class="badge badge-primary patient-status-badge">
                                            <i class="fas fa-user-md mr-1"></i>
                                            Recommended
                                        </span>
                                    @endif

                                    @if ($patient->is_emergency)
                                        <span class="badge badge-danger patient-status-badge ml-2">
                                            <i class="fas fa-truck-medical mr-1"></i>
                                            Emergency
                                        </span>
                                    @endif
                                </div>


                                <div class="patient-meta">
                                    <span>
                                        <i class="fas fa-id-card mr-1"></i>
                                        {{ $patient->patient_code ?? 'N/A' }}
                                    </span>

                                    <span class="mx-2">
                                        •
                                    </span>

                                    <span>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Added
                                        {{ optional($patient->created_at)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- PATIENT PROFILE CODE --}}
                    <div class="col-md-3 text-md-right mt-3 mt-md-0">

                        <div class="patient-profile-label">

                            PATIENT PROFILE

                        </div>


                        <div class="patient-profile-code">

                            #{{ $patient->patient_code ?? 'N/A' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- IMAGE ZOOM MODAL --}}
        <div id="imageZoomModal" class="zoom-modal">
            <span class="zoom-close">&times;  </span>
            <img class="zoom-modal-content" id="zoomedImage">
        </div>


        {{-- MAIN PATIENT INFORMATION --}}
        <div class="row">
            <div class="col-lg-12">
                {{-- PERSONAL INFORMATION --}}
                <div class="patient-section-card">
                    <div class="patient-section-header">
                        <div class="section-icon blue">
                            <i class="fas fa-user"></i>
                        </div>

                        <div>
                            <h5 class="mb-0"> Personal Information </h5>
                            <small>Basic identity and demographic information </small>
                        </div>
                    </div>

                    <div class="patient-section-body">
                        @include('backend.patient_management.partial_pages.show_page.part_1')
                    </div>
                </div>

                {{-- CONTACT INFORMATION --}}
                <div class="patient-section-card">
                    <div class="patient-section-header">
                        <div class="section-icon green">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0"> Contact Information</h5>
                            <small>Patient and family contact numbers </small>
                        </div>
                    </div>

                    <div class="patient-section-body">
                        @include('backend.patient_management.partial_pages.show_page.part_2')
                    </div>
                </div>

                {{-- CALL MODAL --}}
                @include('backend.patient_management.modals.show_page.call_confirm_modal')

                {{-- LOCATION --}}
                <div class="patient-section-card">
                    <div class="patient-section-header">
                        <div class="section-icon orange">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Patient Location</h5>
                            <small>Current address and location details</small>
                        </div>
                    </div>

                    <div class="patient-section-body">
                        @include('backend.patient_management.partial_pages.show_page.part_3')
                    </div>
                </div>

                {{-- RECOMMENDATION PART --}}
                @include('backend.patient_management.partial_pages.show_page.part_4')
                {{-- TREATMENT PART --}}
                @include('backend.patient_management.partial_pages.show_page.part_5')
                {{-- INVESTIGATION PART --}}
                @include('backend.patient_management.partial_pages.show_page.part_6')

                {{-- MEDICAL INFORMATION PART --}}
                <div class="patient-section-card">
                    <div class="patient-section-header">
                        <div class="section-icon red">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Medical Information</h5>
                            <small>Patient condition, medication and remarks</small>
                        </div>
                    </div>

                    <div class="patient-section-body">
                        @include('backend.patient_management.partial_pages.show_page.part_7')
                    </div>
                </div>
            </div>
            @include('backend.patient_management.partial_pages.show_page.part_8')
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/show_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_info.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_location.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_recommendation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_medical.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/patient_cancer.css') }}">

    {{-- KEEPING THIS 40PX UNCHANGED --}}
    <div style="height: 40px;"></div>

@stop


@section('js')

    {{-- Existing JS kept unchanged --}}
    <script src="{{ asset('js/backend/patient_management/zoom.js') }}"></script>

    <script src="{{ asset('js/backend/patient_management/patient_phone_whatsapp.js') }}"></script>

@endsection
