<?php
/**
 * College Template - Notice Single Page
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Get theme colors dynamically
$primary_color = get_theme_color('primary');
$secondary_color = get_theme_color('secondary');
$accent_color = get_theme_color('accent');
$primary_dark = darken_color($primary_color, 15);
?>

<!-- Notice Single Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Notice Content -->
            <div class="col-lg-9 ftco-animate">
                <article class="notice-article">
                    <!-- Notice Header -->
                    <div class="notice-header mb-4 pb-4" style="border-bottom: 1px solid #eee;">
                        <div class="notice-meta mb-3">
                            <span class="badge rounded-pill px-3" style="background-color: <?php echo $primary_color; ?>;">
                                <?php echo htmlspecialchars($notice->category); ?>
                            </span>
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
                        
                        <div class="notice-info mt-3 text-muted">
                            <span class="me-4">
                                <i class="fa fa-calendar me-2"></i>
                                <?php echo date('F d, Y', strtotime($notice->created_at)); ?>
                            </span>
                            <span class="me-4">
                                <i class="fa fa-eye me-2"></i>
                                <?php echo number_format($notice->views); ?> views
                            </span>
                            <?php if ($notice->target_audience !== 'all'): ?>
                                <span>
                                    <i class="fa fa-users me-2"></i>
                                    For: <?php echo ucfirst($notice->target_audience); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($notice->start_date || $notice->end_date): ?>
                            <div class="notice-validity mt-3 p-3 rounded" style="background-color: #e3f2fd; border-left: 4px solid <?php echo $primary_color; ?>;">
                                <i class="fa fa-clock-o me-2" style="color: <?php echo $primary_color; ?>;"></i>
                                <strong>Validity:</strong>
                                <?php if ($notice->start_date): ?>
                                    From <?php echo date('M d, Y', strtotime($notice->start_date)); ?>
                                <?php endif; ?>
                                <?php if ($notice->end_date): ?>
                                    until <?php echo date('M d, Y', strtotime($notice->end_date)); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Notice Content -->
                    <div class="notice-content">
                        <?php echo $notice->content; ?>
                    </div>

                    <!-- Attachment -->
                    <?php if (!empty($notice->attachment)): ?>
                        <div class="notice-attachment mt-4 p-4 rounded" style="background-color: #f8f9fa; border-left: 4px solid <?php echo $primary_color; ?>;">
                            <h5 style="color: #333; font-weight: 600;">
                                <i class="fa fa-paperclip me-2" style="color: <?php echo $primary_color; ?>;"></i>Attachment
                            </h5>
                            <div class="d-flex align-items-center mt-3">
                                <i class="fa fa-file-pdf-o fa-2x me-3" style="color: #dc3545;"></i>
                                <div>
                                    <strong><?php echo htmlspecialchars($notice->attachment_name ?? $notice->attachment); ?></strong>
                                    <br>
                                    <a href="<?php echo base_url('notices/download/' . $notice->slug); ?>" class="btn btn-sm mt-2 me-2" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: #fff; border: none;">
                                        <i class="fa fa-download me-1"></i> Download
                                    </a>
                                    <a href="<?php echo base_url('assets/uploads/notices/' . $notice->attachment); ?>" target="_blank" class="btn btn-sm btn-outline-secondary mt-2">
                                        <i class="fa fa-external-link me-1"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="notice-share mt-4 pt-4 border-top">
                        <h5 class="mb-3" style="color: #333; font-weight: 600;">Share this notice:</h5>
                        <div class="share-buttons d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #1877f2; color: white; border: none;" title="Share on Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($notice->title); ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #1da1f2; color: white; border: none;" title="Share on X">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>&title=<?php echo urlencode($notice->title); ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #0077b5; color: white; border: none;" title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode($notice->title . ' - ' . current_url()); ?>" 
                               target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #25D366; color: white; border: none;" title="Share on WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="notice-navigation mt-4 pt-4 border-top">
                        <a href="<?php echo base_url('notices'); ?>" class="btn btn-outline-primary" style="border-color: <?php echo $primary_color; ?>; color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-arrow-left me-2"></i>Back to All Notices
                        </a>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3 sidebar ftco-animate">
                <!-- Latest Notices -->
                <?php if (!empty($latest_notices)): ?>
                    <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-clock me-2"></i>Latest Notices
                        </h3>
                        <ul class="quick-links-list">
                            <?php foreach ($latest_notices as $item): ?>
                                <?php if ($item->id !== $notice->id): ?>
                                    <li>
                                        <a href="<?php echo base_url('notices/' . $item->slug); ?>">
                                            <span class="quick-link-icon">
                                                <div class="priority-indicator priority-<?php echo $item->priority; ?>" style="width: 8px; height: 8px; border-radius: 50%; background: <?php echo $item->priority === 'urgent' ? '#dc3545' : ($item->priority === 'high' ? '#ffc107' : $primary_color); ?>;"></div>
                                            </span>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;">
                                                <?php echo htmlspecialchars($item->title); ?>
                                            </span>
                                            <small class="d-block text-muted mt-1">
                                                <?php echo date('M d, Y', strtotime($item->created_at)); ?>
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                    <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-folder me-2"></i>Categories
                        </h3>
                        <ul class="quick-links-list">
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?php echo base_url('notices/category/' . urlencode($cat->category)); ?>">
                                        <span class="quick-link-icon"><i class="fa fa-folder-open"></i></span>
                                        <span><?php echo htmlspecialchars($cat->category); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Quick Links -->
                <div class="sidebar-box p-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-link me-2"></i>Quick Links
                    </h3>
                    <ul class="quick-links-list">
                        <li>
                            <a href="<?php echo base_url('contact'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-envelope"></i></span>
                                <span>Contact Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-calendar"></i></span>
                                <span>Events Calendar</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('announcements'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-bullhorn"></i></span>
                                <span>Announcements</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners section -->
<?php include VIEWPATH . 'templates/college/sections/partners.php'; ?>

<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

<style>
.notice-article {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.notice-title {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.notice-info {
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
    color: #333;
    font-weight: 600;
}

.notice-content ul, .notice-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.notice-content li {
    margin-bottom: 0.5rem;
}

.share-buttons .btn:hover {
    transform: translateY(-2px);
    opacity: 0.85;
}

.sidebar-box {
    background: #f8f9fa;
}

.heading-sidebar {
    font-weight: 600;
    color: #333;
}

.quick-links-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.quick-links-list li {
    margin-bottom: 8px;
}

.quick-links-list li:last-child {
    margin-bottom: 0;
}

.quick-links-list a {
    display: flex;
    align-items: flex-start;
    padding: 12px 15px;
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%);
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.quick-links-list a:hover {
    background: linear-gradient(135deg, <?php echo $primary_dark; ?> 0%, <?php echo $primary_color; ?> 100%);
    transform: translateX(5px);
    color: #fff;
}

.quick-link-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-right: 12px;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.quick-links-list a span:last-child {
    flex: 1;
}

@media (max-width: 768px) {
    .notice-article {
        padding: 25px;
    }
    
    .notice-title {
        font-size: 1.5rem;
    }
    
    .notice-footer {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.notice-article, .sidebar-box');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.visibility = 'visible';
                entry.target.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.ftco-animate').forEach(el => observer.observe(el));
});
</script>
