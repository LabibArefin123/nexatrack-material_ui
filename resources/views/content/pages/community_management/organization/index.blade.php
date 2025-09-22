@extends('layouts/contentNavbarLayout')

@section('title', 'Organizations')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Organizations</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('organizations.create') }}" class="btn btn-success " title="Add Organization">
                <i class="bi bi-plus-lg">Create</i>
            </a>
            <button id="gridViewBtn" class="btn btn-outline-primary " title="Grid View">
                <i class="bi bi-grid-3x2-gap">Grid View</i>
            </button>
            <button id="listViewBtn" class="btn btn-outline-secondary " title="List View">
                <i class="bi bi-list">List View</i>
            </button>
        </div>
    </div>

    <!-- Grid View -->
    <div id="gridView" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($organizations as $organization)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    @if ($organization->image)
                        <img src="{{ asset('uploads/images/organization/' . $organization->image) }}" class="card-img-top"
                            alt="{{ $organization->name }}" style="height:150px; object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:150px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $organization->name }}</h5>
                        <div class="mt-auto d-flex justify-content-between gap-1">
                            <a href="{{ route('organizations.edit', $organization->id) }}" class="btn  btn-primary"
                                title="Edit">
                                <i class="bi bi-pencil-fill">Edit</i>
                            </a>
                            <a href="{{ route('organizations.show', $organization->id) }}" class="btn  btn-warning"
                                title="Show">
                                <i class="bi bi-eye-fill">Show</i>
                            </a>
                            <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-danger" title="Delete">
                                    <i class="bi bi-trash-fill">Delete</i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-secondary text-center">
                    No organizations found.
                </div>
            </div>
        @endforelse
    </div>

    <!-- List View -->
    <div id="listView" class="table-responsive d-none mt-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">SL</th>
                    <th>Organization Name</th>
                    <th class="text-center">Image</th>
                    <th style="width: 140px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organizations as $key => $organization)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $organization->name }}</td>
                        <td class="text-center">
                            @if ($organization->image)
                                <img src="{{ asset('uploads/images/organization/' . $organization->image) }}"
                                    alt="Organization Image" width="120" height="50">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('organizations.edit', $organization->id) }}" class="btn  btn-primary"
                                title="Edit">
                                <i class="bi bi-pencil-fill">Edit</i>
                            </a>
                            <a href="{{ route('organizations.show', $organization->id) }}" class="btn  btn-warning"
                                title="Show">
                                <i class="bi bi-eye-fill">Show</i>
                            </a>
                            <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-danger" title="Delete">
                                    <i class="bi bi-trash-fill">Delete</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No organizations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@stop

@section('js')
    <script>
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');

        gridBtn.addEventListener('click', () => {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
            gridBtn.classList.add('btn-primary');
            gridBtn.classList.remove('btn-outline-primary');
            listBtn.classList.add('btn-outline-secondary');
            listBtn.classList.remove('btn-secondary');
        });

        listBtn.addEventListener('click', () => {
            listView.classList.remove('d-none');
            gridView.classList.add('d-none');
            listBtn.classList.add('btn-secondary');
            listBtn.classList.remove('btn-outline-secondary');
            gridBtn.classList.add('btn-outline-primary');
            gridBtn.classList.remove('btn-primary');
        });
    </script>
@stop
