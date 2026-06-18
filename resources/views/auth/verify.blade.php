
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
                        Verify Your Account
                    </h4>

                    <p>
                        To activate your account and access all hospital
                        management features, please verify your email address.
                    </p>

                    <p>
                        We have sent a verification email containing a secure
                        activation link to your registered email address.
                    </p>

                    <ul class="ps-3">
                        <li>Secure account activation</li>
                        <li>Email identity verification</li>
                        <li>Enhanced account protection</li>
                        <li>Access to all system features</li>
                    </ul>

                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="login-panel">

                <div class="login-panel-scroll">

                    <div class="text-center mb-4">

                        <h4 class="fw-bold">
                            Email Verification Required
                        </h4>

                        <p class="text-muted">
                            Please verify your email before continuing
                        </p>

                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if (session('resent'))
                        <div class="alert alert-success">

                            A fresh verification link has been sent to your
                            email address.

                        </div>
                    @endif

                    {{-- INFORMATION --}}
                    <div class="alert alert-info">

                        Before proceeding, please check your email for a
                        verification link.

                    </div>

                    <p class="text-center text-muted mb-4">
                        Didn't receive the email? Request a new verification
                        link below.
                    </p>

                    {{-- RESEND BUTTON --}}
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf

                        <button type="submit" class="btn login-btn w-100 rounded-pill">

                            Resend Verification Email

                        </button>

                    </form>

                    {{-- LOGOUT BUTTON --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf

                        <button type="submit" class="btn btn-outline-light w-100 rounded-pill">

                            Log Out

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <small class="text-muted">

                            Check your Inbox, Spam, or Junk folder if the
                            verification email is not visible.

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

