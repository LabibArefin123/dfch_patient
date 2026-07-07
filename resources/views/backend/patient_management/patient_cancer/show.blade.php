@extends('adminlte::page')

@section('title', 'Patient Cancer Report Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-2 mb-md-0">
            <i class="fas fa-file-medical text-danger"></i>
            Patient Cancer Report Details
        </h1>

        <div class="d-flex flex-wrap">
            <a href="{{ route('patient-cancer-photos.edit', $patientCancerPhoto->id) }}" class="btn btn-primary mr-2 mb-2">
                <i class="fas fa-edit"></i> Edit Report
            </a>

            <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary mb-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/patient_search.css') }}">

    <div class="container-fluid">

        {{-- Top Summary --}}
        <div class="row">
            {{-- Patient --}}
            <div class="col-lg-7 col-md-12 mb-3">
                <div class="card border-0 shadow-sm patient-select-card h-100">
                    <div class="card-body">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-user-injured text-primary mr-1"></i>
                            Patient
                        </label>

                        <div class="border rounded-lg p-3 bg-light">
                            <h5 class="mb-1 font-weight-bold text-dark">
                                {{ $patientCancerPhoto->patient->patient_name ?? 'N/A' }}
                            </h5>

                            @if (!empty($patientCancerPhoto->patient->patient_code))
                                <small class="text-muted">
                                    Patient Code: {{ $patientCancerPhoto->patient->patient_code }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Cancer --}}
            <div class="col-lg-5 col-md-12 mb-3">
                <div class="card border-0 shadow-sm total-cancer-card h-100">
                    <div class="card-body">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-notes-medical text-danger mr-1"></i>
                            Total Cancer
                        </label>

                        <div class="input-group cancer-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-calculator text-danger"></i>
                                </span>
                            </div>

                            <input type="text" class="form-control border-left-0 bg-white"
                                value="{{ $patientCancerPhoto->total_cancer ?? 0 }}" readonly>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Total cancer count recorded for this patient.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Remarks + Report Meta --}}
        <div class="row">
            {{-- Remarks --}}
            <div class="col-lg-8 col-md-12 mb-3">
                <div class="card card-outline card-info shadow-sm h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sticky-note text-info"></i> Remarks
                        </h3>
                    </div>

                    <div class="card-body">
                        @if (!empty($patientCancerPhoto->remarks))
                            <div class="p-3 rounded bg-light border" style="min-height: 120px; white-space: pre-line;">
                                {{ $patientCancerPhoto->remarks }}
                            </div>
                        @else
                            <div class="alert alert-light border mb-0">
                                <i class="fas fa-info-circle text-muted mr-1"></i>
                                No remarks added for this cancer report.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Report Information --}}
            <div class="col-lg-4 col-md-12 mb-3">
                <div class="card card-outline card-secondary shadow-sm h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle text-secondary"></i> Report Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Report ID</small>
                            <div class="font-weight-bold">#{{ $patientCancerPhoto->id }}</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Created At</small>
                            <div class="font-weight-bold">
                                {{ optional($patientCancerPhoto->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <div class="font-weight-bold">
                                {{ optional($patientCancerPhoto->updated_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </div>
                        </div>

                        @if (!empty($patientCancerPhoto->patient->patient_code))
                            <div class="mb-0">
                                <small class="text-muted d-block">Patient Code</small>
                                <div class="font-weight-bold">
                                    {{ $patientCancerPhoto->patient->patient_code }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- X-Ray Images --}}
        <div class="card card-danger card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-images"></i> X-Ray Images
                </h3>
            </div>

            <div class="card-body">
                @php
                    $photos = is_array($patientCancerPhoto->xray_photo) ? $patientCancerPhoto->xray_photo : [];
                @endphp

                @if (count($photos))
                    <div class="row">
                        @foreach ($photos as $photo)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card shadow-sm border-0 h-100">

                                    <img src="{{ asset($photo) }}" alt="X-Ray Image" class="card-img-top"
                                        style="height: 250px; object-fit: cover; border-radius: 0.35rem 0.35rem 0 0;">


                                    <div class="card-footer bg-white text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger previewImageBtn"
                                            data-bs-toggle="modal" data-bs-target="#imagePreviewModal"
                                            data-image="{{ asset($photo) }}">
                                            <i class="fas fa-eye"></i> View Full Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border mb-0">
                        <i class="fas fa-image text-muted mr-1"></i>
                        No X-Ray images found for this cancer report.
                    </div>
                @endif
            </div>
        </div>

        {{-- X-Ray Descriptions --}}
        <div class="card card-primary card-outline shadow-sm mt-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-notes-medical"></i> X-Ray Descriptions
                </h3>
            </div>

            <div class="card-body">
                @php
                    $descriptions = is_array($patientCancerPhoto->xray_description)
                        ? array_filter($patientCancerPhoto->xray_description, fn($item) => !empty(trim($item)))
                        : [];
                @endphp

                @if (count($descriptions))
                    <div class="row">
                        @foreach ($descriptions as $index => $description)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 bg-light h-100">
                                    <div class="mb-2 font-weight-bold text-primary">
                                        <i class="fas fa-angle-right mr-1"></i>
                                        Description {{ $index + 1 }}
                                    </div>

                                    <div class="text-dark" style="white-space: pre-line;">
                                        {{ $description }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border mb-0">
                        <i class="fas fa-info-circle text-muted mr-1"></i>
                        No X-Ray descriptions added for this report.
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer Action Buttons --}}
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="text-muted mb-2 mb-md-0">
                    <i class="fas fa-heartbeat text-danger mr-1"></i>
                    Review the report details, images, and descriptions before making any update.
                </div>
            </div>
        </div>

        <div style="height: 40px;"></div>
    </div>
@stop
