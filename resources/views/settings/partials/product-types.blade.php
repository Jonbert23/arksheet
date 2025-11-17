<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Product Types</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addProductTypeModal">
        <iconify-icon icon="ic:round-plus" class="icon text-xl"></iconify-icon>
        Add Type
    </button>
</div>

<div id="productTypesList">
    @forelse($productTypes as $type)
    <div class="config-item {{ $type->is_active ? '' : 'inactive' }}" data-id="{{ $type->id }}">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <h6 class="text-md mb-1">{{ $type->setting_label }}</h6>
                <p class="text-sm text-secondary-light mb-0">Value: <code>{{ $type->setting_value }}</code></p>
                @if($type->description)
                <p class="text-sm text-secondary-light mb-0 mt-1">{{ $type->description }}</p>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge {{ $type->is_active ? 'bg-success-100 text-success-600' : 'bg-secondary-100 text-secondary-600' }} badge-status">
                    {{ $type->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if(!$type->is_system)
                <button type="button" class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-type" data-id="{{ $type->id }}" data-label="{{ $type->setting_label }}" data-value="{{ $type->setting_value }}" data-description="{{ $type->description }}" data-active="{{ $type->is_active }}" title="Edit">
                    <iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-type" data-id="{{ $type->id }}" title="Delete">
                    <iconify-icon icon="mingcute:delete-2-line" class="text-lg"></iconify-icon>
                </button>
                @else
                <span class="badge bg-info-100 text-info-600 badge-status fw-medium">System</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div class="d-flex justify-content-center mb-3">
            <iconify-icon icon="mdi:shape" class="text-secondary-light" style="font-size: 48px;"></iconify-icon>
        </div>
        <p class="text-secondary-light mb-0">No product types configured</p>
    </div>
    @endforelse
</div>

<!-- Add Product Type Modal -->
<div class="modal fade" id="addProductTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Add Product Type
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductTypeForm">
                @csrf
                <input type="hidden" name="setting_key" value="product_type">
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="label" required placeholder="e.g., Digital Product">
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type Value <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="value" required placeholder="e.g., digital">
                        <small class="text-secondary-light d-block mt-1"><iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon> Lowercase, no spaces (use underscores)</small>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                        <textarea class="form-control radius-8" name="description" rows="2" placeholder="Brief description..."></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                        <label class="form-check-label fw-medium">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                        <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                        Cancel
                    </button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                        Add Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Type Modal -->
<div class="modal fade" id="editProductTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Edit Product Type
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductTypeForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="type_id" id="edit_type_id">
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="label" id="edit_type_label" required>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type Value <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="value" id="edit_type_value" required>
                        <small class="text-secondary-light d-block mt-1"><iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon> Lowercase, no spaces (use underscores)</small>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                        <textarea class="form-control radius-8" name="description" id="edit_type_description" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_type_active">
                        <label class="form-check-label fw-medium">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                        <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                        Cancel
                    </button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                        Update Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Product Types - Add
    $('#addProductTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("settings.config.product-types.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addProductTypeModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Product Types - Edit
    $('.edit-type').on('click', function() {
        $('#edit_type_id').val($(this).data('id'));
        $('#edit_type_label').val($(this).data('label'));
        $('#edit_type_value').val($(this).data('value'));
        $('#edit_type_description').val($(this).data('description'));
        $('#edit_type_active').prop('checked', $(this).data('active'));
        $('#editProductTypeModal').modal('show');
    });

    $('#editProductTypeForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#edit_type_id').val();
        $.ajax({
            url: `/settings/config/product-types/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editProductTypeModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Product Types - Delete
    $('.delete-type').on('click', function() {
        if (confirm('Are you sure you want to delete this type?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/settings/config/product-types/${id}`,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Cannot delete this type'));
                }
            });
        }
    });
});
</script>
@endpush

