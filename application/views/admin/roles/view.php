<!-- Role Details View -->
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
        <?php if (!$role->is_system_role): ?>
            <a href="<?= base_url('admin/roles/edit/' . $role->uid) ?>" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Role
            </a>
        <?php endif; ?>
        <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<div class="row">
    <!-- Role Information -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-shield-alt me-2"></i>Role Information
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" style="width: 20%;">Role Name:</td>
                        <td>
                            <span class="badge" style="background-color: <?= htmlspecialchars($role->color) ?>; font-size: 1em;">
                                <?= htmlspecialchars($role->name) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Type:</td>
                        <td>
                            <?php if ($role->is_system_role): ?>
                                <span class="badge bg-info">System Role</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Custom Role</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status:</td>
                        <td>
                            <?php if ($role->status == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Description:</td>
                        <td><?= htmlspecialchars($role->description) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created:</td>
                        <td><?= date('M d, Y H:i', strtotime($role->created_at)) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Updated:</td>
                        <td><?= date('M d, Y H:i', strtotime($role->updated_at)) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Assigned Permissions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-key me-2"></i>Assigned Permissions
            </div>
            <div class="card-body">
                <?php if (empty($permissions)): ?>
                    <p class="text-muted text-center py-4">No permissions assigned to this role</p>
                <?php else: ?>
                    <div class="row">
                        <?php
                        $grouped = [];
                        foreach ($permissions as $perm) {
                            if (!isset($grouped[$perm->module])) {
                                $grouped[$perm->module] = [];
                            }
                            $grouped[$perm->module][] = $perm;
                        }
                        ?>
                        <?php foreach ($grouped as $module => $perms): ?>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary text-uppercase mb-3">
                                    <i class="fas fa-cube me-2"></i><?= ucfirst(str_replace('_', ' ', $module)) ?>
                                </h6>
                                <div class="list-group list-group-sm">
                                    <?php foreach ($perms as $perm): ?>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($perm->name) ?></h6>
                                                    <p class="small text-muted mb-0"><?= htmlspecialchars($perm->description) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Role Statistics -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie me-2"></i>Statistics
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Total Permissions</label>
                    <h3><?= count($permissions) ?></h3>
                </div>
            </div>
        </div>

        <!-- Role Info -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info me-2"></i>Role Info
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Role ID:</td>
                        <td><strong><?= $role->id ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">UID:</td>
                        <td><small><?= htmlspecialchars($role->uid) ?></small></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if (!$role->is_system_role): ?>
                        <a href="<?= base_url('admin/roles/edit/' . $role->uid) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit Role
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" id="deleteBtn">
                            <i class="fas fa-trash me-2"></i>Delete Role
                        </button>
                    <?php else: ?>
                        <p class="text-muted small text-center mb-0">System roles cannot be edited or deleted</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!$role->is_system_role): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('deleteBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
            fetch('<?= base_url('admin/roles/delete') ?>/<?= $role->uid ?>', {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '<?= base_url('admin/roles') ?>';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>
<?php endif; ?>
