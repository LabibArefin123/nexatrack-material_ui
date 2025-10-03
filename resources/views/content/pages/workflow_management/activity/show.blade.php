@extends('layouts/contentNavbarLayout')

@section('title', 'Activity Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Activity Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('activities.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>
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
                    <input type="text" class="form-control"
                        value="{{ $activity->time ? \Carbon\Carbon::parse($activity->time)->format('h:i A') : '-' }}"
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
                    <div class="row">
                        @php
                            // guests string থেকে IDs বের করা
                            $guestIds = collect($activity->guests)
                                ->flatMap(fn($g) => explode(',', trim($g, '[]"')))
                                ->filter()
                                ->map(fn($id) => (int) $id);

                            $guests = \App\Models\Customer::whereIn('id', $guestIds)->get();
                        @endphp

                        @forelse ($guests as $guest)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="d-flex align-items-center p-2">
                                        <!-- Left side: Photo -->
                                        <img src="{{ $guest->photo ? asset('storage/' . $guest->photo) : asset('uploads/images/default.jpg') }}"
                                            class="rounded-circle me-3" width="50" height="50" alt="Guest Photo">

                                        <!-- Right side: Name & Software -->
                                        <div>
                                            <h6 class="mb-1">{{ $guest->name }}</h6>
                                            <small class="text-muted">{{ $guest->software ?? '-' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No guests found</p>
                        @endforelse
                    </div>
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
            </form>
        </div>
    </div>
@endsection
