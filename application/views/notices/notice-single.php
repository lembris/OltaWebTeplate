<!-- Single Notice Page -->
<section class="notice-single-section py-6">
    <div class="container">
        <div class="row">
            <!-- Notice Content -->
            <div class="col-lg-8">
                <article class="notice-article">
                    <!-- Notice Header -->
                    <div class="notice-header mb-4">
                        <div class="notice-meta mb-3">
                            <span class="badge bg-info"><?= htmlspecialchars($notice->category) ?></span>
                            <?php if ($notice->priority === 'urgent'): ?>
                                <span class="badge bg-danger ms-2">
                                    <i class="fa fa-exclamation-circle me-1"></i>Urgent
                                </span>
                            <?php elseif ($notice->priority === 'high'): ?>
                                <span class="badge bg-warning text-dark ms-2">
                                    <i class="fa fa-exclamation-triangle me-1"></i>High Priority
                                </span>
                            <?php endif; ?>
                            <?php if ($notice->pinned): ?>
                                <span class="badge bg-warning ms-2">
                                    <i class="fa fa-thumb-tack me-1"></i>Pinned
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <h1 class="notice-title"><?= htmlspecialchars($notice->title) ?></h1>
                        
                        <div class="notice-info mt-3">
                            <span class="me-4">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                Published: <?= date('F d, Y', strtotime($notice->created_at)) ?>
                            </span>
                            <span class="me-4">
                                <i class="fa fa-eye me-2 text-muted"></i>
                                <?= number_format($notice->views) ?> views
                            </span>
                            <?php if ($notice->target_audience !== 'all'): ?>
                                <span>
                                    <i class="fa fa-users me-2 text-muted"></i>
                                    For: <?= ucfirst($notice->target_audience) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($notice->start_date || $notice->end_date): ?>
                            <div class="notice-validity mt-3 alert alert-info">
                                <i class="fa fa-clock-o me-2"></i>
                                <strong>Validity:</strong>
                                <?php if ($notice->start_date): ?>
                                    From <?= date('M d, Y', strtotime($notice->start_date)) ?>
                                <?php endif; ?>
                                <?php if ($notice->end_date): ?>
                                    until <?= date('M d, Y', strtotime($notice->end_date)) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Notice Content -->
                    <div class="notice-content">
                        <?= $notice->content ?>
                    </div>

                    <!-- Attachment -->
                    <?php if (!empty($notice->attachment)): ?>
                        <div class="notice-attachment mt-4 p-4 bg-light rounded">
                            <h5><i class="fa fa-paperclip me-2"></i>Attachment</h5>
                            <div class="d-flex align-items-center mt-3">
                                <i class="fa fa-file-pdf fa-2x text-danger me-3"></i>
                                <div>
                                    <strong><?= htmlspecialchars($notice->attachment_name ?? $notice->attachment) ?></strong>
                                    <br>
                                    <a href="<?= base_url('notices/download/' . $notice->slug) ?>" class="btn btn-primary btn-sm mt-2">
                                        <i class="fa fa-download me-1"></i> Download Attachment
                                    </a>
                                    <a href="<?= base_url('assets/uploads/notices/' . $notice->attachment) ?>" target="_blank" class="btn btn-outline-secondary btn-sm mt-2 ms-2">
                                        <i class="fa fa-external-link me-1"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="notice-share mt-4 pt-4 border-top">
                        <h5 class="mb-3">Share this notice:</h5>
                        <div class="share-buttons d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                               target="_blank" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($notice->title) ?>" 
                               target="_blank" class="btn btn-dark rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on X">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(current_url()) ?>&title=<?= urlencode($notice->title) ?>" 
                               target="_blank" class="btn btn-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?= urlencode($notice->title . ' - ' . current_url()) ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #25D366; color: white; border: none;" title="Share on WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="https://www.instagram.com" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background: linear-gradient(45deg, #405de6, #5b51d8, #833ab4, #c13584, #e1306c, #fd1d1d); color: white; border: none;" title="Follow on Instagram">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="notice-navigation mt-4 pt-4 border-top">
                        <a href="<?= base_url('notices') ?>" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Back to All Notices
                        </a>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Latest Notices -->
                <?php if (!empty($latest_notices)): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">Latest Notices</h5>
                        <ul class="latest-notices-list">
                            <?php foreach ($latest_notices as $item): ?>
                                <?php if ($item->id !== $notice->id): ?>
                                    <li class="latest-notice-item">
                                        <a href="<?= base_url('notices/' . $item->slug) ?>">
                                            <div class="d-flex align-items-start">
                                                <div class="priority-indicator priority-<?= $item->priority ?>"></div>
                                                <div>
                                                    <strong><?= htmlspecialchars($item->title) ?></strong>
                                                    <small class="d-block text-muted">
                                                        <?= date('M d, Y', strtotime($item->created_at)) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">Categories</h5>
                        <ul class="category-list">
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?= base_url('notices/category/' . urlencode($cat->category)) ?>">
                                        <i class="fa fa-folder-open me-2"></i>
                                        <?= htmlspecialchars($cat->category) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            </div>
                            <?php endif; ?>

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
/* Theme-aware styles for notice detail page */
.notice-single-section {
    background: #f8f9fa;
}

.notice-article {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.notice-title {
    font-size: 2rem;
    font-weight: 700;
    color: #212529;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.notice-info {
    color: #6c757d;
    font-size: 0.9rem;
}

.notice-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
    margin-top: 2rem;
}

.notice-content h2, .notice-content h3, .notice-content h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #212529;
    font-weight: 600;
}

.notice-content ul, .notice-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.notice-content li {
    margin-bottom: 0.5rem;
}

.notice-attachment {
    background: #f8f9fa;
    border-left: 4px solid var(--theme-primary, #C7805C);
}

.notice-attachment h5 {
    color: #212529;
    font-weight: 600;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-buttons .btn {
    width: 40px;
    height: 40px;
    padding: 0 !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    border-radius: 50%;
    font-size: 18px;
}

.share-buttons .btn-primary:hover {
    opacity: 0.85;
    transform: translateY(-2px);
}

.share-buttons .btn-dark:hover,
.share-buttons .btn-secondary:hover {
    opacity: 0.85;
    transform: translateY(-2px);
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
    border-bottom: 3px solid var(--primary, #5c6bc0);
    color: #212529;
}

.latest-notices-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.latest-notice-item {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.latest-notice-item:last-child {
    border-bottom: none;
}

.latest-notice-item a {
    color: #495057;
    text-decoration: none;
    transition: color 0.3s;
}

.latest-notice-item a:hover {
    color: var(--primary, #5c6bc0);
}

.latest-notice-item strong {
    display: block;
    margin-bottom: 4px;
    color: #212529;
}

.priority-indicator {
    width: 4px;
    height: 40px;
    border-radius: 2px;
    margin-right: 12px;
    flex-shrink: 0;
}

.priority-urgent { background: #dc3545; }
.priority-high { background: #ffc107; }
.priority-normal { background: #0d6efd; }
.priority-low { background: #6c757d; }

.category-list, .quick-links {
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
    transition: all 0.2s;
}

.category-list a:hover, .quick-links a:hover {
    background: var(--primary, #5c6bc0);
    color: white;
    padding-left: 15px;
}

@media (max-width: 768px) {
    .notice-article {
        padding: 25px;
    }
    
    .notice-title {
        font-size: 1.5rem;
    }
}
</style>
