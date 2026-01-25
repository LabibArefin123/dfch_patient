@extends('adminlte::page')

@section('title', 'Ban User')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Ban User</h1>
        <a href="{{ route('ban_users.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0 back-btn">
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
            <form action="{{ route('ban_users.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="user_id">Select User<span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="ban_reason">Ban Reason</label>
                        <textarea name="ban_reason" id="ban_reason" rows="3"
                            class="form-control @error('ban_reason') is-invalid @enderror">{{ old('ban_reason') }}</textarea>
                        @error('ban_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-danger">
                    Ban User
                </button>
            </form>
        </div>
    </div>
@stop
