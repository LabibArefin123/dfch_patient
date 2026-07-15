@extends('adminlte::page')

@section('title', 'Specialist Details')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <h1>
        <i class="fas fa-user-md text-danger"></i>
        Specialist Profile
    </h1>

    <div>

        <a href="{{ route('specialists.edit',$specialist->id) }}"
           class="btn btn-primary">

            <i class="fas fa-edit"></i>
            Edit

        </a>

        <a href="{{ route('specialists.index') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Back

        </a>

    </div>

</div>

@stop

@section('content')

<div class="row">

    {{-- ================= LEFT PROFILE ================= --}}

    <div class="col-lg-4">

        <div class="card card-primary card-outline shadow">

            <div class="card-body box-profile">

                <div class="text-center">

                    <img src="{{ asset('uploads/images/welcome_page/doctors/' . $specialist->photo) }}"
                         class="img-fluid img-thumbnail"
                         style="width:230px;height:300px;object-fit:contain;background:#fff;padding:8px;">

                </div>

                <h3 class="profile-username text-center mt-3">

                    {{ $specialist->name }}

                </h3>

                <p class="text-muted text-center">

                    {{ $specialist->designation }}

                </p>

                <div class="text-center mb-3">

                    <span class="badge badge-info">

                        {{ $specialist->degree }}

                    </span>

                </div>

                <hr>

                <strong>

                    <i class="fas fa-sort-numeric-up mr-2"></i>

                    Display Position

                </strong>

                <p class="text-muted">

                    #{{ $specialist->position }}

                </p>

                <hr>

                <strong>

                    <i class="fas fa-toggle-on mr-2"></i>

                    Status

                </strong>

                <p>

                    @if($specialist->is_active)

                        <span class="badge badge-success">

                            Active

                        </span>

                    @else

                        <span class="badge badge-danger">

                            Inactive

                        </span>

                    @endif

                </p>

            </div>

        </div>

    </div>

    {{-- ================= RIGHT INFORMATION ================= --}}

    <div class="col-lg-8">

        <div class="card card-outline card-primary shadow">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-id-card"></i>

                    Specialist Information

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="220">Full Name</th>
                        <td>{{ $specialist->name }}</td>
                    </tr>

                    <tr>
                        <th>Designation</th>
                        <td>{{ $specialist->designation }}</td>
                    </tr>

                    <tr>
                        <th>Degree</th>
                        <td>{{ $specialist->degree }}</td>
                    </tr>

                    <tr>
                        <th>Slug</th>
                        <td>{{ $specialist->slug }}</td>
                    </tr>

                    <tr>
                        <th>Display Position</th>
                        <td>{{ $specialist->position }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>

                        <td>

                            @if($specialist->is_active)

                                <span class="badge badge-success">

                                    Active

                                </span>

                            @else

                                <span class="badge badge-danger">

                                    Inactive

                                </span>

                            @endif

                        </td>

                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $specialist->created_at->format('d M Y, h:i A') }}</td>
                    </tr>

                    <tr>
                        <th>Updated At</th>
                        <td>{{ $specialist->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>

                </table>

            </div>

        </div>

        <div class="card card-outline card-success shadow">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-file-medical-alt"></i>

                    Biography / Details

                </h3>

            </div>

            <div class="card-body">

                {!! $specialist->details !!}

            </div>

        </div>

    </div>

</div>

@stop

