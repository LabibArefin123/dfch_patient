@extends('adminlte::page')

@section('title', 'Add Patient Cancer Report')

@section('plugins.Select2', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1><i class="fas fa-x-ray text-danger"></i> Add Patient Cancer Report</h1>
        <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/patient_search.css') }}">
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
                                        <select name="patient_id" id="patientSelect" class="form-control" required>
                                            <option value="">Select Patient</option>

                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    data-name="{{ strtolower($patient->patient_name) }}"
                                                    data-code="{{ strtolower($patient->patient_code) }}"
                                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->patient_name }}{{ $patient->patient_code ? ' (' . $patient->patient_code . ')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        Search by patient name or patient code. First 15 patients are shown initially.
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
                                            value="{{ old('total_cancer', 1) }}" placeholder="Enter total cancer count"
                                            required>
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
                                <label>Remarks</label>
                                <textarea name="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
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
                        X-Ray Descriptions
                    </h5>

                    <div id="descriptionArea">

                        <div class="input-group mb-2">

                            <input type="text" name="xray_description[]" class="form-control"
                                placeholder="Enter X-Ray Description">

                            <div class="input-group-append">

                                <button type="button" class="btn btn-success" id="addDescription">

                                    <i class="fas fa-plus"></i>

                                </button>

                            </div>

                        </div>

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
    <script>
        $(function() {

            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            $('#addDescription').click(function() {

                $('#descriptionArea').append(`
                <div class="input-group mb-2">
                <input type="text" name="xray_description[]" class="form-control" placeholder="Enter X-Ray Description">
                <div class="input-group-append">
                <button type="button" class="btn btn-danger removeDescription">
                <i class="fas fa-trash"></i>
                </button>
                </div>
                </div>
                `);

            });

            $(document).on('click', '.removeDescription', function() {
                $(this).closest('.input-group').remove();
            });

            $('#xray_photo').change(function() {

                $('#previewContainer').html('');

                if (this.files) {

                    Array.from(this.files).forEach(function(file) {

                        let reader = new FileReader();

                        reader.onload = function(e) {

                            $('#previewContainer').append(`
                            <div class="col-md-3 mb-3">
                            <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height:220px;object-fit:cover;">
                            <div class="card-footer text-center">
                            <small class="text-muted">${file.name}</small>
                            </div>
                            </div>
                            </div>
                            `);

                        }

                        reader.readAsDataURL(file);

                    });

                }

            });

        });
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_select_search.js') }}"></script>
@stop
