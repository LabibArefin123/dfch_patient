@extends('frontend.layouts.app')

@section('content')
    <style>
        body {
            background: url('{{ asset('uploads/images/welcome_page/cover.png') }}') center/cover no-repeat;
        }
    </style>
    
    <div class="login-wrapper">

        <div class="login-glass">

            {{-- LEFT PANEL --}}
            <div class="about-slider">

                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="Hospital Logo">

                <div class="about-content short">

                    <h4 class="fw-bold mb-3">
                        Confirm Your Password
                    </h4>

                    <p>
                        This is a secure area of the application.
                        Please confirm your password before continuing.
                    </p>

                    <p>
                        Password confirmation helps protect sensitive
                        information and administrative functions.
                    </p>

                    <ul class="ps-3">
                        <li>Enhanced account security</li>
                        <li>Protected sensitive data</li>
                        <li>Secure user verification</li>
                        <li>Safe administrative access</li>
                    </ul>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="login-panel-scroll">

                    <div class="text-center mb-4">

                        <h4 class="fw-bold">
                            Confirm Password
                        </h4>

                        <p class="text-muted">
                            Please enter your password to continue
                        </p>

                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        {{-- PASSWORD --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your current password" required autocomplete="current-password">

                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- CONFIRM BUTTON --}}
                        <button type="submit" class="btn login-btn w-100 rounded-pill mt-3">

                            Confirm Password

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a href="{{ route('dashboard') }}" class="text-decoration-none header-link">

                            Back to Dashboard

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
