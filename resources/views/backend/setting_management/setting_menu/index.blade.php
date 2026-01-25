@extends('adminlte::page')

@section('title', 'System Settings')

@section('content_header')
    <h3 class="mb-0">System Settings</h3>
@stop

@section('content')

    <div class="container-fluid">

        {{-- Main Settings Accordion --}}
        <div class="accordion" id="settingsAccordion">

            {{-- Security Settings --}}
            <div class="card" id="security">
                <div class="card-header bg-primary text-white" data-toggle="collapse" data-target="#securitySettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">🔐 Security Settings</h5>
                </div>
                <div id="securitySettings" class="collapse show" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="{{ route('settings.2fa') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Two-Factor Authentication (2FA)</strong><br>
                                        <small class="text-muted">Enable/Disable 2FA, choose provider Email/SMS/App</small>
                                    </div>

                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>


                            <li class="list-group-item">
                                <a href="{{ route('settings.password_policy') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Password Policy</strong><br>
                                        Minimum length, symbols, numbers, expiry days
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('settings.timeout') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Session Timeout / Auto Logout</strong><br>
                                        Auto logout after X minutes of inactivity
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <strong>IP Whitelist</strong> (optional)<br>
                                Allow specific IPs to access admin panel
                            </li>

                        </ul>

                    </div>
                </div>
            </div>


            {{-- Notification Settings --}}
            <div class="card" id="notifications">
                <div class="card-header bg-info text-white" data-toggle="collapse" data-target="#notificationSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">🔔 Notification Settings</h5>
                </div>
                <div id="notificationSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <strong>Enable/Disable Notifications</strong>
                            </li>

                            <li class="list-group-item">
                                <strong>Notification Triggers</strong><br>
                                Meeting schedule, visitor approval, pass expiry, emergency alerts, system errors
                            </li>

                            <li class="list-group-item">
                                <strong>Notification Channels</strong><br>
                                Email, SMS, Web Push, In-App Alerts
                            </li>

                        </ul>

                    </div>
                </div>
            </div>


            {{-- System Settings --}}
            <div class="card" id="system">
                <div class="card-header bg-secondary text-white" data-toggle="collapse" data-target="#systemSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">🛠️ System Settings</h5>
                </div>
                <div id="systemSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('settings.language') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Language Setting</strong><br>
                                        Changes the system language like bangla -> english
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="{{ route('settings.datetime') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Date & Time Settings</strong><br>
                                        Timezone, date format, time format
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            {{-- Logs --}}
            <div class="card" id="logs">
                <div class="card-header bg-dark text-white" data-toggle="collapse" data-target="#logSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">📂 Log & Debug Settings</h5>
                </div>
                <div id="logSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="{{ route('settings.logs') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Error Log Viewer</strong><br>
                                        View, download, clear logs
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            {{-- Integration --}}
            {{-- <div class="card" id="integration">
                <div class="card-header bg-purple text-white" data-toggle="collapse" data-target="#integrationSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">🌐 Integration Settings</h5>
                </div>
                <div id="integrationSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <strong>SMS Gateway</strong><br>
                                API key & Sender ID
                            </li>

                            <li class="list-group-item">
                                <strong>Email SMTP</strong><br>
                                Host, port, username, encryption
                            </li>

                            <li class="list-group-item">
                                <strong>API Access Tokens</strong><br>
                                External app integration, regenerate tokens
                            </li>

                        </ul>

                    </div>
                </div>
            </div> --}}


            {{-- UI Settings --}}
            <div class="card" id="ui">
                <div class="card-header bg-pink text-white" data-toggle="collapse" data-target="#uiSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">🎨 UI Settings</h5>
                </div>
                <div id="uiSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="{{ route('settings.theme') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Theme Mode</strong><br>
                                        Light / Dark / Custom colors
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <strong>Sidebar Settings</strong><br>
                                Collapse by default, show/hide icons
                            </li>

                        </ul>

                    </div>
                </div>
            </div>


            {{-- Backup & Maintenance --}}
            <div class="card" id="backup">
                <div class="card-header bg-orange text-white" data-toggle="collapse" data-target="#backupSettings"
                    style="cursor:pointer;">
                    <h5 class="mb-0">💾 Backup & Maintenance</h5>
                </div>
                <div id="backupSettings" class="collapse" data-parent="#settingsAccordion">
                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="{{ route('settings.database.backup') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>System Backup</strong><br>
                                        Create, download, schedule auto-backup
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="{{ route('settings.maintenance') }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Maintenance Mode</strong><br>
                                        Enable/Disable, custom message
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop
