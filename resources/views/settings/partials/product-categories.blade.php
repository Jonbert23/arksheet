<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Product Categories</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addProductCategoryModal">
        <i class="bi bi-plus-circle"></i>
        Add Category
    </button>
</div>

<div id="productCategoriesList">
    @forelse($productCategories as $category)
    <div class="config-item {{ $category->is_active ? '' : 'inactive' }}" data-id="{{ $category->id }}">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <h6 class="text-md mb-1">{{ $category->name }}</h6>
                @if($category->description)
                <p class="text-sm text-secondary-light mb-0">{{ $category->description }}</p>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge {{ $category->is_active ? 'bg-success-100 text-success-600' : 'bg-secondary-100 text-secondary-600' }} badge-status">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </span>
                <button type="button" class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}" data-active="{{ $category->is_active }}" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-category" data-id="{{ $category->id }}" title="Delete">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div class="d-flex justify-content-center mb-3">
            <i class="bi bi-inbox" style="font-size: 48px; color: #9ca3af;"></i>
        </div>
        <p class="text-secondary-light mb-0">No product categories yet</p>
    </div>
    @endforelse
</div>

<!-- Add Product Category Modal -->
<div class="modal fade" id="addProductCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Add Product Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductCategoryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Category Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="name" required placeholder="e.g., Electronics">
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                        <textarea class="form-control radius-8" name="description" rows="3" placeholder="Brief description of this category..."></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                        <label class="form-check-label fw-medium">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        <i class="bi bi-plus-circle"></i>
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Category Modal -->
<div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Edit Product Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="category_id" id="edit_category_id">
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Category Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="name" id="edit_category_name" required>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                        <textarea class="form-control radius-8" name="description" id="edit_category_description" rows="3"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_category_active">
                        <label class="form-check-label fw-medium">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        <i class="bi bi-check-circle"></i>
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Add Product Category
    $('#addProductCategoryForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("settings.config.product-categories.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addProductCategoryModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Edit Product Category - Show Modal
    $('.edit-category').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');
        const isActive = $(this).data('active');

        $('#edit_category_id').val(id);
        $('#edit_category_name').val(name);
        $('#edit_category_description').val(description);
        $('#edit_category_active').prop('checked', isActive);
        
        $('#editProductCategoryModal').modal('show');
    });

    // Update Product Category
    $('#editProductCategoryForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#edit_category_id').val();
        $.ajax({
            url: `/settings/config/product-categories/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editProductCategoryModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Delete Product Category
    $('.delete-category').on('click', function() {
        if (confirm('Are you sure you want to delete this category?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/settings/config/product-categories/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Cannot delete this category'));
                }
            });
        }
    });
});
</script>
@endpush

