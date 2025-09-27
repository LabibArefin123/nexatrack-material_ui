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
            const dealRange = document.getElementById('dealFilter').value;
            const dealStage = document.getElementById('dealStageFilter').value;

            let list = document.getElementById('contractsList');
            list.innerHTML = `<li class="list-group-item text-center text-muted">Loading...</li>`;
            document.getElementById('chartLoader').style.display = "block";

            // 👇 Update browser URL (so reload dileo filters thakbe)
            const newUrl = `?contract_range=${contractRange}&deal_range=${dealRange}&deal_stage=${dealStage}`;
            window.history.replaceState({}, '', newUrl);

            fetch(`{{ route('analytics.index') }}${newUrl}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Update contracts
                    list.innerHTML = "";
                    if (data.recentContracts.length > 0) {
                        data.recentContracts.forEach(c => {
                            list.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${c.subject}</strong><br>
                                <small class="text-muted">${new Date(c.created_at).toLocaleDateString()}</small>
                            </div>
                            <a href="/contracts/${c.id}" class="btn btn-sm btn-outline-primary">View</a>
                        </li>`;
                        });
                    } else {
                        list.innerHTML =
                            `<li class="list-group-item text-center text-muted">No contracts found in this period.</li>`;
                    }

                    // Update chart
                    dealsChart.data.labels = data.deal_stage;
                    dealsChart.data.datasets[0].data = data.stageCounts;
                    dealsChart.update();

                    document.getElementById('chartLoader').style.display = "none";
                });
        }

        document.getElementById('contractFilter').addEventListener('change', fetchAnalytics);
        document.getElementById('dealFilter').addEventListener('change', fetchAnalytics);
        document.getElementById('dealStageFilter').addEventListener('change', fetchAnalytics);
    </script>
@endsection
