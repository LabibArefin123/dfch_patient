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
                    @include('backend.patient_management.partial_pages.create_page.part_1')
                    @include('backend.patient_management.partial_pages.create_page.part_2')
                    @include('backend.patient_management.partial_pages.create_page.part_3')

                    {{-- Date --}}
                    <div class="form-group col-md-6">
                        <label>Date of Registration</label>
                        <input type="date" name="date_of_patient_added" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="w-100"></div>
                    @include('backend.patient_management.partial_pages.create_page.part_4')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            ClassicEditor
                .create(document.querySelector('#patient_problem_description'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#patient_drug_description'))
                .catch(error => {
                    console.error(error);
                });

        });
    </script>
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
