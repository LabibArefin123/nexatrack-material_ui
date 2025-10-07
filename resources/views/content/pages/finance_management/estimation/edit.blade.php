@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Estimate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Estimate</h3>
        <a href="{{ route('estimations.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <form action="{{ route('estimations.update', $estimation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control @error('company_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('company_id', $estimation->company_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Bill To --}}
                    <div class="form-group col-md-6">
                        <label class="form-label fw-bold">Bill To <span class="text-danger">*</span></label>
                        <input type="text" name="bill_to" id="bill_to"
                            value="{{ old('bill_to', $estimation->bill_to) }}"
                            class="form-control @error('bill_to') is-invalid @enderror">
                        @error('bill_to')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Ship To --}}
                    <div class="form-group col-md-6">
                        <label class="form-label fw-bold">Ship To <span class="text-danger">*</span></label>
                        <input type="text" name="ship_to" id="ship_to"
                            value="{{ old('ship_to', $estimation->ship_to) }}"
                            class="form-control @error('ship_to') is-invalid @enderror">
                        @error('ship_to')
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
                                    {{ old('project_id', $estimation->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estimate By --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Estimate By <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $estimation->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $estimation->amount) }}" placeholder="Enter amount">
                        @error('amount')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Currency <span class="text-danger">*</span></label>
                        <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                            <option value="">Select Currency</option>
                            <option value="taka"
                                {{ old('currency', $estimation->currency) == 'taka' ? 'selected' : '' }}>৳</option>
                            <option value="rupee"
                                {{ old('currency', $estimation->currency) == 'rupee' ? 'selected' : '' }}>₹</option>
                            <option value="dollar"
                                {{ old('currency', $estimation->currency) == 'dollar' ? 'selected' : '' }}>$</option>
                            <option value="pound"
                                {{ old('currency', $estimation->currency) == 'pound' ? 'selected' : '' }}>£</option>
                        </select>
                        @error('currency')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estimate Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Estimate Date <span class="text-danger">*</span></label>
                        <input type="date" name="estimate_date"
                            class="form-control @error('estimate_date') is-invalid @enderror"
                            value="{{ old('estimate_date', $estimation->estimate_date ? \Carbon\Carbon::parse($estimation->estimate_date)->format('Y-m-d') : '') }}">
                        @error('estimate_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Expiry Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Expiry Date <span class="text-danger">*</span></label>
                        <input type="date" name="expiry_date"
                            class="form-control @error('expiry_date') is-invalid @enderror"
                            value="{{ old('expiry_date', $estimation->expiry_date ? \Carbon\Carbon::parse($estimation->expiry_date)->format('Y-m-d') : '') }}">
                        @error('expiry_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            <option value="draft" {{ old('status', $estimation->status) == 'draft' ? 'selected' : '' }}>
                                Draft</option>
                            <option value="sent" {{ old('status', $estimation->status) == 'sent' ? 'selected' : '' }}>
                                Sent</option>
                            <option value="accepted"
                                {{ old('status', $estimation->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected"
                                {{ old('status', $estimation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Tags <span class="text-danger">*</span></label>
                        <input type="text" id="tagsInput" class="form-control" placeholder="Enter tag">
                        <div id="tagsContainer" class="mt-2 d-flex flex-wrap gap-1"></div>
                        <input type="hidden" name="tags" id="tagsHidden" value='@json(old('tags', $estimation->tags ?? []))'>
                        @error('tags')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Attachment (optional) --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Attachment</label>
                        <input type="file" name="attachment" class="form-control">
                        @if ($estimation->attachment)
                            <a href="{{ asset('storage/' . $estimation->attachment) }}" target="_blank"
                                class="d-block mt-2">
                                View Current Attachment
                            </a>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $estimation->description) }}</textarea>
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
        // --- Tags ---
        // --- Tags ---
        let tags = [];

        // Load existing tags from hidden input
        const hidden = document.getElementById('tagsHidden');
        if (hidden.value) {
            try {
                tags = JSON.parse(hidden.value);
            } catch (e) {
                tags = hidden.value.split(',').map(t => t.trim());
            }
        }

        const input = document.getElementById('tagsInput');
        const container = document.getElementById('tagsContainer');

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

        // Add new tag on spacebar
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
