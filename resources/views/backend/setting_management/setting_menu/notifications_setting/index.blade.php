@extends('adminlte::page')

@section('title', 'Notification Settings')

@section('content_header')
    <h1>🔔 Notification Settings</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Manage Notifications</h3>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('settings.notification.update') }}">
                @csrf

                <ul class="list-group mb-3">

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Enable/Disable Notifications</strong>
                        <input type="checkbox" name="is_notifications" {{ $user->is_notifications ? 'checked' : '' }}>
                    </li>

                    <li class="list-group-item">
                        <strong>Notification Channels</strong><br>
                        Email, SMS, Web Push, In-App Alerts
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Email Sender (from .env):</strong><br>
                            {{ config('mail.from.address') }} ({{ config('mail.from.name') }})
                        </div>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#mailConfigModal">
                            More Info
                        </button>
                    </li>
                </ul>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>

            <hr>

            <form method="POST" action="{{ route('settings.notification.test') }}">
                @csrf
                {{-- <button type="submit" class="text-right btn btn-success">
                    📧 Send Test Notification Email
                </button> --}}
                <div class="text-right mt-3">
                    <button class="btn btn-success btn-sm">
                        📧 Send Test Notification Email
                    </button>
                </div>
            </form>
        </div>
        <!-- Mail Config Modal -->
        <div class="modal fade" id="mailConfigModal" tabindex="-1" aria-labelledby="mailConfigModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="mailConfigModalLabel">Mail Configuration Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <strong>MAIL_MAILER:</strong> {{ config('mail.default') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_HOST:</strong> {{ config('mail.mailers.smtp.host') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_PORT:</strong> {{ config('mail.mailers.smtp.port') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_USERNAME:</strong> {{ config('mail.username') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_PASSWORD:</strong> {{ str_repeat('*', strlen(config('mail.password'))) }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_ENCRYPTION:</strong> {{ config('mail.mailers.smtp.encryption') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_FROM_ADDRESS:</strong> {{ config('mail.from.address') }}
                            </li>

                            <li class="list-group-item">
                                <strong>MAIL_FROM_NAME:</strong> {{ config('mail.from.name') }}
                            </li>

                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
