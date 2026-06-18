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
                        Reset Your Password
                    </h4>

                    <p>
                        Create a new secure password to regain access to your
                        hospital management account.
                    </p>

                    <p>
                        For security reasons, choose a strong password that
                        contains letters, numbers, and special characters.
                    </p>

                    <ul class="ps-3">
                        <li>Secure password recovery</li>
                        <li>Protected account access</li>
                        <li>Encrypted authentication system</li>
                        <li>Fast and safe password reset</li>
                    </ul>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="login-panel-scroll">

                    <div class="text-center mb-4">

                        <h4 class="fw-bold">
                            Reset Password
                        </h4>

                        <p class="text-muted">
                            Enter your new password below
                        </p>

                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        {{-- RESET TOKEN --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email address" required autofocus autocomplete="username">

                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- NEW PASSWORD --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                New Password
                            </label>

                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter new password" required autocomplete="new-password">

                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm new password" required autocomplete="new-password">

                            @error('password_confirmation')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- RESET BUTTON --}}
                        <button type="submit" class="btn login-btn w-100 rounded-pill mt-3">

                            Reset Password

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a href="{{ route('login') }}" class="text-decoration-none header-link">

                            Back to Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
