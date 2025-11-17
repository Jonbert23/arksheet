<x-layout.master>
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">My Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">My Profile</li>
            </ul>
        </div>

        @if(session('success'))
        <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-24 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('success') }}
            </div>
            <button class="remove-button cursor-pointer bg-transparent border-0" onclick="this.parentElement.remove()">
                <iconify-icon icon="iconamoon:sign-times-light" class="icon text-2xl"></iconify-icon>                            
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-24 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:circle-alert" class="icon text-xl"></iconify-icon>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button class="remove-button cursor-pointer bg-transparent border-0" onclick="this.parentElement.remove()">
                <iconify-icon icon="iconamoon:sign-times-light" class="icon text-2xl"></iconify-icon>                            
            </button>
        </div>
        @endif

        <div class="row gy-4">
            <!-- Left Column - Profile Card -->
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/images/user.png') }}" 
                                 alt="{{ $user->name }}" 
                                 class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover"
                                 id="profileAvatar">
                        </div>
                        <h6 class="mb-0 mt-16">{{ $user->name }}</h6>
                        <span class="text-secondary-light mb-16 d-block">{{ $user->email }}</span>
                        <span class="badge bg-primary-100 text-primary-600 px-16 py-6 radius-8 fw-semibold">
                            <iconify-icon icon="mdi:shield-account" class="text-sm"></iconify-icon>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Personal Info</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->name }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->email }}</span>
                            </li>
                            @if($user->phone)
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Phone</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->phone }}</span>
                            </li>
                            @endif
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Role</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ ucfirst($user->role) }}</span>
                            </li>
                            @if($user->business)
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Business</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->business->name }}</span>
                            </li>
                            @endif
                            <li class="d-flex align-items-center gap-1">
                                <span class="w-30 text-md fw-semibold text-primary-light">Status</span>
                                <span class="w-70">
                                    <span class="badge {{ $user->is_active ? 'bg-success-100 text-success-600' : 'bg-danger-100 text-danger-600' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Tabbed Content -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-32">
                        <ul class="nav border-gradient-tab nav-pills mb-32 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2 px-24 py-12 fw-medium active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                                <iconify-icon icon="solar:user-linear" class="text-xl"></iconify-icon>
                                Edit Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2 px-24 py-12 fw-medium" id="pills-change-password-tab" data-bs-toggle="pill" data-bs-target="#pills-change-password" type="button" role="tab" aria-controls="pills-change-password" aria-selected="false">
                                <iconify-icon icon="solar:lock-password-outline" class="text-xl"></iconify-icon>
                                Change Password
                            </button>
                        </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Edit Profile Tab -->
                            <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab">
                                <h6 class="text-lg fw-semibold mb-20">Profile Image</h6>
                                
                                <!-- Upload Image Start -->
                                <div class="mb-32">
                                <div class="avatar-upload">
                                    <div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden>
                                        <label for="imageUpload" class="w-40-px h-40-px d-flex justify-content-center align-items-center bg-primary-600 text-white border-0 bg-hover-primary-700 text-xl rounded-circle cursor-pointer shadow-sm">
                                            <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                        </label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url('{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/images/user.png') }}');">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- Upload Image End -->

                                <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                Full Name <span class="text-danger-600">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control radius-8 @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name"
                                                   value="{{ old('name', $user->name) }}"
                                                   placeholder="Enter Full Name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                Email <span class="text-danger-600">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control radius-8 @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="Enter email address">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
                                            <input type="text" 
                                                   class="form-control radius-8 @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone"
                                                   value="{{ old('phone', $user->phone) }}"
                                                   placeholder="Enter phone number">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Role</label>
                                            <input type="text" 
                                                   class="form-control radius-8 bg-neutral-50" 
                                                   value="{{ ucfirst($user->role) }}"
                                                   readonly>
                                            <small class="text-secondary-light">Contact admin to change your role</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-32">
                                    <button type="reset" class="btn btn-outline-secondary px-32 py-12 radius-8 d-flex align-items-center gap-2 fw-medium">
                                        <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary-600 px-32 py-12 radius-8 d-flex align-items-center gap-2 fw-semibold">
                                        <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade" id="pills-change-password" role="tabpanel" aria-labelledby="pills-change-password-tab">
                                <h6 class="text-lg fw-semibold mb-24">Change Your Password</h6>
                                <form action="{{ route('profile.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-24">
                                    <label for="current-password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Current Password <span class="text-danger-600">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control radius-8 @error('current_password') is-invalid @enderror" 
                                               id="current-password" 
                                               name="current_password"
                                               placeholder="Enter Current Password">
                                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#current-password"></span>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-24">
                                    <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        New Password <span class="text-danger-600">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control radius-8 @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password"
                                               placeholder="Enter New Password (min. 8 characters)">
                                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#password"></span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-24">
                                    <label for="password-confirmation" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Confirm New Password <span class="text-danger-600">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control radius-8" 
                                               id="password-confirmation" 
                                               name="password_confirmation"
                                               placeholder="Re-enter New Password">
                                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#password-confirmation"></span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3 mt-32">
                                    <button type="reset" class="btn btn-outline-secondary px-32 py-12 radius-8 d-flex align-items-center gap-2 fw-medium">
                                        <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary-600 px-32 py-12 radius-8 d-flex align-items-center gap-2 fw-semibold">
                                        <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                                        Update Password
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ======================== Upload Image Start =====================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                    $("#imagePreview").hide();
                    $("#imagePreview").fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageUpload").change(function() {
            readURL(this);
            uploadAvatar(this);
        });

        function uploadAvatar(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('avatar', input.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route("profile.avatar.update") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Update profile avatar on profile page
                            $('#profileAvatar').attr('src', response.avatar_url);
                            
                            // Update navbar avatar
                            $('#navbarAvatar').attr('src', response.avatar_url);
                            
                            // Show success message
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to upload avatar. Please try again.');
                        } else {
                            alert('Failed to upload avatar. Please try again.');
                        }
                    }
                });
            }
        }
        // ======================== Upload Image End =====================

        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on("click", function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        
        // Call the function
        initializePasswordToggle(".toggle-password");
        // ========================= Password Show Hide Js End ===========================
    </script>
    @endpush
</x-layout.master>

