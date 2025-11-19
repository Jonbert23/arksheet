<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Expense Details</h6>
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
                <li class="fw-medium">Details</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0" style="font-size: 18px !important; color: #4b5563;">Expense Information</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-success-600 radius-8 px-20 py-11">
                        <i class="bi bi-circle-fill"></i>
                        Edit
                    </a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger-600 radius-8 px-20 py-11 delete-btn">
                            <i class="bi bi-circle-fill"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row gy-4">
                    <!-- Expense Date -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Expense Date</span>
                            </div>
                            <h6 class="mb-0">{{ $expense->date->format('F d, Y') }}</h6>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Category</span>
                            </div>
                            <span class="badge bg-primary-100 text-primary-600 px-16 py-6 text-md">
                                {{ $expense->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="col-12">
                        <div class="p-16 border radius-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Title</span>
                            </div>
                            <h6 class="mb-0">{{ $expense->title }}</h6>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($expense->description)
                    <div class="col-12">
                        <div class="p-16 border radius-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Description</span>
                            </div>
                            <p class="mb-0">{{ $expense->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Amount -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100 bg-danger-50">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Amount</span>
                            </div>
                            <h4 class="mb-0 text-danger-600">{{ auth()->user()->business->currency }} {{ number_format($expense->amount, 2) }}</h4>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Payment Method</span>
                            </div>
                            <h6 class="mb-0">{{ $expense->payment_method ?? 'Not Specified' }}</h6>
                        </div>
                    </div>

                    <!-- Vendor -->
                    <div class="col-md-12">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Vendor/Supplier</span>
                            </div>
                            <h6 class="mb-0">{{ $expense->vendor ?? 'Not Specified' }}</h6>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($expense->notes)
                    <div class="col-12">
                        <div class="p-16 border radius-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm text-secondary-light">Notes</span>
                            </div>
                            <p class="mb-0">{{ $expense->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Metadata -->
                    <div class="col-12">
                        <div class="p-16 border radius-8 bg-neutral-50">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-circle-fill"></i>
                                        <span class="text-sm text-secondary-light">Created: {{ $expense->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-circle-fill"></i>
                                        <span class="text-sm text-secondary-light">Updated: {{ $expense->updated_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="col-12">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary-600 radius-8 px-20 py-11">
                            <i class="bi bi-circle-fill"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $script = '<script>
            $(document).ready(function() {
                $(".delete-btn").on("click", function(e) {
                    e.preventDefault();
                    var form = $(this).closest("form");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won\'t be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>';

        echo $script;
    @endphp

</x-layout.master>

