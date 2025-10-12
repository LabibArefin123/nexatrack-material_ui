@extends('layouts/contentNavbarLayout')

@section('title', 'Proposals List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Proposals List</h3>
        <a href="{{ route('proposals.create') }}" class="btn btn-primary">+ Add New Proposal</a>
    </div>

    @php
        $draftProposals = $proposals->where('status', 'draft');
    @endphp

    @if ($draftProposals->isNotEmpty())
        <div class="d-flex align-items-center justify-content-between mb-3 p-2 border rounded"
            style="background: #fff; box-shadow: 0 0 6px rgba(0,0,0,0.1);">
            <div>
                <strong>You have total {{ $draftProposals->count() }} draft proposal(s) pending</strong>
            </div>
            <button id="draftBadgeBtn" class="btn btn-danger rounded-circle position-relative"
                style="width: 50px; height: 50px; font-size: 0.9rem; font-weight: bold;">
                {{ $draftProposals->count() }}
            </button>
        </div>

        {{-- Modal Overlay --}}
        <div id="draftModal" class="draft-modal" style="display: none;">
            <div class="draft-modal-content p-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-warning fw-bold mb-0">Draft Proposals ({{ $draftProposals->count() }})</h6>
                    <button id="draftModalClose" class="btn btn-sm btn-danger">&times;</button>
                </div>
                <div class="row g-2">
                    @foreach ($draftProposals as $proposal)
                        <div class="col-md-3">
                            <div class="card shadow-sm border-warning h-100" style="font-size: 0.8rem;">
                                <div class="card-body d-flex flex-column p-2">
                                    <h6 class="card-title text-truncate">{{ $proposal->subject }}</h6>
                                    <p class="mb-1"><strong>Client:</strong> {{ $proposal->customer->name ?? '-' }}</p>
                                    <p class="mb-1"><strong>Project:</strong> {{ $proposal->project->name ?? '-' }}</p>
                                    <p class="mb-1"><strong>Deal:</strong> {{ $proposal->deal->name ?? '-' }}</p>
                                    <p class="mb-1"><strong>Open Till:</strong>
                                        {{ $proposal->open_till ? $proposal->open_till->format('d/m/Y') : '-' }}</p>
                                    <div class="mt-auto d-flex justify-content-between">
                                        <a href="{{ route('proposals.edit', $proposal->id) }}"
                                            class="btn btn-sm btn-primary" style="font-size: 0.7rem;">Edit</a>
                                        <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-size: 0.7rem;"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Styles --}}
        <style>
            .draft-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.4);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1050;
            }

            .draft-modal-content {
                background: #fff;
                border-radius: 8px;
                max-width: 800px;
                width: 90%;
                max-height: 60%;
                overflow-y: auto;
                font-size: 0.85rem;
            }

            .draft-modal-content::-webkit-scrollbar {
                width: 6px;
            }

            .draft-modal-content::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 3px;
            }
        </style>

        {{-- Script --}}
        <script>
            const draftBadgeBtn = document.getElementById('draftBadgeBtn');
            const draftModal = document.getElementById('draftModal');
            const draftModalClose = document.getElementById('draftModalClose');

            draftBadgeBtn.addEventListener('click', () => {
                draftModal.style.display = 'flex';
            });

            draftModalClose.addEventListener('click', () => {
                draftModal.style.display = 'none';
            });

            draftModal.addEventListener('click', (e) => {
                if (e.target === draftModal) {
                    draftModal.style.display = 'none';
                }
            });
        </script>
    @endif

    <div class="card mb-3 p-3">
        <form action="{{ route('proposals.index') }}" method="GET" class="row g-2">
            {{-- Status --}}
            <div class="col-md-2">
                <label for="status" class="form-label fw-bold">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                </select>
            </div>

            {{-- Start Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            {{-- End Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            {{-- Submit --}}
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Deal</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>Open Till</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->subject }}</td>
                            <td>{{ $proposal->customer->name ?? '-' }}</td>
                            <td>{{ $proposal->project->name ?? '-' }}</td>
                            <td>{{ $proposal->deal->name ?? '-' }}</td>
                            <td>{{ $proposal->currency ?? '-' }}</td>
                            <td>{{ ucfirst($proposal->status ?? '-') }}</td>
                            <td>
                                @php
                                    $assignedUsers = is_array($proposal->assigned_to)
                                        ? $proposal->assigned_to
                                        : (is_string($proposal->assigned_to)
                                            ? json_decode($proposal->assigned_to ?? '[]', true)
                                            : []);
                                @endphp
                                @if (!empty($assignedUsers))
                                    @foreach ($assignedUsers as $user_id)
                                        @php $user = \App\Models\User::find($user_id); @endphp
                                        <span class="badge bg-info">{{ $user->name ?? 'User' }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $tags = is_array($proposal->tags)
                                        ? $proposal->tags
                                        : (is_string($proposal->tags)
                                            ? json_decode($proposal->tags ?? '[]', true)
                                            : []);
                                @endphp
                                @if (!empty($tags))
                                    @foreach ($tags as $tag)
                                        <span class="badge bg-info">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $proposal->date ? $proposal->date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $proposal->open_till ? $proposal->open_till->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('proposals.edit', $proposal->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-warning">Show</a>
                                    <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $proposals->links('pagination::bootstrap-5') }}
            </div>
            @if ($proposals->isEmpty())
                <div class="text-center text-muted mt-3">No proposals found.</div>
            @endif
        </div>
    </div>
@stop
