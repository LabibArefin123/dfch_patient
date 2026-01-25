@extends('adminlte::page')

@section('title', 'View Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Role Details</h1>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
            ← Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-body">
            {{-- Role Name --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Role Name</label>
                    <input type="text" class="form-control" value="{{ $role->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Total Permissions</label>
                    <input type="text" class="form-control" value="{{ $role->permissions->count() }}" readonly>
                </div>
            </div>

            <hr>

            {{-- Permissions --}}
            <h5 class="text-primary mb-3">Assigned Permissions</h5>

            @forelse($groupedPermissions as $group => $permissions)
                <div class="mb-4">
                    <h6 class="text-uppercase text-secondary mb-2">
                        {{ ucfirst($group) }}
                    </h6>

                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <span class="badge bg-success">
                                    {{ $permission->name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-muted">No permissions assigned to this role.</p>
            @endforelse
        </div>
    </div>
@stop
