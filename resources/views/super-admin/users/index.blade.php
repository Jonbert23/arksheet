@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">User Management</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-house" class="icon text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Users</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <form method="GET" action="{{ route('super-admin.users.index') }}" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" class="form-control" placeholder="Search users..." 
                       value="{{ request('search') }}" style="min-width: 200px;">
                
                <select name="business_id" class="form-select" style="min-width: 200px;">
                    <option value="">All Businesses</option>
                    @foreach($businesses as $business)
                        <option value="{{ $business->id }}" {{ request('business_id') == $business->id ? 'selected' : '' }}>
                            {{ $business->name }}
                        </option>
                    @endforeach
                </select>

                <select name="role" class="form-select" style="min-width: 150px;">
                    <option value="">All Roles</option>
                    <option value="business_owner" {{ request('role') === 'business_owner' ? 'selected' : '' }}>Business Owner</option>
                    <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="accountant" {{ request('role') === 'accountant' ? 'selected' : '' }}>Accountant</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>

                <select name="status" class="form-select" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn btn-primary-600">
                    <i class="bi bi-circle-fill"></i> Search
                </button>
                
                @if(request()->hasAny(['search', 'business_id', 'role', 'status']))
                    <a href="{{ route('super-admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-circle-fill"></i> Reset
                    </a>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Business</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle bg-primary-600 text-white" style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->business)
                                    <a href="{{ route('super-admin.businesses.show', $user->business) }}" 
                                       class="text-primary-600">
                                        {{ $user->business->name }}
                                    </a>
                                @else
                                    <span class="text-secondary-light">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'business_owner' ? 'primary' : ($user->role === 'manager' ? 'info' : 'secondary') }}-100 
                                             text-{{ $user->role === 'business_owner' ? 'primary' : ($user->role === 'manager' ? 'info' : 'secondary') }}-600">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">Active</span>
                                @else
                                    <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('super-admin.users.show', $user) }}" 
                                       class="btn btn-sm btn-outline-info-600">
                                        <i class="bi bi-circle-fill"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.users.toggle-status', $user) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}-600" 
                                                onclick="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} this user?')">
                                            <i class="bi bi-circle-fill">is_active ? 'eye-closed-linear' : 'check-circle-linear' }}"></i>
                                        </button>
                                    </form>
                                    @if($user->role !== 'business_owner')
                                        <form method="POST" action="{{ route('super-admin.users.destroy', $user) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger-600" 
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="bi bi-circle-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary-light py-4">
                                <i class="bi bi-circle-fill"></i>
                                <p class="mb-0">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

