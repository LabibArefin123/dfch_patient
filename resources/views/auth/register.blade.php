@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <div class="text-center mb-4">
                <img src="{{ asset('vendor/adminlte/dist/img/SORKAR (2).png') }}" alt="Logo"
                    style="width: 150px; height: 150px;">
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-2">Welcome to Bid Track Management System</h2>
                    <p class="fw-bold text-muted">Your Pathway to Smarter Bidding!</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header" style="text-align: center"></div>

                        <div class="card shadow-lg rounded-4 border-0">
                            <div class="card-body p-3">
                                <h3 class="text-center mb-4 text-primary fw-bold">Create Your Account</h3>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    {{-- Name --}}
                                    <div class="form-floating mb-3">
                                        <input id="name" type="text"
                                            class="form-control rounded-3 @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autofocus>
                                        <label for="name">Full Name</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Phone Number --}}
                                    <div class="form-floating mb-3">
                                        <input id="phone_1" type="text"
                                            class="form-control rounded-3 @error('phone_1') is-invalid @enderror"
                                            name="phone_1" value="{{ old('phone_1') }}" required>
                                        <label for="phone_1">Phone Number</label>
                                        @error('phone_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- Email --}}
                                    <div class="form-floating mb-3">
                                        <input id="email" type="email"
                                            class="form-control rounded-3 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required>
                                        <label for="email">Email Address</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Password --}}
                                    <div class="form-floating mb-3">
                                        <input id="password" type="password"
                                            class="form-control rounded-3 @error('password') is-invalid @enderror"
                                            name="password" required>
                                        <label for="password">Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="form-floating mb-4">
                                        <input id="password-confirm" type="password" class="form-control rounded-3"
                                            name="password_confirmation" required>
                                        <label for="password-confirm">Confirm Password</label>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                            <i class="fas fa-user-plus me-2"></i> Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-8 text-center">
                            <h5 class="mb-1">Helpdesk</h5>
                            <p class="mb-1">
                                <a href="tel:09643111222" class="text-decoration-none">09643 111 222</a>
                            </p>
                            <p>
                                <a href="mailto:helpdesk@totalofftec.com"
                                    class="text-decoration-none">helpdesk@totalofftec.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-8">
                            <!-- Footer Message -->
                            <h5 class="text-center">Design and Developed by
                                <a href="https://totalofftec.com" target="_blank"
                                    class="text-decoration-none">TOTALOFFTEC</a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <style>
        body {
            background-image: url('{{ asset('images/wallpaper.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
