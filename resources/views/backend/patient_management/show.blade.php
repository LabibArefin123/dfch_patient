@extends('adminlte::page')

@section('title', 'Patient Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Patient Details </h1>
        <div>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/show_page/zoom-modal.css') }}">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- LEFT CONTENT --}}
                <div class="col-md-9">

                    {{-- HEADER --}}
                    <div class="form-group">
                        <label>Patient Name</label>
                        <input type="text" class="form-control" disabled
                            value="{{ $patient->patient_name }} ({{ $patient->patient_code ?? 'N/A' }})">
                    </div>

                    {{-- BASIC INFO --}}
                    @include('backend.patient_management.partial_pages.show_page.part_1')
                    {{-- CONTACT INFO --}}
                    <h6 class="text-muted mt-3">Contact Information</h6>
                    @include('backend.patient_management.partial_pages.show_page.part_2')
                    <!-- Call Confirmation Modal -->
                    @include('backend.patient_management.modals.show_page.call_confirm_modal')
                    {{-- LOCATION --}}
                    <h6 class="text-muted mt-2">Location</h6>
                    @include('backend.patient_management.partial_pages.show_page.part_3')
                    {{-- RECOMMENDATION SECTION --}}
                    @include('backend.patient_management.partial_pages.show_page.part_4')
                    {{-- MEDICAL SECTION --}}
                    <h6 class="text-muted">Medical Information</h6>
                    @include('backend.patient_management.partial_pages.show_page.part_5')
                </div>

                {{-- RIGHT IMAGE --}}
                @include('backend.patient_management.partial_pages.show_page.part_6')
            </div>
        </div>
    </div>
    @include('backend.patient_management.partial_pages.show_page.part_7')

    <div style="height: 40px;"></div>
@stop

@section('js')
    <script src="{{ asset('js/backend/patient_management/zoom.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_phone_whatsapp.js') }}"></script>
@endsection
