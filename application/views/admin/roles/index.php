<!-- Roles List -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/roles/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Role
        </a>
        <a href="<?= base_url('admin/roles/permissions') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-key me-2"></i>Manage Permissions
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Statistics -->
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['total'] ?></h3>
                <p class="card-text small">Total Roles</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['system_roles'] ?></h3>
                <p class="card-text small">System Roles</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['custom_roles'] ?></h3>
                <p class="card-text small">Custom Roles</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['active'] ?></h3>
                <p class="card-text small">Active</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form method="get" class="row g-2">
            <div class="col-md-6">
                <input type="text" 
                       name="keyword" 
                       class="form-control" 
                       placeholder="Search roles..." 
                       value="<?= htmlspecialchars($keyword) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('admin/roles') ?>" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Roles Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($roles)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-inbox text-muted" style="font-size: 2em;"></i>
                            <p class="text-muted mt-2">No roles found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($roles as $role): ?>
                        <tr>
                            <td class="text-muted small"><?= $role->id ?></td>
                            <td>
                                <span class="badge" style="background-color: <?= htmlspecialchars($role->color) ?>">
                                    <?= htmlspecialchars($role->name) ?>
                                </span>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars(substr($role->description, 0, 50)) ?></td>
                            <td>
                                <?php if ($role->is_system_role): ?>
                                    <span class="badge bg-info">System</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Custom</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($role->status == 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= base_url('admin/roles/view/' . $role->uid) ?>" 
                                       class="btn btn-outline-primary" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (!$role->is_system_role): ?>
                                        <a href="<?= base_url('admin/roles/edit/' . $role->uid) ?>" 
                                           class="btn btn-outline-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger delete-role" 
                                                data-uid="<?= $role->uid ?>" 
                                                data-name="<?= htmlspecialchars($role->name) ?>"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle role deletion
    document.querySelectorAll('.delete-role').forEach(button => {
        button.addEventListener('click', function() {
            const roleUid = this.dataset.uid;
            const roleName = this.dataset.name;

            if (confirm(`Are you sure you want to delete the role "${roleName}"?`)) {
                fetch('<?= base_url('admin/roles/delete') ?>/' + roleUid, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});
</script>
