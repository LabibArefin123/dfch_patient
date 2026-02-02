@extends('adminlte::page')

@section('title', 'Organization Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Organization Details</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Logo Name</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_logo_name }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $organization->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Slogan</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_slogan }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Location</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_location }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Organization Logo</label>

                        @php
                            $filePath = null;
                            $fileType = null;

                            if ($organization->organization_picture) {
                                foreach (['jpg', 'jpeg', 'png', 'webp', 'pdf'] as $ext) {
                                    $path = public_path(
                                        'uploads/images/backend/organization/' .
                                            $organization->organization_picture .
                                            '.' .
                                            $ext,
                                    );

                                    if (file_exists($path)) {
                                        $filePath = asset(
                                            'uploads/images/backend/organization/' .
                                                $organization->organization_picture .
                                                '.' .
                                                $ext,
                                        );
                                        $fileType = $ext;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        <div class="mt-2">
                            @if ($filePath)
                                @if ($fileType === 'pdf')
                                    <a href="{{ $filePath }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        View PDF
                                    </a>
                                @else
                                    <a href="{{ $filePath }}" target="_blank">
                                        <img src="{{ $filePath }}" alt="Organization Logo"
                                            style="width:350px; height:75px;">
                                    </a>
                                @endif
                            @else
                                <span class="badge bg-danger">No File Available</span>
                            @endif
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@stop
