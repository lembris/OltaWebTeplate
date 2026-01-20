<div class="page-header">
    <div>
        <h1 class="page-title">Hospital Partners</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Hospital Partners</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/hospitals/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Hospital
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
            <i class="fas fa-hospital me-2"></i>All Hospital Partners
        </div>
        <div class="text-muted">
            Total: <?= count($hospitals) ?> hospitals
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($hospitals)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No hospital partners found.</p>
                <a href="<?= base_url('admin/hospitals/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Hospital
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Hospital Name</th>
                            <th>Type</th>
                            <th>Country</th>
                            <th>Display Order</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hospitals as $index => $hospital): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($hospital->logo)): ?>
                                    <div class="logo-box bg-white rounded d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px; overflow: hidden;">
                                        <img src="<?= base_url('assets/img/partners/' . $hospital->logo) ?>" alt="<?= htmlspecialchars($hospital->name) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <?php else: ?>
                                    <div class="logo-box bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-hospital"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($hospital->name) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($hospital->short_description) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $hospital->type === 'tanzania' ? 'bg-success' : 'bg-info' ?>">
                                    <?= $hospital->type === 'tanzania' ? 'Tanzania' : 'International' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($hospital->country ?: '-') ?></td>
                            <td><?= $hospital->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/hospitals/toggle_featured/' . $hospital->uid) ?>" class="btn btn-sm <?= $hospital->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>">
                                    <i class="fas fa-star<?= $hospital->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/hospitals/toggle_status/' . $hospital->uid) ?>" class="btn btn-sm <?= $hospital->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>">
                                    <?= $hospital->status === 'active' ? '<i class="fas fa-check"></i> Active' : '<i class="fas fa-times"></i> Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/hospitals/edit/' . $hospital->uid) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/hospitals/delete/' . $hospital->uid) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this hospital?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
