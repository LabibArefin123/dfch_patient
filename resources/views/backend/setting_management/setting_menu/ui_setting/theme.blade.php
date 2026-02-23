@extends('adminlte::page')

@section('title', 'Theme Settings')

@section('content_header')
    <h3>Theme Settings</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('settings.theme.update') }}" method="POST">
                @csrf

                {{-- Theme Mode (dark only) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Theme Mode</label>
                    <select name="theme_mode" class="form-select" disabled>
                        <option value="dark" selected>Dark</option>
                    </select>
                    <small class="text-muted">Only dark mode is available.</small>
                </div>

                {{-- Custom Primary Color --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Primary Color</label>
                    <input type="color" name="primary_color" class="form-control form-control-color"
                        value="{{ session('primary_color', '#66fbfb') }}">
                    <small class="text-muted">Pick your custom primary color (hex code like #66fbfb).</small>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
@stop
