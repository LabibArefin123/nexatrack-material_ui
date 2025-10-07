@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Proposal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Proposal</h3>
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

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    {{-- Subject --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject', $proposal->subject) }}">
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
                                <option value="{{ $client->id }}"
                                    {{ old('client_id', $proposal->client_id) == $client->id ? 'selected' : '' }}>
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
                                    {{ old('project_id', $proposal->project_id) == $project->id ? 'selected' : '' }}>
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
                                <option value="{{ $deal->id }}"
                                    {{ old('deal_id', $proposal->deal_id) == $deal->id ? 'selected' : '' }}>
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
                            <option value="taka" {{ old('currency', $proposal->currency) == 'taka' ? 'selected' : '' }}>৳
                            </option>
                            <option value="rupee" {{ old('currency', $proposal->currency) == 'rupee' ? 'selected' : '' }}>
                                ₹</option>
                            <option value="dollar"
                                {{ old('currency', $proposal->currency) == 'dollar' ? 'selected' : '' }}>$</option>
                            <option value="pound" {{ old('currency', $proposal->currency) == 'pound' ? 'selected' : '' }}>
                                £</option>
                        </select>
                        @error('currency')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status', $proposal->status) == 'draft' ? 'selected' : '' }}>
                                Draft</option>
                            <option value="sent" {{ old('status', $proposal->status) == 'sent' ? 'selected' : '' }}>Sent
                            </option>
                            <option value="accepted"
                                {{ old('status', $proposal->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected"
                                {{ old('status', $proposal->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', optional($proposal->date)->format('Y-m-d')) }}">
                        @error('date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Open Till Date <span class="text-danger">*</span></label>
                        <input type="date" name="open_till" class="form-control @error('open_till') is-invalid @enderror"
                            value="{{ old('open_till', optional($proposal->open_till)->format('Y-m-d')) }}">
                        @error('open_till')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Assigned To --}}
                    <div class="col-md-12 mt-3">
                        <label class="form-label fw-bold">Assigned To <span class="text-danger">*</span></label>

                        @php
                            $assignedIds = is_array($proposal->assigned_to)
                                ? $proposal->assigned_to
                                : explode(',', $proposal->assigned_to ?? '');
                        @endphp

                        {{-- User grid --}}
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            @foreach ($users as $user)
                                @php $isAssigned = in_array($user->id, $assignedIds); @endphp
                                <div class="col">
                                    <div class="card h-100 p-2 shadow-sm d-flex align-items-center assigned-card
                    {{ $isAssigned ? 'border border-primary border-2' : '' }}"
                                        style="cursor:pointer; transition:all .2s;"
                                        onclick="toggleAssigned({{ $user->id }}, '{{ $user->name }}', this)">

                                        <div class="d-flex align-items-center w-100">
                                            <img src="{{ $user->avatar ?? asset('uploads/images/default.jpg') }}"
                                                alt="Avatar" class="rounded-circle me-3"
                                                style="width:50px;height:50px;object-fit:cover;">
                                            <div class="text-start">
                                                <div class="fw-semibold text-dark" style="font-size:14px;">
                                                    {{ $user->name }}</div>
                                                <div class="text-muted" style="font-size:13px;">
                                                    {{ '@' . ($user->username ?? Str::slug($user->name)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Hidden input for IDs --}}
                        <input type="hidden" name="assigned_to" id="assignedInput"
                            value="{{ implode(',', $assignedIds) }}">

                        {{-- Selected badges --}}
                        <div id="assignedList" class="mt-2 d-flex flex-wrap gap-1">
                            @foreach ($users->whereIn('id', $assignedIds) as $user)
                                <span class="badge bg-primary d-flex align-items-center gap-1"
                                    id="badge-{{ $user->id }}">
                                    {{ $user->name }}
                                    <button type="button" class="btn-close btn-close-white btn-sm ms-1"
                                        aria-label="Remove" onclick="removeAssigned({{ $user->id }})"></button>
                                </span>
                            @endforeach
                        </div>

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

                        @if ($proposal->attachment)
                            <div class="mt-1">
                                <small class="text-muted">Current file:</small>
                                <a href="{{ asset('uploads/proposals/' . $proposal->attachment) }}" target="_blank"
                                    class="d-block">
                                    {{ $proposal->attachment }}
                                </a>
                            </div>
                        @endif
                    </div>


                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $proposal->description) }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
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
        // --- ASSIGNED USERS ---
        let assigned = @json($proposal->assigned_to ?? []);
        if (typeof assigned === 'string') {
            try {
                assigned = JSON.parse(assigned);
            } catch (e) {
                assigned = assigned ? assigned.split(',') : [];
            }
        }

        function toggleAssigned(id, username, card) {
            id = id.toString();
            const input = document.getElementById('assignedInput');
            const list = document.getElementById('assignedList');
            const index = assigned.indexOf(id);

            if (index !== -1) {
                // Remove user
                assigned.splice(index, 1);
                card.classList.remove('border', 'border-primary', 'border-2');
                const badge = document.getElementById('badge-' + id);
                if (badge) badge.remove();
            } else {
                // Add user
                assigned.push(id);
                card.classList.add('border', 'border-primary', 'border-2');

                const badge = document.createElement('span');
                badge.className = 'badge bg-primary d-flex align-items-center gap-1';
                badge.id = 'badge-' + id;
                badge.innerHTML = `
                @${username}
                <button type="button" class="btn-close btn-close-white btn-sm ms-1"
                    aria-label="Remove" onclick="removeAssigned(${id})"></button>
            `;
                list.appendChild(badge);
            }

            input.value = JSON.stringify(assigned);
        }

        function removeAssigned(id) {
            id = id.toString();
            const input = document.getElementById('assignedInput');
            const list = document.getElementById('assignedList');
            assigned = assigned.filter(v => v !== id);
            input.value = JSON.stringify(assigned);

            const badge = document.getElementById('badge-' + id);
            if (badge) badge.remove();

            const card = document.querySelector(`.assigned-card[onclick*="toggleAssigned(${id},"]`);
            if (card) card.classList.remove('border', 'border-primary', 'border-2');
        }

        function renderAssigned() {
            const list = document.getElementById('assignedList');
            list.innerHTML = '';
            assigned.forEach(id => {
                const card = document.querySelector(`.assigned-card[onclick*="toggleAssigned(${id},"]`);
                if (card) card.classList.add('border', 'border-primary', 'border-2');

                const username = card?.querySelector('.text-muted')?.innerText?.replace('@', '') ?? 'user';
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary d-flex align-items-center gap-1';
                badge.id = 'badge-' + id;
                badge.innerHTML = `
                @${username}
                <button type="button" class="btn-close btn-close-white btn-sm ms-1"
                    aria-label="Remove" onclick="removeAssigned(${id})"></button>
            `;
                list.appendChild(badge);
            });
            document.getElementById('assignedInput').value = JSON.stringify(assigned);
        }

        // --- TAGS ---
        let tags = @json($proposal->tags ?? []);
        if (typeof tags === 'string') {
            try {
                tags = JSON.parse(tags);
            } catch (e) {
                tags = tags ? tags.split(',') : [];
            }
        }

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
            updateHidden();
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

        // INITIALIZE
        renderAssigned();
        renderTags();
    </script>
@endsection
