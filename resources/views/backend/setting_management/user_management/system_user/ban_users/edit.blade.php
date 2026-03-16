@extends('adminlte::page')

@section('title', 'Edit Ban User')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Edit Ban User</h1>

        <a href="{{ route('ban_users.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fas fa-arrow-left"></i> Go Back
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ban_users.update', $ban_user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select User<span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $ban_user->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Ban Reason</label>
                        <textarea name="ban_reason" rows="3" class="form-control">{{ $ban_user->ban_reason }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    Update Ban
                </button>
            </form>
        </div>
    </div>
@stop
