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
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/edit_page/patient_preview.css') }}">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('backend.patient_management.modals.patient_image_info')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data"
                data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">
                    @include('backend.patient_management.partial_pages.edit_page.part_1')
                    @include('backend.patient_management.partial_pages.edit_page.part_2')
                    @include('backend.patient_management.partial_pages.edit_page.part_3')
                    @include('backend.patient_management.partial_pages.edit_page.part_4')


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
                    @include('backend.patient_management.modals.patient_photo_validate_modal')
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
   
@stop
