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

                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                <div class="about-content short">

                    <h4 class="fw-bold mb-3">
                        Reset Your Password
                    </h4>

                    <p>
                        Forgot your password? Don't worry.
                        Enter your registered email address and we will send
                        you a secure password reset link.
                    </p>

                    <p class="mt-3">
                        The reset link is valid for a limited time and helps
                        keep your account protected from unauthorized access.
                    </p>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">
                <div class="login-panel-scroll">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">
                            Forgot Password
                        </h4>

                        <p class="text-muted">
                            Recover your account securely
                        </p>
                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if (session('status'))
                        <div class="alert alert-success rounded-3 mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                placeholder="Enter your registered email address" required autofocus>

                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- SEND LINK BUTTON --}}
                        <button type="submit" class="btn login-btn w-100 rounded-pill mt-3">

                            Send Password Reset Link

                        </button>

                        {{-- BACK TO LOGIN --}}
                        <div class="text-center mt-4">

                            <a href="{{ route('login') }}" class="text-decoration-none header-link">

                                ← Back to Login

                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
@endsection
