@extends('frontend.layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-glass">

            {{-- LEFT : ABOUT (Same as Login Page) --}}
            <div class="about-slider">
                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                <div class="about-content short">
                    <h4 class="fw-bold mb-3">Reset Your Password</h4>
                    <p>
                        Forgot your password? No worries. Enter your registered email
                        address and we’ll send you a secure reset link.
                    </p>
                </div>
            </div>

            {{-- RIGHT : FORGOT PASSWORD --}}
            <div class="login-panel">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Forgot Password</h4>
                    <p class="text-muted">Recover your account securely</p>
                </div>

                {{-- SESSION STATUS --}}
                @if (session('status'))
                    <div class="alert alert-success rounded-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            placeholder="Enter your registered email" required autofocus>

                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    {{-- SUBMIT --}}
                    <button class="btn login-btn w-100 py-2 rounded-pill mt-3">
                        Send Reset Link
                    </button>

                    {{-- BACK TO LOGIN --}}
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none dev-link">
                            ← Back to Login
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- BACKGROUND --}}
    <style>
        body {
            background: url('{{ asset('uploads/images/welcome_page/cover.png') }}') center/cover no-repeat;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/backend/login.css') }}">
@endsection
