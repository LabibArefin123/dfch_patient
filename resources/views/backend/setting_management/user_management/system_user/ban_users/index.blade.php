@extends('adminlte::page')

@section('title', 'Banned Users')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Banned Users</h1>
        <a href="{{ route('ban_users.create') }}" class="btn btn-primary btn-sm">
            Add User
        </a>
    </div>
@stop

@section('content')
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Banned At</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bannedUsers as $ban)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ban->user->name ?? 'N/A' }}</td>
                                <td>{{ $ban->user->email ?? 'N/A' }}</td>
                                <td>{{ $ban->user->username ?? 'N/A' }}</td>
                                <td>
                                    {{ $ban->banned_at ? \Carbon\Carbon::parse($ban->banned_at)->format('d M Y, h:i A') : '--:--' }}
                                </td>
                                
                                <td>{{ $ban->ban_reason ?? 'Not Provided' }}</td>
                                <td>
                                    @if ($ban->is_banned)
                                        <span class="badge badge-danger">Banned</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($ban->is_banned)
                                        <form action="{{ route('ban_users.destroy', $ban->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to unban this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ml-1">Unban</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No banned users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@stop
