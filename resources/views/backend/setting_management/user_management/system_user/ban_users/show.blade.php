@extends('adminlte::page')

@section('title', 'View Ban User')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Ban User Details</h1>
        <div>
            <a href="{{ route('ban_users.edit', $ban_user->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('ban_users.index') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop



@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>User</label>
                    <input type="text" class="form-control"
                        value="{{ $ban_user->user->name ?? '' }} ({{ $ban_user->user->email ?? '' }})" disabled>
                </div>

                <div class="form-group col-md-6">
                    <label>Created At</label>
                    <input type="text" class="form-control" value="{{ $ban_user->created_at }}" disabled>
                </div>

                <div class="form-group col-md-12">
                    <label>Ban Reason</label>
                    <textarea class="form-control" rows="3" disabled>{{ $ban_user->ban_reason }}</textarea>
                </div>

            </div>
        </div>
    </div>
@stop
