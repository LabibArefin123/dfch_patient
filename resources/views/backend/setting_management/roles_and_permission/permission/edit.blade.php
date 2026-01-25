@extends('adminlte::page')

@section('title', 'Edit Permission')

@section('content_header')
    <h1>Update Permission</h1>
@stop

@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Permission Name"
                            value="{{ old('name', $permission->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="guard_name">Guard <span class="text-danger">*</span></label>
                        <input type="text" name="guard_name" class="form-control" placeholder="Guard Name"
                            value="{{ old('guard_name', $permission->guard_name) }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </div>
            </div>
        </form>
    </div>
@stop
