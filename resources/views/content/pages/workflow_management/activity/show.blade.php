@extends('layouts/contentNavbarLayout')

@section('title', 'Activity Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Activity Details</h3>
        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning">Edit</a>
    </div>
    @php
        // Guests er IDs theke customer names fetch kora
        $guestNames = \App\Models\Customer::whereIn('id', $activity->guests ?? [])
            ->pluck('name')
            ->join(', ');
    @endphp

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-6 form-group">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" value="{{ $activity->title }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Type</label>
                    <input type="text" class="form-control" value="{{ ucfirst($activity->activity_type) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Due Date</label>
                    <input type="text" class="form-control" value="{{ $activity->due_date->format('d M Y') }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Time</label>
                    <input type="text" class="form-control" value="{{ $activity->time?->format('H:i') ?? '-' }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Owner</label>
                    <input type="text" class="form-control" value="{{ $activity->owner->name ?? '-' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Reminder (minutes)</label>
                    <input type="text" class="form-control" value="{{ $activity->reminder ?? '-' }}" readonly>
                </div>

                <div class="col-md-12 form-group">
                    <label class="form-label">Guests</label>
                    <input type="text" class="form-control" value="{{ $guestNames }}" readonly>
                </div>

                <div class="col-md-12 form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" readonly>{{ $activity->description ?? '-' }}</textarea>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Deal</label>
                    <input type="text" class="form-control" value="{{ $activity->deal->name ?? '-' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Contract</label>
                    <input type="text" class="form-control" value="{{ $activity->contract->subject ?? '-' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Company</label>
                    <input type="text" class="form-control" value="{{ $activity->company->name ?? '-' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">Created At</label>
                    <input type="text" class="form-control" value="{{ $activity->created_at->format('d M Y, h:i a') }}"
                        readonly>
                </div>
            </form>
        </div>
    </div>
@endsection
