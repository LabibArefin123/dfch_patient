@extends('adminlte::page')

@section('title', 'User Details Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">User Details</h1>
        <a href="{{ route('system_users.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0 back-btn">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone 1</label>
                            <input type="text" class="form-control" value="{{ $user->phone_1 ?? 'Not Provided' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone 2</label>
                            <input type="text" class="form-control" value="{{ $user->phone_2 ?? 'Not Provided' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>User Role</label>
                            <input type="text" class="form-control"
                                value="{{ $user->getRoleNames()->first() ?? 'Not Assigned' }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="text" class="form-control" value="{{ $user->decrypted_password }}" readonly>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@stop
