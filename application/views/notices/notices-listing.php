<!-- Notices Listing Page -->
<section class="notices-section py-6">
    <div class="container">
        <div class="row">
            <!-- Notices Column -->
            <div class="col-lg-8">
                <!-- Page Header -->
                <div class="mb-5">
                    <h1 class="page-title">Notices & Updates</h1>
                    <p class="page-subtitle">Stay informed with the latest announcements and important information</p>
                </div>

                <!-- Pinned Notices -->
                <?php if (!empty($pinned_notices)): ?>
                    <div class="pinned-notices mb-5">
                        <h5 class="text-uppercase text-muted mb-3">
                            <i class="fa fa-thumb-tack text-warning me-2"></i>Pinned Notices
                        </h5>
                        <?php foreach ($pinned_notices as $notice): ?>
                            <div class="notice-card pinned" data-aos="fade-up">
                                <div class="notice-priority priority-<?= $notice->priority ?>"></div>
                                <div class="notice-content">
                                    <div class="notice-meta">
                                        <span class="notice-category badge bg-info"><?= htmlspecialchars($notice->category) ?></span>
                                        <span class="notice-date">
                                            <i class="fa fa-calendar me-1"></i>
                                            <?= date('M d, Y', strtotime($notice->created_at)) ?>
                                        </span>
                                        <?php if ($notice->priority === 'urgent' || $notice->priority === 'high'): ?>
                                            <span class="badge bg-danger ms-2">
                                                <i class="fa fa-exclamation-circle me-1"></i><?= ucfirst($notice->priority) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="notice-title">
                                        <a href="<?= base_url('notices/' . $notice->slug) ?>">
                                            <?= htmlspecialchars($notice->title) ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($notice->excerpt): ?>
                                        <p class="notice-excerpt"><?= htmlspecialchars($notice->excerpt) ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="notice-footer">
                                        <a href="<?= base_url('notices/' . $notice->slug) ?>" class="btn btn-sm btn-outline-primary">
                                            Read More <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                        <?php if (!empty($notice->attachment)): ?>
                                            <a href="<?= base_url('notices/download/' . $notice->slug) ?>" class="btn btn-sm btn-outline-secondary ms-2">
                                                <i class="fa fa-download me-1"></i> Download
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- All Notices -->
                <?php if (!empty($notices)): ?>
                    <div class="notices-list">
                        <h5 class="text-uppercase text-muted mb-3">
                            <i class="fa fa-list me-2"></i>All Notices
                        </h5>
                        
                        <?php foreach ($notices as $notice): ?>
                            <div class="notice-card" data-aos="fade-up">
                                <div class="notice-priority priority-<?= $notice->priority ?>"></div>
                                <div class="notice-content">
                                    <div class="notice-meta">
                                        <span class="notice-category badge bg-info"><?= htmlspecialchars($notice->category) ?></span>
                                        <span class="notice-date">
                                            <i class="fa fa-calendar me-1"></i>
                                            <?= date('M d, Y', strtotime($notice->created_at)) ?>
                                        </span>
                                        <?php if ($notice->priority === 'urgent'): ?>
                                            <span class="badge bg-danger ms-2">Urgent</span>
                                        <?php elseif ($notice->priority === 'high'): ?>
                                            <span class="badge bg-warning text-dark ms-2">High Priority</span>
                                        <?php endif; ?>
                                        <?php if ($notice->pinned): ?>
                                            <span class="badge bg-warning ms-2">
                                                <i class="fa fa-thumb-tack"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="notice-title">
                                        <a href="<?= base_url('notices/' . $notice->slug) ?>">
                                            <?= htmlspecialchars($notice->title) ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($notice->excerpt): ?>
                                        <p class="notice-excerpt"><?= htmlspecialchars($notice->excerpt) ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="notice-footer">
                                        <a href="<?= base_url('notices/' . $notice->slug) ?>" class="btn btn-sm btn-outline-primary">
                                            Read More <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                        <?php if (!empty($notice->attachment)): ?>
                                            <a href="<?= base_url('notices/download/' . $notice->slug) ?>" class="btn btn-sm btn-outline-secondary ms-2">
                                                <i class="fa fa-download me-1"></i> Download
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (!empty($pagination)): ?>
                        <nav class="notices-pagination mt-5">
                            <?= $pagination ?>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        No notices available at this time. Check back soon!
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">Categories</h5>
                        <ul class="category-list">
                            <li>
                                <a href="<?= base_url('notices') ?>" class="<?= !isset($category) ? 'active' : '' ?>">
                                    <i class="fa fa-folder me-2"></i>All Notices
                                </a>
                            </li>
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?= base_url('notices/category/' . urlencode($cat->category)) ?>" 
                                       class="<?= (isset($category) && $category === $cat->category) ? 'active' : '' ?>">
                                        <i class="fa fa-folder-open me-2"></i>
                                        <?= htmlspecialchars($cat->category) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Priority Legend -->
                <div class="sidebar-widget mb-4">
                    <h5 class="widget-title">Priority Legend</h5>
                    <ul class="priority-legend">
                        <li>
                            <span class="priority-dot priority-urgent"></span>
                            Urgent - Requires immediate attention
                        </li>
                        <li>
                            <span class="priority-dot priority-high"></span>
                            High - Important notice
                        </li>
                        <li>
                            <span class="priority-dot priority-normal"></span>
                            Normal - Regular notice
                        </li>
                        <li>
                            <span class="priority-dot priority-low"></span>
                            Low - Informational
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="sidebar-widget">
                    <h5 class="widget-title">Quick Links</h5>
                    <ul class="quick-links">
                        <li><a href="<?= base_url('contact') ?>"><i class="fa fa-envelope me-2"></i>Contact Us</a></li>
                        <li><a href="<?= base_url('events') ?>"><i class="fa fa-calendar me-2"></i>Events Calendar</a></li>
                        <li><a href="<?= base_url('announcements') ?>"><i class="fa fa-bullhorn me-2"></i>Announcements</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.notices-section {
    background: #f8f9fa;
}

.notice-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    display: flex;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.notice-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

.notice-card.pinned {
    border: 2px solid #ffc107;
}

.notice-priority {
    width: 5px;
    flex-shrink: 0;
}

.priority-urgent { background: #dc3545; }
.priority-high { background: #ffc107; }
.priority-normal { background: #0d6efd; }
.priority-low { background: #6c757d; }

.notice-content {
    padding: 20px;
    flex: 1;
}

.notice-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 0.85rem;
}

.notice-date {
    color: #6c757d;
}

.notice-title {
    font-size: 1.25rem;
    margin-bottom: 10px;
}

.notice-title a {
    color: #212529;
    text-decoration: none;
}

.notice-title a:hover {
    color: var(--primary-color);
}

.notice-excerpt {
    color: #6c757d;
    margin-bottom: 15px;
    line-height: 1.6;
}

.notice-footer {
    display: flex;
    align-items: center;
}

.sidebar-widget {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.widget-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--primary-color);
}

.category-list, .priority-legend, .quick-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li, .quick-links li {
    margin-bottom: 8px;
}

.category-list a, .quick-links a {
    color: #495057;
    text-decoration: none;
    display: block;
    padding: 8px 12px;
    border-radius: 5px;
    transition: background 0.2s;
}

.category-list a:hover, .quick-links a:hover,
.category-list a.active {
    background: #e9ecef;
    color: var(--primary-color);
}

.priority-legend li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 0.875rem;
    color: #6c757d;
}

.priority-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.notices-pagination .pagination {
    justify-content: center;
}

.notices-pagination .page-link {
    color: var(--primary-color);
}

.notices-pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
