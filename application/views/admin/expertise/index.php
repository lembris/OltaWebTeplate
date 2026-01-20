<div class="page-header">
    <div>
        <h1 class="page-title">Medical Expertise</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Medical Expertise</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/expertise/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Expertise
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
            <i class="fas fa-user-md me-2"></i>All Medical Expertise
        </div>
        <div class="text-muted">
            Total: <?= count($expertises) ?> items
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($expertises)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No medical expertise found.</p>
                <a href="<?= base_url('admin/expertise/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Expertise
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
                        <?php foreach ($expertises as $index => $expertise): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($expertise->icon)): ?>
                                    <div class="icon-box bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi <?= htmlspecialchars($expertise->icon) ?>"></i>
                                    </div>
                                    <?php else: ?>
                                    <div class="icon-box bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-heart-pulse"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($expertise->name) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($expertise->short_description) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars(ucfirst($expertise->category)) ?></span>
                            </td>
                            <td><?= $expertise->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/expertise/toggle_featured/' . $expertise->uid) ?>" class="btn btn-sm <?= $expertise->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>">
                                    <i class="fas fa-star<?= $expertise->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/expertise/toggle_status/' . $expertise->uid) ?>" class="btn btn-sm <?= $expertise->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>">
                                    <?= $expertise->status === 'active' ? '<i class="fas fa-check"></i> Active' : '<i class="fas fa-times"></i> Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/expertise/edit/' . $expertise->uid) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?= base_url('admin/expertise/delete/' . $expertise->uid) ?>', 'expertise')">
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
