@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Lead')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Lead</h3>
        <a href="{{ route('leads.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Customer -->
                    <div class="col-md-6 form-group">
                        <label>Customer ID <span class="text-danger">*</span></label>
                        <select name="customer_id" id="customer_id"
                            class="form-control @error('customer_id') is-invalid @enderror">
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                    data-email="{{ $customer->email }}" data-phone="{{ $customer->phone }}"
                                    {{ old('customer_id', $lead->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="col-md-6 form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $lead->name) }}" readonly>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $lead->email) }}" readonly>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $lead->phone) }}" readonly>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Plan -->
                    <div class="col-md-6 form-group">
                        <label for="plan">Plan <span class="text-danger">*</span></label>
                        <select name="plan" id="plan" class="form-control @error('plan') is-invalid @enderror">
                            <option value="">Select a Plan</option>
                            <option value="Standard" {{ old('plan', $lead->plan) == 'Standard' ? 'selected' : '' }}>
                                Standard - BDT 10,000 /yr + 20,000 BDT setup cost
                            </option>
                            <option value="Professional"
                                {{ old('plan', $lead->plan) == 'Professional' ? 'selected' : '' }}>
                                Professional - BDT 15,000 /yr + 20,000 BDT setup cost
                            </option>
                            <option value="Premium" {{ old('plan', $lead->plan) == 'Premium' ? 'selected' : '' }}>
                                Premium - BDT 25,000 /yr + 20,000 BDT setup cost
                            </option>
                            <option value="Premium Plus"
                                {{ old('plan', $lead->plan) == 'Premium Plus' ? 'selected' : '' }}>
                                Premium Plus - BDT 50,000 /yr + 20,000 BDT setup cost
                            </option>
                        </select>
                        @error('plan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Assigned User -->
                    <div class="col-md-6 form-group">
                        <label>Assigned User <span class="text-danger">*</span></label>
                        <select name="assigned_to" class="form-control @error('assigned_to') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>
                                Contacted
                            </option>
                            <option value="not_contacted"
                                {{ old('status', $lead->status) == 'not_contacted' ? 'selected' : '' }}>Not Contacted
                            </option>
                            <option value="closed" {{ old('status', $lead->status) == 'closed' ? 'selected' : '' }}>Closed
                            </option>
                            <option value="lost" {{ old('status', $lead->status) == 'lost' ? 'selected' : '' }}>Lost
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6 form-group">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $lead->amount) }}" readonly>
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Customer auto-fill
        document.getElementById('customer_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const name = selected.getAttribute('data-name') || '';
            const email = selected.getAttribute('data-email') || '';
            const phone = selected.getAttribute('data-phone') || '';

            document.querySelector('input[name="name"]').value = name;
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="phone"]').value = phone;
        });

        // Plan wise amount calculation
        document.getElementById('plan').addEventListener('change', function() {
            const plan = this.value;
            let amount = 0;

            switch (plan) {
                case 'Standard':
                    amount = 10000 + 20000; // yearly + setup
                    break;
                case 'Professional':
                    amount = 15000 + 20000;
                    break;
                case 'Premium':
                    amount = 25000 + 20000;
                    break;
                case 'Premium Plus':
                    amount = 50000 + 20000;
                    break;
            }

            document.querySelector('input[name="amount"]').value = amount;
        });
    </script>
@endsection
