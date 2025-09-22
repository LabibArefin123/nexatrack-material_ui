@extends('adminlte::page')

@section('title', 'Edit Customer Memo')

@section('css')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Customer Plan Memo</h1>
        {{-- Pass plan_id to go back to memo list --}}
        <a href="{{ route('plan_memos.memo', $editMemo->plan_id) }}" class="btn btn-success ">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong class="mb-2">Please fix the following errors:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card border-warning shadow-sm">
                <div class="card-header bg-warning text-white py-2 d-flex justify-content-end align-items-center">
                    <a href="{{ route('plan_memos.memo', $editMemo->plan_id) }}" class="btn  btn-light text-dark">Cancel</a>
                </div>
                <div class="card-body">
                    {{-- Pass memo id to update route --}}
                    <form action="{{ route('plan_memos.memo.update', $editMemo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control">{{ old('remarks', $editMemo->remarks) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ old('date', $editMemo->date) }}">
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Memo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
