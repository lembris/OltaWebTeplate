<!-- Permissions Management -->
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
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-3">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['total'] ?></h3>
                <p class="card-text small">Total Permissions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['active'] ?></h3>
                <p class="card-text small">Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= $statistics['inactive'] ?></h3>
                <p class="card-text small">Inactive</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?= count($permissions_grouped) ?></h3>
                <p class="card-text small">Modules</p>
            </div>
        </div>
    </div>
</div>

<!-- Permissions by Module -->
<div class="row">
    <?php foreach ($permissions_grouped as $module => $permissions): ?>
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-cube me-2"></i><?= ucfirst(str_replace('_', ' ', $module)) ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="permission-list">
                        <?php foreach ($permissions as $perm): ?>
                            <div class="permission-item mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <?= htmlspecialchars($perm->name) ?>
                                            <?php if ($perm->status == 'active'): ?>
                                                <span class="badge bg-success-subtle text-success ms-2">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger ms-2">Inactive</span>
                                            <?php endif; ?>
                                        </h6>
                                        <p class="text-muted small mb-1"><?= htmlspecialchars($perm->description) ?></p>
                                        <code class="text-muted" style="font-size: 0.85em;"><?= htmlspecialchars($perm->slug) ?></code>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Permission Legend -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-info-circle me-2"></i>Permission Guide
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary">Common Actions</h6>
                <ul class="small">
                    <li><strong>Create:</strong> Permission to create new items</li>
                    <li><strong>Read:</strong> Permission to view/list items</li>
                    <li><strong>Update:</strong> Permission to edit items</li>
                    <li><strong>Delete:</strong> Permission to remove items</li>
                    <li><strong>Manage:</strong> Full management capability</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="text-primary">How to Use</h6>
                <ul class="small">
                    <li>Go to <a href="<?= base_url('admin/roles') ?>">Manage Roles</a></li>
                    <li>Create or edit a role</li>
                    <li>Select permissions to assign</li>
                    <li>Save the role</li>
                </ul>
            </div>
        </div>
    </div>
</div>
