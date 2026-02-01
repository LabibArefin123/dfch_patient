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
    <div class="row">

        {{-- BASIC INFO --}}
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Basic Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Patient Code:</strong> {{ $patient->patient_code ?? 'N/A' }}</p>
                    <p><strong>Name:</strong> {{ $patient->patient_name }}</p>
                    <p><strong>Father:</strong> {{ $patient->patient_f_name ?? 'N/A' }}</p>
                    <p><strong>Mother:</strong> {{ $patient->patient_m_name ?? 'N/A' }}</p>
                    <p><strong>Age:</strong> {{ $patient->age ?? 'N/A' }}</p>
                    <p><strong>Gender:</strong>
                        <span class="badge badge-secondary text-uppercase">
                            {{ $patient->gender ?? 'N/A' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- CONTACT --}}
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Contact Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Phone 1:</strong> {{ $patient->phone_1 }}</p>
                    <p><strong>Phone 2:</strong> {{ $patient->phone_2 ?? 'N/A' }}</p>
                    <p><strong>Father Phone:</strong> {{ $patient->phone_f_1 ?? 'N/A' }}</p>
                    <p><strong>Mother Phone:</strong> {{ $patient->phone_m_1 ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- LOCATION --}}
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Location Details</h3>
                </div>
                <div class="card-body">

                    @if ($patient->location_type == 1)
                        <p><strong>Type:</strong> Simple</p>
                        <p>{{ $patient->location_simple }}</p>
                    @elseif ($patient->location_type == 2)
                        <p><strong>Type:</strong> Bangladesh</p>
                        <p><strong>House:</strong> {{ $patient->house_address }}</p>
                        <p><strong>City:</strong> {{ $patient->city }}</p>
                        <p><strong>District:</strong> {{ $patient->district }}</p>
                        <p><strong>Post Code:</strong> {{ $patient->post_code }}</p>
                    @else
                        <p><strong>Type:</strong> Outside Bangladesh</p>
                        <p><strong>Country:</strong> {{ $patient->country }}</p>
                        <p><strong>Passport No:</strong> {{ $patient->passport_no }}</p>
                    @endif

                </div>
            </div>
        </div>

        {{-- RECOMMENDATION --}}
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Doctor Recommendation</h3>
                </div>
                <div class="card-body">

                    @if ($patient->is_recommend)
                        <p>
                            <span class="badge badge-success">Recommended</span>
                        </p>
                        <p><strong>Doctor Name:</strong> {{ $patient->recommend_doctor_name }}</p>
                        <p><strong>Note:</strong> {{ $patient->recommend_note }}</p>
                    @else
                        <span class="badge badge-secondary">Not Recommended</span>
                    @endif

                </div>
            </div>
        </div>

        {{-- DOCUMENTS --}}
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Patient Documents</h3>
                </div>
                <div class="card-body p-0">
                    @if ($patient->documents->count())
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->documents as $doc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $doc->document_name ?? 'Document' }}</td>
                                        <td>
                                            <span class="badge badge-info text-uppercase">
                                                {{ $doc->document_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="p-3 mb-0 text-muted">No documents uploaded.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- REMARKS --}}
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Patient's Problem</h3>
                </div>
                <div class="card-body">
                    {{ $patient->patient_problem_description ?? 'No remarks' }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Patient's Drug Description</h3>
                </div>
                <div class="card-body">
                    {{ $patient->patient_drug_description ?? 'No remarks' }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Remarks</h3>
                </div>
                <div class="card-body">
                    {{ $patient->remarks ?? 'No remarks' }}
                </div>
            </div>
        </div>

    </div>
      <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop
