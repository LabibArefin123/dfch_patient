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
                        Verify Your Email
                    </h4>

                    <p>
                        Thanks for registering. Before getting started,
                        please verify your email address by clicking the
                        link we emailed to you.
                    </p>

                    <p>
                        If you didn't receive the email, we can send
                        another verification link instantly.
                    </p>

                    <ul class="ps-3">
                        <li>Email verification required</li>
                        <li>Secure account activation</li>
                        <li>Protects your account access</li>
                        <li>Quick verification process</li>
                    </ul>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="login-panel-scroll">

                    <div class="text-center mb-4">

                        <h4 class="fw-bold">
                            Email Verification
                        </h4>

                        <p class="text-muted">
                            Verify your email address to continue
                        </p>

                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">

                            A new verification link has been sent to the email
                            address you provided during registration.

                        </div>
                    @endif

                    {{-- RESEND VERIFICATION --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <button type="submit" class="btn login-btn w-100 rounded-pill">

                            Resend Verification Email

                        </button>

                    </form>

                    {{-- LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf

                        <button type="submit" class="btn btn-outline-light w-100 rounded-pill">

                            Log Out

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <small class="text-muted">
                            Check your inbox and spam folder if you don't
                            see the verification email.
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

