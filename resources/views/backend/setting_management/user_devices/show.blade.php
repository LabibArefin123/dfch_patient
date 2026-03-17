@extends('adminlte::page')

@section('title', 'Device Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Device Details</h1>
        <a href="{{ route('user_devices.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                <!-- User -->
                <div class="col-md-6 form-group">
                    <label><b>User</b></label>
                    <input type="text" class="form-control" value="{{ $device->user->name ?? '-' }}" disabled>
                </div>

                <!-- IP Address -->
                <div class="col-md-6 form-group">
                    <label><b>IP Address</b></label>
                    <input type="text" class="form-control" value="{{ $device->ip_address }}" disabled>
                </div>

                <!-- Device Name -->
                <div class="col-md-6 form-group">
                    <label><b>Device Name</b></label>
                    <input type="text" class="form-control" value="{{ $device->device_name ?? '-' }}" disabled>
                </div>

                <!-- Device Type -->
                <div class="col-md-6 form-group">
                    <label><b>Device Type (OS + Browser)</b></label>
                    <input type="text" class="form-control" value="{{ $device->device_type ?? '-' }}" disabled>
                </div>

                <!-- Last Login -->
                <div class="col-md-6 form-group">
                    <label><b>Last Login</b></label>
                    <input type="text" class="form-control"
                        value="{{ $device->last_login_at ? $device->last_login_at->format('d M Y H:i') : '-' }}" disabled>
                </div>

                <!-- Status -->
                <div class="col-md-6 form-group">
                    <label><b>Status</b></label><br>
                    @if ($device->is_banned)
                        <span class="badge badge-danger">Banned</span>
                    @else
                        <span class="badge badge-success">Active</span>
                    @endif
                </div>

                <!-- User Agent -->
                <div class="col-md-12 form-group">
                    <label><b>User Agent</b></label>
                    <textarea class="form-control" rows="3" disabled>{{ $device->user_agent }}</textarea>
                </div>

            </div>

            <div class="mt-3">
                <a href="{{ route('user_devices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
@stop
