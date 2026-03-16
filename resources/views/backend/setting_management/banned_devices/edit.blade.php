@extends('adminlte::page')

@section('title', 'Edit Banned Device')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Banned Device</h1>

        <a href="{{ route('banned_devices.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('banned_devices.update', $device->id) }}">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>IP Address</label>
                        <input type="text" name="ip_address" class="form-control" value="{{ $device->ip_address }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Device Name</label>
                        <input type="text" name="device_name" class="form-control" value="{{ $device->device_name }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Device Type</label>
                        <input type="text" name="device_type" class="form-control" value="{{ $device->device_type }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>User</label>
                        <select name="user_id" class="form-control">

                            <option value="">None</option>

                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}" {{ $device->user_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div class="col-md-6 form-group">
                        <label>Status</label>

                        <select name="is_active" class="form-control">

                            <option value="1" {{ $device->is_active == 1 ? 'selected' : '' }}>
                                Banned
                            </option>

                            <option value="0" {{ $device->is_active == 0 ? 'selected' : '' }}>
                                Allow
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6 form-group">
                        <label>Reason</label>
                        <input type="text" name="reason" value="{{ $device->reason }}" class="form-control">
                    </div>

                </div>

                <br>

                <button class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>

            </form>

        </div>

    </div>

@stop
