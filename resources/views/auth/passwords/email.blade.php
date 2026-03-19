@extends('frontend.layouts.app')

@section('content')
    <div class="login-wrapper">
        <div class="login-glass">

            {{-- LEFT : FRIENDLY INFO --}}
            <div class="about-slider">
                <img src="{{ asset('uploads/images/login_page/logo.png') }}" class="hospital-logo" alt="DFCH Logo">

                {{-- SHORT --}}
                <div class="about-content short" id="aboutShort">
                    <h4 class="fw-bold mb-3">Forgot Your Password?</h4>
                    <p>
                        Don’t worry 😊 it happens to everyone.
                        Enter your email and we’ll send you a secure link to reset your password.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(true)">
                        Need Help?
                    </button>
                </div>

                {{-- FULL --}}
                <div class="about-content full" id="aboutFull" style="display:none;">
                    <h4 class="fw-bold mb-3">What Happens Next?</h4>

                    <ul class="ps-3">
                        <li>📩 We’ll send a reset link to your email</li>
                        <li>🔗 Click the link to create a new password</li>
                        <li>🔐 Use a strong and secure password</li>
                    </ul>

                    <p class="mt-2 small">
                        Didn’t receive the email? Check your spam/junk folder.
                    </p>

                    <button class="btn btn-outline-light rounded-pill mt-3" onclick="toggleAbout(false)">
                        Show Less
                    </button>
                </div>
            </div>

            {{-- RIGHT : FORM --}}
            <div class="login-panel">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Reset Your Password</h4>
                    <p class="text-muted">Hospital Management System</p>
                </div>

                {{-- SUCCESS MESSAGE --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 rounded-3">
                        ✅ {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input id="email" type="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Enter your registered email" required autofocus>

                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <button class="btn login-btn w-100 py-2 rounded-pill mt-3">
                        📩 Send Reset Link
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
