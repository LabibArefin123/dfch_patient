@extends('adminlte::page')

@section('title', 'Banned Devices')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Banned Devices</h1>
        <a href="{{ route('banned_devices.create') }}" class="btn btn-primary btn-sm">
            Add Device
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="dataTables">
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
                                <a href="{{ route('banned_devices.show', $device->id) }}" class="btn btn-primary btn-sm">
                                    Show
                                </a>
                                <form action="{{ route('banned_devices.destroy', $device->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this device?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
