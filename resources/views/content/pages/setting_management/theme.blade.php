@extends('layouts/contentNavbarLayout')

@section('title', 'Theme Settings')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Theme Settings</h3>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <form method="POST" action="{{ route('settings.theme.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Theme</label>
                            <select name="theme" class="form-select">
                                <option value="light" {{ $currentTheme == 'light' ? 'selected' : '' }}>🌞 Light</option>
                                <option value="dark" {{ $currentTheme == 'dark' ? 'selected' : '' }}>🌙 Dark</option>
                                <option value="system" {{ $currentTheme == 'system' ? 'selected' : '' }}>💻 System Default
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Theme</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
