@extends('adminlte::page')

@section('title', 'Edit Organization')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Organization</h3>
        <a href="{{ route('organizations.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('organizations.update', $organization->id) }}" method="POST"
                enctype="multipart/form-data" data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Organization Name --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="name">
                            Organization Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $organization->name) }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Organization Short Name --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="organization_logo_name">
                            Organization Short Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="organization_logo_name" id="organization_logo_name"
                            value="{{ old('organization_logo_name', $organization->organization_logo_name) }}"
                            class="form-control @error('organization_logo_name') is-invalid @enderror">

                        @error('organization_logo_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Organization Location --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="organization_location">
                            Organization Location <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="organization_location" id="organization_location"
                            value="{{ old('organization_location', $organization->organization_location) }}"
                            class="form-control @error('organization_location') is-invalid @enderror">

                        @error('organization_location')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Organization Slogan --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="organization_slogan">
                            Organization Slogan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="organization_slogan" id="organization_slogan"
                            value="{{ old('organization_slogan', $organization->organization_slogan) }}"
                            class="form-control @error('organization_slogan') is-invalid @enderror">
                        @error('organization_slogan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone Numbers --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="phone_1">Mobile Phone 1</label>
                        <input type="text" name="phone_1" id="phone_1"
                            value="{{ old('phone_1', $organization->phone_1) }}"
                            class="form-control @error('phone_1') is-invalid @enderror" placeholder="e.g. 01XXXXXXXXX">
                        @error('phone_1')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="phone_2">Mobile Phone 2</label>
                        <input type="text" name="phone_2" id="phone_2"
                            value="{{ old('phone_2', $organization->phone_2) }}"
                            class="form-control @error('phone_2') is-invalid @enderror" placeholder="e.g. 01XXXXXXXXX">
                        @error('phone_2')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="land_phone_1">Land Phone 1</label>
                        <input type="text" name="land_phone_1" id="land_phone_1"
                            value="{{ old('land_phone_1', $organization->land_phone_1) }}"
                            class="form-control @error('land_phone_1') is-invalid @enderror" placeholder="e.g. 02XXXXXXXX">
                        @error('land_phone_1')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="land_phone_2">Land Phone 2</label>
                        <input type="text" name="land_phone_2" id="land_phone_2"
                            value="{{ old('land_phone_2', $organization->land_phone_2) }}"
                            class="form-control @error('land_phone_2') is-invalid @enderror" placeholder="e.g. 02XXXXXXXX">
                        @error('land_phone_2')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Organization Logo / Picture --}}
                    <div class="form-group col-md-6 mb-4">
                        <label for="organization_picture">
                            Organization Logo <span class="text-danger">*</span>
                        </label>

                        <input type="file" name="organization_picture" id="organization_picture"
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                            class="form-control @error('organization_picture') is-invalid @enderror">
                        @error('organization_picture')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        {{-- File status --}}
                        @php
                            $imagePath = null;
                            if ($organization->organization_picture) {
                                foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                                    $path = public_path(
                                        'uploads/images/backend/organization/' .
                                            $organization->organization_picture .
                                            '.' .
                                            $ext,
                                    );
                                    if (file_exists($path)) {
                                        $imagePath = asset(
                                            'uploads/images/backend/organization/' .
                                                $organization->organization_picture .
                                                '.' .
                                                $ext,
                                        );
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if ($imagePath)
                            <small class="text-success d-block mt-1">
                                ✔ File found —
                                <a href="{{ $imagePath }}" target="_blank" class="fw-semibold">
                                    View logo
                                </a>
                            </small>
                        @else
                            <small class="text-danger d-block mt-1">
                                ✖ File not found
                            </small>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success px-4">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
