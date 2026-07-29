@extends('adminlte::page')

@section('title', 'Add Patient Cancer Report')

@section('plugins.Select2', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1><i class="fas fa-x-ray text-danger"></i> Add Patient Cancer Report</h1>
        <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/create_page/patient_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/create_page/patient_cancer_select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/create_page/patient_cancer_info.css') }}">
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
                <h3 class="card-title"><i class="fas fa-file-medical"></i> Cancer Report Information</h3>
            </div>

            <form action="{{ route('patient-cancer-photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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

                                        <select name="patient_id" id="patientSelect" class="form-control">

                                            <option value="">Select Patient</option>

                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    data-name="{{ strtolower($patient->patient_name) }}"
                                                    data-code="{{ strtolower($patient->patient_code) }}"
                                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                                                    {{ $patient->patient_name }}

                                                    {{ $patient->patient_code ? ' (' . $patient->patient_code . ')' : '' }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-search mr-1"></i>
                                        Search by patient name or patient code.
                                        First 15 patients are shown initially.
                                    </small>



                                </div>
                            </div>
                        </div>

                        <div class="card mt-3 shadow-sm" id="patientInfoCard">
                            <div class="card-header">
                                <strong>
                                    Patient Information
                                </strong>
                            </div>

                            <div class="card-body">
                                <div id="patientInformation">
                                    <div class="patient-empty-state">
                                        <div class="patient-empty-state-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <h5>Select a Patient</h5>
                                        <p> Search and select a patient to view details.</p>
                                    </div>
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
                                            value="{{ old('total_cancer', 1) }}" placeholder="Enter total cancer count">
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        Enter the total cancer count for the selected patient.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-comment-medical text-info mr-1"></i>
                                    Patient Cancer Remarks
                                </label>
                                <textarea name="cancer_remarks" id="cancer_remarks" class="form-control" rows="6">{!! old('cancer_remarks') !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="text-danger">
                        <i class="fas fa-images"></i>
                        Upload X-Ray Images
                    </h5>

                    <div class="form-group">
                        <label>Select X-Ray Images</label>
                        <input type="file" name="xray_photo[]" id="xray_photo" class="form-control" multiple
                            accept="image/*">
                        <small class="text-muted">
                            You can select multiple X-Ray images.
                        </small>
                    </div>

                    <div class="row" id="previewContainer"></div>

                    <hr>

                    <h5 class="text-primary">
                        <i class="fas fa-notes-medical"></i>
                        X-Ray Description
                    </h5>

                    <div class="form-group">

                        <textarea name="xray_description[]" id="xray_description" class="form-control" rows="8"
                            placeholder="Enter detailed X-Ray description...">{!! old('xray_description.0') !!}</textarea>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Report
                        </button>
                        <button type="reset" class="btn btn-warning">
                            <i class="fas fa-redo"></i> Reset
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
    <script src="{{ asset('js/backend/patient_management/patient_cancer/create_page/patient_cancer_editor.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/create_page/patient-cancer-image-preview.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_init.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_events.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_dropdown.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_helpers.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search/patient_search_filter.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/create_page/patient_cancer_ajax.js') }}"></script>
@endsection
