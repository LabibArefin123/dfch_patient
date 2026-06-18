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

                {{-- SHORT INFO --}}
                <div class="about-content short" id="aboutShort">

                    <h4 class="fw-bold mb-3">
                        Phone Verification
                    </h4>

                    <p>
                        A 6-digit verification code has been sent to your
                        registered phone number.
                    </p>

                    <p>
                        Enter the code below to securely activate
                        your account and complete the registration process.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        More Information
                    </button>

                </div>

                {{-- FULL INFO --}}
                <div class="about-content full" id="aboutFull">

                    <h4 class="fw-bold mb-3">
                        Why Verification Matters
                    </h4>

                    <p>
                        Phone verification helps us ensure that your account
                        belongs to a real user and protects your personal data.
                    </p>

                    <ul class="ps-3">
                        <li>Protects your account from unauthorized access</li>
                        <li>Ensures secure communication</li>
                        <li>Required for full system access</li>
                        <li>Allows password recovery and notifications</li>
                    </ul>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(false)">
                        Show Less
                    </button>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="text-center mb-4">

                    <h4 class="fw-bold">
                        Verify Your Phone Number
                    </h4>

                    <p class="text-muted">
                        Enter the 6-digit verification code
                    </p>

                </div>

                {{-- SESSION MESSAGE --}}
                @if (session('message'))
                    <div class="alert alert-info rounded-3 mb-3">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- VERIFY FORM --}}
                <form method="POST" action="{{ route('register.verifyPhone') }}">
                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Verification Code
                        </label>

                        <input id="verification_code" type="text" name="verification_code" maxlength="6" pattern="\d{6}"
                            required placeholder="------"
                            class="form-control form-control-lg text-center @error('verification_code') is-invalid @enderror">

                        @error('verification_code')
                            <div class="invalid-feedback d-block mt-2">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>

                    <button type="submit" class="btn login-btn w-100 rounded-pill mt-3">

                        Verify & Complete Registration

                    </button>

                </form>

                {{-- BACK TO LOGIN --}}
                <div class="text-center mt-4">

                    <a href="{{ route('login') }}" class="text-decoration-none header-link">

                        ← Back to Login

                    </a>

                </div>

                <hr class="my-4">

                {{-- RESEND CODE --}}
                <div class="text-center">

                    <form method="POST" action="{{ route('register.resendCode') }}">
                        @csrf

                        <button type="submit" class="btn btn-outline-secondary rounded-pill">

                            🔄 Resend Verification Code

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

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
