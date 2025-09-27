<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Progress (%)</th>
                    <th>Total Members</th>
                    <th>Sent</th>
                    <th>Opened</th>
                    <th>Closed</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td>{{ implode(' ', array_slice(explode(' ', $campaign->name), 0, 2)) }}</td>
                        <td>{{ $campaign->type_name }}</td>
                        <td>{{ $campaign->progress }}%</td>
                        <td>{{ $campaign->total_members }}</td>
                        <td>{{ $campaign->sent }}</td>
                        <td>{{ $campaign->opened }}</td>
                        <td>{{ $campaign->closed }}</td>
                        <td> {{ $campaign->status }} </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-info ">View</a>
                                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-warning ">Edit</a>
                                <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger "
                                        onclick="return confirm('Delete this campaign?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No campaigns found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
