@extends('adminlte::page')

@section('title', 'System Dashboard')

@section('content_header')
    <h3 class="fw-bold mb-1">
        <i class="fas fa-server text-primary"></i> System Summary Dashboard
    </h3>
    <p class="text-muted mb-3">
        Overview of system health, database statistics, and backup status.
    </p>

    <div class="p-3 bg-light rounded">
        <p class="mb-1">
            💡 This section provides a high-level overview of the system status.
        </p>
        <p class="mb-0 small text-muted">
            Note: Database content is not editable or viewable from here for security reasons.
        </p>
    </div>
@endsection

@section('content')

    {{-- =======================
        SUMMARY INFO BOXES
    ======================= --}}
    <div class="row g-4 mt-1">

        {{-- Total Users --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-info text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        {{-- Total Records --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-success text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ number_format($totalRecords) }}</h3>
                    <p>Total Records</p>
                </div>
                <div class="icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>

        {{-- Database Size --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-warning text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $databaseSize }} MB</h3>
                    <p>Database Size</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hdd"></i>
                </div>
            </div>
        </div>

        {{-- Last Backup Time --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-secondary text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h5 class="mb-1">{{ $lastBackupTime }}</h5>
                    <p>Last Backup</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- =======================
        TABLE ROW COUNTS
    ======================= --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-table"></i> Database Table Summary
            </h5>
            <span class="badge bg-info">
                {{ count($tableCounts) }} Tables
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%">Table Name</th>
                            <th class="text-end">Record Count</th>
                            <th class="text-end">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tableCounts as $table => $data)
                            <tr>
                                <td>{{ $table }}</td>

                                <td class="text-end">
                                    {{ number_format($data['count']) }}
                                </td>

                                <td class="text-end">
                                    @if ($data['updated_at'])
                                        {{ \Carbon\Carbon::parse($data['updated_at'])->diffForHumans() }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No table data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer text-muted small">
            <i class="fas fa-shield-alt"></i>
            This view is read-only and intended for monitoring purposes only.
        </div>
    </div>

    {{-- =======================
        STYLES
    ======================= --}}
    <style>
        .dashboard-box {
            border-radius: 8px;
            transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
        }

        .dashboard-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .small-box .icon i {
            opacity: 0.25;
            font-size: 70px;
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>

@endsection
