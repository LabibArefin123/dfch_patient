@extends('adminlte::page')

@section('title', 'View Banned Device')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Banned Device Details</h1>
        <div>
            <a href="{{ route('banned_devices.edit', $device->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('banned_devices.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop



@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>IP Address</label>
                    <input type="text" class="form-control" value="{{ $device->ip_address }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Device Name</label>
                    <input type="text" class="form-control" value="{{ $device->device_name }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Device Type</label>
                    <input type="text" class="form-control" value="{{ $device->device_type }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>User</label>
                    <input type="text" class="form-control" value="{{ optional($device->user)->name }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $device->is_active ? 'Banned' : 'Allow' }}"
                        disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Reason</label>
                    <input type="text" class="form-control" value="{{ $device->reason }}" disabled>
                </div>
            </div>
        </div>
    </div>
@stop
