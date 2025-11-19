<div class="row">
    <!-- Product Categories Section -->
    <div class="col-md-6">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-20">
                <h6 class="text-lg mb-0">Product Categories</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductCategoryModal">
                    <i class="bi bi-circle-fill"></i> Add Category
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
                            <button type="button" class="btn btn-sm btn-outline-primary btn-icon edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}" data-active="{{ $category->is_active }}">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-icon delete-category" data-id="{{ $category->id }}">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-circle-fill"></i>
                    <p class="text-secondary-light mt-2">No product categories yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Product Types & Units Section -->
    <div class="col-md-6">
        <!-- Product Types -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-20">
                <h6 class="text-lg mb-0">Product Types</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductTypeModal">
                    <i class="bi bi-circle-fill"></i> Add Type
                </button>
            </div>

            <div id="productTypesList">
                @forelse($productTypes as $type)
                <div class="config-item {{ $type->is_active ? '' : 'inactive' }}" data-id="{{ $type->id }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-md mb-1">{{ $type->setting_label }}</h6>
                            @if($type->description)
                            <p class="text-sm text-secondary-light mb-0">{{ $type->description }}</p>
                            @endif
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge {{ $type->is_active ? 'bg-success-100 text-success-600' : 'bg-secondary-100 text-secondary-600' }} badge-status">
                                {{ $type->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if(!$type->is_system)
                            <button type="button" class="btn btn-sm btn-outline-primary btn-icon edit-type" data-id="{{ $type->id }}" data-label="{{ $type->setting_label }}" data-value="{{ $type->setting_value }}" data-description="{{ $type->description }}" data-active="{{ $type->is_active }}">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-icon delete-type" data-id="{{ $type->id }}">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                            @else
                            <span class="badge bg-info-100 text-info-600 badge-status">System</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-circle-fill"></i>
                    <p class="text-secondary-light mt-2">No product types configured</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Product Category Modal -->
<div class="modal fade" id="addProductCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductCategoryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Category Modal -->
<div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="category_id" id="edit_category_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="edit_category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_category_description" rows="3"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_category_active">
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Product Type Modal -->
<div class="modal fade" id="addProductTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductTypeForm">
                @csrf
                <input type="hidden" name="setting_key" value="product_type">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="setting_label" required placeholder="e.g., Digital Product">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="setting_value" required placeholder="e.g., digital">
                        <small class="text-secondary-light">Lowercase, no spaces (use underscores)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Type Modal -->
<div class="modal fade" id="editProductTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductTypeForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="type_id" id="edit_type_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="setting_label" id="edit_type_label" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="setting_value" id="edit_type_value" required>
                        <small class="text-secondary-light">Lowercase, no spaces (use underscores)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_type_description" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_type_active">
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Type</button>
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

    // Product Types - Similar handlers
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

