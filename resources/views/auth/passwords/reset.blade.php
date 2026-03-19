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
                        You're just one step away. Create a new password to securely access
                        your hospital management account.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        More Info
                    </button>
                </div>

                {{-- FULL --}}
                <div class="about-content full" id="aboutFull" style="display:none;">
                    <h4 class="fw-bold mb-3">Password Guidelines</h4>

                    <ul class="ps-3">
                        <li>Minimum 8 characters</li>
                        <li>Use uppercase & lowercase letters</li>
                        <li>Include numbers & symbols</li>
                        <li>Avoid common or old passwords</li>
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
                        <input id="email" type="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                            value="{{ $email ?? old('email') }}" required autofocus>

                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <input id="password" type="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
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
                        <input id="password-confirm" type="password" class="form-control form-control-lg"
                            name="password_confirmation" placeholder="Confirm new password" required>
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
