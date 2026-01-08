<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $group ? 'Edit Contact Group' : 'Create Contact Group' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/contact-groups') ?>">Contact Groups</a></li>
                <li class="breadcrumb-item active"><?= $group ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/contact-groups') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Groups
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open($form_action, ['id' => 'groupForm']) ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Group Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Group Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               value="<?= set_value('name', $group->name ?? '') ?>" 
                               placeholder="e.g., All Students, Faculty Members"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Brief description of this group"><?= set_value('description', $group->description ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Icon</label>
                                <select name="icon" class="form-select" id="groupIcon">
                                    <?php foreach ($icons as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('icon', $key, ($group->icon ?? 'fa-users') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Color</label>
                                <div class="input-group">
                                    <input type="color" 
                                           name="color" 
                                           class="form-control form-control-color" 
                                           id="groupColor"
                                           value="<?= set_value('color', $group->color ?? '#0d6efd') ?>"
                                           style="width: 60px;">
                                    <input type="text" 
                                           class="form-control" 
                                           id="colorHex"
                                           value="<?= set_value('color', $group->color ?? '#0d6efd') ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Preview -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-eye me-2"></i>Preview
                </div>
                <div class="card-body">
                    <div class="text-center py-4" id="groupPreview">
                        <div class="mb-3">
                            <i class="fas <?= $group->icon ?? 'fa-users' ?> fa-3x" id="previewIcon" 
                               style="color: <?= $group->color ?? '#0d6efd' ?>;"></i>
                        </div>
                        <h5 id="previewName"><?= $group->name ?? 'Group Name' ?></h5>
                        <p class="text-muted small mb-0" id="previewDesc"><?= $group->description ?? 'Description will appear here' ?></p>
                    </div>
                </div>
            </div>

            <!-- Publish -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Save
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1" 
                                   <?= set_checkbox('is_active', '1', ($group->is_active ?? 1) == 1) ?>>
                            <label class="form-check-label" for="is_active">
                                <strong>Active</strong>
                                <br><small class="text-muted">Enable this group for notifications</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $group ? 'Update Group' : 'Create Group' ?>
                        </button>
                        <a href="<?= base_url('admin/contact-groups') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="name"]');
    const descInput = document.querySelector('textarea[name="description"]');
    const iconSelect = document.getElementById('groupIcon');
    const colorInput = document.getElementById('groupColor');
    const colorHex = document.getElementById('colorHex');
    
    // Update preview
    function updatePreview() {
        document.getElementById('previewName').textContent = nameInput.value || 'Group Name';
        document.getElementById('previewDesc').textContent = descInput.value || 'Description will appear here';
        
        const icon = document.getElementById('previewIcon');
        icon.className = 'fas ' + iconSelect.value + ' fa-3x';
        icon.style.color = colorInput.value;
    }
    
    nameInput.addEventListener('input', updatePreview);
    descInput.addEventListener('input', updatePreview);
    iconSelect.addEventListener('change', updatePreview);
    colorInput.addEventListener('input', function() {
        colorHex.value = this.value;
        updatePreview();
    });
});
</script>
