{{-- resources/views/setting_management/setting/timeout.blade.php --}}
@extends('adminlte::page')

@section('title', 'Session Timeout / Auto Logout')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Session Timeout / Auto Logout</h3>
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
            <div class="card shadow">

                <div class="card-body">
                    <p class="mb-3">Select the duration of inactivity after which the system will automatically log out
                        the user.</p>

                    {{-- Success/Error Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('settings.timeout.update') }}" method="POST"
                        class="d-flex align-items-center justify-content-between">
                        @csrf
                        <label class="form-label mb-0">Auto Logout Time:</label>
                        <select name="timeout" class="form-select w-auto" onchange="this.form.submit()">
                            @php
                                // Standard times including seconds (represented as minutes)
                                $standardTimes = [0.25, 0.5, 1, 2, 5, 10, 15, 30, 60]; // 0.25 = 15s, 0.5 = 30s
                            @endphp
                            @foreach ($standardTimes as $time)
                                <option value="{{ $time }}" {{ ($timeout ?? 5) == $time ? 'selected' : '' }}>
                                    @if ($time < 1)
                                        {{ intval($time * 60) }} seconds
                                    @else
                                        {{ $time }} minute{{ $time > 1 ? 's' : '' }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                    </form>
                    <small class="text-muted d-block mt-2">Default is 5 minutes.</small>

                </div>
            </div>
        </div>
    </div>
@stop
