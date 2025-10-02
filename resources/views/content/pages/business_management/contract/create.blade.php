@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Contract')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New Contract</h3>
        <a href="{{ route('contracts.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
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

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contract Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Choose Type</option>
                            <option value="contracts_under_seal"
                                {{ old('type') == 'contracts_under_seal' ? 'selected' : '' }}>Contracts Under Seal</option>
                            <option value="implied_contracts" {{ old('type') == 'implied_contracts' ? 'selected' : '' }}>
                                Implied Contracts</option>
                            <option value="executory_contracts"
                                {{ old('type') == 'executory_contracts' ? 'selected' : '' }}>Executory Contracts</option>
                            <option value="voidable_contracts" {{ old('type') == 'voidable_contracts' ? 'selected' : '' }}>
                                Voidable Contracts</option>
                        </select>
                        @error('type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contract Value <span class="text-danger">*</span></label>
                        <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value') }}" placeholder="Enter contract value">
                        @error('value')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date') }}">
                        @error('end_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Attachment --}}
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

                    <div class="col-12 text-end mt-2">
                        <button type="submit" class="btn btn-success">Save contract</button>
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
