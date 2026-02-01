@extends('adminlte::page')

@section('title', 'Patient Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Patient Details</h1>
        <div>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- LEFT: PATIENT DETAILS --}}
                <div class="col-md-8">

                    <h4 class="mb-3">
                        {{ $patient->patient_name }}
                        <small class="text-muted">
                            ({{ $patient->patient_code ?? 'N/A' }})
                        </small>
                    </h4>

                    <hr>

                    {{-- BASIC INFO --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Father:</strong> {{ $patient->patient_f_name ?? 'N/A' }}</p>
                            <p><strong>Mother:</strong> {{ $patient->patient_m_name ?? 'N/A' }}</p>
                            <p><strong>Age:</strong> {{ $patient->age ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Gender:</strong>
                                <span class="text-uppercase">
                                    {{ $patient->gender ?? 'N/A' }}
                                </span>
                            </p>
                            <p><strong>Registered On:</strong> {{ $patient->date_of_patient_added?->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    {{-- CONTACT --}}
                    <h6 class="mb-2">Contact Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> {{ $patient->phone_1 }}</p>
                            <p><strong>Alt Phone:</strong> {{ $patient->phone_2 ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Father Phone:</strong> {{ $patient->phone_f_1 ?? 'N/A' }}</p>
                            <p><strong>Mother Phone:</strong> {{ $patient->phone_m_1 ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-2">Location</h6>
                    @if ($patient->location_type == 1)
                        <p>{{ $patient->location_simple }}</p>
                    @elseif ($patient->location_type == 2)
                        <p>
                            {{ $patient->house_address }}<br>
                            {{ $patient->city }}, {{ $patient->district }} - {{ $patient->post_code }}
                        </p>
                    @else
                        <p>
                            {{ $patient->country }} <br>
                            Passport: {{ $patient->passport_no }}
                        </p>
                    @endif

                    <hr>

                    {{-- RECOMMENDATION --}}
                    <h6 class="text-muted mb-2">Doctor Recommendation</h6>
                    @if ($patient->is_recommend)
                        <p><strong>Doctor:</strong> {{ $patient->recommend_doctor_name }}</p>
                        <p class="mb-0">{{ $patient->recommend_note }}</p>
                    @else
                        <p class="text-muted">Not Recommended</p>
                    @endif
                </div>

                {{-- RIGHT: PATIENT PHOTO --}}
                <div class="col-md-4 text-center">

                    <div class="border rounded p-2 mb-3" style="width:220px;height:220px;margin:auto;">
                        <img src="{{ $patient->photo_path ? asset($patient->photo_path) : asset('images/patient_placeholder.png') }}"
                            alt="Patient Photo" class="img-fluid" style="object-fit:cover;width:100%;height:100%;">
                    </div>

                    <small class="text-muted">Patient Photo</small>

                </div>

            </div>

            <hr>

            {{-- DOCUMENTS --}}
            <h6 class="text-muted mb-2">Documents</h6>

            @if ($patient->documents->count())
                <ul class="list-unstyled">
                    @foreach ($patient->documents as $doc)
                        <li class="mb-1">
                            📄 {{ $doc->document_name ?? 'Document' }}
                            <a href="{{ asset($doc->file_path) }}" target="_blank" class="ml-2">
                                View
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No documents uploaded.</p>
            @endif

            <hr>

            {{-- MEDICAL NOTES --}}
            <h6 class="mb-2">Medical Notes</h6>
            <p><strong>Problem:</strong> {{ $patient->patient_problem_description ?? 'N/A' }}</p>
            <p><strong>Drug Description:</strong> {{ $patient->patient_drug_description ?? 'N/A' }}</p>

            <hr>

            {{-- REMARKS --}}
            <h6 class="text-muted mb-2">Remarks</h6>
            <p>{{ $patient->remarks ?? 'No remarks' }}</p>

        </div>
    </div>

@stop
