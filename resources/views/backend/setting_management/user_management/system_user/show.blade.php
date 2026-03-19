@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="mb-0 fw-bold">User Details</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('system_users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <a href="{{ route('system_users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="card shadow border-0">

                    <!-- HEADER -->
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">Profile Information</h5>

                        <div class="ms-auto"> <!-- ensure right alignment -->
                            <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="row g-4">

                            <!-- NAME -->
                            <div class="col-md-6">
                                <label class="text-muted small">Full Name</label>
                                <div class="fw-semibold fs-6">{{ $user->name }}</div>
                            </div>

                            <!-- USERNAME -->
                            <div class="col-md-6">
                                <label class="text-muted small">Username</label>
                                <div class="fw-semibold fs-6">{{ $user->username }}</div>
                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6">
                                <label class="text-muted small">Email Address</label>
                                <div class="fw-semibold fs-6">{{ $user->email }}</div>
                            </div>

                            <!-- PHONE 1 -->
                            <div class="col-md-6">
                                <label class="text-muted small">Phone 1</label>
                                <div class="fw-semibold fs-6">
                                    {{ $user->phone_1 ?? '—' }}
                                </div>
                            </div>

                            <!-- PHONE 2 -->
                            <div class="col-md-6">
                                <label class="text-muted small">Phone 2</label>
                                <div class="fw-semibold fs-6">
                                    {{ $user->phone_2 ?? '—' }}
                                </div>
                            </div>

                            <!-- ROLE -->
                            <div class="col-md-6">
                                <label class="text-muted small">User Role</label>
                                <div>
                                    <span class="badge bg-info text-dark px-3 py-2">
                                        {{ $user->getRoleNames()->first() ?? 'Not Assigned' }}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer bg-light d-flex justify-content-end">

                        <a href="{{ route('system_users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-key"></i> Change Password
                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>
@stop
