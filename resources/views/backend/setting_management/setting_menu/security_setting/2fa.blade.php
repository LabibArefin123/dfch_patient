@extends('adminlte::page')

@section('title', 'Two-Factor Authentication')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Two-Factor Authentication</h1>
        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                        4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                        0 0 1 0-.708l5-5a.5.5 0 0
                        1 .708.708L2.707 7.5H14.5A.5.5
                        0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">

                <div class="card-body">
                    <p class="mb-4">Enable or disable Two-Factor Authentication (2FA) for your account. This adds an extra
                        layer of security.</p>

                    {{-- Success/Error Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- 2FA Toggle --}}
                    <form action="{{ route('settings.toggle2fa') }}" method="POST"
                        class="d-flex align-items-center justify-content-between mb-3">
                        @csrf
                        <label class="form-label mb-0">Two-Factor Authentication (2FA)</label>
                        @php
                            $twoFactorVerified = is_null($user->two_factor_code);
                        @endphp
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactorSwitch" name="two_factor_enabled"
                                onchange="this.form.submit()" {{ $user->two_factor_enabled ? 'checked' : '' }}
                                @if ($user->two_factor_enabled && !$twoFactorVerified) disabled @endif>
                        </div>
                    </form>

                    @if ($user->two_factor_enabled && !is_null($user->two_factor_code))
                        {{-- Verify 2FA Code --}}
                        <form action="{{ route('settings.2fa.verify') }}" method="POST" class="mb-2">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="code" class="form-control"
                                    placeholder="Enter 6-digit 2FA code" required>
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </div>
                        </form>

                        {{-- Resend 2FA Code --}}
                        <form action="{{ route('settings.2fa.resend') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-block">Resend Code</button>
                        </form>
                    @endif

                    {{-- Admin view --}}
                    @role('admin')
                        <div class="mt-3">
                            <p><strong>Two-Factor Code:</strong> {{ $user->two_factor_code ?? 'N/A' }}</p>
                            <p><strong>Expires At:</strong>
                                {{ $user->two_factor_expires_at ? \Carbon\Carbon::parse($user->two_factor_expires_at)->format('d F Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    @endrole

                </div>

            </div>
        </div>
    </div>
@stop
