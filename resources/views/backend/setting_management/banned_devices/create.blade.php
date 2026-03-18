@extends('adminlte::page')

@section('title', 'Ban Device')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-ban text-danger"></i> Create Banned Device
        </h4>

        <a href="{{ route('banned_devices.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('banned_devices.store') }}">
                @csrf

                <div class="row">

                    {{-- DEVICE INFO --}}
                    <div class="col-md-6">
                        <div class="card border-left-primary shadow-sm h-100">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-desktop"></i> Device Info</strong>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label>IP Address</label>
                                    <input type="text" name="ip_address" class="form-control form-control-sm"
                                        value="{{ $device['ip_address'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Device Name</label>
                                    <input type="text" name="device_name" class="form-control form-control-sm"
                                        value="{{ $device['device_name'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Device Type</label>
                                    <input type="text" name="device_type" class="form-control form-control-sm"
                                        value="{{ $device['device_type'] }}">
                                </div>

                                <input type="hidden" name="user_agent" value="{{ $device['user_agent'] }}">

                            </div>
                        </div>
                    </div>

                    {{-- SETTINGS --}}
                    <div class="col-md-6">
                        <div class="card border-left-danger shadow-sm h-100">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-cog"></i> Settings</strong>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label>User</label>
                                    <select name="user_id" class="form-control form-control-sm select2">
                                        <option value="">None</option>
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control form-control-sm">
                                        <option value="1">🔴 Banned</option>
                                        <option value="0">🟢 Allow</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Reason</label>
                                    <textarea name="reason" rows="2" class="form-control form-control-sm" placeholder="Optional reason..."></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Save Device
                    </button>
                </div>

            </form>

        </div>
    </div>

@stop

@push('js')
    <script>
        $('.select2').select2({
            placeholder: "Select user",
            allowClear: true,
            width: '100%'
        });
    </script>
@endpush
