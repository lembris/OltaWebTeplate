<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage YouTube Videos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">YouTube Videos</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin-youtube/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Video
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($videos ?? []);
    $active = count(array_filter($videos ?? [], function($v) { return $v->is_active; }));
    $featured = count(array_filter($videos ?? [], function($v) { return $v->is_featured; }));
    $inactive = $total - $active;
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-video"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Videos</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $active ?></div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-value"><?= $featured ?></div>
            <div class="stat-label">Featured</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-eye-slash"></i></div>
            <div class="stat-value"><?= $inactive ?></div>
            <div class="stat-label">Inactive</div>
        </div>
    </div>
</div>

<!-- Videos Table -->
<div class="card">
    <div class="card-header">
        <span><i class="fas fa-video me-2"></i>YouTube Videos</span>
    </div>
    
    <div class="card-body">
        <?php if (!empty($videos)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">
                            <i class="fas fa-grip-vertical text-muted"></i>
                        </th>
                        <th>Video</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 100px;">Featured</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="videosList" class="sortable-list">
                    <?php foreach ($videos as $video): ?>
                    <tr class="video-row" data-uid="<?= $video->uid ?>">
                        <td class="drag-handle" style="cursor: move; text-align: center;">
                            <i class="fas fa-grip-vertical text-muted"></i>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="video-thumbnail" style="width: 60px; height: 45px; overflow: hidden; border-radius: 4px;">
                                    <img src="<?= $video->thumbnail_url ?>" alt="<?= htmlspecialchars($video->title) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <strong><?= htmlspecialchars(character_limiter($video->title, 50)) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($video->youtube_video_id) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($video->category)): ?>
                            <span class="badge bg-info"><?= htmlspecialchars($video->category) ?></span>
                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?= htmlspecialchars(character_limiter($video->description ?? 'No description', 40)) ?>
                            </small>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input active-toggle" 
                                       type="checkbox" 
                                       data-uid="<?= $video->uid ?>"
                                       <?= $video->is_active ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <?= $video->is_active ? 'Active' : 'Inactive' ?>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input featured-toggle" 
                                       type="checkbox" 
                                       data-uid="<?= $video->uid ?>"
                                       <?= $video->is_featured ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?= base_url('admin-youtube/edit/' . $video->uid) ?>" 
                                   class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete('<?= base_url('admin-youtube/delete/' . $video->uid) ?>', 'video')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (isset($pagination) && !empty($pagination)): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <?= $pagination ?>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-5">
            <div class="text-muted">
                <i class="fas fa-video fa-4x mb-3"></i>
                <h4>No Videos Yet</h4>
                <p>Start by adding your first YouTube video to the media library.</p>
                <a href="<?= base_url('admin-youtube/create') ?>" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i>Add First Video
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.video-thumbnail {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.drag-handle {
    cursor: move;
}

.sortable-ghost {
    opacity: 0.5;
    background-color: #f5f5f5;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable for drag-and-drop reordering
    const videosList = document.getElementById('videosList');
    if (videosList) {
        const sortable = new Sortable(videosList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                // Build the new order array
                const rows = videosList.querySelectorAll('.video-row');
                const orders = [];
                rows.forEach((row, index) => {
                    orders.push({
                        uid: row.dataset.uid,
                        position: index + 1
                    });
                });
                
                // Send AJAX request to update order
                orders.forEach(order => {
                    fetch('<?= base_url('admin-youtube/update_order') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: '<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&uid=' + order.uid + '&order=' + order.position
                    });
                });
            }
        });
    }

    // Active toggle
    document.querySelectorAll('.active-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const uid = this.dataset.uid;
            const checkbox = this;
            const label = checkbox.nextElementSibling;
            
            fetch('<?= base_url('admin-youtube/toggle_active/') ?>' + uid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    label.textContent = data.is_active ? 'Active' : 'Inactive';
                    showToast('success', 'Status updated successfully');
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                showToast('error', 'An error occurred');
            });
        });
    });

    // Featured toggle
    document.querySelectorAll('.featured-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const uid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin-youtube/toggle_featured/') ?>' + uid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Featured status updated');
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                showToast('error', 'An error occurred');
            });
        });
    });

    function showToast(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Success!' : 'Error',
                text: message,
                timer: 1500,
                showConfirmButton: false
            });
        }
    }

    // Confirm delete
    window.confirmDelete = function(url, type) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete ' + type + '?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        } else {
            if (confirm('Are you sure you want to delete this ' + type + '?')) {
                window.location.href = url;
            }
        }
    };
});
</script>
