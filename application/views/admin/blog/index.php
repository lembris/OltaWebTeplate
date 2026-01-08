<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Blog Posts</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Blog Posts</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/blog/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Post
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-palette me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing posts for "<?= ucfirst($active_template) ?>" theme and universal posts (theme = "all")</span>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($posts);
    $published = count(array_filter($posts, function($p) { return $p->published; }));
    $draft = $total - $published;
    $total_views = array_sum(array_map(function($p) { return $p->views ?? 0; }, $posts));
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Posts</div>
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
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value"><?= $draft ?></div>
            <div class="stat-label">Drafts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-eye"></i></div>
            <div class="stat-value"><?= number_format($total_views) ?></div>
            <div class="stat-label">Total Views</div>
        </div>
    </div>
</div>

<!-- Blog Posts Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Blog Posts</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="published">Published</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="draft">Drafts</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="blogTable">
                <thead>
                    <tr>
                        <th width="60">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th width="80">Theme</th>
                        <th>Author</th>
                        <th width="100">Published</th>
                        <th width="80">Views</th>
                        <th width="120">Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr data-status="<?= $post->published ? 'published' : 'draft' ?>">
                            <td>
                                <?php if (!empty($post->featured_image)): ?>
                                    <img src="<?= base_url('assets/img/blog/' . $post->featured_image) ?>" 
                                         alt="<?= htmlspecialchars($post->title) ?>" 
                                         class="img-thumbnail" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary d-flex align-items-center justify-content-center text-white" 
                                         style="width: 50px; height: 50px; border-radius: 5px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($post->title) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($post->slug) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars($post->category) ?></span>
                            </td>
                            <td>
                                <?php 
                                $theme = isset($post->theme) ? $post->theme : 'all';
                                $theme_class = ($theme === 'all') ? 'bg-secondary' : 'bg-success';
                                ?>
                                <span class="badge <?= $theme_class ?>"><?= ucfirst($theme) ?></span>
                            </td>
                            <td><?= htmlspecialchars($post->author ?? 'Unknown') ?></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input publish-toggle" 
                                           type="checkbox" 
                                           data-uid="<?= $post->uid ?>"
                                           <?= $post->published ? 'checked' : '' ?>>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= number_format($post->views ?? 0) ?></span>
                            </td>
                            <td>
                                <?= isset($post->created_at) ? date('M d, Y', strtotime($post->created_at)) : 'N/A' ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/blog/edit/' . $post->uid) ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('blog/post/' . $post->slug) ?>" 
                                       class="btn btn-sm btn-outline-info" title="View" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete('<?= base_url('admin/blog/delete/' . $post->uid) ?>', 'blog post')">
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
    let table;
    if ($.fn.DataTable.isDataTable('#blogTable')) {
        table = $('#blogTable').DataTable();
        table.destroy();
    }
    
    table = $('#blogTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[7, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 5, 8] }
        ],
        language: {
            emptyTable: '<div class="text-center py-4"><i class="fas fa-newspaper fa-3x mb-3 text-muted"></i><p class="text-muted">No blog posts found for theme "<?= ucfirst($active_template) ?>". <a href="<?= base_url('admin/blog/create') ?>">Create your first post</a></p></div>'
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
                document.querySelectorAll('#blogTable tbody tr').forEach(row => {
                    row.style.display = '';
                });
            } else {
                document.querySelectorAll('#blogTable tbody tr').forEach(row => {
                    const status = row.dataset.status;
                    
                    if (filter === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    });

    // Publish toggle
    document.querySelectorAll('.publish-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const postUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/blog/toggle_publish/') ?>' + postUid, {
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
