<!-- Announcements Listing Page -->
<section class="announcements-section py-6">
    <div class="container">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="page-title">Announcements</h1>
            <p class="page-subtitle">Stay updated with the latest news and important updates</p>
        </div>

        <?php if (!empty($announcements)): ?>
            <div class="row">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="col-lg-6 mb-4" data-aos="fade-up">
                        <div class="announcement-card type-<?= $announcement->type ?>">
                            <div class="announcement-icon">
                                <i class="fa <?= str_replace('fa-', 'fa-', $announcement->icon) ?>"></i>
                            </div>
                            
                            <div class="announcement-content">
                                <div class="announcement-meta">
                                    <span class="announcement-type badge badge-<?= $announcement->type ?>">
                                        <?= ucfirst($announcement->type) ?>
                                    </span>
                                    <span class="announcement-date">
                                        <i class="fa fa-clock-o me-1"></i>
                                        <?= date('M d, Y', strtotime($announcement->created_at)) ?>
                                    </span>
                                </div>
                                
                                <h3 class="announcement-title">
                                    <a href="<?= base_url('announcements/' . $announcement->slug) ?>">
                                        <?= htmlspecialchars($announcement->title) ?>
                                    </a>
                                </h3>
                                
                                <?php if ($announcement->excerpt): ?>
                                    <p class="announcement-excerpt"><?= htmlspecialchars($announcement->excerpt) ?></p>
                                <?php else: ?>
                                    <p class="announcement-excerpt"><?= htmlspecialchars(substr(strip_tags($announcement->content), 0, 150)) ?>...</p>
                                <?php endif; ?>
                                
                                <div class="announcement-footer">
                                    <a href="<?= base_url('announcements/' . $announcement->slug) ?>" class="btn btn-sm btn-outline-primary">
                                        Read More <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                    <?php if (!empty($announcement->link_url)): ?>
                                        <a href="<?= base_url('announcements/track_click/' . $announcement->slug) ?>" class="btn btn-sm btn-primary ms-2">
                                            <?= $announcement->link_text ?: 'Learn More' ?> <i class="fa fa-external-link ms-1"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($announcement->image)): ?>
                                <div class="announcement-image">
                                    <img src="<?= base_url('assets/uploads/announcements/' . $announcement->image) ?>" 
                                         alt="<?= htmlspecialchars($announcement->title) ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fa fa-bullhorn fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">No Announcements</h3>
                <p class="text-muted">There are no active announcements at this time. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.announcements-section {
    background: #f8f9fa;
}

.announcement-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.3s, box-shadow 0.3s;
    border-left: 4px solid;
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.announcement-card.type-info { border-left-color: #0dcaf0; }
.announcement-card.type-success { border-left-color: #198754; }
.announcement-card.type-warning { border-left-color: #ffc107; }
.announcement-card.type-danger { border-left-color: #dc3545; }

.announcement-icon {
    padding: 20px 25px 0;
}

.announcement-icon i {
    font-size: 2rem;
    opacity: 0.8;
}

.type-info .announcement-icon i { color: #0dcaf0; }
.type-success .announcement-icon i { color: #198754; }
.type-warning .announcement-icon i { color: #ffc107; }
.type-danger .announcement-icon i { color: #dc3545; }

.announcement-content {
    padding: 15px 25px 25px;
    flex: 1;
}

.announcement-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 12px;
    font-size: 0.85rem;
}

.badge-info { background: #0dcaf0; color: #000; }
.badge-success { background: #198754; color: #fff; }
.badge-warning { background: #ffc107; color: #000; }
.badge-danger { background: #dc3545; color: #fff; }

.announcement-date {
    color: #6c757d;
}

.announcement-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 12px;
    line-height: 1.4;
}

.announcement-title a {
    color: #212529;
    text-decoration: none;
}

.announcement-title a:hover {
    color: var(--primary-color);
}

.announcement-excerpt {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 15px;
}

.announcement-image {
    width: 100%;
    height: 180px;
    overflow: hidden;
}

.announcement-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.announcement-footer {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

@media (max-width: 768px) {
    .announcement-card {
        flex-direction: column;
    }
    
    .announcement-image {
        order: -1;
    }
}
</style>
