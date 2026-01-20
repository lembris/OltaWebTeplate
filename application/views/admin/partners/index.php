<div class="page-header">
    <div>
        <h1 class="page-title">Partners</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Partners</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/partners/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Partner
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
            <i class="fas fa-handshake me-2"></i>All Partners
        </div>
        <div class="text-muted">
            Total: <?= count($partners) ?> partners
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($partners)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No partners found.</p>
                <a href="<?= base_url('admin/partners/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Partner
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Partner Name</th>
                            <th>Type</th>
                            <th>Template</th>
                            <th>Country</th>
                            <th>Display Order</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partners as $index => $partner): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($partner->logo)): ?>
                                    <div class="logo-box bg-white rounded d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px; overflow: hidden;">
                                        <img src="<?= base_url('assets/img/partners/' . $partner->logo) ?>" alt="<?= htmlspecialchars($partner->name) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <?php else: ?>
                                    <div class="logo-box bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($partner->name) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($partner->short_description) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $partner->type === 'tanzania' ? 'bg-success' : 'bg-info' ?>">
                                    <?= $partner->type === 'tanzania' ? 'Tanzania' : 'International' ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $template = $partner->template ?? 'all';
                                $template_class = 'bg-dark';
                                if ($template === 'medical') {
                                    $template_class = 'bg-primary';
                                } elseif ($template === 'college') {
                                    $template_class = 'bg-secondary';
                                } elseif ($template === 'tourism') {
                                    $template_class = 'bg-success';
                                }
                                ?>
                                <span class="badge <?= $template_class ?>">
                                    <?= ucfirst($partner->template ?? 'all') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($partner->country ?: '-') ?></td>
                            <td><?= $partner->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/partners/toggle_featured/' . $partner->uid) ?>" class="btn btn-sm <?= $partner->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>">
                                    <i class="fas fa-star<?= $partner->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/partners/toggle_status/' . $partner->uid) ?>" class="btn btn-sm <?= $partner->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>">
                                    <?= $partner->status === 'active' ? '<i class="fas fa-check"></i> Active' : '<i class="fas fa-times"></i> Inactive' ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/partners/edit/' . $partner->uid) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?= base_url('admin/partners/delete/' . $partner->uid) ?>', 'partner')">
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
