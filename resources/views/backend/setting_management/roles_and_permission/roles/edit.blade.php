@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Edit Role: {{ $role->name }}</h1>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.update', $role->id) }}" data-confirm="edit">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
        </div>

        {{-- GLOBAL SELECT ALL --}}
        <div class="card border-primary mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">
                    All Permissions
                </h5>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" id="selectAllPermissions">
                        Select All
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" id="unselectAllPermissions">
                        Unselect All
                    </button>
                </div>
            </div>
        </div>


        @foreach ($groupedPermissions as $group => $groupPermissions)
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5 class="text-primary mb-0 text-uppercase">{{ ucfirst($group) }}</h5>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary select-all-btn"
                        data-group="{{ $group }}">
                        Select All
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-danger unselect-all-btn"
                        data-group="{{ $group }}">
                        Unselect All
                    </button>
                </div>
            </div>

            <div class="card shadow-lg mt-2">
                <div class="card-body">
                    <div class="row">
                        @foreach ($groupPermissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        class="form-check-input perm-all perm-{{ $group }}"
                                        id="perm_{{ $permission->id }}"
                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-4">
            {{ $permissions->links('pagination::bootstrap-5') }}
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- spacing card -->
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 🔹 GLOBAL SELECT ALL
            document.getElementById('selectAllPermissions')?.addEventListener('click', function() {
                document.querySelectorAll('.perm-all').forEach(cb => cb.checked = true);
            });

            document.getElementById('unselectAllPermissions')?.addEventListener('click', function() {
                document.querySelectorAll('.perm-all').forEach(cb => cb.checked = false);
            });

            // 🔹 GROUP SELECT
            document.querySelectorAll('.select-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = true);
                });
            });

            document.querySelectorAll('.unselect-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = false);
                });
            });

        });
    </script>
@stop
