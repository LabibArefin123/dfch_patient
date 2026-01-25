@extends('adminlte::page')

@section('title', 'Edit Organization')

@section('content_header')
    <h1>Edit Organization</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('organizations.update', $organization->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Organization Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $organization->name) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('organizations.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@stop
