@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Activity')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Activity</h3>
        <a href="{{ route('activities.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('activities.update', $activity->id) }}" method="POST" class="p-4">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    {{-- Title --}}
                    <div class="form-group col-md-6">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}"
                            class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Activity Type --}}
                    <div class="form-group col-md-6">
                        <label for="activity_type">Activity Type <span class="text-danger">*</span></label>
                        <select name="activity_type" id="activity_type"
                            class="form-control @error('activity_type') is-invalid @enderror">
                            <option value="">-- Select Type --</option>
                            @foreach (['call', 'email', 'task', 'meeting'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('activity_type', $activity->activity_type) == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('activity_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="form-group col-md-6">
                        <label for="due_date">Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" id="due_date"
                            value="{{ old('due_date', $activity->due_date?->format('Y-m-d')) }}"
                            class="form-control @error('due_date') is-invalid @enderror">
                        @error('due_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Time --}}
                    <div class="form-group col-md-6">
                        <label for="time">Time <span class="text-danger">*</span></label>
                        <input type="time" name="time" id="time"
                            value="{{ old('time', $activity->time?->format('H:i')) }}"
                            class="form-control @error('time') is-invalid @enderror">
                        @error('time')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Reminder --}}
                    <div class="form-group col-md-6">
                        <label for="reminder">Reminder (minutes before) <span class="text-danger">*</span></label>
                        <input type="number" name="reminder" id="reminder"
                            value="{{ old('reminder', $activity->reminder) }}"
                            class="form-control @error('reminder') is-invalid @enderror" placeholder="e.g. 15">
                        @error('reminder')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Owner --}}
                    <div class="form-group col-md-6">
                        <label for="owner_id">Owner <span class="text-danger">*</span></label>
                        <select name="owner_id" id="owner_id" class="form-control @error('owner_id') is-invalid @enderror">
                            <option value="">-- Select Owner --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('owner_id', $activity->owner_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Guests --}}
                    <div class="form-group col-md-12">
                        <label for="guests">Guests</label>
                        <div class="row g-2">
                            <!-- Filters -->
                            <div class="col-md-4">
                                <select id="filterSoftware" class="form-control">
                                    <option value="">-- Select Software --</option>
                                    @foreach ($softwares as $software)
                                        <option value="{{ $software }}">{{ $software }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="filterCountry" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="filterCustomer" class="form-control">
                                    <option value="">-- Select Customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" data-software="{{ $customer->software }}"
                                            data-country="{{ $customer->country }}" data-name="{{ $customer->name }}"
                                            data-phone="{{ $customer->phone }}"
                                            data-software-name="{{ $customer->software }}"
                                            data-img="{{ $customer->image ? asset('uploads/images/' . $customer->image) : asset('uploads/images/default.jpg') }}">
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="guests[]" id="selectedGuests"
                            value="{{ implode(',', (array) $activity->guests) }}">

                        <!-- Guests Grid -->
                        <div id="guestsGrid" class="row mt-3">
                            @php
                                $guestIds = collect($activity->guests)
                                    ->flatMap(fn($g) => explode(',', trim($g, '[]"')))
                                    ->filter()
                                    ->map(fn($id) => (int) $id);
                                $selectedGuests = \App\Models\Customer::whereIn('id', $guestIds)->get();
                            @endphp
                            @foreach ($selectedGuests as $guest)
                                <div class="col-md-4 mb-3 guest-card" data-id="{{ $guest->id }}">
                                    <div class="card h-100 shadow-sm p-2 position-relative">
                                        <button type="button"
                                            class="btn-close position-absolute top-0 end-0 m-1 removeGuest"></button>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $guest->image ? asset('uploads/images/' . $guest->image) : asset('uploads/images/default.jpg') }}"
                                                class="rounded me-2" width="60" height="60" alt="Customer">
                                            <div>
                                                <h6 class="mb-1">{{ $guest->name }}</h6>
                                                <small class="text-muted">{{ $guest->software ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-12">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $activity->description) }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Related Models --}}
                    <div class="form-group col-md-6">
                        <label for="deal_id">Deal <span class="text-danger">*</span></label>
                        <select name="deal_id" id="deal_id" class="form-control">
                            <option value="">-- Select Deal --</option>
                            @foreach ($deals as $deal)
                                <option value="{{ $deal->id }}"
                                    {{ old('deal_id', $activity->deal_id) == $deal->id ? 'selected' : '' }}>
                                    {{ $deal->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contract_id">Contract <span class="text-danger">*</span></label>
                        <select name="contract_id" id="contract_id" class="form-control">
                            <option value="">-- Select Contract --</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->id }}"
                                    {{ old('contract_id', $activity->contract_id) == $contract->id ? 'selected' : '' }}>
                                    {{ $contract->subject }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="company_id">Company <span class="text-danger">*</span></label>
                        <select name="company_id" id="company_id" class="form-control">
                            <option value="">-- Select Company --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id', $activity->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let selectedGuests = $('#selectedGuests').val() ? $('#selectedGuests').val().split(',') : [];

            // Filter Customers
            $('#filterSoftware, #filterCountry').on('change', function() {
                let software = $('#filterSoftware').val();
                let country = $('#filterCountry').val();
                $('#filterCustomer option').each(function() {
                    let s = $(this).data('software');
                    let c = $(this).data('country');
                    if ((!software || s == software) && (!country || c == country) || $(this)
                        .val() === "") {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Add Guest
            $('#filterCustomer').on('change', function() {
                let customer = $(this).find(':selected');
                let id = customer.val();
                if (id && !selectedGuests.includes(id)) {
                    selectedGuests.push(id);
                    let name = customer.data('name');
                    let software = customer.data('software-name');
                    let img = customer.data('img');
                    let card = `
                        <div class="col-md-4 mb-3 guest-card" data-id="${id}">
                            <div class="card h-100 shadow-sm p-2 position-relative">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-1 removeGuest"></button>
                                <div class="d-flex align-items-center">
                                    <img src="${img}" class="rounded me-2" width="60" height="60" alt="Customer">
                                    <div>
                                        <h6 class="mb-1">${name}</h6>
                                        <small class="text-muted">${software}</small>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#guestsGrid').append(card);
                    updateHiddenInput();
                }
            });

            // Remove Guest
            $(document).on('click', '.removeGuest', function() {
                let card = $(this).closest('.guest-card');
                let id = card.data('id');
                selectedGuests = selectedGuests.filter(g => g != id);
                card.remove();
                updateHiddenInput();
            });

            function updateHiddenInput() {
                $('#selectedGuests').val(selectedGuests.join(','));
            }
        });
    </script>
@endsection
