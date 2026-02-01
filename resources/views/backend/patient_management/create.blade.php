@extends('adminlte::page')

@section('title', 'Add Patient')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Add Patient</h1>
        <a href="{{ route('patients.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0 back-btn">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')
    {{-- Validation Errors --}}
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
            <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Patient Name --}}
                    <div class="form-group col-md-6">
                        <label>Patient Name <span class="text-danger">*</span></label>
                        <input type="text" name="patient_name"
                            class="form-control @error('patient_name') is-invalid @enderror"
                            value="{{ old('patient_name') }}">
                        @error('patient_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Father Name --}}
                    <div class="form-group col-md-6">
                        <label>Father Name</label>
                        <input type="text" name="patient_f_name" class="form-control"
                            value="{{ old('patient_f_name') }}">
                    </div>

                    {{-- Mother Name --}}
                    <div class="form-group col-md-6">
                        <label>Mother Name</label>
                        <input type="text" name="patient_m_name" class="form-control"
                            value="{{ old('patient_m_name') }}">
                    </div>

                    {{-- Age --}}
                    <div class="form-group col-md-3">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control" value="{{ old('age') }}">
                    </div>

                    {{-- Gender --}}
                    <div class="form-group col-md-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    {{-- Phones --}}
                    <div class="form-group col-md-6">
                        <label>Phone 1 <span class="text-danger">*</span></label>
                        <input type="text" name="phone_1" class="form-control @error('phone_1') is-invalid @enderror"
                            value="{{ old('phone_1') }}">
                        @error('phone_1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Phone 2</label>
                        <input type="text" name="phone_2" class="form-control" value="{{ old('phone_2') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Father Phone</label>
                        <input type="text" name="phone_f_1" class="form-control" value="{{ old('phone_f_1') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Mother Phone</label>
                        <input type="text" name="phone_m_1" class="form-control" value="{{ old('phone_m_1') }}">
                    </div>

                    {{-- Location Type --}}
                    <div class="form-group col-md-6">
                        <label>Location Type <span class="text-danger">*</span></label>
                        <select name="location_type" id="location_type" class="form-control">
                            <option value="">Select</option>
                            <option value="1">Simple Location</option>
                            <option value="2">Bangladesh Address</option>
                            <option value="3">Outside Bangladesh</option>
                        </select>
                    </div>

                    {{-- Type 1 --}}
                    <div class="form-group col-md-6 location location-1 d-none">
                        <label>Location</label>
                        <textarea name="location_simple" class="form-control"></textarea>
                    </div>

                    {{-- Type 2 --}}
                    <div class="location location-2 d-none col-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>House Address</label>
                                <input type="text" name="house_address" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>District</label>
                                <input type="text" name="district" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Post Code</label>
                                <input type="text" name="post_code" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- Type 3 --}}
                    <div class="location location-3 d-none col-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Passport No</label>
                                <input type="text" name="passport_no" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- Recommendation --}}
                    <div class="form-group col-md-4">
                        <label>Recommended?</label>
                        <select name="is_recommend" id="is_recommend" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="recommend-section d-none col-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Doctor Name</label>
                                <input type="text" name="recommend_doctor_name" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Doctor Note</label>
                                <textarea name="recommend_note" class="form-control"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Recommendation Documents (PDF)</label>
                                <input type="file" name="documents[]" multiple class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- Date --}}
                    <div class="form-group col-md-6">
                        <label>Date of Registration</label>
                        <input type="date" name="date_of_patient_added" class="form-control"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="w-100"></div>

                     <div class="form-group col-md-6">
                        <label>Patient's Problem <span class="text-danger">*</span></label>
                         <textarea name="patient_problem_description" class="form-control"></textarea>
                    </div>

                     <div class="form-group col-md-6">
                        <label>Patient's Drug Description <span class="text-danger">*</span></label>
                        <textarea name="patient_drug_description" class="form-control"></textarea>
                    </div>

                    {{-- Remarks --}}
                    <div class="form-group col-md-12">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control"></textarea>
                    </div>

                </div>

                <button class="btn btn-primary mt-2">Submit</button>
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
    <script>
        $('#location_type').on('change', function() {
            $('.location').addClass('d-none');
            $('.location-' + $(this).val()).removeClass('d-none');
        });

        $('#is_recommend').on('change', function() {
            $(this).val() == 1 ?
                $('.recommend-section').removeClass('d-none') :
                $('.recommend-section').addClass('d-none');
        });
    </script>
@stop
