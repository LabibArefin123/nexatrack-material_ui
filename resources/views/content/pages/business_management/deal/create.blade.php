@extends('layouts/contentNavbarLayout')

@section('title', 'Create Deal')

@section('content_header')

@stop

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Create Deal</h3>
        <a href="{{ route('deals.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left"
                viewBox="0 0 24 24">
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
            <form action="{{ route('deals.store') }}" method="POST" class="p-4">
                @csrf
                <div class="row">
                    {{-- Name --}}
                    <div class="form-group col-md-6">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stage --}}
                    <div class="form-group col-md-6">
                        <label for="deal_stage">Stage <span class="text-danger">*</span></label>
                        <select name="deal_stage" id="deal_stage"
                            class="form-control @error('deal_stage') is-invalid @enderror">
                            <option disabled selected>Select stage</option>
                            @foreach (['new', 'create_stage', 'invoice', 'in_progress', 'final_invoice', 'deal_won', 'deal_lost', 'analyze_failure'] as $stage)
                                <option value="{{ $stage }}" {{ old('deal_stage') == $stage ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $stage)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('deal_stage')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="form-group col-md-4">
                        <label for="amount">Amount <span class="text-danger">*</span></label>
                        <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                            class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="form-group col-md-2">
                        <label for="currency">Currency <span class="text-danger">*</span></label>
                        <select name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror">
                            <option disabled selected>Select currency</option>
                            @foreach (['BDT', 'USD', 'EUR', 'GBP', 'INR'] as $currency)
                                <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>
                                    {{ $currency }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="form-group col-md-6">
                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div class="form-group col-md-6">
                        <label for="client_option">Client <span class="text-danger">*</span></label>
                        <select name="client_option" id="client_option"
                            class="form-control @error('client_option') is-invalid @enderror">
                            <option disabled selected>Select client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->name }}"
                                    {{ old('client_option') == $client->name ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_option')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Company --}}
                    <div class="form-group col-md-6">
                        <label for="company_option">Company <span class="text-danger">*</span></label>
                        <select name="company_option" id="company_option"
                            class="form-control @error('company_option') is-invalid @enderror">
                            <option disabled>Select company</option>
                            @if (old('client_option') && isset($companiesByClient[old('client_option')]))
                                @foreach ($companiesByClient[old('client_option')] as $company)
                                    <option value="{{ $company }}"
                                        {{ old('company_option') == $company ? 'selected' : '' }}>
                                        {{ $company }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('company_option')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <h5>More Info</h5>
                    <div class="w-100"></div>

                    {{-- Deal Type --}}
                    <div class="form-group col-md-6">
                        <label for="deal_type">Deal Type <span class="text-danger">*</span></label>
                        <select name="deal_type" id="deal_type"
                            class="form-control @error('deal_type') is-invalid @enderror">
                            <option disabled selected>Select type</option>
                            @foreach (['sales', 'integrated_sales', 'merchandise_sales', 'services', 'after_sales_service'] as $type)
                                <option value="{{ $type }}" {{ old('deal_type') == $type ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('deal_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Source --}}
                    <div class="form-group col-md-6">
                        <label for="source">Source <span class="text-danger">*</span></label>
                        <select name="source" id="source" class="form-control @error('source') is-invalid @enderror">
                            <option disabled selected>Select source</option>
                            @foreach (['call', 'email', 'website', 'advertising', 'existing_client', 'by_recommendation', 'show_or_exhibition', 'crm_form', 'callback', 'sales_boost', 'online_store', 'other'] as $source)
                                <option value="{{ $source }}" {{ old('source') == $source ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $source)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('source')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="form-group col-md-6">
                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                            class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Responsible --}}
                    <div class="form-group col-md-12">
                        <label>Responsible <span class="text-danger">*</span></label>
                        <div id="responsible-container" class="row">
                            @php $oldResponsibles = old('responsibles', []); @endphp
                            @forelse ($oldResponsibles as $responsible)
                                <div class="col-md-6 mb-2 responsible-item">
                                    <div class="card p-2 shadow-sm position-relative">
                                        @if (!$loop->first)
                                            <button type="button" class="btn  btn-danger position-absolute"
                                                style="top:5px; right:5px;"
                                                onclick="this.closest('.responsible-item').remove()">×</button>
                                        @endif
                                        <select name="responsibles[]" class="form-control">
                                            <option disabled>Select user</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $responsible == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @empty
                                {{-- Default blank select if no old --}}
                                <div class="col-md-6 mb-2 responsible-item">
                                    <div class="card p-2 shadow-sm">
                                        <select name="responsibles[]" class="form-control">
                                            <option disabled selected>Select user</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <button type="button" class="btn btn-outline-primary  mt-2" id="add-responsible">
                            <i class="fas fa-plus"></i> Add More
                        </button>
                    </div>

                    {{-- Observer --}}
                    <div class="form-group col-md-12">
                        <label>Observer</label>
                        <div id="observer-container" class="row">
                            @php $oldObservers = old('observers', []); @endphp
                            @foreach ($oldObservers as $observer)
                                <div class="col-md-6 mb-2 observer-item">
                                    <div class="card p-2 shadow-sm position-relative">
                                        <select name="observers[]" class="form-control">
                                            <option disabled>Select observer</option>
                                            @foreach ($users as $user)
                                                <option value="user_{{ $user->id }}"
                                                    {{ $observer == "user_$user->id" ? 'selected' : '' }}>
                                                    User: {{ $user->name }}
                                                </option>
                                            @endforeach
                                            @foreach ($customers as $customer)
                                                <option value="customer_{{ $customer->id }}"
                                                    {{ $observer == "customer_$customer->id" ? 'selected' : '' }}>
                                                    Customer: {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn  btn-danger position-absolute"
                                            style="top:5px; right:5px;"
                                            onclick="this.closest('.observer-item').remove()">×</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary " id="add-observer">
                            <i class="fas fa-plus"></i> Add Observer
                        </button>
                    </div>

                    {{-- Comment --}}
                    <div class="form-group col-md-6">
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment" class="form-control summernote">{{ old('comment') }}</textarea>
                        @error('comment')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Source Info --}}
                    <div class="form-group col-md-6">
                        <label for="source_information">Source Info</label>
                        <textarea name="source_information" id="source_information" class="form-control summernote">{{ old('source_information') }}</textarea>
                        @error('source_information')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="form-group col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            $('.summernote').summernote({
                height: 150
            });

            // Restore old values into Summernote
            @if (old('comment'))
                $('#comment').summernote('code', {!! json_encode(old('comment')) !!});
            @endif

            @if (old('source_information'))
                $('#source_information').summernote('code', {!! json_encode(old('source_information')) !!});
            @endif
        });
    </script>
    <script>
        // Handle dynamic company select
        const clientCompanies = @json($companiesByClient);
        const clientSelect = document.getElementById('client_option');
        const companySelect = document.getElementById('company_option');

        function populateCompanies(clientName) {
            const companies = clientCompanies[clientName] || [];
            companySelect.innerHTML = '<option disabled selected>Select company</option>';

            companies.forEach(company => {
                const option = document.createElement('option');
                option.value = company;
                option.textContent = company;
                companySelect.appendChild(option);
            });

            companySelect.disabled = companies.length === 0;
        }

        clientSelect.addEventListener('change', () => populateCompanies(clientSelect.value));
        document.addEventListener("DOMContentLoaded", function() {
            // Add Responsible
            const addResponsibleBtn = document.getElementById("add-responsible");
            const responsibleContainer = document.getElementById("responsible-container");

            addResponsibleBtn.addEventListener("click", function() {
                let newResponsible = document.createElement("div");
                newResponsible.classList.add("col-md-6", "mb-2", "responsible-item");
                newResponsible.innerHTML = `
            <div class="card p-2 shadow-sm position-relative">
                <button type="button" class="btn  btn-danger position-absolute" style="top:5px; right:5px;" onclick="this.closest('.responsible-item').remove()">×</button>
                <select name="responsibles[]" class="form-control" >
                    <option disabled selected>Select user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        `;
                responsibleContainer.appendChild(newResponsible);
            });

            // Add Observer
            const addObserverBtn = document.getElementById("add-observer");
            const observerContainer = document.getElementById("observer-container");

            addObserverBtn.addEventListener("click", function() {
                let newObserver = document.createElement("div");
                newObserver.classList.add("col-md-6", "mb-2", "observer-item");
                newObserver.innerHTML = `
             <div class="card p-2 shadow-sm position-relative">
                <select name="observers[]" class="form-control">
            <option disabled selected>Select observer</option>
            @foreach ($users as $user)
                <option value="user_{{ $user->id }}">User: {{ $user->name }}</option>
            @endforeach
            @foreach ($customers as $customer)
                <option value="customer_{{ $customer->id }}">Customer: {{ $customer->name }}</option>
            @endforeach
            </select>

                <button type="button" class="btn  btn-danger position-absolute" style="top:5px; right:5px;" onclick="this.closest('.observer-item').remove()">×</button>
            </div>
        `;
                observerContainer.appendChild(newObserver);
            });
        });
    </script>

@stop
