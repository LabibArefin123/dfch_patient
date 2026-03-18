@extends('adminlte::page')

@section('title', 'Activity Logs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-history text-primary"></i> Activity Logs
        </h4>
        <button class="btn btn-outline-primary btn-sm" data-toggle="collapse" data-target="#filterSection">
            <i class="fas fa-filter"></i> Filters
        </button>
    </div>
@stop

@section('content')

    {{-- FILTER CARD --}}
    <div class="card shadow-sm collapse mb-3" id="filterSection">
        <div class="card-body">
            <div class="row g-2">

                <div class="col-md-2">
                    <label>User</label>
                    <select id="user" class="form-control form-control-sm">
                        <option value="">All Users</option>
                        @foreach ($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Log</label>
                    <input type="text" id="log_name" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <label>From</label>
                    <input type="date" id="from_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <label>To</label>
                    <input type="date" id="to_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <label>Source</label>
                    <select id="source" class="form-control form-control-sm">
                        <option value="">All</option>
                        @foreach ($sources as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Description</label>
                    <input type="text" id="description" class="form-control form-control-sm">
                </div>

                <div class="col-md-12 mt-2 d-flex gap-2">
                    <button class="btn btn-success btn-sm" id="filterBtn"><i class="fas fa-search"></i> Apply</button>
                    <button class="btn btn-secondary btn-sm" id="resetBtn"><i class="fas fa-redo"></i> Reset</button>
                </div>

            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive p-2">
            <table class="table table-sm table-hover align-middle" id="dataTables">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Log</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>ID</th>
                        <th>Details</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="mt-4" style="height:50px;"> </div>
    {{-- MODAL --}}
    <div class="modal fade" id="propertyModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-database"></i> Activity Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="changeHighlight" class="mb-3"></div>
                    <h6 class="text-muted">Full JSON</h6>
                    <pre id="modalProperties"
                        style="max-height:300px; overflow:auto; background:#111; color:#0f0; padding:10px; border-radius:5px;"></pre>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success btn-sm" onclick="copyJSON()"><i class="fas fa-copy"></i> Copy</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this log?')"><i
                                class="fas fa-trash"></i></button>
                    </form>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@stop
@push('js')
    <script>
        let table;
        $(document).ready(function() {

            // --- Ensure Select2 is loaded before using it ---
            if ($.fn.select2) {
                $('#user, #source').select2({
                    placeholder: 'Select option',
                    allowClear: true,
                    width: '100%'
                });
            } else {
                console.warn('Select2 is not loaded!');
            }

            // --- Initialize DataTable ---
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                responsive: true,
                order: [
                    [7, 'desc']
                ],
                ajax: {
                    url: "{{ route('activity.logs.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.user = $('#user').val();
                        d.log_name = $('#log_name').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.description = $('#description').val();
                        d.source = $('#source').val();
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTables AJAX error:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'user'
                    },
                    {
                        data: 'log'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: 'subject_id'
                    },
                    {
                        data: 'details',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date'
                    }
                ]
            });

            // --- Filter buttons ---
            $('#filterBtn').on('click', function() {
                table.ajax.reload();
            });

            $('#resetBtn').on('click', function() {
                $('#user, #source').val(null).trigger('change');
                $('#log_name, #from_date, #to_date, #description').val('');
                table.ajax.reload();
            });

            // --- Modal for property details ---
            let currentJSON = '';
            $('#propertyModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let properties = button.data('properties');
                let id = button.data('id');

                currentJSON = JSON.stringify(properties, null, 4);
                $('#modalProperties').text(currentJSON);

                let html = '';
                if (properties.old || properties.attributes) {
                    html += '<div class="row">';
                    if (properties.old) {
                        html +=
                            `<div class="col-md-6"><h6 class="text-danger">Old</h6><pre class="bg-light p-2 border">${JSON.stringify(properties.old,null,2)}</pre></div>`;
                    }
                    if (properties.attributes) {
                        html +=
                            `<div class="col-md-6"><h6 class="text-success">New</h6><pre class="bg-light p-2 border">${JSON.stringify(properties.attributes,null,2)}</pre></div>`;
                    }
                    html += '</div>';
                } else {
                    html = '<p class="text-muted">No change data available</p>';
                }
                $('#changeHighlight').html(html);

                let url = "{{ route('activity.logs.destroy', ':id') }}";
                $('#deleteForm').attr('action', url.replace(':id', id));
            });

            // --- Copy JSON ---
            window.copyJSON = function() {
                navigator.clipboard.writeText(currentJSON);
                alert('JSON copied to clipboard!');
            };

        });
    </script>
@endpush
