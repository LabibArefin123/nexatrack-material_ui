@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Proposal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New Proposal</h3>
        <a href="{{ route('proposals.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Subject --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}">
                        @error('subject')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Project --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Project <span class="text-danger">*</span></label>
                        <select name="project_id" class="form-control @error('project_id') is-invalid @enderror">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Deal --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Deal <span class="text-danger">*</span></label>
                        <select name="deal_id" class="form-control @error('deal_id') is-invalid @enderror">
                            <option value="">Select Deal</option>
                            @foreach ($deals as $deal)
                                <option value="{{ $deal->id }}" {{ old('deal_id') == $deal->id ? 'selected' : '' }}>
                                    {{ $deal->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('deal_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Currency <span class="text-danger">*</span></label>
                        <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                            <option value="">Select Currency</option>
                            <option value="taka" {{ old('currency') == 'taka' ? 'selected' : '' }}>৳</option>
                            <option value="rupee" {{ old('currency') == 'rupee' ? 'selected' : '' }}>₹</option>
                            <option value="dollar" {{ old('currency') == 'dollar' ? 'selected' : '' }}>$</option>
                            <option value="pound" {{ old('currency') == 'pound' ? 'selected' : '' }}>£</option>
                        </select>
                        @error('currency')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date') }}">
                        @error('date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Open Till Date <span class="text-danger">*</span></label>
                        <input type="date" name="open_till" class="form-control @error('open_till') is-invalid @enderror"
                            value="{{ old('open_till') }}">
                        @error('open_till')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Assigned To --}}
                    <div class="col-md-12 mt-3">
                        <label class="form-label fw-bold">Assigned To <span class="text-danger">*</span></label>

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            @foreach ($users as $user)
                                <div class="col">
                                    <div class="card h-100 p-2 shadow-sm d-flex align-items-center"
                                        style="cursor:pointer;"
                                        onclick="addAssigned({{ $user->id }}, '{{ $user->name }}')">

                                        <div class="d-flex align-items-center w-100">
                                            <img src="{{ $user->avatar ?? asset('uploads/images/default.jpg') }}"
                                                alt="Avatar" class="rounded-circle me-3"
                                                style="width: 50px; height: 50px; object-fit: cover;">

                                            <div class="text-start">
                                                <div class="fw-semibold text-dark" style="font-size: 14px;">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-muted" style="font-size: 13px;">
                                                    {{ '@' . ($user->username ?? Str::slug($user->name)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="assigned_to" id="assignedInput">
                        <div id="assignedList" class="mt-2 d-flex flex-wrap gap-1"></div>

                        @error('assigned_to')
                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tags <span class="text-danger">*</span></label>
                        <input type="text" id="tagsInput" class="form-control @error('tags') is-invalid @enderror"
                            placeholder="Enter tag">
                        <div id="tagsContainer" class="mt-2 d-flex flex-wrap gap-1"></div>
                        <input type="hidden" name="tags" id="tagsHidden">
                        @error('tags')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Attachment --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Attachment</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // --- Assigned Users ---
        let assigned = [];

        function addAssigned(id, name) {
            if (!assigned.includes(id)) {
                assigned.push(id);
                renderAssigned();
            }
        }

        function removeAssigned(id) {
            assigned = assigned.filter(i => i != id);
            renderAssigned();
        }

        function renderAssigned() {
            const list = document.getElementById('assignedList');
            list.innerHTML = '';
            assigned.forEach(id => {
                const userCard = document.createElement('span');
                let userName = document.querySelector(`.card[onclick*="addAssigned(${id}"] small`).innerText;
                userCard.className = 'badge bg-info text-dark d-flex align-items-center gap-1';
                userCard.innerHTML =
                    `${userName} <span style="cursor:pointer;" onclick="removeAssigned(${id})">&times;</span>`;
                list.appendChild(userCard);
            });
            document.getElementById('assignedInput').value = JSON.stringify(assigned);
        }

        // --- Tags ---
        let tags = [];
        const input = document.getElementById('tagsInput');
        const container = document.getElementById('tagsContainer');
        const hidden = document.getElementById('tagsHidden');

        function renderTags() {
            container.innerHTML = '';
            tags.forEach((tag, i) => {
                const span = document.createElement('span');
                span.className = 'badge bg-primary me-1 mb-1';
                span.style.cursor = 'pointer';
                span.innerHTML = `${tag} &times;`;
                span.addEventListener('click', () => {
                    tags.splice(i, 1);
                    updateHidden();
                    renderTags();
                });
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
        renderTags();
    </script>
@stop
