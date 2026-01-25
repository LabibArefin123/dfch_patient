@extends('adminlte::page')

@section('title', 'Database Backup & Download')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Database Backup & Download</h3>
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

                    <p class="mb-3">
                        Click the button below to generate a full backup of your database.
                        The system will export a downloadable <strong>.sql</strong> file.
                    </p>

                    {{-- Success/Error Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('settings.database.backup.download') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary btn-lg d-flex gap-2 align-items-center">
                            <i class="fas fa-download"></i> Download Database Backup
                        </button>
                    </form>

                    <small class="text-muted d-block mt-3">
                        Backup file name includes date & time for easy identification.<br>
                        Format: <strong>your_dbname_backup_YYYY-MM-DD_HH-MM-SS.sql</strong>
                    </small>

                </div>
            </div>
        </div>
    </div>

@stop
