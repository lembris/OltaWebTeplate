<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Testimonials</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Testimonials</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/testimonials/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Testimonial
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-palette me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing testimonials for "<?= ucfirst($active_template) ?>" theme and universal testimonials (theme = "all")</span>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($testimonials);
    $active = count(array_filter($testimonials, function($t) { return $t->status === 'active'; }));
    $featured = count(array_filter($testimonials, function($t) { return $t->is_featured; }));
    $avg_rating = $total > 0 ? number_format(array_sum(array_map(function($t) { return $t->rating; }, $testimonials)) / $total, 1) : 0;
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-quote-left"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Testimonials</div>
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
            <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
            <div class="stat-value"><?= $avg_rating ?>/5</div>
            <div class="stat-label">Avg Rating</div>
        </div>
    </div>
</div>

<!-- Testimonials Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Testimonials</span>
        <div class="text-muted">
            Theme: <span class="badge bg-info"><?= ucfirst($active_template) ?></span> or <span class="badge bg-secondary">all</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($testimonials)): ?>
            <div class="text-center py-5">
                <i class="fas fa-comment-slash fa-3x mb-3 text-muted"></i>
                <p class="text-muted">No testimonials found for theme "<?= ucfirst($active_template) ?>".</p>
                <a href="<?= base_url('admin/testimonials/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Testimonial
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="testimonialsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Image</th>
                            <th>Person</th>
                            <th>Content</th>
                            <th width="80">Rating</th>
                            <th width="100">Theme</th>
                            <th width="80">Order</th>
                            <th width="80">Featured</th>
                            <th width="80">Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $testimonial): ?>
                        <tr>
                            <td>
                                <?php if (!empty($testimonial->image)): ?>
                                    <img src="<?= base_url('assets/img/testimonials/' . $testimonial->image) ?>" 
                                         alt="<?= htmlspecialchars($testimonial->name) ?>" 
                                         class="rounded-circle"
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                         style="width: 45px; height: 45px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($testimonial->name) ?></strong>
                                <?php if (!empty($testimonial->role)): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($testimonial->role) ?></small>
                                <?php endif; ?>
                                <?php if (!empty($testimonial->company)): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($testimonial->company) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?= htmlspecialchars($testimonial->content) ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-warning">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i > $testimonial->rating ? '-o' : '' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="ms-1 text-muted small">(<?= $testimonial->rating ?>)</span>
                                </div>
                            </td>
                            <td>
                                <?php 
                                $theme = $testimonial->theme;
                                $theme_class = ($theme === 'all') ? 'bg-secondary' : 'bg-success';
                                ?>
                                <span class="badge <?= $theme_class ?>"><?= ucfirst($theme) ?></span>
                            </td>
                            <td><?= $testimonial->display_order ?></td>
                            <td>
                                <a href="<?= base_url('admin/testimonials/toggle_featured/' . $testimonial->uid) ?>" 
                                   class="btn btn-sm <?= $testimonial->is_featured ? 'btn-warning' : 'btn-outline-warning' ?>" 
                                   title="Toggle Featured">
                                    <i class="fas fa-star<?= $testimonial->is_featured ? '' : '-o' ?>"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/testimonials/toggle_status/' . $testimonial->uid) ?>" 
                                   class="btn btn-sm <?= $testimonial->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>" 
                                   title="Toggle Status">
                                    <?= $testimonial->status === 'active' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' ?>
                                </a>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/testimonials/edit/' . $testimonial->uid) ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('<?= base_url('admin/testimonials/delete/' . $testimonial->uid) ?>', 'testimonial')"
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
