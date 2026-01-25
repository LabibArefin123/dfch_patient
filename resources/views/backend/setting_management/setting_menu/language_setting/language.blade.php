@extends('adminlte::page')

@section('title', 'Language Settings')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Language Settings</h3>
        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                            4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                            0 0 1 0-.708l5-5a.5.5 0 0 1
                            .708.708L2.707 7.5H14.5A.5.5
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

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('settings.language.update') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Choose System Language</label>

                            <select name="app_language" class="form-select form-select-lg">
                                <option value="en" {{ session('app_locale') == 'en' ? 'selected' : '' }}>
                                    English
                                </option>
                                <option value="bn" {{ session('app_locale') == 'bn' ? 'selected' : '' }}>
                                    বাংলা
                                </option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">Save</button>
                        </div>
                    </form>

                    <small class="text-muted d-block mt-2">
                        The selected language will apply system-wide immediately.
                    </small>
                </div>
            </div>

        </div>
    </div>
@stop
