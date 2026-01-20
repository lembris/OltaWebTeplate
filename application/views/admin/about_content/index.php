<!-- About Content - <?= ucfirst($section) ?> List -->
<style>
    /* Timeline Styles */
    .timeline-container {
        position: relative;
        padding: 20px 0;
    }

    .timeline {
        position: relative;
        padding-left: 140px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 115px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #667eea, #764ba2);
        border-radius: 3px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 35px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-year-badge {
        position: absolute;
        left: -145px;
        top: 15px;
        width: 120px;
        padding: 8px 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        text-align: center;
        border-radius: 25px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .timeline-dot {
        position: absolute;
        left: -33px;
        top: 22px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #fff;
        border: 4px solid #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        z-index: 1;
    }

    .timeline-content {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .timeline-content:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transform: translateX(5px);
    }

    .timeline-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .timeline-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .timeline-desc {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: rgba(39, 174, 96, 0.15);
        color: #27ae60;
    }

    .status-badge.inactive {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= ucfirst($section) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active"><?= ucfirst($section) ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/about_content/' . $section . '/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-palette me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing <?= $section ?> for "<?= ucfirst($active_template) ?>" theme and universal items (theme = "all")</span>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Section Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?= $section === 'timeline' ? 'active' : '' ?>" href="<?= base_url('admin/about_content/timeline') ?>">
            <i class="fas fa-history me-2"></i>Timeline
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $section === 'accreditations' ? 'active' : '' ?>" href="<?= base_url('admin/about_content/accreditations') ?>">
            <i class="fas fa-certificate me-2"></i>Accreditations
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $section === 'faq' ? 'active' : '' ?>" href="<?= base_url('admin/about_content/faq') ?>">
            <i class="fas fa-question-circle me-2"></i>FAQs
        </a>
    </li>
</ul>

<!-- TIMELINE SECTION -->
<?php if ($section === 'timeline'): ?>
    <div class="timeline-container">
        <?php if (empty($items)): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-history mb-3" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mb-0">No timeline items found</p>
                </div>
            </div>
        <?php else: ?>
            <div class="timeline">
                <?php foreach ($items as $item): ?>
                <div class="timeline-item">
                    <div class="timeline-year-badge"><?= htmlspecialchars($item->year) ?></div>
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="timeline-title">
                                <div class="timeline-icon">
                                    <i class="fas <?= !empty($item->icon) ? htmlspecialchars($item->icon) : 'fa-calendar' ?>"></i>
                                </div>
                                <span><?= htmlspecialchars($item->title) ?></span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('admin/about_content/timeline/edit/' . $item->uid) ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('admin/about_content/timeline/delete/' . $item->uid) ?>');" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <p class="timeline-desc mb-3"><?= htmlspecialchars($item->description) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="status-badge <?= $item->status ?>"><?= ucfirst($item->status) ?></span>
                            <small class="text-muted"><i class="fas fa-sort me-1"></i>Order: <?= $item->display_order ?></small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<!-- FAQS SECTION - Table Style -->
<?php elseif ($section === 'faq'): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>All FAQs</span>
            <span class="text-muted">Total: <?= count($items) ?> items</span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($items)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-3x mb-3 text-muted"></i>
                    <p class="text-muted">No FAQs found</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 250px;">Question</th>
                                <th>Answer</th>
                                <th style="width: 120px;">Category</th>
                                <th style="width: 80px;">Order</th>
                                <th style="width: 80px;">Status</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($item->question) ?></strong>
                                </td>
                                <td>
                                    <div style="max-width: 350px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?= htmlspecialchars($item->answer) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($item->category)): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($item->category) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item->display_order ?></td>
                                <td>
                                    <a href="<?= base_url('admin/about_content/faq/toggle/' . $item->uid) ?>" 
                                       class="btn btn-sm <?= $item->status === 'active' ? 'btn-success' : 'btn-outline-success' ?>" 
                                       title="Toggle Status">
                                        <?= $item->status === 'active' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?= base_url('admin/about_content/faq/edit/' . $item->uid) ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('admin/about_content/faq/delete/' . $item->uid) ?>');" title="Delete">
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

<!-- ACCREDITATIONS SECTION - Cards -->
<?php else: ?>
    <div class="row">
        <?php if (empty($items)): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-certificate mb-3" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mb-0">No accreditations found</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($item->name) ?></h6>
                                <?php if (!empty($item->website_url)): ?>
                                    <small><a href="<?= $item->website_url ?>" target="_blank" style="color: rgba(255,255,255,0.8);">Visit Website</a></small>
                                <?php endif; ?>
                            </div>
                            <i class="fas fa-certificate fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted"><?= htmlspecialchars(substr($item->description, 0, 150)) ?><?= strlen($item->description) > 150 ? '...' : '' ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="status-badge <?= $item->status ?>"><?= ucfirst($item->status) ?></span>
                            <small class="text-muted">Order: <?= $item->display_order ?></small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('admin/about_content/accreditations/edit/' . $item->uid) ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('admin/about_content/accreditations/delete/' . $item->uid) ?>');" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
