@extends('adminlte::page')

@section('title', 'Edit Patient')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Edit Patient</h1>
        <a href="{{ route('patients.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data"
                data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Patient Name --}}
                    <div class="form-group col-md-6">
                        <label>Patient's Name <span class="text-danger">*</span></label>
                        <input type="text" name="patient_name" class="form-control"
                            value="{{ old('patient_name', $patient->patient_name) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Father Name<span class="text-danger">*</span></label>
                        <input type="text" name="patient_f_name" class="form-control"
                            value="{{ old('patient_f_name', $patient->patient_f_name) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Mother Name<span class="text-danger">*</span></label>
                        <input type="text" name="patient_m_name" class="form-control"
                            value="{{ old('patient_m_name', $patient->patient_m_name) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Age<span class="text-danger">*</span></label>
                        <input type="number" name="age" class="form-control" value="{{ old('age', $patient->age) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Gender<span class="text-danger">*</span></label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Phone 1 <span class="text-danger">*</span></label>
                        <input type="text" name="phone_1" class="form-control"
                            value="{{ old('phone_1', $patient->phone_1) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Phone 2</label>
                        <input type="text" name="phone_2" class="form-control"
                            value="{{ old('phone_2', $patient->phone_2) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Father Phone</label>
                        <input type="text" name="phone_f_1" class="form-control"
                            value="{{ old('phone_f_1', $patient->phone_f_1) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Mother Phone</label>
                        <input type="text" name="phone_m_1" class="form-control"
                            value="{{ old('phone_m_1', $patient->phone_m_1) }}">
                    </div>

                    {{-- Location --}}
                    <div class="form-group col-md-6">
                        <label>Location Type *</label>
                        <select name="location_type" id="location_type" class="form-control">
                            <option value="1" {{ $patient->location_type == 1 ? 'selected' : '' }}>Simple</option>
                            <option value="2" {{ $patient->location_type == 2 ? 'selected' : '' }}>Bangladesh</option>
                            <option value="3" {{ $patient->location_type == 3 ? 'selected' : '' }}>Outside BD</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 location location-1">
                        <label>Location</label>
                        <textarea name="location_simple" class="form-control">{{ $patient->location_simple }}</textarea>
                    </div>

                    <div class="location location-2 col-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>House Address</label>
                                <input type="text" name="house_address" class="form-control"
                                    value="{{ $patient->house_address }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ $patient->city }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>District</label>
                                <input type="text" name="district" class="form-control"
                                    value="{{ $patient->district }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Post Code</label>
                                <input type="text" name="post_code" class="form-control"
                                    value="{{ $patient->post_code }}">
                            </div>
                        </div>
                    </div>

                    <div class="location location-3 col-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control"
                                    value="{{ $patient->country }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Passport No</label>
                                <input type="text" name="passport_no" class="form-control"
                                    value="{{ $patient->passport_no }}">
                            </div>
                        </div>
                    </div>

                    {{-- Recommendation --}}
                    <div class="form-group col-md-6">
                        <label>Recommended?</label>
                        <select name="is_recommend" id="is_recommend" class="form-control">
                            <option value="0" {{ !$patient->is_recommend ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $patient->is_recommend ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <div class="recommend-section col-12">
                        <div class="row">

                            <!-- Doctor Name -->
                            <div class="form-group col-md-6">
                                <label>Doctor Name</label>
                                <input type="text" name="recommend_doctor_name" class="form-control"
                                    value="{{ $patient->recommend_doctor_name }}">
                            </div>

                            <!-- Doctor Note -->
                            <div class="form-group col-md-6">
                                <label>Doctor's Note</label>
                                <textarea name="recommend_note" id="edit_recommend_note" class="form-control">{!! $patient->recommend_note !!}</textarea>
                            </div>

                            <!-- Existing Documents -->
                            <div class="form-group col-md-12">
                                <label>Patient Documents</label>

                                <div class="card p-2" style="min-height:100px;">
                                    @php
                                        $documents = $patient->documents->where('document_type', 'recommendation');
                                    @endphp

                                    @if ($documents->count() > 0)
                                        <ul class="list-group">
                                            @foreach ($documents as $doc)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $doc->document_name }}</span>

                                                    <a href="{{ asset($doc->file_path) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center text-muted">
                                            No file available
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Upload New Documents -->
                            <div class="form-group col-md-6">
                                <label>Add More Documents</label>
                                <input type="file" name="documents[]" multiple class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date</label>

                                <input type="date" name="date_of_patient_added"
                                    class="form-control @error('date_of_patient_added') is-invalid @enderror"
                                    value="{{ old('date_of_patient_added', $patient->date_of_patient_added ? \Carbon\Carbon::parse($patient->date_of_patient_added)->format('Y-m-d') : '') }}">

                                @error('date_of_patient_added')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <label>Remarks</label>
                        <textarea name="remarks" id="edit_remarks" class="form-control">{!! $patient->remarks !!}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Patient's Problem</label>
                        <textarea name="patient_problem_description" id="edit_patient_problem_description" class="form-control">{!! $patient->patient_problem_description !!}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Patient's Drug Description</label>
                        <textarea name="patient_drug_description" id="edit_patient_drug_description" class="form-control">{!! $patient->patient_drug_description !!}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <style>
                            .progress-circle {
                                width: 90px;
                                height: 90px;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-weight: 600;
                                margin: auto;
                                background: conic-gradient(#28a745 0%, #e9ecef 0%);
                                transition: 0.4s ease;
                            }
                        </style>

                        <label class="font-weight-bold">Patient Photo</label>

                        <div class="card shadow-sm p-3 text-center">

                            <!-- Image Preview -->
                            <div class="mb-3">
                                <img id="mainPreview"
                                    src="{{ $patient->patient_photo ? asset($patient->patient_photo) : 'https://via.placeholder.com/150' }}"
                                    class="rounded-circle shadow"
                                    style="width:140px;height:140px;object-fit:cover;border:3px solid #eee;">
                            </div>

                            <!-- Hidden REAL input (IMPORTANT) -->
                            <input type="file" name="patient_photo" id="hiddenPhotoInput" hidden>

                            <!-- Action Button -->
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#photoModal">
                                <i class="fa fa-upload"></i> Change Photo
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="photoModal">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content p-4">

                                <h5 class="mb-3 text-center">Upload Patient Photo</h5>

                                <!-- Select File -->
                                <input type="file" id="photoInput" class="form-control mb-3">

                                <!-- Preview -->
                                <div class="text-center mb-3">
                                    <img id="previewImage" class="rounded shadow" style="max-width:180px; display:none;">
                                </div>

                                <!-- Progress -->
                                <div class="text-center mb-3">
                                    <div class="progress-circle" id="progressCircle">0%</div>
                                </div>

                                <!-- Info -->
                                <div id="fileInfo" class="small text-muted text-center mb-3"></div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirmUpload" class="btn btn-success btn-sm" disabled>
                                        ✔ Use This Photo
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-2">Update</button>
            </form>

        </div>
    </div>
    <div class="card mt-4">
        <div style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let selectedFile = null;

        const photoInput = document.getElementById('photoInput');
        const hiddenInput = document.getElementById('hiddenPhotoInput');
        const confirmBtn = document.getElementById('confirmUpload');
        const preview = document.getElementById('previewImage');
        const mainPreview = document.getElementById('mainPreview');

        photoInput.addEventListener('change', function(e) {

            const file = e.target.files[0];
            if (!file) return;

            selectedFile = file;

            const img = new Image();
            const reader = new FileReader();

            reader.onload = function(event) {
                img.src = event.target.result;
                preview.src = img.src;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);

            img.onload = function() {

                let percent = 0;

                // TYPE
                if (['image/jpeg', 'image/png'].includes(file.type)) percent += 25;

                // SIZE (2MB)
                if (file.size <= 2 * 1024 * 1024) percent += 25;

                // DIMENSION
                let type = '';
                if (img.width === img.height) type = 'Square';
                else if (img.height > img.width) type = 'Portrait';
                else type = 'Landscape';
                percent += 25;

                // LOAD
                percent += 25;

                // UI update
                document.getElementById('progressCircle').innerText = percent + '%';
                document.getElementById('progressCircle').style.background =
                    `conic-gradient(#28a745 ${percent}%, #e9ecef ${percent}%)`;

                document.getElementById('fileInfo').innerHTML = `
            <b>Size:</b> ${(file.size/1024).toFixed(1)} KB <br>
            <b>Type:</b> ${file.type} <br>
            <b>Dimension:</b> ${img.width} x ${img.height} (${type})
        `;

                confirmBtn.disabled = (percent !== 100);
            };
        });


        // ✅ FINAL FIX (IMPORTANT)
        confirmBtn.addEventListener('click', function() {

            if (!selectedFile) return;

            // Put file into real input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(selectedFile);
            hiddenInput.files = dataTransfer.files;

            // Update main preview
            mainPreview.src = URL.createObjectURL(selectedFile);

            // Close modal
            $('#photoModal').modal('hide');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            if (document.querySelector('#edit_remarks')) {
                ClassicEditor.create(
                    document.querySelector('#edit_remarks'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'bulletedList', 'numberedList', '|',
                            'undo', 'redo'
                        ]
                    }
                );
            }

            if (document.querySelector('#edit_recommend_note')) {
                ClassicEditor.create(
                    document.querySelector('#edit_recommend_note'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'bulletedList', 'numberedList', '|',
                            'undo', 'redo'
                        ]
                    }
                );
            }

            if (document.querySelector('#edit_patient_problem_description')) {
                ClassicEditor.create(
                    document.querySelector('#edit_patient_problem_description'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'bulletedList', 'numberedList', '|',
                            'undo', 'redo'
                        ]
                    }
                );
            }

            if (document.querySelector('#edit_patient_drug_description')) {
                ClassicEditor.create(
                    document.querySelector('#edit_patient_drug_description'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'bulletedList', 'numberedList', '|',
                            'undo', 'redo'
                        ]
                    }
                );
            }

        });
    </script>
    <script>
        function toggleLocation() {
            $('.location').hide();
            $('.location-' + $('#location_type').val()).show();
        }

        function toggleRecommend() {
            $('#is_recommend').val() == 1 ?
                $('.recommend-section').show() :
                $('.recommend-section').hide();
        }

        toggleLocation();
        toggleRecommend();

        $('#location_type').change(toggleLocation);
        $('#is_recommend').change(toggleRecommend);
    </script>
@stop
