@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Phone Verification</h3>
    <p class="text-center">Enter the 6-digit code sent to your phone number.</p>

    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('register.verifyPhone') }}">
        @csrf
        <div class="form-floating mb-3">
            <input id="verification_code" type="text"
                class="form-control @error('verification_code') is-invalid @enderror"
                name="verification_code" required autofocus maxlength="6" pattern="\d{6}">
            <label for="verification_code">Verification Code</label>
            @error('verification_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                Verify & Complete Registration
            </button>
        </div>
    </form>
</div>
@endsection
