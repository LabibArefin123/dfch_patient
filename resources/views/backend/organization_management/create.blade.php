@extends('adminlte::page')

@section('title', 'Add Organization')

@section('content_header')
    <h1>Add Organization</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('organizations.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Organization Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="Enter organization name">
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('organizations.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@stop
