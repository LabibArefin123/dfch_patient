@extends('adminlte::page')

@section('title', 'Activity Logs')

@section('content_header')
    <h1>Activity Logs</h1>
@stop

@section('content')

    <div class="card shadow-sm">

        <div class="card-header">
            <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#filterSection">
                Filters
            </button>
        </div>

        <div class="collapse" id="filterSection">
            <div class="card-body">

                <form method="GET">

                    <div class="row">

                        <div class="col-md-3">
                            <label>User ID</label>
                            <input type="text" name="user" class="form-control" value="{{ request('user') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Log Name</label>
                            <input type="text" name="log_name" class="form-control" value="{{ request('log_name') }}">
                        </div>

                        <div class="col-md-3">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control"
                                value="{{ request('description') }}">
                        </div>

                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success btn-sm">Apply Filter</button>
                        <a href="{{ route('activity.logs.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>

                </form>

            </div>
        </div>


        <div class="card-body table-responsive">

            <table class="table table-striped table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Log</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>Date</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($activities as $activity)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ optional($activity->causer)->name ?? 'System' }}
                            </td>

                            <td>
                                <span class="badge badge-info">
                                    {{ $activity->log_name }}
                                </span>
                            </td>

                            <td>
                                {{ $activity->description }}
                            </td>

                            <td>
                                {{ class_basename($activity->subject_type) }}
                            </td>

                            <td>
                                {{ $activity->subject_id }}
                            </td>

                            <td>
                                {{ $activity->created_at->format('d M Y H:i') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">No Activity Found</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">
                {{ $activities->links() }}
            </div>

        </div>

    </div>

@stop
