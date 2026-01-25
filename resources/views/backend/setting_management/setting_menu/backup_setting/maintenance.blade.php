@extends('adminlte::page')

@section('title', 'Maintenance Mode')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Maintenance Mode</h3>

        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                      4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                      0 0 1 0-.708l5-5a.5.5
                      0 0 1 .708.708L2.707 7.5H14.5A.5.5
                      0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('settings.maintenance.update') }}" method="POST">
                        @csrf

                        {{-- Maintenance Switch --}}
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-4 bg-light">
                            <div>
                                <h6 class="mb-1">Maintenance Mode</h6>
                                <small class="text-muted">
                                    Temporarily disable site access for users
                                </small>
                            </div>

                            <div class="form-check form-switch form-switch-lg">
                                <input class="form-check-input" type="checkbox" role="switch" id="maintenanceSwitch"
                                    name="is_maintenance" value="1"
                                    {{ $user->is_maintenance ?? false ? 'checked' : '' }}>
                            </div>
                        </div>

                        {{-- Status Indicator --}}
                        <div class="mb-3">
                            <small class="text-muted">
                                Current Status:
                                <span
                                    class="{{ $user->is_maintenance ?? false ? 'text-danger' : 'text-success' }} font-weight-bold">
                                    {{ $user->is_maintenance ?? false ? 'ON (Maintenance Enabled)' : 'OFF (Site Live)' }}
                                </span>
                            </small>
                        </div>

                        {{-- Custom Message --}}
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">
                                Maintenance Message
                            </label>
                            <textarea name="maintenance_message" class="form-control" rows="4"
                                placeholder="Enter the message users will see during maintenance">{{ $user->maintenance_message ?? '' }}</textarea>
                            <small class="text-muted">
                                This message will be shown when maintenance mode is enabled.
                            </small>
                        </div>

                        {{-- Save Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
