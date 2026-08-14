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
    <div class="container-fluid">

        {{-- Top Summary --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm patient-select-card">

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
                                    Patient Code:
                                    {{ $patientCancerPhoto->patient->patient_code }}
                                </small>
                            @endif

                        </div>

                    </div>

                </div>
            </div>

            {{-- Age --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-birthday-cake text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Personal Information
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Age
                                </h6>
                            </div>
                        </div>

                        <input type="text" class="form-control bg-light border-0"
                            value="{{ $patientCancerPhoto->patient->age ?? 'Not provided' }}" readonly>

                    </div>
                </div>
            </div>


            {{-- Primary Phone --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-phone text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Contact Information
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Primary Number
                                </h6>
                            </div>
                        </div>

                        <input type="text" class="form-control bg-light border-0"
                            value="{{ $patientCancerPhoto->patient->phone_1 ?? 'Not provided' }}" readonly>

                    </div>
                </div>
            </div>


            {{-- Alternative Phone --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-phone-alt text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Contact Information
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Alternative Number
                                </h6>
                            </div>
                        </div>

                        <input type="text" class="form-control bg-light border-0"
                            value="{{ $patientCancerPhoto->patient->phone_2 ?? 'Not provided' }}" readonly>

                    </div>
                </div>
            </div>


            {{-- Father's Number --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-male text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Family Contact
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Father's Number
                                </h6>
                            </div>
                        </div>

                        <input type="text" class="form-control bg-light border-0"
                            value="{{ $patientCancerPhoto->patient->phone_f_1 ?? 'Not provided' }}" readonly>

                    </div>
                </div>
            </div>


            {{-- Mother's Number --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-female text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Family Contact
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Mother's Number
                                </h6>
                            </div>
                        </div>

                        <input type="text" class="form-control bg-light border-0"
                            value="{{ $patientCancerPhoto->patient->phone_m_1 ?? 'Not provided' }}" readonly>

                    </div>
                </div>
            </div>


            {{-- Total Cancer --}}
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-notes-medical text-white"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Medical Information
                                </small>

                                <h6 class="mb-0 font-weight-bold text-dark">
                                    Total Cancer
                                </h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control bg-light border-0"
                                value="{{ $patientCancerPhoto->total_cancer ?? 0 }}" readonly>

                            <span class="badge badge-danger ml-2 px-3 py-2">
                                Records
                            </span>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Total cancer count recorded for this patient.
                        </small>

                    </div>
                </div>
            </div>


            {{-- Address --}}
            {{-- Location --}}
            <div class="col-md-12 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">

                        {{-- Header --}}
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center mr-3"
                                    style="width: 42px; height: 42px;">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>

                                <div>
                                    <h5 class="mb-1 font-weight-bold text-dark">
                                        Patient Location
                                    </h5>

                                    <span class="badge badge-light text-muted border">
                                        <i class="fas fa-location-arrow mr-1"></i>
                                        {{ $patientCancerPhoto->patient->display_location['type'] ?? 'Location' }}
                                    </span>
                                </div>
                            </div>

                            <span class="text-muted small">
                                <i class="fas fa-info-circle mr-1"></i>
                                Registered Address
                            </span>
                        </div>

                        @if (!empty($patientCancerPhoto->patient->display_location['fields']))

                            <div class="row">

                                @foreach ($patientCancerPhoto->patient->display_location['fields'] as $field)
                                    @php
                                        $hasValue = filled($field['value']);
                                    @endphp

                                    <div class="{{ $field['col'] ?? 'col-md-6' }} mb-3">

                                        <div class="card bg-light border-0 h-100 mb-0">
                                            <div class="card-body py-3">

                                                <div class="d-flex align-items-center mb-2">

                                                    <span class="text-danger mr-2">
                                                        <i class="{{ $field['icon'] ?? 'fas fa-map-marker-alt' }}"></i>
                                                    </span>

                                                    <label class="mb-0 text-muted small font-weight-bold text-uppercase">
                                                        {{ $field['label'] }}
                                                    </label>

                                                </div>

                                                <input type="text" class="form-control border-0 bg-white shadow-sm"
                                                    value="{{ $hasValue ? $field['value'] : 'Not provided' }}" disabled>

                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-2">
                                    <i class="fas fa-map-marked-alt fa-2x"></i>
                                </div>

                                <h6 class="font-weight-bold text-dark mb-1">
                                    No Location Information
                                </h6>

                                <small class="text-muted">
                                    No registered location information is available for this patient.
                                </small>
                            </div>

                        @endif

                    </div>
                </div>
            </div>


            {{-- CLINICAL STATUS --}}
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded p-2 mr-3">
                                <i class="fas fa-clipboard-check text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold text-dark">
                                    Clinical Status
                                </h5>
                                <small class="text-muted">
                                    Referral, treatment and investigation information
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-2">
                        <div class="row">

                            {{--  REFERRED --}}
                            <div class="col-md-12 mb-3">
                                <div class="card border h-100 shadow-sm">
                                    <div class="card-body">

                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                    style="width:38px;height:38px;">
                                                    <i class="fas fa-user-md text-white"></i>
                                                </div>

                                                <div>
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Referred
                                                    </h6>
                                                    <small class="text-muted">
                                                        Referral status
                                                    </small>
                                                </div>
                                            </div>

                                            @if ($patientCancerPhoto->patient->is_referred)
                                                <span class="badge badge-success px-3 py-2">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge badge-secondary px-3 py-2">
                                                    <i class="fas fa-times mr-1"></i>
                                                    No
                                                </span>
                                            @endif
                                        </div>

                                        @if ($patientCancerPhoto->patient->is_referred)

                                            <div class="border-top pt-3">

                                                @if ($patientCancerPhoto->patient->referred_doctor_name)
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fas fa-user-md mr-1"></i>
                                                            Referred Doctor
                                                        </small>

                                                        <strong class="text-dark">
                                                            {{ $patientCancerPhoto->patient->referred_doctor_name }}
                                                        </strong>
                                                    </div>
                                                @endif

                                                @if ($patientCancerPhoto->patient->referred_note)
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fas fa-sticky-note mr-1"></i>
                                                            Referral Note
                                                        </small>

                                                        <div class="text-dark small">
                                                            {!! $patientCancerPhoto->patient->referred_note !!}
                                                        </div>
                                                    </div>
                                                @endif

                                                @php
                                                    $referralDocuments = $patientCancerPhoto->patient->documents->where(
                                                        'document_type',
                                                        'recommendation',
                                                    );

                                                    $imageExtensions = [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'webp',
                                                        'bmp',
                                                        'svg',
                                                        'jfif',
                                                    ];
                                                @endphp

                                                <div class="border-top pt-3">

                                                    <small class="text-muted d-block mb-3">
                                                        <i class="fas fa-paperclip mr-1"></i>
                                                        Supporting Documents
                                                    </small>

                                                    @if ($referralDocuments->count())

                                                        <div class="row">

                                                            @foreach ($referralDocuments as $document)
                                                                @php
                                                                    $documentUrl = asset($document->file_path);
                                                                    $extension = strtolower(
                                                                        pathinfo(
                                                                            $document->file_path,
                                                                            PATHINFO_EXTENSION,
                                                                        ),
                                                                    );
                                                                    $isImage = in_array($extension, $imageExtensions);
                                                                @endphp

                                                                <div class="col-6 mb-3">

                                                                    <div class="border rounded p-2 bg-light h-100">

                                                                        @if ($isImage)
                                                                            <img src="{{ $documentUrl }}"
                                                                                alt="{{ $document->document_name }}"
                                                                                class="img-fluid rounded border"
                                                                                style="width:100%;height:200px;object-fit:contain;cursor:pointer;"
                                                                                data-toggle="modal"
                                                                                data-target="#imageZoomModal"
                                                                                data-image="{{ $documentUrl }}">

                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-primary btn-block mt-2"
                                                                                data-toggle="modal"
                                                                                data-target="#imageZoomModal"
                                                                                data-image="{{ $documentUrl }}">
                                                                                <i class="fas fa-search-plus mr-1"></i>
                                                                                View
                                                                            </button>
                                                                        @else
                                                                            <div class="text-center py-3">
                                                                                <i class="fas fa-file-alt text-primary"
                                                                                    style="font-size:35px;"></i>

                                                                                <small class="d-block text-muted mt-2">
                                                                                    {{ strtoupper($extension) }}
                                                                                </small>
                                                                            </div>

                                                                            <a href="{{ $documentUrl }}" target="_blank"
                                                                                class="btn btn-sm btn-outline-primary btn-block">
                                                                                <i
                                                                                    class="fas fa-external-link-alt mr-1"></i>
                                                                                Open
                                                                            </a>
                                                                        @endif

                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    @else
                                                        <div class="text-muted small">
                                                            <i class="fas fa-folder-open mr-1"></i>
                                                            No supporting documents available.
                                                        </div>

                                                    @endif

                                                </div>

                                            </div>
                                        @else
                                            <div class="text-muted small border-top pt-3">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                This patient has not been referred.
                                            </div>

                                        @endif

                                    </div>
                                </div>
                            </div>


                            {{-- TREATMENT --}}
                            <div class="col-md-12 mb-3">
                                <div class="card border h-100 shadow-sm">
                                    <div class="card-body">

                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                    style="width:38px;height:38px;">
                                                    <i class="fas fa-procedures text-white"></i>
                                                </div>

                                                <div>
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Treatment
                                                    </h6>
                                                    <small class="text-muted">
                                                        Treatment status
                                                    </small>
                                                </div>
                                            </div>

                                            @if ($patientCancerPhoto->patient->is_treatment)
                                                <span class="badge badge-success px-3 py-2">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge badge-secondary px-3 py-2">
                                                    <i class="fas fa-times mr-1"></i>
                                                    No
                                                </span>
                                            @endif
                                        </div>

                                        @if ($patientCancerPhoto->patient->is_treatment)

                                            <div class="border-top pt-3">

                                                @if (!empty($patientCancerPhoto->patient->treatment_type))
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-2">
                                                            <i class="fas fa-tags mr-1"></i>
                                                            Treatment Type
                                                        </small>

                                                        @foreach ($patientCancerPhoto->patient->treatment_type as $type)
                                                            <span class="badge badge-warning mr-1 mb-1">
                                                                {{ $type }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if ($patientCancerPhoto->patient->treatment_information)
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fas fa-notes-medical mr-1"></i>
                                                            Treatment Information
                                                        </small>

                                                        <div class="text-dark small">
                                                            {!! $patientCancerPhoto->patient->treatment_information !!}
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (!empty($patientCancerPhoto->patient->treatment_images))

                                                    <div class="border-top pt-3">

                                                        <small class="text-muted d-block mb-3">
                                                            <i class="fas fa-images mr-1"></i>
                                                            Treatment Images
                                                        </small>

                                                        <div class="row">

                                                            @foreach ($patientCancerPhoto->patient->treatment_images as $image)
                                                                @php
                                                                    $imageUrl = asset($image);
                                                                @endphp

                                                                <div class="col-6 mb-3">

                                                                    <div class="border rounded p-2 bg-light">

                                                                        <img src="{{ $imageUrl }}"
                                                                            alt="Treatment Image"
                                                                            class="img-fluid rounded border"
                                                                            style="width:100%;height:200px;object-fit:contain;cursor:pointer;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageZoomModal"
                                                                            data-bs-img-src="{{ $imageUrl }}">

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-warning btn-block mt-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageZoomModal"
                                                                            data-bs-img-src="{{ $imageUrl }}">

                                                                            <i class="fas fa-search-plus mr-1"></i>
                                                                            Zoom

                                                                        </button>

                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                @else
                                                    <div class="border-top pt-3 text-muted small">
                                                        <i class="fas fa-image mr-1"></i>
                                                        No treatment images available.
                                                    </div>

                                                @endif

                                            </div>
                                        @else
                                            <div class="text-muted small border-top pt-3">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                No treatment has been recorded.
                                            </div>

                                        @endif

                                    </div>
                                </div>
                            </div>

                            {{--  INVESTIGATION --}}
                            <div class="col-md-12 mb-3">
                                <div class="card border h-100 shadow-sm">
                                    <div class="card-body">

                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                    style="width:38px;height:38px;">
                                                    <i class="fas fa-microscope text-white"></i>
                                                </div>

                                                <div>
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Investigation
                                                    </h6>
                                                    <small class="text-muted">
                                                        Investigation status
                                                    </small>
                                                </div>
                                            </div>

                                            @if ($patientCancerPhoto->patient->is_investigated)
                                                <span class="badge badge-success px-3 py-2">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge badge-secondary px-3 py-2">
                                                    <i class="fas fa-times mr-1"></i>
                                                    No
                                                </span>
                                            @endif
                                        </div>

                                        @if ($patientCancerPhoto->patient->is_investigated)

                                            <div class="border-top pt-3">

                                                @if ($patientCancerPhoto->patient->investigation_information)
                                                    <div class="mb-3">

                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fas fa-file-medical mr-1"></i>
                                                            Investigation Information
                                                        </small>

                                                        <div class="text-dark small">
                                                            {!! $patientCancerPhoto->patient->investigation_information !!}
                                                        </div>

                                                    </div>
                                                @endif

                                                @if (!empty($patientCancerPhoto->patient->investigation_images))

                                                    <div class="border-top pt-3">

                                                        <small class="text-muted d-block mb-3">
                                                            <i class="fas fa-images mr-1"></i>
                                                            Investigation Images
                                                        </small>

                                                        <div class="row">

                                                            @foreach ($patientCancerPhoto->patient->investigation_images as $image)
                                                                @php
                                                                    $imageUrl = asset($image);
                                                                @endphp

                                                                <div class="col-6 mb-3">

                                                                    <div class="border rounded p-2 bg-light">

                                                                        <img src="{{ $imageUrl }}"
                                                                            alt="Investigation Image"
                                                                            class="img-fluid rounded border"
                                                                            style="width:100%;height:200px;object-fit:contain;cursor:pointer;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageZoomModal"
                                                                            data-bs-img-src="{{ $imageUrl }}">

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-success btn-block mt-2"
                                                                            data-toggle="modal"
                                                                            data-target="#imageZoomModal"
                                                                            data-image="{{ $imageUrl }}">
                                                                            <i class="fas fa-search-plus mr-1"></i>
                                                                            Zoom
                                                                        </button>

                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                @else
                                                    <div class="border-top pt-3 text-muted small">
                                                        <i class="fas fa-image mr-1"></i>
                                                        No investigation images available.
                                                    </div>

                                                @endif

                                            </div>
                                        @else
                                            <div class="text-muted small border-top pt-3">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                No investigation has been recorded.
                                            </div>

                                        @endif

                                    </div>
                                </div>
                            </div>

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
                            @if (!empty($patientCancerPhoto->cancer_remarks))
                                <div class="p-3 rounded bg-light border"
                                    style="min-height: 120px; white-space: pre-line;">
                                    {!! $patientCancerPhoto->cancer_remarks !!}
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
                                            style="height: 250px; object-fit: contain; border-radius: 0.35rem 0.35rem 0 0;">


                                        <div class="card-footer bg-white text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                data-bs-img-src="{{ asset($photo) }}">
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
                        <i class="fas fa-notes-medical"></i>
                        X-Ray Descriptions
                    </h3>
                </div>

                <div class="card-body">
                    @if (!empty($patientCancerPhoto->xray_description))
                        <div class="p-3 rounded bg-light border" style="min-height: 120px; white-space: pre-line;">
                            {!! $patientCancerPhoto->xray_description !!}
                        </div>
                    @else
                        <div class="alert alert-light border mb-0">
                            <i class="fas fa-info-circle text-muted mr-1"></i>
                            No xray description for this cancer report.
                        </div>
                    @endif
                </div>
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
        <script src="{{ asset('js/backend/patient_management/patient_cancer/show_page/patient_data_load.js') }}"></script>
    @stop
