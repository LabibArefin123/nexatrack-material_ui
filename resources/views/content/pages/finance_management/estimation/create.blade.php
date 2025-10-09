@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Estimate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New Estimate</h3>
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
            <form action="{{ route('estimations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control @error('company_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('company_id') == $client->id ? 'selected' : '' }}>
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
                        <input type="text" name="bill_to" id="bill_to" value="{{ old('bill_to') }}"
                            class="form-control @error('bill_to') is-invalid @enderror">
                        @error('bill_to')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Ship To --}}
                    <div class="form-group col-md-6">
                        <label class="form-label fw-bold">Ship To <span class="text-danger">*</span></label>
                        <input type="text" name="ship_to" id="ship_to" value="{{ old('ship_to') }}"
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
                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
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
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            value="{{ old('amount') }}" placeholder="Enter amount">
                        @error('amount')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-6">
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

                    {{-- Estimate Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Estimate Date <span class="text-danger">*</span></label>
                        <input type="date" name="estimate_date"
                            class="form-control @error('estimate_date') is-invalid @enderror"
                            value="{{ old('estimate_date') }}">
                        @error('estimate_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Expiry Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Expiry Date <span class="text-danger">*</span></label>
                        <input type="date" name="expiry_date"
                            class="form-control @error('expiry_date') is-invalid @enderror"
                            value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
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

                    {{-- Tags --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Tags <span class="text-danger">*</span></label>
                        <input type="text" id="tagsInput" class="form-control @error('tags') is-invalid @enderror"
                            placeholder="Enter tag">
                        <div id="tagsContainer" class="mt-2 d-flex flex-wrap gap-1"></div>
                        <input type="hidden" name="tags" id="tagsHidden">
                        @error('tags')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Attachment (optional) --}}
                    <div class="col-md-12">
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
