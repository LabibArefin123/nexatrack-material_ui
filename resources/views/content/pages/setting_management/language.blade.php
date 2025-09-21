@extends('layouts/contentNavbarLayout')

@section('title', 'Language Settings')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-language me-2"></i> Language Settings
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('settings.language.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="language" class="form-label">Select Language</label>
                        <select name="language" id="language" class="form-select">
                            @foreach ($languages as $code => $name)
                                <option value="{{ $code }}" {{ $currentLang === $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Language
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
