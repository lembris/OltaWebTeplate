<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Pages</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Pages</li>
            </ol>
        </nav>
        <div class="mt-2">
            <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
            <small class="text-muted ms-2">Showing pages for this theme</small>
        </div>
    </div>
    <div>
        <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Page
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($pages);
    $published = count(array_filter($pages, function($p) { return $p->status === 'published'; }));
    $draft = $total - $published;
    $footer_pages = count(array_filter($pages, function($p) { return $p->show_in_footer; }));
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Pages</div>
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
            <div class="stat-icon"><i class="fas fa-file"></i></div>
            <div class="stat-value"><?= $draft ?></div>
            <div class="stat-label">Drafts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-columns"></i></div>
            <div class="stat-value"><?= $footer_pages ?></div>
            <div class="stat-label">Footer Links</div>
        </div>
    </div>
</div>

<!-- Pages Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Pages</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="published">Published</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="draft">Drafts</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="pagesTable">
                <thead>
                    <tr>
                        <th width="50">Order</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th width="100">Template</th>
                        <th width="80">Footer</th>
                        <th width="80">Header</th>
                        <th width="100">Status</th>
                        <th width="120">Updated</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                        <tr data-status="<?= $page->status ?>">
                            <td>
                                <span class="badge bg-secondary"><?= $page->sort_order ?></span>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($page->title) ?></strong>
                                <br>
                                <small class="text-muted">UID: <?= htmlspecialchars($page->uid) ?></small>
                            </td>
                            <td>
                                <code>/<?= htmlspecialchars($page->slug) ?></code>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars($page->template) ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($page->show_in_footer): ?>
                                    <i class="fas fa-check text-success"></i>
                                <?php else: ?>
                                    <i class="fas fa-times text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($page->show_in_header): ?>
                                    <i class="fas fa-check text-success"></i>
                                <?php else: ?>
                                    <i class="fas fa-times text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" 
                                           type="checkbox" 
                                           data-uid="<?= $page->uid ?>"
                                           <?= $page->status === 'published' ? 'checked' : '' ?>>
                                </div>
                            </td>
                            <td>
                                <?= isset($page->updated_at) ? date('M d, Y', strtotime($page->updated_at)) : 'N/A' ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/pages/edit/' . $page->uid) ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('page/' . $page->slug) ?>" 
                                       class="btn btn-sm btn-outline-info" title="View" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/pages/delete/' . $page->uid) ?>', 'page')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = $('#pagesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [4, 5, 6, 8] }
        ],
        language: {
            emptyTable: '<div class="text-center py-4"><i class="fas fa-file-alt fa-3x mb-3 text-muted"></i><p class="text-muted">No pages found for theme "<?= ucfirst($active_template) ?>". <a href="<?= base_url('admin/pages/create') ?>">Create your first page</a></p></div>'
        }
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            if (filter === 'all') {
                table.search('').columns().search('').draw();
                document.querySelectorAll('#pagesTable tbody tr').forEach(row => {
                    row.style.display = '';
                });
            } else {
                document.querySelectorAll('#pagesTable tbody tr').forEach(row => {
                    const status = row.dataset.status;
                    row.style.display = (filter === status) ? '' : 'none';
                });
            }
        });
    });

    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const uid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/pages/toggle_status/') ?>' + uid, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '<?= $csrf_name ?>=<?= $csrf_hash ?>'
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
                    checkbox.closest('tr').dataset.status = data.status;
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
