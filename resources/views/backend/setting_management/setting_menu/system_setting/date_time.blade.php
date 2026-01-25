@extends('adminlte::page')

@section('title', 'Date & Time Settings')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Date & Time Settings</h3>

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

                    <form action="{{ route('settings.datetime.update') }}" method="POST">
                        @csrf

                        {{-- Timezone --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Timezone</label>

                            <select name="timezone" class="form-select">
                                @foreach (timezone_identifiers_list() as $tz)
                                    <option value="{{ $tz }}"
                                        {{ config('app.timezone') == $tz ? 'selected' : '' }}>
                                        {{ $tz }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date Format --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Date Format</label>

                            <select name="date_format" class="form-select">
                                <option value="Y-m-d" {{ config('app.date_format') == 'Y-m-d' ? 'selected' : '' }}>
                                    2025-12-31 (Y-m-d)
                                </option>
                                <option value="d-m-Y" {{ config('app.date_format') == 'd-m-Y' ? 'selected' : '' }}>
                                    31-12-2025 (d-m-Y)
                                </option>
                                <option value="d M, Y" {{ config('app.date_format') == 'd M, Y' ? 'selected' : '' }}>
                                    31 Dec, 2025 (d M, Y)
                                </option>
                                <option value="l, d F Y" {{ config('app.date_format') == 'l, d F Y' ? 'selected' : '' }}>
                                    Wednesday, 31 December 2025 (l, d F Y)
                                </option>
                            </select>
                        </div>

                        {{-- Time Format --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Time Format</label>

                            <select name="time_format" class="form-select">
                                <option value="h:i A" {{ config('app.time_format') == 'h:i A' ? 'selected' : '' }}>
                                    12-Hour (07:30 PM)
                                </option>
                                <option value="H:i" {{ config('app.time_format') == 'H:i' ? 'selected' : '' }}>
                                    24-Hour (19:30)
                                </option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">Save</button>
                        </div>
                    </form>

                    <small class="text-muted d-block mt-2">
                        Date & Time settings will apply system-wide instantly.
                    </small>

                </div>
            </div>

        </div>
    </div>

@stop
