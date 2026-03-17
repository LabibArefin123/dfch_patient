@extends('adminlte::page')

@section('title', 'User Devices')

@section('content_header')
    <h1>User Devices</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="dataTables">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th class="text-center">IP</th>
                        <th class="text-center">Device</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Last Login</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action (Ban/Unban)</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ optional($device->user)->name }}</td>
                            <td class="text-center">{{ $device->ip_address }}</td>
                            <td class="text-center">{{ $device->device_name }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ $device->device_type }}
                                </span>
                            </td>
                            <td title="{{ $device->last_login_at }}" class="text-center">
                                {{ $device->last_login_at ? $device->last_login_at->diffForHumans() : '-' }}
                            </td>
                            <td class="text-center">
                                @if ($device->is_banned)
                                    <span class="badge badge-danger">Banned</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">

                                    <!-- Ban / Unban -->
                                    @if (!$device->is_banned)
                                        <form method="POST" action="{{ route('user_devices.ban', $device->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">Ban</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('user_devices.unban', $device->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Unban</button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">

                                    <!-- View -->
                                    <a href="{{ route('user_devices.show', $device->id) }}" class="btn btn-primary btn-sm">
                                        View
                                    </a>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('user_devices.destroy', $device->id) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this device?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $devices->links() }}
            </div>
        </div>
    </div>
@stop
