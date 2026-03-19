@extends('frontend.layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-glass">

            {{-- LEFT : INFO PANEL --}}
            <div class="about-slider">
                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                {{-- SHORT INFO --}}
                <div class="about-content short" id="aboutShort">
                    <h4 class="fw-bold mb-3">Phone Verification</h4>
                    <p>
                        A 6-digit verification code has been sent to your phone number.
                        Please enter it to complete your registration securely.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        More Info
                    </button>
                </div>

                {{-- FULL INFO --}}
                <div class="about-content full" id="aboutFull" style="display:none;">
                    <h4 class="fw-bold mb-3">Why Verification Matters</h4>

                    <p>
                        Phone verification ensures that your account is secure and linked
                        to a valid mobile number.
                    </p>

                    <ul class="ps-3">
                        <li>Protects your account from unauthorized access</li>
                        <li>Ensures secure communication</li>
                        <li>Required for full system access</li>
                    </ul>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(false)">
                        Show Less
                    </button>
                </div>
            </div>

            {{-- RIGHT : VERIFY FORM --}}
            <div class="login-panel">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Enter Verification Code</h4>
                    <p class="text-muted">Hospital Management System</p>
                </div>

                {{-- SESSION MESSAGE --}}
                @if (session('message'))
                    <div class="alert alert-info py-2 px-3 rounded-3">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.verifyPhone') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">6-Digit Code</label>
                        <input id="verification_code" type="text"
                            class="form-control form-control-lg text-center tracking-widest @error('verification_code') is-invalid @enderror"
                            name="verification_code" placeholder="------" required maxlength="6" pattern="\d{6}">

                        @error('verification_code')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <button class="btn login-btn w-100 py-2 rounded-pill mt-3">
                        Verify & Complete Registration
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none dev-link">
                            ← Back to Login
                        </a>
                    </div>

                    <hr class="my-4">

                    {{-- RESEND CODE --}}
                    <div class="text-center">
                        <form method="POST" action="{{ route('register.resendCode') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">
                                🔄 Resend Code
                            </button>
                        </form>
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

    {{-- JS --}}
    <script>
        function toggleAbout(showFull) {
            const shortAbout = document.getElementById('aboutShort');
            const fullAbout = document.getElementById('aboutFull');

            if (showFull) {
                shortAbout.style.display = 'none';
                fullAbout.style.display = 'block';
            } else {
                fullAbout.style.display = 'none';
                shortAbout.style.display = 'block';
            }
        }
    </script>
@endsection
