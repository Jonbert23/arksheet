@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">{{ $user->name }}</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-house" class="icon text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('super-admin.users.index') }}" class="hover-text-primary">Users</a>
        </li>
        <li>-</li>
        <li class="fw-medium">{{ $user->name }}</li>
    </ul>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- User Profile Card -->
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-circle bg-primary-600 text-white mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-secondary-light mb-3">{{ $user->email }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @if($user->is_active)
                        <span class="badge bg-success-100 text-success-600 px-3 py-2">Active</span>
                    @else
                        <span class="badge bg-danger-100 text-danger-600 px-3 py-2">Inactive</span>
                    @endif
                    <span class="badge bg-primary-100 text-primary-600 px-3 py-2">
                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <form method="POST" action="{{ route('super-admin.users.toggle-status', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-{{ $user->is_active ? 'warning' : 'success' }}-600"
                                onclick="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} this user?')">
                            <i class="bi bi-circle-fill">is_active ? 'eye-closed-linear' : 'check-circle-linear' }}"></i>
                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    @if($user->role !== 'business_owner')
                        <form method="POST" action="{{ route('super-admin.users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger-600"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="bi bi-circle-fill"></i>
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Business Info -->
        @if($user->business)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Business</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('super-admin.businesses.show', $user->business) }}" 
                       class="d-flex align-items-center gap-2 text-primary-600">
                        <i class="bi bi-circle-fill"></i>
                        <div>
                            <div class="fw-semibold">{{ $user->business->name }}</div>
                            <div class="text-sm text-secondary-light">{{ $user->business->email }}</div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-8">
        <!-- User Details -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">User Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-secondary-light" width="200">Full Name:</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Email Address:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Phone:</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Role:</td>
                        <td>
                            <span class="badge bg-primary-100 text-primary-600">
                                {{ ucwords(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Status:</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-100 text-success-600">Active</span>
                            @else
                                <span class="badge bg-danger-100 text-danger-600">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Account Created:</td>
                        <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Last Updated:</td>
                        <td>{{ $user->updated_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Permissions (for Staff) -->
        @if($user->role === 'staff' && isset($stats['allowed_modules']))
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Module Permissions</h6>
                </div>
                <div class="card-body">
                    @if(count($stats['allowed_modules']) > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($stats['allowed_modules'] as $module => $label)
                                <span class="badge bg-info-100 text-info-600 px-3 py-2">
                                    <i class="bi bi-circle-fill"></i>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-secondary-light mb-0">No module permissions assigned</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

