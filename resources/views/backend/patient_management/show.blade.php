@extends('adminlte::page')

@section('title', 'Patient Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Patient Details {{  }}</h1>
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Father's Name</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $patient->patient_f_name ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mother's Name</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $patient->patient_m_name ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Age</label>
                                <input type="text" class="form-control" disabled value="{{ $patient->age ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Gender</label>
                                <input type="text" class="form-control text-uppercase" disabled
                                    value="{{ $patient->gender ?? 'N/A' }}">
                            </div>
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <h6 class="text-muted mt-3">Contact Information</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" disabled value="📞 {{ $patient->phone_1 }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" disabled
                                value="Alt: {{ $patient->phone_2 ?? 'N/A' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" disabled
                                value="Father: {{ $patient->phone_f_1 ?? 'N/A' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" disabled
                                value="Mother: {{ $patient->phone_m_1 ?? 'N/A' }}">
                        </div>
                    </div>

                    {{-- LOCATION --}}
                    <h6 class="text-muted mt-3">Location</h6>

                    <p class="form-control mb-2 bg-light">
                        @if ($patient->location_type == 1)
                            {{ $patient->location_simple }}
                        @elseif ($patient->location_type == 2)
                            {{ $patient->house_address }},
                            {{ $patient->city }},
                            {{ $patient->district }} - {{ $patient->post_code }}
                        @else
                            {{ $patient->country }}
                            <br>
                            <strong>Passport:</strong> {{ $patient->passport_no }}
                        @endif
                    </p>

                    {{-- RECOMMENDATION --}}
                    @if ($patient->is_recommend)
                        <h6 class="text-muted mt-3">Doctor Recommendation</h6>
                        <input type="text" class="form-control mb-2" disabled
                            value="{{ $patient->recommend_doctor_name }}">

                        <input type="text" class="form-control mb-3" disabled
                            value="{{ $patient->recommend_note ?? '-' }}">
                    @endif

                    {{-- MEDICAL --}}
                    <h6 class="text-muted">Medical Information</h6>
                    <textarea class="form-control mb-2" rows="2" disabled>{{ $patient->patient_problem_description ?? 'N/A' }}</textarea>
                    <h6 class="text-muted">Drug Information</h6>
                    <textarea class="form-control mb-3" rows="2" disabled>{{ $patient->patient_drug_description ?? 'N/A' }}</textarea>

                    {{-- REMARKS --}}
                    <h6 class="text-muted">Remarks</h6>
                    <textarea class="form-control" rows="2" disabled>{{ $patient->remarks ?? 'No remarks' }}</textarea>

                </div>

                {{-- RIGHT IMAGE --}}
                <div class="col-md-3 d-flex justify-content-end">
                    <div class="text-center">
                        <div class="border rounded mb-2" style="width:200px;height:200px;">
                            <img src="{{ $patient->photo_path ? asset($patient->photo_path) : asset('images/patient_placeholder.png') }}"
                                alt="Patient Photo" class="img-fluid rounded"
                                style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <small class="text-muted">Patient Photo</small>
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop
