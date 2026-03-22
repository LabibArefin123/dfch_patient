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

                        <style>
                            .badge.bg-success {
                                box-shadow: 0 0 8px rgba(40, 167, 69, 0.6);
                            }
                        </style>
                        <h5 class="mb-0 fw-semibold">Profile Information</h5>

                        <div class="ms-auto text-end">

                            <span class="badge {{ $user->is_online ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas fa-circle me-1" style="font-size:8px;"></i>
                                {{ $user->is_online ? 'Online' : 'Offline' }}
                            </span>

                            <div class="small text-muted">
                                {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Never active' }}
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small">Full Name</label>
                                <div class="fw-semibold fs-6">{{ $user->name }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Username</label>
                                <div class="fw-semibold fs-6">{{ $user->username }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Email Address</label>
                                <div class="fw-semibold fs-6">{{ $user->email }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Phone 1</label>
                                <div class="fw-semibold fs-6">
                                    {{ $user->phone_1 ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Phone 2</label>
                                <div class="fw-semibold fs-6">
                                    {{ $user->phone_2 ?? '—' }}
                                </div>
                            </div>

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
                </div>
            </div>
        </div>
    </div>
@stop
