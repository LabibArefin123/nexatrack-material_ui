@extends('layouts/contentNavbarLayout')

@section('title', 'Analytics Dashboard')

@section('content')
    <div class="row">
        {{-- Left: Recently Created Contracts --}}
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recently Created Contracts</h5>
                    <select id="contractFilter" class="form-select form-select-sm w-auto">
                        <option value="30" {{ $contractRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $contractRange == 90 ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="180" {{ $contractRange == 180 ? 'selected' : '' }}>Last 6 Months</option>
                    </select>
                </div>
                <div class="card-body">
                    <ul id="contractsList" class="list-group">
                        @foreach ($recentContracts as $contract)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $contract->subject }}</strong><br>
                                    <small class="text-muted">{{ $contract->created_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ route('contracts.show', $contract->id) }}"
                                    class="btn btn-sm btn-outline-primary">View</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right: Deals by Stage --}}
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">Deals by Stage</h5>

                    <div class="d-flex gap-2">
                        {{-- Stage Filter --}}
                        <select id="dealStageFilter" class="form-select form-select-sm w-auto">
                            <option value="">-- All Stages --</option>
                            @foreach (['new', 'create_stage', 'invoice', 'in_progress', 'final_invoice', 'deal_won', 'deal_lost', 'analyze_failure'] as $stage)
                                <option value="{{ $stage }}" {{ request('deal_stage') == $stage ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $stage)) }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Range Filter --}}
                        <select id="dealFilter" class="form-select form-select-sm w-auto">
                            <option value="30" {{ $dealRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ $dealRange == 90 ? 'selected' : '' }}>Last 3 Months</option>
                            <option value="180" {{ $dealRange == 180 ? 'selected' : '' }}>Last 6 Months</option>
                        </select>
                    </div>
                </div>
                <div class="card-body" style="height: 350px; overflow: hidden;">
                    <div class="text-center" id="chartLoader" style="display:none;">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted small">Updating chart...</p>
                    </div>
                    <canvas id="dealsByStageChart"></canvas>
                </div>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Activities</h5>
                    <select id="activeFilter" class="form-select form-select-sm w-auto">
                        <option value="30" {{ $activeRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $activeRange == 90 ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="180" {{ $activeRange == 180 ? 'selected' : '' }}>Last 6 Months</option>
                    </select>
                </div>
                <div class="card-body">
                    <ul id="activeList" class="list-group">
                        @foreach ($activities as $active)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $active->owner?->profile_image
                                        ? asset('storage/' . $active->owner->profile_image)
                                        : asset('uploads/images/default.jpg') }}"
                                        alt="owner" class="rounded-circle" width="35" height="35">
                                    <div>
                                        <strong>{{ $active->title }}</strong><br>
                                        <small class="text-muted">
                                            {{ $active->created_at->format('d M Y') }} —
                                            {{ $active->owner->name ?? 'Unknown' }}
                                        </small>
                                    </div>
                                </div>
                                <a href="{{ route('activities.show', $active->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Recently Created Campaigns</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Progress (%)</th>
                                    <th>Total Members</th>
                                    <th>Sent</th>
                                    <th>Opened</th>
                                    <th>Closed</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody id="campaignsTable">
                                @forelse ($campaigns as $campaign)
                                    <tr>
                                        <td><a href="{{ route('campaigns.show', $campaign->id) }}">{{ implode(' ', array_slice(explode(' ', $campaign->name), 0, 2)) }}
                                        </td>
                                        <td>{{ ucfirst($campaign->type) }}</a></td>
                                        <td>{{ $campaign->progress }}%</td>
                                        <td>{{ $campaign->total_members }}</td>
                                        <td>{{ $campaign->sent }}</td>
                                        <td>{{ $campaign->opened }}</td>
                                        <td>{{ $campaign->closed }}</td>
                                        <td><span class="badge bg-info">{{ ucfirst($campaign->status) }}</span></td>
                                        <td>{{ $campaign->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No campaigns found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartCtx = document.getElementById('dealsByStageChart').getContext('2d');
        let dealsChart = new Chart(chartCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($deal_stage) !!},
                datasets: [{
                    label: 'Deals Count',
                    data: {!! json_encode($stageCounts) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        function fetchAnalytics() {
            const contractRange = document.getElementById('contractFilter').value;
            const activeRange = document.getElementById('activeFilter').value;
            const dealRange = document.getElementById('dealFilter').value;
            const dealStage = document.getElementById('dealStageFilter').value;

            let contractsList = document.getElementById('contractsList');
            let campaignsTable = document.getElementById('campaignsTable');
            let activeList = document.getElementById('activeList');

            // Loading states
            contractsList.innerHTML = `<li class="list-group-item text-center text-muted">Loading...</li>`;
            activeList.innerHTML = `<li class="list-group-item text-center text-muted">Loading...</li>`;
            campaignsTable.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Loading...</td></tr>`;
            document.getElementById('chartLoader').style.display = "block";

            // 👇 Build query string
            const params = new URLSearchParams({
                contract_range: contractRange,
                deal_range: dealRange,
                deal_stage: dealStage,
                active_range: activeRange
            });

            const newUrl = `?${params.toString()}`;
            window.history.replaceState({}, '', newUrl);

            fetch(`{{ route('analytics.index') }}${newUrl}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // ✅ Update contracts
                    contractsList.innerHTML = "";
                    if (data.recentContracts.length > 0) {
                        data.recentContracts.forEach(c => {
                            contractsList.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${c.subject}</strong><br>
                                <small class="text-muted">${new Date(c.created_at).toLocaleDateString()}</small>
                            </div>
                            <a href="/contracts/${c.id}" class="btn btn-sm btn-outline-primary">View</a>
                        </li>`;
                        });
                    } else {
                        contractsList.innerHTML =
                            `<li class="list-group-item text-center text-muted">No contracts found in this period.</li>`;
                    }

                    // ✅ Update activities
                    activeList.innerHTML = "";
                    if (data.activities.length > 0) {
                        data.activities.forEach(a => {
                            let imgUrl = a.owner && a.owner.profile_image ?
                                `/storage/${a.owner.profile_image}` :
                                `uploads/images/default.jpg`;

                            activeList.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <img src="${imgUrl}" alt="owner" class="rounded-circle" width="35" height="35">
                                <div>
                                    <strong>${a.title}</strong><br>
                                    <small class="text-muted">
                                        ${new Date(a.created_at).toLocaleDateString()} —
                                        ${(a.owner && a.owner.name) ? a.owner.name : 'Unknown'}
                                    </small>
                                </div>
                            </div>
                            <a href="/activities/${a.id}" class="btn btn-sm btn-outline-primary">View</a>
                        </li>`;
                        });
                    } else {
                        activeList.innerHTML =
                            `<li class="list-group-item text-center text-muted">No activities found in this period.</li>`;
                    }

                    // ✅ Update campaigns
                    campaignsTable.innerHTML = "";
                    if (data.campaigns && data.campaigns.length > 0) {
                        data.campaigns.forEach(c => {
                            campaignsTable.innerHTML += `
                        <tr>
                            <td><a href="/campaigns/${c.id}">${c.name}</a></td>
                            <td>${c.type ? c.type.charAt(0).toUpperCase() + c.type.slice(1) : '-'}</td>
                            <td><span class="badge bg-info">${c.status ? c.status.charAt(0).toUpperCase() + c.status.slice(1) : '-'}</span></td>
                            <td>${new Date(c.created_at).toLocaleDateString()}</td>
                        </tr>`;
                        });
                    } else {
                        campaignsTable.innerHTML =
                            `<tr><td colspan="4" class="text-center text-muted">No campaigns found.</td></tr>`;
                    }

                    // ✅ Update chart
                    dealsChart.data.labels = data.deal_stage;
                    dealsChart.data.datasets[0].data = data.stageCounts;
                    dealsChart.update();

                    document.getElementById('chartLoader').style.display = "none";
                });
        }
        document.getElementById('contractFilter').addEventListener('change', fetchAnalytics);
        document.getElementById('dealFilter').addEventListener('change', fetchAnalytics);
        document.getElementById('dealStageFilter').addEventListener('change', fetchAnalytics);
        document.getElementById('activeFilter').addEventListener('change', fetchAnalytics);
    </script>
@endsection
