<!-- Single Announcement Page -->
<section class="announcement-single-section py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="announcement-article type-<?= $announcement->type ?>">
                    <!-- Announcement Header -->
                    <div class="announcement-header text-center mb-4">
                        <div class="announcement-icon-large mb-3">
                            <i class="fa <?= str_replace('fa-', 'fa-', $announcement->icon) ?>"></i>
                        </div>
                        
                        <span class="badge badge-<?= $announcement->type ?> mb-3">
                            <?= ucfirst($announcement->type) ?> Announcement
                        </span>
                        
                        <h1 class="announcement-title"><?= htmlspecialchars($announcement->title) ?></h1>
                        
                        <div class="announcement-info mt-3">
                            <span class="me-4">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                <?= date('F d, Y', strtotime($announcement->created_at)) ?>
                            </span>
                            <span>
                                <i class="fa fa-eye me-2 text-muted"></i>
                                <?= number_format($announcement->views) ?> views
                            </span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <?php if (!empty($announcement->image)): ?>
                        <div class="announcement-featured-image mb-4">
                            <img src="<?= base_url('assets/uploads/announcements/' . $announcement->image) ?>" 
                                 alt="<?= htmlspecialchars($announcement->title) ?>"
                                 class="img-fluid rounded">
                        </div>
                    <?php endif; ?>

                    <!-- Validity Period -->
                    <?php if ($announcement->start_date || $announcement->end_date): ?>
                        <div class="announcement-validity alert alert-info mb-4">
                            <i class="fa fa-clock-o me-2"></i>
                            <strong>Active Period:</strong>
                            <?php if ($announcement->start_date): ?>
                                From <?= date('M d, Y g:i A', strtotime($announcement->start_date)) ?>
                            <?php endif; ?>
                            <?php if ($announcement->end_date): ?>
                                until <?= date('M d, Y g:i A', strtotime($announcement->end_date)) ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Announcement Content -->
                    <div class="announcement-content">
                        <?= $announcement->content ?>
                    </div>

                    <!-- Call to Action -->
                    <?php if (!empty($announcement->link_url)): ?>
                        <div class="announcement-cta text-center my-5">
                            <a href="<?= base_url('announcements/track_click/' . $announcement->slug) ?>" 
                               class="btn btn-lg btn-primary">
                                <?= $announcement->link_text ?: 'Learn More' ?>
                                <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="announcement-share mt-4 pt-4 border-top">
                        <h5 class="mb-3 text-center">Share this announcement:</h5>
                        <div class="share-buttons text-center d-flex gap-2 justify-content-center flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                               target="_blank" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($announcement->title) ?>" 
                               target="_blank" class="btn btn-dark rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on X">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(current_url()) ?>&title=<?= urlencode($announcement->title) ?>" 
                               target="_blank" class="btn btn-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?= urlencode($announcement->title . ' - ' . current_url()) ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #25D366; color: white; border: none;" title="Share on WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="announcement-navigation mt-4 pt-4 border-top text-center">
                        <a href="<?= base_url('announcements') ?>" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Back to All Announcements
                        </a>
                    </div>
                </article>

                <!-- Other Announcements -->
                <?php if (!empty($other_announcements)): ?>
                    <div class="other-announcements mt-5">
                        <h4 class="mb-4">Other Announcements</h4>
                        <div class="row">
                            <?php foreach ($other_announcements as $item): ?>
                                <?php if ($item->id !== $announcement->id): ?>
                                    <div class="col-md-6 mb-3">
                                        <a href="<?= base_url('announcements/' . $item->slug) ?>" class="other-announcement-link">
                                            <div class="other-announcement-card type-<?= $item->type ?>">
                                                <i class="fa <?= str_replace('fa-', 'fa-', $item->icon) ?> me-3"></i>
                                                <div>
                                                    <strong><?= htmlspecialchars($item->title) ?></strong>
                                                    <small class="d-block text-muted">
                                                        <?= date('M d, Y', strtotime($item->created_at)) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.announcement-single-section {
    background: #f8f9fa;
}

.announcement-article {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 3px 20px rgba(0,0,0,0.08);
}

.announcement-icon-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.announcement-icon-large i {
    font-size: 2.5rem;
}

.type-info .announcement-icon-large { background: rgba(13, 202, 240, 0.15); }
.type-info .announcement-icon-large i { color: #0dcaf0; }
.type-success .announcement-icon-large { background: rgba(25, 135, 84, 0.15); }
.type-success .announcement-icon-large i { color: #198754; }
.type-warning .announcement-icon-large { background: rgba(255, 193, 7, 0.15); }
.type-warning .announcement-icon-large i { color: #ffc107; }
.type-danger .announcement-icon-large { background: rgba(220, 53, 69, 0.15); }
.type-danger .announcement-icon-large i { color: #dc3545; }

.badge-info { background: #0dcaf0; color: #000; }
.badge-success { background: #198754; color: #fff; }
.badge-warning { background: #ffc107; color: #000; }
.badge-danger { background: #dc3545; color: #fff; }

.announcement-title {
    font-size: 2rem;
    font-weight: 700;
    color: #212529;
    line-height: 1.3;
}

.announcement-info {
    color: #6c757d;
    font-size: 0.9rem;
}

.announcement-featured-image img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.announcement-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
}

.announcement-content h2, .announcement-content h3, .announcement-content h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #212529;
}

.announcement-content ul, .announcement-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.announcement-cta .btn {
    padding: 15px 40px;
    font-size: 1.1rem;
}

.share-buttons .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
}

.other-announcement-link {
    text-decoration: none;
}

.other-announcement-card {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    border-left: 3px solid;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.other-announcement-card:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.other-announcement-card.type-info { border-left-color: #0dcaf0; }
.other-announcement-card.type-info i { color: #0dcaf0; }
.other-announcement-card.type-success { border-left-color: #198754; }
.other-announcement-card.type-success i { color: #198754; }
.other-announcement-card.type-warning { border-left-color: #ffc107; }
.other-announcement-card.type-warning i { color: #ffc107; }
.other-announcement-card.type-danger { border-left-color: #dc3545; }
.other-announcement-card.type-danger i { color: #dc3545; }

.other-announcement-card strong {
    color: #212529;
}
</style>
