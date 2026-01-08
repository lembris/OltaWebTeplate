<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Itineraries</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Itineraries</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-route me-2"></i>Packages with Itineraries</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="packagesTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Package Name</th>
                        <th width="120">Duration</th>
                        <th width="120">Days Added</th>
                        <th width="100">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($packages)): ?>
                        <?php $i = 1; foreach ($packages as $package): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <strong><?= html_escape($package->package_name) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= html_escape($package->slug) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar-day me-1"></i><?= $package->duration_days ?> Days
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $day_count = intval($package->day_count);
                                    $duration = intval($package->duration_days);
                                    $progress = $duration > 0 ? round(($day_count / $duration) * 100) : 0;
                                    $progress = min(100, $progress);
                                    ?>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2"><?= $day_count ?>/<?= $duration ?></span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar <?= $progress >= 100 ? 'bg-success' : 'bg-warning' ?>" 
                                                 style="width: <?= $progress ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($package->is_active): ?>
                                        <span class="status-badge active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-btns">
                                    <a href="<?= base_url('admin/itineraries/manage/' . $package->uid) ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Manage Itinerary">
                                        <i class="fas fa-tasks"></i> Manage
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p>No packages found. <a href="<?= base_url('admin/packages/create') ?>">Create a package first</a>.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#packagesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });
});
</script>
