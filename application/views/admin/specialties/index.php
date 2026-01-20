<div class="page-header">
    <div>
        <h1 class="page-title">Medical Specialties</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Medical Specialties</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/specialties/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Specialty
        </a>
    </div>
</div>

<?php if ($this->session->flashdata('message')): ?>
    <div class="alert alert-<?= $this->session->flashdata('message_type') ?> alert-dismissible fade show">
        <?= $this->session->flashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-list me-2"></i>All Medical Specialties
        </div>
        <div class="text-muted">
            Total: <?= count($specialties) ?> items
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($specialties)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No medical specialties found.</p>
                <a href="<?= base_url('admin/specialties/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Specialty
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Display Order</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($specialties as $index => $specialty): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($specialty->icon)): ?>
                                    <div class="icon-box bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi <?= htmlspecialchars($specialty->icon) ?>"></i>
                                    </div>
                                    <?php else: ?>
                                    <div class="icon-box bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($specialty->name) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($specialty->short_description) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $specialty->category))) ?></span>
                            </td>
                            <td><?= $specialty->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/specialties/toggle_featured/' . $specialty->uid) ?>" class="btn btn-sm <?= $specialty->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>">
                                    <i class="fas fa-star<?= $specialty->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/specialties/toggle_status/' . $specialty->uid) ?>" class="btn btn-sm <?= $specialty->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>">
                                    <?= $specialty->status === 'active' ? '<i class="fas fa-check"></i> Active' : '<i class="fas fa-times"></i> Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/specialties/edit/' . $specialty->uid) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?= base_url('admin/specialties/delete/' . $specialty->uid) ?>', 'specialty')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
