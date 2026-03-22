@extends('adminlte::page')

@section('title', 'Security Logs')

@section('content_header')
    <h1>🛡️ Security Logs</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between">

            <form method="GET" class="d-flex gap-2">

                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search IP / URL"
                    value="{{ request('search') }}">

                <select name="attack_type" class="form-control form-control-sm">
                    <option value="">All Types</option>
                    <option value="SQL_INJECTION">SQL Injection</option>
                    <option value="XSS">XSS</option>
                    <option value="PATH_TRAVERSAL">Path</option>
                    <option value="COMMAND_INJECTION">Command</option>
                </select>

                <button class="btn btn-primary btn-sm">Filter</button>
            </form>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">

                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>IP</th>
                            <th>Country</th>
                            <th>Type</th>
                            <th>URL</th>
                            <th>User</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="badge bg-dark">
                                        {{ $log->ip_address }}
                                    </span>
                                </td>

                                <td>
                                    🌍 {{ $log->country }}
                                </td>


                                <td>
                                    <span
                                        class="badge 
                                    @if ($log->attack_type == 'SQL_INJECTION') bg-danger
                                    @elseif($log->attack_type == 'XSS') bg-warning
                                    @elseif($log->attack_type == 'PATH_TRAVERSAL') bg-info
                                    @elseif($log->attack_type == 'COMMAND_INJECTION') bg-secondary @endif">
                                        {{ $log->attack_type }}
                                    </span>

                                    @php
                                        $attempts = \App\Models\SecurityLog::where('ip_address', $log->ip_address)
                                            ->where('attack_type', $log->attack_type)
                                            ->count();
                                    @endphp
                                    @if ($attempts >= 3)
                                        <span class="badge bg-dark">🚫 Blocked</span>
                                    @endif
                                </td>

                                <td class="small text-muted">
                                    {{ Str::limit($log->url, 40) }}
                                </td>

                                <td>
                                    {{ $log->user->name ?? 'Guest' }}
                                </td>

                                <td>
                                    {{ $log->created_at->diffForHumans() }}
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('security_logs.destroy', $log->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No security logs found 🚫
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            {{ $logs->links() }}
        </div>

    </div>

@stop
