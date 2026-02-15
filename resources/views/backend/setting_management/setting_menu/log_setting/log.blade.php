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

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">Application Error Logs</h5>

                <form action="{{ route('settings.clearLogs') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to clear all logs?');" class="ml-auto mb-0 d-flex">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="fas fa-trash-alt mr-1"></i> Clear Logs
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
                                    '7days' => 'Past 7 Days',
                                    '1month' => 'Past 1 Month',
                                    '2months' => 'Past 2 Months',
                                    '3months' => 'Past 3 Months',
                                    '6months' => 'Past 6 Months',
                                    '1year' => 'Past 1 Year',
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
                <table id="logTables" class="table table-sm table-bordered table-striped w-100">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px;">#</th>
                            <th style="width:160px;">Timestamp</th>
                            <th style="width:80px;">Level</th>
                            <th>Message</th>
                            <th style="width:60px;">Details</th>
                        </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop


@section('js')
    <script>
        $(function() {

            $('#logTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('settings.logs') }}",
                    data: function(d) {
                        d.range = $('select[name=range]').val();
                    }
                },
                columns: [{
                        data: 'serial',
                        name: 'serial'
                    },
                    {
                        data: 'timestamp',
                        name: 'timestamp'
                    },
                    {
                        data: 'level',
                        name: 'level',
                        orderable: false
                    },
                    {
                        data: 'message_display',
                        name: 'message',
                        orderable: false
                    },
                    {
                        data: 'details',
                        name: 'details',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 25
            });

            $('select[name=range]').on('change', function() {
                $('#logTables').DataTable().ajax.reload();
            });

        });
    </script>
@stop
