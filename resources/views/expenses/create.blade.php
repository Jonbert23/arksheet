<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Record New Expense</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('expenses.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Expenses
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Record</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Expense Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    
                    <div class="row gy-3">
                        <!-- Date -->
                        <div class="col-md-6">
                            <label for="expense_date" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Expense Date <span class="text-danger-600">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control radius-8 @error('expense_date') is-invalid @enderror" 
                                   id="expense_date" 
                                   name="expense_date" 
                                   value="{{ old('expense_date', date('Y-m-d')) }}" 
                                   required>
                            @error('expense_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="expense_category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Category <span class="text-danger-600">*</span>
                            </label>
                            <select class="form-select radius-8 @error('expense_category_id') is-invalid @enderror" 
                                    id="expense_category_id" 
                                    name="expense_category_id" 
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('expense_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Description <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('description') is-invalid @enderror" 
                                   id="description" 
                                   name="description" 
                                   value="{{ old('description') }}" 
                                   placeholder="Enter expense description"
                                   required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6">
                            <label for="amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Amount <span class="text-danger-600">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text radius-8">{{ auth()->user()->business->currency }}</span>
                                <input type="number" 
                                       class="form-control radius-8 @error('amount') is-invalid @enderror" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount') }}" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00"
                                       required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Payment Method
                            </label>
                            <select class="form-select radius-8 @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" 
                                    name="payment_method">
                                <option value="">Select Method</option>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="Debit Card" {{ old('payment_method') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>
                                <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="Other" {{ old('payment_method') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vendor -->
                        <div class="col-md-6">
                            <label for="vendor" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Vendor/Supplier
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('vendor') is-invalid @enderror" 
                                   id="vendor" 
                                   name="vendor" 
                                   value="{{ old('vendor') }}" 
                                   placeholder="Enter vendor name">
                            @error('vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reference Number -->
                        <div class="col-md-6">
                            <label for="reference_number" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Reference Number
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" 
                                   name="reference_number" 
                                   value="{{ old('reference_number') }}" 
                                   placeholder="Enter reference/invoice number">
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label for="notes" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Notes
                            </label>
                            <textarea class="form-control radius-8 @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      placeholder="Additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">
                                    <i class="bi bi-circle-fill"></i>
                                    Save Expense
                                </button>
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary-600 radius-8 px-20 py-11">
                                    <i class="bi bi-circle-fill"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout.master>

