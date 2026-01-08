<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Contact Groups</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/settings') ?>">Settings</a></li>
                <li class="breadcrumb-item active">Contact Groups</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/contact-groups/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Group
        </a>
    </div>
</div>

<!-- Info Alert -->
<div class="alert alert-info alert-dismissible fade show mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Contact Groups</strong> allow you to organize contacts for bulk notifications. Create groups, add members, then use them in Bulk Notifications.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Groups Grid -->
<div class="row">
    <?php if (!empty($groups)): ?>
        <?php foreach ($groups as $group): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 group-card <?= $group->is_active ? '' : 'opacity-50' ?>">
                    <div class="card-header d-flex align-items-center justify-content-between" 
                         style="background: <?= $group->color ?>20; border-left: 4px solid <?= $group->color ?>;">
                        <div class="d-flex align-items-center">
                            <i class="fas <?= $group->icon ?> fa-lg me-3" style="color: <?= $group->color ?>;"></i>
                            <div>
                                <h5 class="mb-0"><?= htmlspecialchars($group->name) ?></h5>
                                <?php if (!$group->is_active): ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/contact-groups/members/' . $group->uid) ?>">
                                        <i class="fas fa-users me-2"></i>Manage Members
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/contact-groups/edit/' . $group->uid) ?>">
                                        <i class="fas fa-edit me-2"></i>Edit Group
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" 
                                       onclick="confirmDelete('<?= base_url('admin/contact-groups/delete/' . $group->uid) ?>', 'contact group')">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($group->description): ?>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($group->description) ?></p>
                        <?php endif; ?>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="h3 mb-0" style="color: <?= $group->color ?>;">
                                    <?= number_format($group->member_count ?? 0) ?>
                                </span>
                                <span class="text-muted ms-2">members</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" 
                                       type="checkbox" 
                                       data-uid="<?= $group->uid ?>"
                                       <?= $group->is_active ? 'checked' : '' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="<?= base_url('admin/contact-groups/members/' . $group->uid) ?>" 
                           class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Manage Members
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                    <h4>No Contact Groups Yet</h4>
                    <p class="text-muted">Create your first contact group to organize recipients for bulk notifications.</p>
                    <a href="<?= base_url('admin/contact-groups/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Group
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const groupUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/contact-groups/toggle-status/') ?>' + groupUid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    checkbox.checked = !checkbox.checked;
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
            });
        });
    });
});
</script>

<style>
.group-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.group-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
</style>
