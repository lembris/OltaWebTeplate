<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Announcements</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Announcements</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/announcements/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Announcement
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($announcements);
    $published = count(array_filter($announcements, function($a) { return $a->published; }));
    $total_views = array_sum(array_map(function($a) { return $a->views ?? 0; }, $announcements));
    $total_clicks = array_sum(array_map(function($a) { return $a->clicks ?? 0; }, $announcements));
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-bullhorn"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Announcements</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $published ?></div>
            <div class="stat-label">Published</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-eye"></i></div>
            <div class="stat-value"><?= number_format($total_views) ?></div>
            <div class="stat-label">Total Views</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-mouse-pointer"></i></div>
            <div class="stat-value"><?= number_format($total_clicks) ?></div>
            <div class="stat-label">Total Clicks</div>
        </div>
    </div>
</div>

<!-- Announcements Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Announcements</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="published">Published</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="draft">Drafts</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="announcementsTable">
                <thead>
                    <tr>
                        <th width="50">Order</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Display Location</th>
                        <th width="100">Published</th>
                        <th width="80">Views</th>
                        <th width="80">Clicks</th>
                        <th width="120">Created</th>
                        <th width="130">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-announcements">
                    <?php if (!empty($announcements)): ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <tr data-uid="<?= $announcement->uid ?>" data-status="<?= $announcement->published ? 'published' : 'draft' ?>">
                                <td>
                                    <span class="badge bg-secondary"><?= $announcement->sort_order ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">
                                            <?php
                                            $type_classes = [
                                                'info' => 'text-info',
                                                'success' => 'text-success',
                                                'warning' => 'text-warning',
                                                'danger' => 'text-danger'
                                            ];
                                            $icon_class = $type_classes[$announcement->type] ?? 'text-info';
                                            ?>
                                            <i class="fas <?= $announcement->icon ?> <?= $icon_class ?> fa-lg"></i>
                                        </span>
                                        <div>
                                            <strong><?= htmlspecialchars($announcement->title) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($announcement->slug) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $type_badges = [
                                        'info' => 'bg-info',
                                        'success' => 'bg-success',
                                        'warning' => 'bg-warning text-dark',
                                        'danger' => 'bg-danger'
                                    ];
                                    $badge = $type_badges[$announcement->type] ?? 'bg-info';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($announcement->type) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $locs = explode(',', $announcement->display_location);
                                    foreach ($locs as $loc):
                                        $loc = trim($loc);
                                        if (!empty($loc)):
                                    ?>
                                        <span class="badge bg-secondary me-1"><?= ucfirst($loc) ?></span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input publish-toggle" 
                                               type="checkbox" 
                                               data-uid="<?= $announcement->uid ?>"
                                               <?= $announcement->published ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= number_format($announcement->views ?? 0) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= number_format($announcement->clicks ?? 0) ?></span>
                                </td>
                                <td>
                                    <?= isset($announcement->created_at) ? date('M d, Y', strtotime($announcement->created_at)) : 'N/A' ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/announcements/edit/' . $announcement->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('announcements/' . $announcement->slug) ?>" 
                                           class="btn btn-sm btn-outline-info" title="View" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/announcements/delete/' . $announcement->uid) ?>', 'announcement')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-bullhorn fa-3x mb-3"></i>
                                    <p>No announcements found. <a href="<?= base_url('admin/announcements/create') ?>">Create your first announcement</a></p>
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
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = $('#announcementsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [4, 8] }
        ]
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            document.querySelectorAll('#announcementsTable tbody tr').forEach(row => {
                const status = row.dataset.status;
                
                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Publish toggle
    document.querySelectorAll('.publish-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const announcementUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/announcements/toggle_publish/') ?>' + announcementUid, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
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
                    });
                    checkbox.closest('tr').dataset.status = data.published ? 'published' : 'draft';
                } else {
                    checkbox.checked = !checkbox.checked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
            });
        });
    });
});
</script>
