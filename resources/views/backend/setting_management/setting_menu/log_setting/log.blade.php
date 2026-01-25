@extends('adminlte::page')

@section('title', 'System Logs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">System Logs</h3>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Application Error Logs</h5>

                <form action="{{ route('settings.clearLogs') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to clear all logs?');">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Clear Logs
                    </button>
                </form>
            </div>

            {{-- Filters --}}
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route('settings.logs') }}" class="row gy-2 gx-3">
                    <div class="col-md-3">
                        <select name="range" class="form-select">
                            @php
                                $ranges = [
                                    'today' => 'Today',
                                    'yesterday' => 'Yesterday',
                                    '7days' => 'Last 7 Days',
                                    '1month' => '1 Month',
                                    '2months' => '2 Months',
                                    '3months' => '3 Months',
                                    '6months' => '6 Months',
                                    '1year' => '1 Year',
                                    'all' => 'All Logs',
                                ];
                            @endphp
                            @foreach ($ranges as $key => $label)
                                <option value="{{ $key }}" {{ ($range ?? 'today') == $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control" placeholder="Start date">
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" placeholder="End date">
                    </div>

                    <div class="col-md-3 d-grid">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    </div>
                </form>
            </div>

            {{-- Logs --}}
            <div class="card-body" style="max-height:70vh; overflow-y:auto; font-family:monospace; font-size:14px;">
                @if (!empty($logs) && count($logs) > 0)
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px;">#</th>
                                <th style="width:160px;">Timestamp</th>
                                <th style="width:80px;">Level</th>
                                <th>Message</th>
                                <th style="width:60px;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr class="{{ $log['level'] == 'ERROR' ? 'table-danger' : '' }}">
                                    <td>{{ $log['serial'] }}</td>
                                    <td>{{ $log['timestamp']?->format('Y-m-d H:i:s') ?? '-' }}</td>
                                    <td>{{ $log['level'] }}</td>
                                    {{-- Short message: first line --}}
                                    <td style="white-space: pre-wrap;">
                                        {{ explode("\n", $log['message'])[0] }}
                                    </td>
                                    {{-- Collapsible stacktrace --}}
                                    <td>
                                        @if (str_contains($log['message'], "\n"))
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#trace{{ $log['serial'] }}" aria-expanded="false"
                                                aria-controls="trace{{ $log['serial'] }}">
                                                View
                                            </button>
                                            <div class="collapse mt-1" id="trace{{ $log['serial'] }}">
                                                <pre class="mb-0" style="font-size:12px;">{{ $log['message'] }}</pre>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center py-5">
                        <i class="fas fa-info-circle"></i>
                        No logs found for the selected filter.
                    </p>
                @endif
            </div>

        </div>
    </div>
@stop

@section('css')
    <style>
        table td,
        table th {
            vertical-align: top;
        }

        pre {
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
@stop
