@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Business Management</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Businesses</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <form method="GET" action="{{ route('super-admin.businesses.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search businesses..." value="{{ request('search') }}">
                <select name="status" class="form-select w-auto">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="btn btn-primary-600">
                    <iconify-icon icon="solar:magnifer-linear"></iconify-icon> Search
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">Business Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Users</th>
                        <th scope="col">Products</th>
                        <th scope="col">Sales</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($businesses as $business)
                        <tr>
                            <td>
                                <a href="{{ route('super-admin.businesses.show', $business) }}" class="text-primary-600 fw-semibold">
                                    {{ $business->name }}
                                </a>
                            </td>
                            <td>{{ $business->email }}</td>
                            <td>{{ $business->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info-100 text-info-600">
                                    {{ $business->users_count }} users
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-100 text-success-600">
                                    {{ $business->products_count }} products
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning-100 text-warning-600">
                                    {{ $business->sales_count }} sales
                                </span>
                            </td>
                            <td>
                                @if($business->is_active)
                                    <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">Active</span>
                                @else
                                    <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $business->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('super-admin.businesses.show', $business) }}" class="btn btn-sm btn-outline-info-600">
                                        <iconify-icon icon="solar:eye-linear"></iconify-icon>
                                    </a>
                                    <a href="{{ route('super-admin.businesses.edit', $business) }}" class="btn btn-sm btn-outline-primary-600">
                                        <iconify-icon icon="solar:pen-linear"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.businesses.toggle-status', $business) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $business->is_active ? 'warning' : 'success' }}-600" 
                                                onclick="return confirm('Are you sure you want to {{ $business->is_active ? 'deactivate' : 'activate' }} this business?')">
                                            <iconify-icon icon="solar:{{ $business->is_active ? 'eye-closed-linear' : 'check-circle-linear' }}"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-secondary-light py-4">
                                <iconify-icon icon="solar:inbox-line-duotone" class="text-5xl mb-2"></iconify-icon>
                                <p class="mb-0">No businesses found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($businesses->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $businesses->firstItem() }} to {{ $businesses->lastItem() }} of {{ $businesses->total() }} businesses
                </div>
                <div>
                    {{ $businesses->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

