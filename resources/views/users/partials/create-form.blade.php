<form id="addUserForm">
    @csrf
    
    <!-- Basic Information Section -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-circle-fill"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Basic Information</h6>
        </div>
        
        <div class="row">
            <!-- Name -->
            <div class="col-md-6 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Full Name <span class="text-danger-600">*</span>
                </label>
                <input type="text" name="name" class="form-control radius-8" placeholder="Enter full name" required>
                <div class="invalid-feedback"></div>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Email Address <span class="text-danger-600">*</span>
                </label>
                <input type="email" name="email" class="form-control radius-8" placeholder="user@example.com" required>
                <div class="invalid-feedback"></div>
            </div>

            <!-- Phone -->
            <div class="col-md-6 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Phone Number
                </label>
                <input type="text" name="phone" class="form-control radius-8" placeholder="+1 234 567 8900">
                <div class="invalid-feedback"></div>
            </div>

            <!-- Role -->
            <div class="col-md-6 mb-0">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Role <span class="text-danger-600">*</span>
                </label>
                <select name="role" class="form-select radius-8" required>
                    <option value="">Select Role</option>
                    <option value="business_owner">Business Owner</option>
                    <option value="manager">Manager</option>
                    <option value="accountant">Accountant</option>
                    <option value="staff">Staff</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    
    <!-- Account Security Section -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-circle-fill"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Account Security</h6>
        </div>
        
        <div class="row">
            <!-- Password -->
            <div class="col-md-6 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Password <span class="text-danger-600">*</span>
                </label>
                <input type="password" name="password" class="form-control radius-8" placeholder="Enter password" required>
                <small class="text-muted">Minimum 8 characters</small>
                <div class="invalid-feedback"></div>
            </div>

            <!-- Password Confirmation -->
            <div class="col-md-6 mb-0">
                <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Confirm Password <span class="text-danger-600">*</span>
                </label>
                <input type="password" name="password_confirmation" class="form-control radius-8" placeholder="Confirm password" required>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    
    <!-- Module Permissions Section -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;" id="permissionsSection">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-circle-fill"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Module Permissions</h6>
        </div>
        
        <div class="row">
            @php
                $modules = \App\Models\User::getAvailableModules();
            @endphp
            @foreach($modules as $key => $label)
            <div class="col-md-6 mb-16">
                <div class="form-check d-flex align-items-center gap-2">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $key }}" id="add_permission_{{ $key }}" style="width: 18px; height: 18px; margin-top: 0; cursor: pointer;">
                    <label class="form-check-label fw-medium mb-0" for="add_permission_{{ $key }}" style="color: #374151; cursor: pointer;">
                        {{ $label }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
        <small class="text-muted d-block mt-12">Select modules this user can access. Business Owners automatically get full access.</small>
    </div>
    
    <!-- Settings Section -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-circle-fill"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Settings</h6>
        </div>
        
        <div class="row">
            <!-- Status -->
            <div class="col-12 mb-0">
                <label class="form-label fw-semibold text-primary-light text-sm mb-12">
                    Account Status
                </label>
                <div class="p-16 rounded-3" style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add_is_active" checked style="width: 48px; height: 24px; cursor: pointer; margin-top: 0;">
                            </div>
                            <div>
                                <label class="form-check-label fw-semibold mb-1" for="add_is_active" style="cursor: pointer; color: #1f2937; font-size: 15px; display: block;">
                                    Active User
                                </label>
                                <small class="text-muted d-block" style="font-size: 13px;">Inactive users cannot log in to the system</small>
                            </div>
                        </div>
                        <span class="badge px-12 py-6" id="add_status_badge" style="background-color: #d1fae5; color: #065f46; font-weight: 600;">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="d-flex justify-content-end gap-3 mt-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500; transition: all 0.2s ease;" data-bs-dismiss="modal">
            <i class="bi bi-circle-fill"></i>
            <span>Cancel</span>
        </button>
        <button type="submit" class="btn text-white radius-8 d-flex align-items-center gap-2" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
            <i class="bi bi-circle-fill"></i>
            <span>Create User</span>
        </button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Handle role change to show/hide permissions
    $('#addUserForm select[name="role"]').on('change', function() {
        const role = $(this).val();
        const permissionsSection = $('#permissionsSection');
        
        if (role === 'business_owner') {
            permissionsSection.hide();
            // Uncheck all permissions for admins
            permissionsSection.find('input[type="checkbox"]').prop('checked', false);
        } else {
            permissionsSection.show();
        }
    });

    // Trigger on page load
    $('#addUserForm select[name="role"]').trigger('change');
    
    // Handle status toggle
    $('#add_is_active').on('change', function() {
        const badge = $('#add_status_badge');
        if ($(this).is(':checked')) {
            badge.text('Active');
            badge.css({
                'background-color': '#d1fae5',
                'color': '#065f46'
            });
        } else {
            badge.text('Inactive');
            badge.css({
                'background-color': '#fee2e2',
                'color': '#991b1b'
            });
        }
    });
});
</script>
