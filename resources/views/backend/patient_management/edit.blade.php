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
                            <div class="form-group col-md-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ $patient->city }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>District</label>
                                <input type="text" name="district" class="form-control"
                                    value="{{ $patient->district }}">
                            </div>
                            <div class="form-group col-md-3">
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
                            <div class="form-group col-md-6">
                                <label>Doctor Name</label>
                                <input type="text" name="recommend_doctor_name" class="form-control"
                                    value="{{ $patient->recommend_doctor_name }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Doctor Note</label>
                                <textarea name="recommend_note" class="form-control">{{ $patient->recommend_note }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Add More Documents</label>
                                <input type="file" name="documents[]" multiple class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Date</label>
                        <input type="date" name="date_of_patient_added" class="form-control"
                            value="{{ $patient->date_of_patient_added }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control">{{ $patient->remarks }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Patient's Problem</label>
                        <textarea name="patient_problem_description" id="edit_patient_problem_description" class="form-control">{!! $patient->patient_problem_description !!}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Patient's Drug Description</label>
                        <textarea name="patient_drug_description" id="edit_patient_drug_description" class="form-control">{!! $patient->patient_drug_description !!}</textarea>
                    </div>

                </div>

                <button class="btn btn-primary mt-2">Update</button>
            </form>

        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
