@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Task')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New Task</h3>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    {{-- Error Box --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category') }}">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Responsible Persons --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Responsible Persons <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($users as $user)
                                <div class="card text-center p-1" style="width: 70px; cursor: pointer;"
                                    onclick="addResponsible({{ $user->id }}, '{{ $user->name }}')">
                                    <img src="{{ $user->avatar ?? asset('uploads/images/default.jpg') }}"
                                        class="rounded-circle mb-1" style="width:40px; height:40px;">
                                    <small>{{ Str::limit($user->name, 6) }}</small>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="responsibles" id="responsiblesInput">
                        <div id="responsiblesList" class="mt-2 d-flex flex-wrap gap-1"></div>
                        @error('responsibles')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                            value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tags <span class="text-danger">*</span></label>
                        <input type="text" id="tagsInput" class="form-control" placeholder="Enter tag">
                        <div id="tagsContainer" class="mt-2 d-flex flex-wrap gap-1"></div>
                        <input type="hidden" name="tags" id="tagsHidden">
                        @error('tags')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
                        <select name="priority" class="form-control @error('priority') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Save Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let responsibles = [];

        function addResponsible(id, name) {
            if (!responsibles.includes(id)) {
                responsibles.push(id);
                renderResponsibles();
            }
        }

        function removeResponsible(id) {
            responsibles = responsibles.filter(r => r != id);
            renderResponsibles();
        }

        function renderResponsibles() {
            const list = document.getElementById('responsiblesList');
            list.innerHTML = '';
            responsibles.forEach(id => {
                const userName = document.querySelector(`.card[onclick*="addResponsible(${id}"] small`).innerText;
                const badge = document.createElement('span');
                badge.className = 'badge bg-info text-dark me-1 mb-1';
                badge.style.cursor = 'pointer';
                badge.innerHTML = `${userName} &times;`;
                badge.onclick = () => removeResponsible(id);
                list.appendChild(badge);
            });
            document.getElementById('responsiblesInput').value = JSON.stringify(responsibles);
        }

        // Tags
        let tags = [];
        const input = document.getElementById('tagsInput');
        const container = document.getElementById('tagsContainer');
        const hidden = document.getElementById('tagsHidden');

        function renderTags() {
            container.innerHTML = '';
            tags.forEach((tag, i) => {
                const span = document.createElement('span');
                span.className = 'badge bg-primary me-1 mb-1';
                span.innerHTML = `${tag} &times;`;
                span.onclick = () => {
                    tags.splice(i, 1);
                    updateHidden();
                    renderTags();
                };
                container.appendChild(span);
            });
        }

        function updateHidden() {
            hidden.value = JSON.stringify(tags);
        }
        input.addEventListener('keyup', e => {
            if (e.key === ' ' && input.value.trim() !== '') {
                tags.push(input.value.trim());
                input.value = '';
                updateHidden();
                renderTags();
            }
        });
    </script>
@endsection
