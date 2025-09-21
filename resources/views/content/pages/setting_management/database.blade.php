@extends('layouts/contentNavbarLayout')

@section('title', 'Database Backup')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Full Database Download -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-dark text-white">Full Database Backup</div>
                    <div class="card-body text-center">
                        <form method="POST" action="{{ route('settings.database.download') }}">
                            @csrf
                            <button class="btn btn-primary">
                                <i class="fas fa-database me-1"></i> Download Full Database
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table-wise Download -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-dark text-white">Table-wise Backup</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.database.downloadTable') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="table" class="form-label">Select Table</label>
                                <select name="table" id="table" class="form-select" required>
                                    <option value="">-- Select Table --</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table }}">{{ $table }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-success">
                                <i class="fas fa-table me-1"></i> Download Selected Table
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
