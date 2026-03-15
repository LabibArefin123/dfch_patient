@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Role: {{ $role->name }}</h1>

        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop


@section('content')

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('PUT')


        {{-- ROLE INFORMATION --}}
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Role Information</h3>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>Role Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}"
                        required>
                </div>
            </div>
        </div>

        {{-- PERMISSIONS --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title">Permission Management</h3>

                <div>

                    <button type="button" class="btn btn-sm btn-success" id="selectAllPermissions">
                        Select All
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" id="unselectAllPermissions">
                        Unselect All
                    </button>

                </div>

            </div>


            <div class="card-body p-0">

                <div style="max-height:400px; overflow-y:auto;">

                    <table class="table table-hover table-bordered mb-0">
                        <thead class="">
                            <tr>
                                <th width="60">#</th>
                                <th width="200">Group</th>
                                <th>Permission</th>
                                <th width="80">Allow</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $index = 1; @endphp

                            @foreach ($groupedPermissions as $group => $groupPermissions)
                                {{-- GROUP HEADER --}}
                                <tr class="">
                                    <td colspan="4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>{{ ucfirst($group) }}</strong>
                                            <div>
                                                <button type="button" class="btn btn-xs btn-light select-all-btn"
                                                    data-group="{{ $group }}">
                                                    Select
                                                </button>

                                                <button type="button" class="btn btn-xs btn-light unselect-all-btn"
                                                    data-group="{{ $group }}">
                                                    Unselect
                                                </button>

                                            </div>

                                        </div>

                                    </td>
                                </tr>
                                {{-- PERMISSIONS --}}
                                @foreach ($groupPermissions as $permission)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td> {{ $group }}
                                        </td>
                                        <td class="text-muted">
                                            {{ $permission->name }}
                                        </td>

                                        <td class="text-center">

                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                class="perm-all perm-{{ $group }}"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>

                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="mt-3 text-right">

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update Role
            </button>

        </div>

    </form>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>

@stop



@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // GLOBAL SELECT
            document.getElementById('selectAllPermissions').addEventListener('click', function() {
                document.querySelectorAll('.perm-all').forEach(cb => cb.checked = true);
            });

            // GLOBAL UNSELECT
            document.getElementById('unselectAllPermissions').addEventListener('click', function() {
                document.querySelectorAll('.perm-all').forEach(cb => cb.checked = false);
            });

            // GROUP SELECT
            document.querySelectorAll('.select-all-btn').forEach(btn => {

                btn.addEventListener('click', function() {

                    const group = this.dataset.group;

                    document.querySelectorAll('.perm-' + group)
                        .forEach(cb => cb.checked = true);

                });

            });

            // GROUP UNSELECT
            document.querySelectorAll('.unselect-all-btn').forEach(btn => {

                btn.addEventListener('click', function() {

                    const group = this.dataset.group;

                    document.querySelectorAll('.perm-' + group)
                        .forEach(cb => cb.checked = false);

                });

            });

        });
    </script>

@stop
