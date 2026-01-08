<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Notices</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Notices</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/notices/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Notice
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($notices);
    $published = count(array_filter($notices, function($n) { return $n->published; }));
    $pinned = count(array_filter($notices, function($n) { return $n->pinned; }));
    $urgent = count(array_filter($notices, function($n) { return $n->priority === 'urgent' || $n->priority === 'high'; }));
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Notices</div>
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
            <div class="stat-icon"><i class="fas fa-thumbtack"></i></div>
            <div class="stat-value"><?= $pinned ?></div>
            <div class="stat-label">Pinned</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="stat-value"><?= $urgent ?></div>
            <div class="stat-label">High Priority</div>
        </div>
    </div>
</div>

<!-- Notices Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Notices</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="published">Published</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="draft">Drafts</button>
            <button type="button" class="btn btn-outline-info filter-btn" data-filter="pinned">Pinned</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="noticesTable">
                <thead>
                    <tr>
                        <th width="40">Pin</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Audience</th>
                        <th width="100">Published</th>
                        <th width="80">Views</th>
                        <th width="120">Created</th>
                        <th width="130">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $notice): ?>
                            <tr data-status="<?= $notice->published ? 'published' : 'draft' ?>" data-pinned="<?= $notice->pinned ? 'pinned' : '' ?>">
                                <td>
                                    <button class="btn btn-sm btn-link p-0 pin-toggle" 
                                            data-uid="<?= $notice->uid ?>"
                                            title="<?= $notice->pinned ? 'Unpin' : 'Pin' ?>">
                                        <i class="fas fa-thumbtack <?= $notice->pinned ? 'text-warning' : 'text-muted' ?>"></i>
                                    </button>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($notice->title) ?></strong>
                                    <?php if (!empty($notice->attachment)): ?>
                                        <span class="badge bg-secondary ms-1" title="Has attachment"><i class="fas fa-paperclip"></i></span>
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($notice->slug) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($notice->category) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $priority_classes = [
                                        'low' => 'bg-secondary',
                                        'normal' => 'bg-primary',
                                        'high' => 'bg-warning text-dark',
                                        'urgent' => 'bg-danger'
                                    ];
                                    $class = $priority_classes[$notice->priority] ?? 'bg-primary';
                                    ?>
                                    <span class="badge <?= $class ?>"><?= ucfirst($notice->priority) ?></span>
                                </td>
                                <td>
                                    <small><?= ucfirst($notice->target_audience) ?></small>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input publish-toggle" 
                                               type="checkbox" 
                                               data-uid="<?= $notice->uid ?>"
                                               <?= $notice->published ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= number_format($notice->views ?? 0) ?></span>
                                </td>
                                <td>
                                    <?= isset($notice->created_at) ? date('M d, Y', strtotime($notice->created_at)) : 'N/A' ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/notices/edit/' . $notice->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('notices/' . $notice->slug) ?>" 
                                           class="btn btn-sm btn-outline-info" title="View" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/notices/delete/' . $notice->uid) ?>', 'notice')">
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
                                    <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                    <p>No notices found. <a href="<?= base_url('admin/notices/create') ?>">Create your first notice</a></p>
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
    const table = $('#noticesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[7, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 5, 8] }
        ]
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            document.querySelectorAll('#noticesTable tbody tr').forEach(row => {
                const status = row.dataset.status;
                const pinned = row.dataset.pinned;
                
                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === 'pinned') {
                    row.style.display = pinned === 'pinned' ? '' : 'none';
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
            const noticeUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/notices/toggle_publish/') ?>' + noticeUid, {
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

    // Pin toggle
    document.querySelectorAll('.pin-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const noticeUid = this.dataset.uid;
            const icon = this.querySelector('i');
            
            fetch('<?= base_url('admin/notices/toggle_pinned/') ?>' + noticeUid, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.pinned) {
                        icon.classList.remove('text-muted');
                        icon.classList.add('text-warning');
                        btn.closest('tr').dataset.pinned = 'pinned';
                    } else {
                        icon.classList.remove('text-warning');
                        icon.classList.add('text-muted');
                        btn.closest('tr').dataset.pinned = '';
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
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
