@extends('adminlte::page')

@section('title', 'Activity Logs')

@section('content_header')
    <h1>Activity Logs</h1>
@stop

@section('content')
    <div class="card">
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
                            <label>User</label>
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
            <table class="table table-striped table-hover" id="dataTables">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Log</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>Details</th>
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
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#propertyModal"
                                    data-properties='@json($activity->properties)' data-id="{{ $activity->id }}">
                                    View
                                </button>
                            </td>

                            <td title="{{ $activity->created_at->format('d M Y H:i') }}">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Activity Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-4" style="height:50px;">

    </div>
    <!-- Properties Modal -->
    <div class="modal fade" id="propertyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Activity Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Highlight Section -->
                    <div id="changeHighlight"></div>

                    <hr>

                    <!-- JSON View -->
                    <h6>Full JSON</h6>
                    <pre id="modalProperties" style="max-height:300px; overflow:auto; background:#000; color:#0f0; padding:10px;"></pre>

                </div>

                <div class="modal-footer">

                    <!-- Copy Button -->
                    <button class="btn btn-success btn-sm" onclick="copyJSON()">Copy JSON</button>

                    <!-- Delete Button (optional) -->
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this log?')">Delete</button>
                    </form>

                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        let currentJSON = '';

        $('#propertyModal').on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);
            let properties = button.data('properties');
            let id = button.data('id');

            currentJSON = JSON.stringify(properties, null, 4);

            // Show JSON
            $('#modalProperties').text(currentJSON);

            // 🔥 Highlight OLD vs NEW
            let html = '';

            if (properties.old || properties.attributes) {

                html += '<div class="row">';

                if (properties.old) {
                    html += `
                    <div class="col-md-6">
                        <h6 class="text-danger">Old</h6>
                        <pre style="background:#ffe6e6; padding:10px;">
${JSON.stringify(properties.old, null, 2)}
                        </pre>
                    </div>
                `;
                }

                if (properties.attributes) {
                    html += `
                    <div class="col-md-6">
                        <h6 class="text-success">New</h6>
                        <pre style="background:#e6ffe6; padding:10px;">
${JSON.stringify(properties.attributes, null, 2)}
                        </pre>
                    </div>
                `;
                }

                html += '</div>';
            } else {
                html = '<p class="text-muted">No change data available</p>';
            }

            $('#changeHighlight').html(html);

            // 🔥 Set delete route dynamically
            let url = "{{ route('activity.logs.destroy', ':id') }}";
            url = url.replace(':id', id);
            $('#deleteForm').attr('action', url);
        });

        // ✅ Copy JSON
        function copyJSON() {
            navigator.clipboard.writeText(currentJSON);
            alert('Copied to clipboard!');
        }
    </script>
@endpush
