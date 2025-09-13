@extends('adminlte::page')

@section('title', 'Customer Memo')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Customer Plan Memo</h1>
        <a href="{{ route('plans.index') }}" class="btn btn-success btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        {{-- Memo List --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Remarks</th>
                                <th>Date & Time</th>
                                <th class="text-center" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customerMemos as $index => $memo)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $memo->remarks }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($memo->date)->format('d M Y') }}
                                        {{ \Carbon\Carbon::parse($memo->created_at)->format('h:i A') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('plan_memos.memo.edit', $memo->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('plan_memos.memo.destroy', $memo->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this memo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No memos found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add Form --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <strong>Add Memo</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('plan_memos.memo.store', $id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" rows="3" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-1"></i> Save Memo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
