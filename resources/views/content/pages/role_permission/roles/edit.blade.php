@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Role')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-shield-lock text-primary"></i> Edit Role:
                <span class="text-info">{{ $role->name }}</span>
            </h4>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PUT')

            <!-- Role Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <strong><i class="bi bi-pencil-square"></i> Role Information</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Role Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                            value="{{ old('name', $role->name) }}">
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="mt-4">
                @forelse ($permissions as $group => $groupPermissions)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0 text-uppercase text-primary fw-bold">
                                <i class="bi bi-folder2-open"></i> {{ ucfirst($group) }}
                            </h6>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary select-all-btn"
                                    data-group="{{ \Illuminate\Support\Str::slug($group) }}">
                                    <i class="bi bi-check2-all"></i> Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger unselect-all-btn"
                                    data-group="{{ \Illuminate\Support\Str::slug($group) }}">
                                    <i class="bi bi-x-circle"></i> Unselect All
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($groupPermissions as $permission)
                                    <div class="col-md-4 col-sm-6 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                class="form-check-input perm-{{ \Illuminate\Support\Str::slug($group) }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No permissions available to assign.</div>
                @endforelse
            </div>

            <!-- Submit -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Update Role
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = true);
                });
            });

            document.querySelectorAll('.unselect-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = false);
                });
            });
        });
    </script>
@endsection
