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

    @include('backend.patient_management.modals.edit_page.patient_image_info')
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
                    @include('backend.patient_management.partial_pages.edit_page.part_5')
                    @include('backend.patient_management.partial_pages.edit_page.part_6')
                    @include('backend.patient_management.partial_pages.edit_page.part_7')
                    @include('backend.patient_management.modals.edit_page.patient_photo_validate_modal')
                </div>

                <button class="btn btn-primary mt-2">Update</button>
            </form>

        </div>
    </div>
      <div style="height: 50px;"></div>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_edit_form.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/edit_page/patient_photo_edit_modal.js') }}"></script>
@stop
