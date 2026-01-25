@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="text-center mb-4">
            <img src="{{ asset('uploads/images/login_page/logo.png') }}" alt="Logo" style="width: 400px; height: 150px;">
        </div>

        <div class="row justify-content-center mt-2">
            <div class="col-md-5">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body px-3 py-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email/Username --}}
                            <div class="mb-4">
                                <label for="login" class="form-label fw-semibold">Email or Username</label>
                                <input id="login" type="text"
                                    class="form-control form-control-lg rounded-3 shadow-sm @error('login') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}" placeholder="Enter your email or username"
                                    required autofocus>

                                {{-- Show login errors only if maintenance is OFF --}}
                                @error('login')
                                    @unless (session('maintenance'))
                                        <div class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></div>
                                    @endunless
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold"></label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg rounded-3 shadow-sm @error('password') is-invalid @enderror"
                                    name="password" placeholder="Enter your password" required>

                                {{-- Show password errors only if maintenance is OFF --}}
                                @error('password')
                                    @unless (session('maintenance'))
                                        <div class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></div>
                                    @endunless
                                @enderror

                                {{-- Maintenance Message --}}
                                @if (session('maintenance'))
                                    <div class="alert alert-warning mt-3 mb-0 py-2 px-3 rounded-3">
                                        <i class="fas fa-tools mr-1"></i>
                                        {{ session('maintenance') }}
                                    </div>
                                @endif

                                {{-- Banned Message --}}
                                @if (session('banned'))
                                    <div class="alert alert-danger mt-3 mb-0 py-2 px-3 rounded-3">
                                        <i class="fas fa-ban mr-1"></i>
                                        {{ session('banned') }}
                                    </div>
                                @endif
                            </div>

                            {{-- Login Button & Forgot Password --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm"
                                    @if (session('maintenance') || session('banned')) disabled @endif>
                                    Login
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary fw-semibold" href="#"
                                        id="forgotPasswordLink">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Helpdesk -->
        <div class="row justify-content-center mt-2">
            <div class="col-md-8 text-center">
                <h5>Need Help?</h5>
                <p class="mb-1">
                    <a href="#" class="text-decoration-none" id="callHelpdesk">📞 01776197999</a>
                </p>
                <p>
                    <a href="#" class="text-decoration-none" id="emailHelpdesk">📧 mdlabibarefin@gmail.com</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center small">
            <style>
                @font-face {
                    font-family: 'OnStage';
                    src: url('fonts/OnStage_Regular.ttf') format('truetype');
                    font-weight: normal;
                    font-style: normal;
                }

                .onstage-text {
                    font-family: 'OnStage', sans-serif;
                    color: #ff9900;
                }

                .off-highlight {
                    color: #B2BEB5 !important;
                }
            </style>
            &copy;
            <a href="https://fazlulhaquehospital.com/" target="_blank" class="text-decoration-none text-primary fw-semibold"
                rel="noopener noreferrer">
                DFCH.
            </a> All rights reserved |
            Design & Developed by
            <a href="https://www.labib.work" target="_blank" rel="noopener noreferrer"
                class="text-decoration-none fw-semibold d-inline-block">
                <span class="onstage-text">Labib Arefin</span>
            </a>
        </footer>
    </div>

    <!-- Background Wallpaper -->
    <style>
        body {
            background-image: url('{{ asset('uploads/images/login_page/wallpaper.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <!-- SweetAlert -->

    <script>
        document.getElementById("forgotPasswordLink").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Forgot Password?",
                text: "We'll help you recover it.",
                icon: "info",
                confirmButtonText: "Go to Reset Page"
            }).then(() => {
                window.location.href = "{{ route('password.request') }}";
            });
        });

        document.getElementById("callHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Call Helpdesk",
                text: "Do you want to call 01776197999?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Call Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "tel:01776197999";
                }
            });
        });

        document.getElementById("emailHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Email Helpdesk",
                text: "Do you want to email us?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Email Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "mailto:mdlabibarefin@gmail.com";
                }
            });
        });

        document.getElementById("visitDeveloper").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Visit TOTALOFFTEC?",
                text: "You are about to leave the page.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Visit"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("https://www.labib.work", "_blank");
                }
            });
        });
    </script>

    {{-- Script for website Redirect user --}}
    <script>
        window.onload = function() {
            const url = new URL(window.location.href);
            const autoLogin = url.searchParams.get("autologin");
            const username = url.searchParams.get("u");
            const password = url.searchParams.get("p");

            if (autoLogin === "no" && username && password) {
                document.querySelector('input[name="login"]').value = username;
                document.querySelector('input[name="password"]').value = password;

                // ✅ Hide URL parameters
                window.history.replaceState({}, document.title, "/login");
            }
        };
    </script>
@endsection
