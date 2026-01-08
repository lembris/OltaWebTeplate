<!-- Role Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/roles') ?>">Roles</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open('', ['id' => 'roleForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Role Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-shield-alt me-2"></i>Role Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                               name="name" 
                               value="<?= set_value('name', isset($role) && $role ? $role->name : '') ?>" 
                               placeholder="e.g., Content Manager"
                               required>
                        <?php if (form_error('name')): ?>
                            <div class="text-danger small mt-1"><?= form_error('name') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Role description and responsibilities"><?= set_value('description', isset($role) && $role ? $role->description : '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" 
                               class="form-control form-control-color" 
                               name="color" 
                               value="<?= set_value('color', isset($role) && $role ? $role->color : '#0d6efd') ?>"
                               style="height: 45px;">
                        <small class="text-muted">Choose a color to identify this role</small>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-key me-2"></i>Assign Permissions
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($permissions as $module => $module_permissions): ?>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary text-uppercase mb-3">
                                    <i class="fas fa-cube me-2"></i><?= ucfirst(str_replace('_', ' ', $module)) ?>
                                </h6>
                                <div class="module-permissions">
                                    <?php foreach ($module_permissions as $permission): ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   name="permissions[]" 
                                                   id="perm_<?= $permission->id ?>" 
                                                   value="<?= $permission->id ?>"
                                                   <?= in_array($permission->id, $selected_permissions) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="perm_<?= $permission->id ?>">
                                                <strong><?= htmlspecialchars($permission->name) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= htmlspecialchars($permission->description) ?></small>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($role) && $role ? 'Update Role' : 'Create Role' ?>
                        </button>
                        <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightning-bolt me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="selectAll">
                            Select All
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="selectNone">
                            Clear All
                        </button>
                    </div>
                </div>
            </div>

            <!-- Role Info (Edit Mode) -->
            <?php if (isset($role) && $role): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Role Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $role->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Type:</td>
                            <td><?= $role->is_system_role ? '<span class="badge bg-info">System</span>' : '<span class="badge bg-warning">Custom</span>' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($role->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($role->updated_at)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Help -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary small">Permissions</h6>
                        <p class="small text-muted">Select permissions to grant this role. Permissions control what actions users with this role can perform.</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">System Roles</h6>
                        <p class="small text-muted">System roles cannot be edited or deleted and always have all permissions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All button
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.checked = true;
        });
    });

    // Select None button
    document.getElementById('selectNone').addEventListener('click', function() {
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
});
</script>
