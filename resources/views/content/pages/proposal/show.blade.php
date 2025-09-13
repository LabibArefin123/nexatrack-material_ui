@extends('layouts/contentNavbarLayout')

@section('title', 'View Proposal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">View Proposal</h3>
        <a href="{{ route('proposals.edit', $proposal->id) }}" class="btn btn-sm btn-primary">Edit Proposal</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                {{-- Subject --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" class="form-control" value="{{ $proposal->subject }}" readonly>
                </div>

                {{-- Client --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <input type="text" class="form-control" value="{{ $proposal->customer->name ?? '-' }}" readonly>
                </div>

                {{-- Project --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Project</label>
                    <input type="text" class="form-control" value="{{ $proposal->project->name ?? '-' }}" readonly>
                </div>

                {{-- Deal --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Deal</label>
                    <input type="text" class="form-control" value="{{ $proposal->deal->name ?? '-' }}" readonly>
                </div>

                {{-- Currency --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Currency</label>
                    <input type="text" class="form-control" value="{{ ucfirst($proposal->currency ?? '-') }}" readonly>
                </div>

                {{-- Status --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($proposal->status ?? '-') }}" readonly>
                </div>

                {{-- Dates --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="text" class="form-control" value="{{ $proposal->date?->format('d/m/Y') ?? '-' }}"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Open Till</label>
                    <input type="text" class="form-control" value="{{ $proposal->open_till?->format('d/m/Y') ?? '-' }}"
                        readonly>
                </div>

                {{-- Assigned To --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Assigned To</label>
                    <div class="d-flex flex-wrap gap-1">
                        @php
                            $assignedUsers = is_array($proposal->assigned_to)
                                ? $proposal->assigned_to
                                : json_decode($proposal->assigned_to, true);
                        @endphp
                        @if ($assignedUsers && is_array($assignedUsers))
                            @foreach ($assignedUsers as $user_id)
                                @php
                                    $user = \App\Models\User::find($user_id);
                                @endphp
                                <span class="badge bg-info">{{ $user->name ?? 'User' }}</span>
                            @endforeach
                        @else
                            -
                        @endif
                    </div>
                </div>

                {{-- Tags --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Tags</label>
                    <div class="d-flex flex-wrap gap-1">
                        @if ($proposal->tags)
                            @foreach (json_decode($proposal->tags, true) as $tag)
                                <span class="badge bg-primary">{{ $tag }}</span>
                            @endforeach
                        @else
                            -
                        @endif
                    </div>
                </div>

                {{-- Attachment --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Attachment</label>
                    @if ($proposal->attachment)
                        <div>
                            <a href="{{ asset('uploads/proposals/' . $proposal->attachment) }}" target="_blank">
                                {{ $proposal->attachment }}
                            </a>
                        </div>
                    @else
                        -
                    @endif
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control" rows="4" readonly>{{ $proposal->description }}</textarea>
                </div>

            </div>
        </div>
    </div>
@endsection
