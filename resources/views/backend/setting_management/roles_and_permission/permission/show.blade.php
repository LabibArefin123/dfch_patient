@extends('adminlte::page')

@section('title', 'View Permission')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Permission Details</h1>

        <div>
            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop


@section('content')

    <div class="card">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 form-group">
                    <label>Permission Name</label>
                    <input type="text" class="form-control" value="{{ $permission->name }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Guard Name</label>
                    <input type="text" class="form-control" value="{{ $permission->guard_name }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Group</label>
                    <input type="text" class="form-control" value="{{ $permission->group }}" disabled>
                </div>

                <div class="col-md-6 form-group">
                    <label>Created At</label>
                    <input type="text" class="form-control" value="{{ $permission->created_at }}" disabled>
                </div>

            </div>

        </div>

    </div>

@stop
