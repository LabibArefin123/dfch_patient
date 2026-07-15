@extends('adminlte::page')

@section('title', 'Edit Specialist')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-user-edit text-primary"></i>
            Edit Specialist
        </h1>

        <a href="{{ route('specialists.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>
@stop

@section('content')

    <form action="{{ route('specialists.update', $specialist->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- ================= LEFT PROFILE ================= --}}
            <div class="col-lg-4">

                <div class="card card-primary card-outline shadow">

                    <div class="card-body box-profile">

                        <div class="text-center">

                            @php
                                $photo = asset('uploads/images/welcome_page/doctors/' . $specialist->photo);
                            @endphp

                            <img id="previewImage" src="{{ $photo }}" class="img-fluid img-thumbnail"
                                style="width:220px;height:280px;object-fit:contain;background:#fff;padding:8px;">

                        </div>

                        <h3 class="profile-username text-center mt-3">
                            {{ $specialist->name }}
                        </h3>

                        <p class="text-muted text-center mb-1">
                            {{ $specialist->designation }}
                        </p>

                        <p class="text-center">

                            <span class="badge badge-info">
                                {{ $specialist->degree }}
                            </span>

                        </p>

                        <hr>

                        <strong>
                            <i class="fas fa-sort-numeric-up"></i>
                            Display Position
                        </strong>

                        <p class="text-muted">

                            #{{ $specialist->position }}

                        </p>

                        <strong>
                            <i class="fas fa-check-circle"></i>
                            Status
                        </strong>

                        <p>

                            @if ($specialist->is_active)
                                <span class="badge badge-success">
                                    Active
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    Inactive
                                </span>
                            @endif

                        </p>

                        <hr>

                        <label>
                            Change Photo
                        </label>

                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <span class="invalid-feedback d-block">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

            {{-- ================= RIGHT CONTENT ================= --}}
            <div class="col-lg-8">

                <div class="card card-outline card-primary shadow">

                    <div class="card-header">

                        <h3 class="card-title">

                            <i class="fas fa-id-card"></i>

                            Specialist Profile

                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Name --}}
                            <div class="form-group col-md-6">

                                <label>

                                    Full Name

                                </label>

                                <input type="text" name="name" value="{{ old('name', $specialist->name) }}"
                                    class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- Designation --}}
                            <div class="form-group col-md-6">

                                <label>

                                    Designation

                                </label>

                                <input type="text" name="designation"
                                    value="{{ old('designation', $specialist->designation) }}"
                                    class="form-control @error('designation') is-invalid @enderror">

                                @error('designation')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- Degree --}}
                            <div class="form-group col-md-6">

                                <label>

                                    Degree

                                </label>

                                <input type="text" name="degree" value="{{ old('degree', $specialist->degree) }}"
                                    class="form-control @error('degree') is-invalid @enderror">

                                @error('degree')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- Position --}}
                            <div class="form-group col-md-3">

                                <label>

                                    Position

                                </label>

                                <input type="number" name="position" value="{{ old('position', $specialist->position) }}"
                                    class="form-control @error('position') is-invalid @enderror">

                                @error('position')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- Status --}}
                            <div class="form-group col-md-3">

                                <label>

                                    Status

                                </label>

                                <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">

                                    <option value="1"
                                        {{ old('is_active', $specialist->is_active) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0"
                                        {{ old('is_active', $specialist->is_active) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                                @error('is_active')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- Biography --}}
                            <div class="form-group col-md-12">

                                <label>

                                    Biography / Details

                                </label>

                                <textarea name="details" rows="10" class="form-control @error('details') is-invalid @enderror">{{ old('details', $specialist->details) }}</textarea>

                                @error('details')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <div>

                            <button class="btn btn-success">

                                <i class="fas fa-save"></i>

                                Update Specialist

                            </button>

                            <a href="{{ route('specialists.index') }}" class="btn btn-secondary">

                                Cancel

                            </a>

                        </div>

                        <button type="button" class="btn btn-danger"
                            onclick="if(confirm('Delete this specialist?')){document.getElementById('deleteForm').submit();}">

                            <i class="fas fa-trash"></i>

                            Delete

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <form id="deleteForm" action="{{ route('specialists.destroy', $specialist->id) }}" method="POST">

        @csrf
        @method('DELETE')

    </form>

@stop

@section('js')

    <script>
        document.getElementById('photo').addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (file) {

                document.getElementById('previewImage').src = URL.createObjectURL(file);

            }

        });
    </script>

@stop

