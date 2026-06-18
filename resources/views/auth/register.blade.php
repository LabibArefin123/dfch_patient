@extends('frontend.layouts.app')

@section('content')
    <style>
        body {
            background: url('{{ asset('uploads/images/welcome_page/cover.png') }}') center/cover no-repeat;
        }
    </style>

    {{-- Login Page CSS --}}
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_responsive.css') }}">

    <div class="login-wrapper">

        <div class="login-glass">

            {{-- LEFT PANEL --}}
            <div class="about-slider">

                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="Hospital Logo">

                <div class="about-content short">

                    <h4 class="fw-bold mb-3">
                        Create Your Account
                    </h4>

                    <p>
                        Register your account to access the hospital management
                        system and its services securely.
                    </p>

                    <p>
                        Your account will allow you to manage appointments,
                        access important information, and receive notifications.
                    </p>

                    <ul class="ps-3">
                        <li>Secure user authentication</li>
                        <li>Email and phone verification</li>
                        <li>Access to hospital services</li>
                        <li>Protected personal information</li>
                    </ul>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="login-panel-scroll">

                    <div class="text-center mb-4">
                        <h4 class="fw-bold">
                            Create Account
                        </h4>

                        <p class="text-muted">
                            Complete the form below to register
                        </p>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- FULL NAME --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Full Name
                            </label>

                            <input id="name" type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name"
                                required autofocus>

                            @error('name')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- PHONE --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <input id="phone_1" type="text" name="phone_1" value="{{ old('phone_1') }}"
                                class="form-control @error('phone_1') is-invalid @enderror"
                                placeholder="Enter your phone number" required>

                            @error('phone_1')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email address" required>

                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Create a password"
                                required>

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

                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm your password" required>

                        </div>

                        {{-- REGISTER BUTTON --}}
                        <button type="submit" class="btn login-btn w-100 rounded-pill mt-3">

                            Create Account

                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none header-link">
                            Already have an account? Login
                        </a>
                    </div>

                </div>

            </div>

        </div>


    </div>
@endsection
