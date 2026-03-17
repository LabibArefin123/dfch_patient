@extends('adminlte::page')

@section('title', 'Ban Device')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Create Banned Device</h1>

        <a href="{{ route('banned_devices.index') }}" class="back-btn btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('banned_devices.store') }}">
                @csrf
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>IP Address</label>
                        <input type="text" name="ip_address" class="form-control" value="{{ $device['ip_address'] }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Device Name</label>
                        <input type="text" name="device_name" class="form-control" value="{{ $device['device_name'] }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Device Type (OS + Browser)</label>
                        <input type="text" name="device_type" class="form-control" value="{{ $device['device_type'] }}">
                    </div>

                    <!-- Hidden User Agent -->
                    <input type="hidden" name="user_agent" value="{{ $device['user_agent'] }}">

                    <div class="col-md-6 form-group">
                        <label>User</label>
                        <select name="user_id" class="form-control select2">
                            <option value="">None</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Banned</option>
                            <option value="0">Allow</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Reason</label>
                        <input type="text" name="reason" class="form-control">
                    </div>

                </div>

                <br>

                <button class="btn btn-success">Save</button>

            </form>

        </div>

    </div>

@stop
@push('js')
    <script>
        $('.select2').select2({
            placeholder: "Select user",
            allowClear: true
        });
    </script>
@endpush
