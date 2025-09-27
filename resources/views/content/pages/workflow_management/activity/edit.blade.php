@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Activity')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Activity</h3>
        <a href="{{ route('activities.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 back-btn">
            <!-- back icon -->
            Back
        </a>
    </div>

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
                            value="{{ old('due_date', $activity->due_date->format('Y-m-d')) }}"
                            class="form-control @error('due_date') is-invalid @enderror">
                        @error('due_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Time --}}
                    <div class="form-group col-md-6">
                        <label for="time">Time</label>
                        <input type="time" name="time" id="time"
                            value="{{ old('time', $activity->time?->format('H:i')) }}"
                            class="form-control @error('time') is-invalid @enderror">
                        @error('time')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Reminder --}}
                    <div class="form-group col-md-6">
                        <label for="reminder">Reminder (minutes before)</label>
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
                        <select name="guests[]" id="guests" class="form-control" multiple>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ collect(old('guests', $activity->guests))->contains($customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $activity->description) }}</textarea>
                    </div>

                    {{-- Related Models --}}
                    <div class="form-group col-md-6">
                        <label for="deal_id">Deal</label>
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
                        <label for="contract_id">Contract</label>
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
                        <label for="company_id">Company</label>
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

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Activity</button>
                </div>
            </form>
        </div>
    </div>
@endsection
