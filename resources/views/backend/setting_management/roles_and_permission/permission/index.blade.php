@extends('adminlte::page')

@section('title', 'Permissions List')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Permissions List</h1>
        @if (auth()->user()->hasRole('admin'))
            <button type="button" id="delete-selected" class="btn btn-danger btn-sm ms-2" title="Delete Selected">
                <i class="fas fa-trash-alt me-1"></i> Delete Selected
            </button>
        @endif
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Add Permission Form -->
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New Permission</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Enter permission name" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Permission</button>
                    </div>
                </div>
            </form>

            <!-- Permissions Table -->
            <table id="dataTables" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>SL</th>
                        <th>Permission Name</th>
                        <th class="text-center">Guard</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" class="row-checkbox" value="{{ $permission->id }}">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td class="text-center">{{ $permission->guard_name }}</td>
                            <td class="text-center">
                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" type="submit"
                                        class="btn btn-danger btn-sm">
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
@section('js')
    <script>
        // Select / Deselect all checkboxes
        $('#select-all').on('click', function() {
            const checked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', checked);
        });

        // Uncheck "Select All" if any single checkbox is unchecked
        $('#dataTables').on('change', '.row-checkbox', function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }
        });

        // Handle bulk delete
        $('#delete-selected').on('click', function() {
            const ids = $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                alert('Please select at least one row to delete.');
                return;
            }

            if (!confirm('Are you sure you want to delete selected permissions?')) return;

            $.ajax({
                url: '{{ route('permissions.deleteSelected') }}', // Route for bulk delete
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(res) {
                    alert(res.message || 'Selected permissions deleted successfully.');
                    location.reload();
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        });
    </script>
@endsection
