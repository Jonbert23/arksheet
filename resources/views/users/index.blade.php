<x-layout.master>

    @push('styles')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    @endpush

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">User Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Users</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Date Range and Filter Section -->
        <form method="GET" action="{{ route('users.index') }}" id="userFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    form-id="userFilterForm"
                    :date-from="$dateFrom"
                    :date-to="$dateTo"
                    :auto-submit="false"
                />

                <!-- Status Filter -->
                <x-filters.status-filter 
                    form-id="userFilterForm"
                    :status-filter="request('is_active', 'all')"
                    :status-options="[
                        ['value' => 'all', 'label' => 'All'],
                        ['value' => '1', 'label' => 'Active'],
                        ['value' => '0', 'label' => 'Inactive']
                    ]"
                    :total-count="$users->count()"
                    module-label="Users"
                    :auto-submit="false"
                    parameter-name="is_active"
                />

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>

        <!-- Summary Stats -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-secondary-light mb-1">Total Users</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ $users->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center text-white" style="background-color: #ec3737;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Active Users</p>
                                <h6 class="mb-0">{{ $users->where('is_active', true)->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center text-white">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Business Owners</p>
                                <h6 class="mb-0">{{ $users->where('role', 'business_owner')->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center text-white">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Managers</p>
                                <h6 class="mb-0">{{ $users->where('role', 'manager')->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center text-white">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-md mb-0 fw-semibold text-secondary-light">Show</span>
                        <select class="form-select form-select-sm w-auto" id="entries-per-page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="icon-field">
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search users..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <button type="button" id="addUserBtn" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-plus-circle"></i>
                    Add New User
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="users-table" style="min-width: 900px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 150px;">User Name</th>
                                <th scope="col" style="min-width: 150px;">Email</th>
                                <th scope="col" style="min-width: 120px;">Phone</th>
                                <th scope="col" style="min-width: 100px;">Role</th>
                                <th scope="col" class="text-center" style="min-width: 80px;">Status</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="w-32-px h-32-px rounded-circle d-flex justify-content-center align-items-center text-white fw-bold" style="background-color: #ec3737; font-size: 12px;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $user->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'business_owner' => 'danger',
                                            'manager' => 'warning',
                                            'accountant' => 'info',
                                            'staff' => 'primary'
                                        ];
                                        $color = $roleColors[$user->role] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}-100 text-{{ $color }}-600 px-12 py-6">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($user->is_active)
                                        <span class="badge bg-success-100 text-success-600 px-12 py-6">Active</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-12 py-6">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="view-user-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" data-user-id="{{ $user->id }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <button type="button" class="edit-user-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-user-id="{{ $user->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-48">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox text-secondary-light mb-3" style="font-size: 48px;"></i>
                                        <p class="text-secondary-light mb-16">No users found</p>
                                        <button type="button" id="addFirstUserBtn" class="btn text-white px-20 py-11 radius-8" style="background-color: #ec3737;">
                                            <i class="bi bi-plus-circle"></i>
                                            Add Your First User
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="addUserModalLabel" style="font-size: 18px !important;">
                        Add New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="addUserModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="editUserModalLabel" style="font-size: 18px !important;">
                        Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editUserModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="viewUserModalLabel" style="font-size: 18px !important;">
                        User Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information Section -->
                    <div class="mb-24">
                        <div class="d-flex align-items-center gap-2 mb-20">
                            <div class="d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Basic Information</h6>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0; color: #ec3737;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Full Name</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827;" id="view_name">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0; color: #ec3737;">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827; word-break: break-all;" id="view_email">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0; color: #ec3737;">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Phone Number</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827;" id="view_phone">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0; color: #ec3737;">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">User Role</p>
                                        <div id="view_role">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Module Permissions Section -->
                    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;" id="view_permissions_section">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Module Permissions</h6>
                        </div>
                        
                        <div class="row" id="view_permissions_list">
                            <div class="col-12">
                                <p class="text-muted text-center py-3">Loading permissions...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Status Section -->
                    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Account Status</h6>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-16 rounded-3" style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="text-secondary-light mb-4" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Status</p>
                                            <span id="view_status">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-16 rounded-3" style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb;">
                                    <div>
                                        <p class="text-secondary-light mb-4" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Joined Date</p>
                                        <p class="fw-semibold mb-0" style="color: #1f2937; font-size: 15px;" id="view_created_at">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top" style="padding: 20px 24px;">
                    <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Flatpickr JS -->
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    
    <script>
        $(document).ready(function() {

            // Initialize DataTable
            if ($.fn.DataTable.isDataTable("#users-table")) {
                $("#users-table").DataTable().destroy();
            }

            var table = $("#users-table").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthChange": false,
                "dom": '<"top">rt<"bottom"p><"clear">',
                "language": {
                    "emptyTable": "No users available",
                    "zeroRecords": "No matching users found",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": '<i class="bi bi-chevron-right"></i>',
                        "previous": '<i class="bi bi-chevron-left"></i>'
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, -1] }
                ],
                "order": [[1, "asc"]]
            });

            // Custom search
            $("#search-input").on("keyup", function() {
                table.search(this.value).draw();
            });

            // Custom page length
            $("#entries-per-page").on("change", function() {
                table.page.len(parseInt(this.value)).draw();
            });

            // Open Add User Modal
            $("#addUserBtn, #addFirstUserBtn").on("click", function() {
                $('#addUserModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $("#addUserModal").modal("show");
                
                $.ajax({
                    url: '{{ route("users.create") }}',
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        $('#addUserModalBody').html(response);
                    },
                    error: function(xhr) {
                        $('#addUserModalBody').html('<div class="alert alert-danger">Error loading form. Please try again.</div>');
                    }
                });
            });

            // Handle add user form submission
            $(document).on('submit', '#addUserForm', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const formData = form.serialize();
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                
                // Clear previous errors
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Creating...');
                
                $.ajax({
                    url: '{{ route("users.store") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#addUserModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to create user. Please try again.'
                            });
                        }
                    }
                });
            });

            // Open Edit User Modal
            $(document).on("click", ".edit-user-btn", function() {
                const userId = $(this).data("user-id");
                
                $('#editUserModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $('#editUserModal').modal('show');
                
                $.ajax({
                    url: '/users/' + userId + '/edit',
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        // Load the edit form partial
                        $.ajax({
                            url: '/users/partials/edit-form',
                            method: 'GET',
                            data: { user: response.user },
                            success: function(formHtml) {
                                $('#editUserModalBody').html(formHtml);
                                
                                // Populate form
                                $('#edit_user_id').val(response.user.id);
                                $('#edit_name').val(response.user.name);
                                $('#edit_email').val(response.user.email);
                                $('#edit_phone').val(response.user.phone || '');
                                $('#edit_role').val(response.user.role);
                                $('#edit_is_active').prop('checked', response.user.is_active);
                                
                                // Populate permissions
                                $('.edit-permission-checkbox').prop('checked', false);
                                if (response.user.permissions && Array.isArray(response.user.permissions)) {
                                    response.user.permissions.forEach(function(permission) {
                                        $('#edit_permission_' + permission).prop('checked', true);
                                    });
                                }
                                
                                // Trigger role change to show/hide permissions section
                                $('#edit_role').trigger('change');
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load user data.'
                        });
                    }
                });
            });

            // Handle edit user form submission
            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const userId = $('#edit_user_id').val();
                const formData = form.serialize();
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                
                // Clear previous errors
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
                
                $.ajax({
                    url: '/users/' + userId,
                    method: 'PUT',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#editUserModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to update user. Please try again.'
                            });
                        }
                    }
                });
            });

            // Open View User Modal
            $(document).on("click", ".view-user-btn", function() {
                const userId = $(this).data("user-id");
                
                $("#viewUserModal").modal("show");

                $.ajax({
                    url: "/users/" + userId,
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    },
                    success: function(response) {
                        const user = response.user;
                        
                        // Basic Information
                        $("#view_name").text(user.name);
                        $("#view_email").text(user.email);
                        $("#view_phone").text(user.phone || "Not Provided");
                        
                        // Role badge with new styling
                        const roleLabels = {
                            'super_admin': 'Super Admin',
                            'business_owner': 'Business Owner',
                            'manager': 'Manager',
                            'accountant': 'Accountant',
                            'staff': 'Staff'
                        };
                        const roleColors = {
                            'super_admin': { bg: '#fee2e2', text: '#991b1b' },
                            'business_owner': { bg: '#fef3c7', text: '#92400e' },
                            'manager': { bg: '#fef3c7', text: '#92400e' },
                            'accountant': { bg: '#dbeafe', text: '#1e40af' },
                            'staff': { bg: '#e5e7eb', text: '#374151' }
                        };
                        
                        const roleLabel = roleLabels[user.role] || user.role.charAt(0).toUpperCase() + user.role.slice(1);
                        const colors = roleColors[user.role] || { bg: '#e5e7eb', text: '#374151' };
                        
                        $("#view_role").html(`<span class="badge px-12 py-6 fw-semibold" style="background-color: ${colors.bg}; color: ${colors.text};">${roleLabel}</span>`);
                        
                        // Status badge with larger style
                        if (user.is_active) {
                            $("#view_status").html('<span class="badge px-16 py-8 fw-semibold" style="background-color: #d1fae5; color: #065f46; font-size: 14px;">Active</span>');
                        } else {
                            $("#view_status").html('<span class="badge px-16 py-8 fw-semibold" style="background-color: #fee2e2; color: #991b1b; font-size: 14px;">Inactive</span>');
                        }
                        
                        // Module Permissions
                        const moduleLabels = {
                            'dashboard': 'Dashboard',
                            'products': 'Products',
                            'stock': 'Stock Management',
                            'sales': 'Sales',
                            'invoices': 'Invoices',
                            'customers': 'Customers',
                            'expenses': 'Expenses',
                            'reports': 'Reports',
                            'goals': 'Target Goals',
                            'users': 'User Management'
                        };
                        
                        let permissionsHtml = '';
                        
                        if (user.role === 'business_owner' || user.role === 'super_admin') {
                            permissionsHtml = '<div class="col-12"><div class="alert alert-info mb-0" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b;"><i class="bi bi-shield-check me-2"></i>This user has full access to all modules.</div></div>';
                        } else if (user.permissions && user.permissions.length > 0) {
                            user.permissions.forEach(function(permission) {
                                const label = moduleLabels[permission] || permission;
                                permissionsHtml += `
                                    <div class="col-md-6 mb-12">
                                        <div class="p-12 rounded-2 d-flex align-items-center gap-2" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                                            <i class="bi bi-check-circle-fill" style="color: #ec3737;"></i>
                                            <span class="fw-medium" style="color: #991b1b; font-size: 14px;">${label}</span>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            permissionsHtml = '<div class="col-12"><div class="alert alert-warning mb-0" style="background-color: #fef3c7; border: 1px solid #fde047; color: #92400e;"><i class="bi bi-exclamation-triangle-fill me-2"></i>No module permissions assigned.</div></div>';
                        }
                        
                        $("#view_permissions_list").html(permissionsHtml);
                        
                        // Hide permissions section for admin roles
                        if (user.role === 'business_owner' || user.role === 'super_admin') {
                            $("#view_permissions_section").hide();
                        } else {
                            $("#view_permissions_section").show();
                        }
                        
                        // Created date
                        const createdDate = new Date(user.created_at);
                        $("#view_created_at").text(createdDate.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        }));
                    },
                    error: function(xhr) {
                        $("#viewUserModal").modal("hide");
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Failed to load user details."
                        });
                    }
                });
            });

            // Delete confirmation
            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This user will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ec3737",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>
    @endpush

</x-layout.master>

