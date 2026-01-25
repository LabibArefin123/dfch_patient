{{-- resources/views/setting_management/setting/password_policy.blade.php --}}
@extends('adminlte::page')

@section('title', 'Password Policy')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Password Policy</h3>
        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                                        0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5
                                        0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <p class="mb-3">
                        A strong password policy is essential to maintain the security of your system and protect sensitive
                        data.
                    </p>

                    <p>
                        <strong>Minimum Length:</strong> All passwords must be at least 8 characters long. Longer passwords
                        are encouraged for better security.
                    </p>

                    <p>
                        <strong>Numbers and Symbols:</strong> Passwords should include numbers and special symbols to make
                        them harder to guess.
                    </p>

                    <p>
                        <strong>Uppercase Letters:</strong> At least one uppercase letter is recommended to increase
                        password complexity.
                    </p>

                    <p>
                        <strong>Password Expiry:</strong> Passwords should expire after 90 days to reduce the risk of
                        compromised credentials being used.
                    </p>

                    <p>
                        <strong>Password History:</strong> Users cannot reuse their last 5 passwords to ensure uniqueness
                        and security.
                    </p>

                    <p>
                        <strong>Account Lockout:</strong> After 5 failed login attempts, the account will be temporarily
                        locked for 15 minutes to prevent brute-force attacks.
                    </p>

                    <p class="text-muted mt-3">
                        Following these guidelines helps ensure the overall security of user accounts and protects sensitive
                        information from unauthorized access.
                    </p>

                </div>
            </div>
        </div>
    </div>
@stop
