<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Units of Measurement</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addUnitModal">
        <iconify-icon icon="ic:round-plus" class="icon text-xl"></iconify-icon>
        Add Unit
    </button>
</div>

<div id="unitsList">
    @forelse($units as $unit)
    <div class="config-item {{ $unit->is_active ? '' : 'inactive' }}" data-id="{{ $unit->id }}">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <h6 class="text-md mb-1">{{ $unit->setting_label }}</h6>
                <p class="text-sm text-secondary-light mb-0">Value: <code>{{ $unit->setting_value }}</code></p>
                @if($unit->description)
                <p class="text-sm text-secondary-light mb-0 mt-1">{{ $unit->description }}</p>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge {{ $unit->is_active ? 'bg-success-100 text-success-600' : 'bg-secondary-100 text-secondary-600' }} badge-status">
                    {{ $unit->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if(!$unit->is_system)
                <button type="button" class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-unit" 
                    data-id="{{ $unit->id }}" 
                    data-label="{{ $unit->setting_label }}"
                    data-value="{{ $unit->setting_value }}"
                    data-description="{{ $unit->description }}"
                    data-active="{{ $unit->is_active }}"
                    title="Edit">
                    <iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-unit" data-id="{{ $unit->id }}" title="Delete">
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
            <iconify-icon icon="mdi:ruler" class="text-secondary-light" style="font-size: 48px;"></iconify-icon>
        </div>
        <p class="text-secondary-light mb-0">No units configured</p>
    </div>
    @endforelse
</div>

<!-- Add Unit Modal -->
<div class="modal fade" id="addUnitModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Add Unit of Measurement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUnitForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Unit Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="label" required placeholder="e.g., Pieces">
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Unit Symbol/Abbreviation <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="value" required placeholder="e.g., pcs">
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
                        Add Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Unit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                    Edit Unit of Measurement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUnitForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="unit_id" id="edit_unit_id">
                <div class="modal-body">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Unit Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="label" id="edit_unit_label" required>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Unit Symbol/Abbreviation <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" name="value" id="edit_unit_value" required>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                        <textarea class="form-control radius-8" name="description" id="edit_unit_description" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_unit_active">
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
                        Update Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#addUnitForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("settings.config.units.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function() { $('#addUnitModal').modal('hide'); location.reload(); },
            error: function(xhr) { alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong')); }
        });
    });

    $('.edit-unit').on('click', function() {
        $('#edit_unit_id').val($(this).data('id'));
        $('#edit_unit_label').val($(this).data('label'));
        $('#edit_unit_value').val($(this).data('value'));
        $('#edit_unit_description').val($(this).data('description'));
        $('#edit_unit_active').prop('checked', $(this).data('active'));
        $('#editUnitModal').modal('show');
    });

    $('#editUnitForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#edit_unit_id').val();
        $.ajax({
            url: `/settings/config/units/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function() { $('#editUnitModal').modal('hide'); location.reload(); },
            error: function(xhr) { alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong')); }
        });
    });

    $('.delete-unit').on('click', function() {
        if (confirm('Are you sure?')) {
            $.ajax({
                url: `/settings/config/units/${$(this).data('id')}`,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() { location.reload(); },
                error: function(xhr) { alert('Error: ' + (xhr.responseJSON?.message || 'Cannot delete')); }
            });
        }
    });
});
</script>
@endpush

