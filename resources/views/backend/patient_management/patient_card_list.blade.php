@extends('adminlte::page')

@section('title', 'Patient Card List')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">

                <i class="fas fa-id-card text-primary mr-2"></i>

                Patient Card List

            </h1>

            <p class="text-muted mb-0">

                Search and view patient identification cards

            </p>

        </div>


        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left mr-1"></i>

            Back to Patients

        </a>

    </div>

@stop


@section('content')

    <div class="card patient-card-container">

        <div class="card-header border-0">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <div class="patient-search-box">

                        <i class="fas fa-search search-icon"></i>

                        <input type="text" id="patientCardSearch" class="form-control"
                            placeholder="Search patient name, code, phone..." autocomplete="off">

                        <button type="button" id="clearPatientCardSearch" class="btn btn-clear-search">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                </div>

                <div class="col-lg-5 text-lg-right mt-3 mt-lg-0">

                    <div id="patientCardTotal" class="patient-total-badge">

                        <i class="fas fa-users mr-2"></i>

                        Loading...
                    </div>

                </div>

            </div>

        </div>

        <div class="card-body">

            <div id="patientCardLoading" class="patient-loading d-none">

                <div class="spinner-border text-primary"></div>

                <h6 class="mt-4 mb-1">
                    Loading Patients
                </h6>

                <p class="text-muted">
                    Please wait a moment...
                </p>

            </div>

            <div id="patientCardGrid" class="row"></div>

            <div id="patientCardEmpty" class="patient-empty-state d-none">

                <div class="empty-icon">

                    <i class="fas fa-user-slash"></i>

                </div>

                <h4>
                    No Patients Found
                </h4>

                <p>
                    Try searching with another keyword.
                </p>

            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0">

            <div id="patientCardPagination" class="patient-pagination-wrapper">

            </div>

        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_total.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_photo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_effects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_empty.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_card/patient_card_responsive.css') }}">
@stop

@section('js')
    <script>
        const patientCardSearchRoute =
            "{{ route('patients.card.list.search') }}";
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_config.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_loader.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_initial.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_search.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_clear.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_card/patient_card_pagination.js') }}"></script>
@stop
