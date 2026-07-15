
@extends('adminlte::page')

@section('title', 'Add Specialist')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-user-md text-danger"></i>
            Add Specialist
        </h1>

        <a href="{{ route('specialists.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>
@stop

@section('content')

    <div class="card card-outline card-primary shadow">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-stethoscope"></i>
                Specialist Information
            </h3>
        </div>

        <form action="{{ route('specialists.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="card-body">

                <div class="row">

                    {{-- Specialist Name --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>Name <span class="text-danger">*</span></label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Designation --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>Designation</label>

                        <input type="text" name="designation" value="{{ old('designation') }}"
                            class="form-control @error('designation') is-invalid @enderror">

                        @error('designation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Degree --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>Degree</label>

                        <input type="text" name="degree" value="{{ old('degree') }}"
                            class="form-control @error('degree') is-invalid @enderror">

                        @error('degree')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Position --}}
                    <div class="form-group col-md-3 mb-3">
                        <label>Display Position</label>

                        <input type="number" min="1" name="position" value="{{ old('position', 1) }}"
                            class="form-control @error('position') is-invalid @enderror">

                        @error('position')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group col-md-3 mb-3">
                        <label>Status</label>

                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">

                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>

                        </select>

                        @error('is_active')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Photo --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>Specialist Photo <span class="text-danger">*</span></label>

                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Image Preview --}}
                    <div class="form-group col-md-6 mb-3 text-center">

                        <label>Photo Preview</label>

                        <div>

                            <img id="previewImage" src="{{ asset('uploads/images/default.jpg') }}"
                                class="img-thumbnail shadow"
                                style="width:180px;height:220px;object-fit:contain;background:#fff;">

                        </div>

                    </div>

                    {{-- Details --}}
                    <div class="form-group col-md-12">

                        <label>Biography / Details</label>

                        <textarea name="details" rows="7" class="form-control @error('details') is-invalid @enderror">{{ old('details') }}</textarea>

                        @error('details')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Save Specialist
                </button>

                <a href="{{ route('specialists.index') }}" class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

@stop

@section('js')

    <script>
        document.getElementById('photo').addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (file) {

                document.getElementById('previewImage').src =
                    URL.createObjectURL(file);

            }

        });
    </script>

@stop

