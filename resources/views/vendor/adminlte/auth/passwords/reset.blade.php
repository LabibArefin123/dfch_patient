@extends('frontend.layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-glass">

            {{-- LEFT : INFO --}}
            <div class="about-slider">
                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                {{-- SHORT --}}
                <div class="about-content short" id="aboutShort">
                    <h4 class="fw-bold mb-3">Reset Your Password</h4>
                    <p>
                        Create a new secure password to regain access to your account.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        More Info
                    </button>
                </div>

                {{-- FULL --}}
                <div class="about-content full" id="aboutFull" style="display:none;">
                    <h4 class="fw-bold mb-3">Security Tips</h4>

                    <ul class="ps-3">
                        <li>Use at least 8 characters</li>
                        <li>Include uppercase & lowercase letters</li>
                        <li>Add numbers and symbols</li>
                        <li>Do not reuse old passwords</li>
                    </ul>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(false)">
                        Show Less
                    </button>
                </div>
            </div>

            {{-- RIGHT : RESET FORM --}}
            <div class="login-panel">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Create New Password</h4>
                    <p class="text-muted">Hospital Management System</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    {{-- TOKEN --}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            placeholder="Enter new password" required>

                        @error('password')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                            placeholder="Confirm new password" required>

                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <button class="btn login-btn w-100 py-2 rounded-pill mt-3">
                        🔐 Reset Password
                    </button>

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
