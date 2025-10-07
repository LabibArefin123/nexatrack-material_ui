@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Task')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Task</h3>
        <a href="{{ route('tasks.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}"
                            required>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category</label>
                        <input type="text" name="category" class="form-control"
                            value="{{ old('category', $task->category) }}">
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
                            <button type="button" class="btn  btn-primary" onclick="showAddUserModal()">Add</button>
                        </div>
                        <input type="hidden" name="responsibles" id="responsiblesInput"
                            value="{{ old('responsibles', json_encode($task->responsibles)) }}">
                        <div id="responsiblesList" class="mt-2 d-flex flex-wrap gap-1"></div>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', $task->start_date?->format('Y-m-d')) }}" required>
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" class="form-control"
                            value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" required>
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tags</label>
                        <input type="text" id="tagsInput" class="form-control" placeholder="Enter tag">
                        <div id="tagsContainer" class="mt-2 d-flex flex-wrap gap-1"></div>
                        <input type="hidden" name="tags" id="tagsHidden"
                            value="{{ old('tags', json_encode($task->tags)) }}">
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Priority</label>
                        <select name="priority" class="form-control">
                            <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low
                            </option>
                            <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>
                                Medium</option>
                            <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High
                            </option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="Pending" {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="In Progress"
                                {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>
                                Completed</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="form-group col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // --- Responsible Persons ---
        let responsibles = {!! json_encode($task->responsibles ?? []) !!};

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
                // Find user name directly from PHP variable instead of DOM
                let user = {!! json_encode($users->keyBy('id')->map(fn($u) => $u->name)) !!};
                let userName = user[id] || 'Unknown';
                const userDiv = document.createElement('div');
                userDiv.className = 'badge bg-info text-dark d-flex align-items-center gap-1';
                userDiv.innerHTML =
                    `${userName} <span style="cursor:pointer;" onclick="removeResponsible(${id})">&times;</span>`;
                list.appendChild(userDiv);
            });
            document.getElementById('responsiblesInput').value = JSON.stringify(responsibles);
        }

        renderResponsibles();

        // --- Tags ---
        let tags = {!! json_encode($task->tags ?? []) !!};
        const input = document.getElementById('tagsInput');
        const container = document.getElementById('tagsContainer');
        const hidden = document.getElementById('tagsHidden');

        function renderTags() {
            container.innerHTML = '';
            tags.forEach((tag, index) => {
                const span = document.createElement('span');
                span.className = 'badge bg-primary me-1 mb-1';
                span.style.cursor = 'pointer';
                span.innerHTML = `${tag} &times;`;
                span.addEventListener('click', () => {
                    tags.splice(index, 1);
                    updateHidden();
                    renderTags();
                });
                container.appendChild(span);
            });
        }

        function updateHidden() {
            hidden.value = JSON.stringify(tags);
        }

        input.addEventListener('keyup', (e) => {
            if (e.key === ' ' && input.value.trim() !== '') { // SPACE dile tag add hobe
                let val = input.value.trim();
                tags.push(val);
                input.value = '';
                updateHidden();
                renderTags();
            }
        });

        renderTags();
    </script>
@stop
