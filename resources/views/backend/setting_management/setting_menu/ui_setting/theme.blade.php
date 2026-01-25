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

                <div class="mb-3">
                    <label class="form-label fw-bold">Theme Mode</label>
                    <select name="theme_mode" class="form-select">
                        <option value="light" {{ Session::get('theme_mode') == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ Session::get('theme_mode') == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
@stop
