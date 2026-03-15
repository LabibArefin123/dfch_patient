@extends('adminlte::page')

@section('title', 'Banned Devices')

@section('content_header')
    <h1>Banned Devices</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-header">
            <a href="{{ route('banned_devices.create') }}" class="btn btn-primary btn-sm">
                Add Ban
            </a>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>IP</th>
                        <th>Device</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($devices as $device)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $device->ip_address }}</td>

                            <td>{{ $device->device_name }}</td>

                            <td>{{ optional($device->user)->name }}</td>

                            <td>
                                @if ($device->is_active)
                                    <span class="badge badge-danger">Banned</span>
                                @else
                                    <span class="badge badge-success">Allowed</span>
                                @endif
                            </td>

                            <td>

                                <a href="{{ route('banned_devices.edit', $device->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@stop
