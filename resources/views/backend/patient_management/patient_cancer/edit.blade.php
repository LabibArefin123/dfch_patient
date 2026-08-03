@extends('adminlte::page')

@section('title', 'Edit Patient Cancer Report')

@section('plugins.Select2', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-x-ray text-danger"></i> Edit Patient Cancer Report</h1>
        <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/patient_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/edit_page/patient_cancer_card.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_cancer/edit_page/patient_cancer_gallery.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_cancer/edit_page/patient_cancer_preview.css') }}">

    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-medical"></i> Cancer Report Information
                </h3>
            </div>

            <form action="{{ route('patient-cancer-photos.update', $patientCancerPhoto->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        {{-- Patient --}}
                        <div class="col-lg-7 col-md-12 mb-3">
                            <div class="card border-0 shadow-sm patient-select-card h-100">
                                <div class="card-body">
                                    <label for="patientSelect" class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-user-injured text-primary mr-1"></i>
                                        Patient <span class="text-danger">*</span>
                                    </label>

                                    <div class="patient-select-wrapper">
                                        <select name="patient_id" id="patientSelect" class="form-control" required disabled>
                                            <option value="{{ $patientCancerPhoto->patient->id }}" selected>
                                                {{ $patientCancerPhoto->patient->patient_name }}
                                                {{ $patientCancerPhoto->patient->patient_code ? ' (' . $patientCancerPhoto->patient->patient_code . ')' : '' }}
                                            </option>
                                        </select>

                                        {{-- If you ever submit this form, disabled fields are not submitted --}}
                                        <input type="hidden" name="patient_id"
                                            value="{{ $patientCancerPhoto->patient->id }}">
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        The patient associated with this cancer report is displayed below and cannot be
                                        changed.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Total Cancer --}}
                        <div class="col-lg-5 col-md-12 mb-3">
                            <div class="card border-0 shadow-sm total-cancer-card h-100">
                                <div class="card-body">
                                    <label for="total_cancer" class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-notes-medical text-danger mr-1"></i>
                                        Total Cancer <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group cancer-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0">
                                                <i class="fas fa-calculator text-danger"></i>
                                            </span>
                                        </div>
                                        <input type="number" name="total_cancer" id="total_cancer"
                                            class="form-control border-left-0" min="0"
                                            value="{{ old('total_cancer', $patientCancerPhoto->total_cancer) }}"
                                            placeholder="Enter total cancer count" required>
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        Enter the total cancer count for the selected patient.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Patient Cancer Remarks</label>
                                <textarea name="cancer_remarks" id="cancer_remarks" class="form-control" rows="6">{!! old('cancer_remarks', $patientCancerPhoto->cancer_remarks) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    {{-- Existing Images --}}
                    <h5 class="text-danger">
                        <i class="fas fa-images"></i>
                        Existing X-Ray Images
                    </h5>


                    @if (count($oldPhotos))
                        <div class="row" id="existingImageContainer">
                            @foreach ($oldPhotos as $photoIndex => $photo)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 existing-image-card">
                                    <div class="card preview-card shadow-sm border-0">
                                        <a href="{{ asset($photo) }}" target="_blank">
                                            <img src="{{ asset($photo) }}" class="card-img-top preview-image">
                                        </a>


                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock mr-1"></i>

                                                    @if ($photoLastUpdated[$photo])
                                                        {{ $photoLastUpdated[$photo]->format('d M Y') }}
                                                        <span class="mx-1">•</span>
                                                        {{ $photoLastUpdated[$photo]->format('h:i A') }}
                                                    @else
                                                        Unknown
                                                    @endif
                                                </small>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input delete-image-checkbox" type="checkbox"
                                                    name="delete_images[]" value="{{ $photo }}"
                                                    id="delete_image_{{ $photoIndex }}">

                                                <label class="form-check-label text-danger"
                                                    for="delete_image_{{ $photoIndex }}">
                                                    Delete Image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light border">
                            <i class="fas fa-image mr-2"></i>
                            No existing cancer images found.
                        </div>
                    @endif

                    {{-- Upload New Images --}}
                    <h5 class="text-danger">
                        <i class="fas fa-upload"></i>
                        Upload New X-Ray Images
                    </h5>

                    <div class="form-group">
                        <label>Select New X-Ray Images</label>
                        <input type="file" name="xray_photo[]" id="xray_photo" class="form-control" multiple
                            accept="image/*">
                        <small class="text-muted">
                            You can upload multiple new X-Ray images. Selected images will be previewed below.
                        </small>
                    </div>

                    <div id="previewContainer" class="row mt-3"></div>

                    <hr>

                    {{-- X-Ray Descriptions --}}
                    <div class="form-group">
                        <label for="xray_description">
                            <i class="fas fa-notes-medical mr-1"></i>
                            X-Ray Description
                        </label>

                        <textarea name="xray_description" id="xray_description" class="form-control xray-description-editor" rows="5"
                            placeholder="Enter X-Ray Description">{!! old('xray_description', $patientCancerPhoto->xray_description) !!}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Report
                    </button>

                    <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div style="height: 50px;"></div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/edit_page/patient_cancer_editor.js') }}"></script>
    <script
        src="{{ asset('js/backend/patient_management/patient_cancer/edit_page/patient-cancer-edit-image-preview.js') }}">
    </script>
    <script
        src="{{ asset('js/backend/patient_management/patient_cancer/edit_page/patient_cancer_old_image_destroy.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_init.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_events.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_dropdown.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_helpers.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_filter.js') }}"></script>
@endsection
