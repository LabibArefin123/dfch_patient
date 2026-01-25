@extends('adminlte::page')

@section('title', 'Organization Details')

@section('content_header')
    <h1>Organization Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Organization Name:</strong> {{ $organization->name }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('organizations.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
