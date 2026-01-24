<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">YouTube Videos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">YouTube Videos</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/youtube/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Video
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-palette me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing videos for "<?= ucfirst($active_template) ?>" theme and universal videos (theme = "all")</span>
    </div>
</div>

<!-- Stats Row -->
<?php
$total = count($videos);
$active = count(array_filter($videos, function($v) { return $v->is_active; }));
$featured = count(array_filter($videos, function($v) { return $v->is_featured; }));
$categories = count($categories);
?>
<div class="row mb-4">
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
            <div class="stat-icon"><i class="fas fa-folder"></i></div>
            <div class="stat-value"><?= $categories ?></div>
            <div class="stat-label">Categories</div>
        </div>
    </div>
</div>

<!-- Videos Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Videos</span>
        <span class="text-muted"><?= $total ?> videos</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($videos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-video-slash fa-3x mb-3 text-muted"></i>
                <p class="text-muted">No YouTube videos found for theme "<?= ucfirst($active_template) ?>".</p>
                <a href="<?= base_url('admin/youtube/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Video
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="videosTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Thumbnail</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th width="80">Theme</th>
                            <th width="80">Order</th>
                            <th width="80">Featured</th>
                            <th width="80">Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($videos as $video): ?>
                        <tr>
                            <td>
                                <a href="<?= $video->youtube_url ?>" target="_blank">
                                    <img src="<?= $video->thumbnail_url ?>" 
                                         alt="<?= htmlspecialchars($video->title) ?>"
                                         class="rounded"
                                         style="width: 100px; height: 56px; object-fit: cover;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= $video->youtube_url ?>" target="_blank" class="font-weight-bold text-decoration-none">
                                    <?= htmlspecialchars($video->title) ?>
                                </a>
                                <?php if (!empty($video->description)): ?>
                                <p class="small text-muted mb-0" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?= htmlspecialchars(substr(strip_tags($video->description), 0, 50)) ?><?= strlen(strip_tags($video->description)) > 50 ? '...' : '' ?>
                                </p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($video->category)): ?>
                                <span class="badge bg-info"><?= htmlspecialchars($video->category) ?></span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $theme = isset($video->theme) ? $video->theme : 'all';
                                $theme_class = ($theme === 'all') ? 'bg-secondary' : 'bg-success';
                                ?>
                                <span class="badge <?= $theme_class ?>"><?= ucfirst($theme) ?></span>
                            </td>
                            <td><?= $video->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/youtube/toggle_featured/' . $video->uid) ?>" 
                                   class="btn btn-sm <?= $video->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>" 
                                   title="Toggle Featured">
                                    <i class="fas fa-star<?= $video->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/youtube/toggle_active/' . $video->uid) ?>" 
                                   class="btn btn-sm <?= $video->is_active ? 'btn-success' : 'btn-outline-success' ?>" 
                                   title="Toggle Status">
                                    <?= $video->is_active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' ?>
                                </a>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/youtube/edit/' . $video->uid) ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('<?= base_url('admin/youtube/delete/' . $video->uid) ?>', 'video')"
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
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(url, name) {
    if (confirm('Are you sure you want to delete this ' + name + '?')) {
        window.location.href = url;
    }
}
</script>
