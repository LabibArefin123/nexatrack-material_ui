@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">System Settings</h3>

        <div class="row g-4">
            <!-- Theme Change -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-paint-brush-line fs-1 text-primary"></i>
                    </div>
                    <h5 class="mb-2">Theme Change</h5>
                    <p class="text-muted small">Switch between light & dark mode</p>
                    <a href="{{ route('settings.theme') }}" class="btn  btn-outline-primary">Manage</a>
                </div>
            </div>

            <!-- Software Error / Log -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-bug-line fs-1 text-danger"></i>
                    </div>
                    <h5 class="mb-2">Software Error & Logs</h5>
                    <p class="text-muted small">Check recent system errors & logs</p>
                    <a href="{{ route('settings.logs') }}" class="btn  btn-outline-danger">View Logs</a>
                </div>
            </div>

            <!-- Database Backup / Download -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-database-2-line fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">Database Backup</h5>
                    <p class="text-muted small">Download & restore database backups</p>
                    <a href="{{ route('settings.database') }}" class="btn  btn-outline-success">Backup Now</a>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-notification-line fs-1 text-warning"></i>
                    </div>
                    <h5 class="mb-2">Notification Settings</h5>
                    <p class="text-muted small">Configure email, SMS & in-app notifications for the system</p>
                    <a href="#" class="btn btn-outline-warning">Manage</a>
                    {{-- <a href="{{ route('settings.notifications') }}" class="btn btn-outline-warning">Manage</a> --}}
                </div>
            </div>

            <!-- Email / SMTP Settings -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-mail-settings-line fs-1 text-info"></i>
                    </div>
                    <h5 class="mb-2">Email Settings</h5>
                    <p class="text-muted small">Configure outgoing emails for proposals, invoices, alerts</p>
                    <a href="#" class="btn btn-outline-info">Configure</a>
                    {{-- <a href="{{ route('settings.email') }}" class="btn btn-outline-info">Configure</a> --}}
                </div>
            </div>

            <!-- Integration Settings -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm setting-card h-100 text-center p-4">
                    <div class="setting-icon mb-3">
                        <i class="ri-plug-line fs-1 text-secondary"></i>
                    </div>
                    <h5 class="mb-2">Integration Settings</h5>
                    <p class="text-muted small">Connect CRM with tools like Slack, Google Calendar, Payment gateways</p>
                    {{-- <a href="{{ route('settings.integrations') }}" class="btn btn-outline-secondary">Manage</a> --}}
                    <a href="#" class="btn btn-outline-secondary">Manage</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .setting-card {
            border-radius: 1rem;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .setting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .setting-icon i {
            padding: 18px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
