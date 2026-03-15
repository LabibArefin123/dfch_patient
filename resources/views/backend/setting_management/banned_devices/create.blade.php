@extends('adminlte::page')

@section('title', 'Ban Device')

@section('content')

    <div class="card">

        <div class="card-body">

            <form method="POST" action="{{ route('banned_devices.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <label>IP Address</label>
                        <input type="text" name="ip_address" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Device Name</label>
                        <input type="text" name="device_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Device Type</label>
                        <input type="text" name="device_type" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>User</label>
                        <select name="user_id" class="form-control">
                            <option value="">None</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Banned</option>
                            <option value="0">Allow</option>
                        </select>
                    </div>

                    <div class="col-md-6">
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
