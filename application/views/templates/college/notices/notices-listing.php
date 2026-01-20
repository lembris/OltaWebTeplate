<?php
/**
 * College Template - Notices Listing Page
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Get theme colors dynamically
$primary_color = get_theme_color('primary');
$secondary_color = get_theme_color('secondary');
$accent_color = get_theme_color('accent');
$primary_dark = darken_color($primary_color, 15);
?>

<!-- Notices Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9 ftco-animate">
                <!-- Pinned Notices -->
                <?php if (!empty($pinned_notices)): ?>
                    <div class="pinned-notices mb-5">
                        <h5 class="text-uppercase text-muted mb-4">
                            <i class="fa fa-thumb-tack text-warning me-2"></i>Pinned Notices
                        </h5>
                        <?php foreach ($pinned_notices as $notice): ?>
                            <?php
                            $priority_class = '';
                            $priority_color = $primary_color;
                            if ($notice->priority === 'urgent') {
                                $priority_class = 'priority-urgent';
                                $priority_color = '#dc3545';
                            } elseif ($notice->priority === 'high') {
                                $priority_class = 'priority-high';
                                $priority_color = '#ffc107';
                            }
                            ?>
                            <div class="notice-card pinned mb-4">
                                <div class="notice-priority <?php echo $priority_class; ?>"></div>
                                <div class="notice-content">
                                    <div class="notice-meta mb-3">
                                        <span class="notice-category badge rounded-pill px-3" style="background-color: <?php echo $primary_color; ?>;">
                                            <?php echo htmlspecialchars($notice->category); ?>
                                        </span>
                                        <span class="notice-date text-muted ms-2">
                                            <i class="fa fa-calendar me-1"></i>
                                            <?php echo date('M d, Y', strtotime($notice->created_at)); ?>
                                        </span>
                                        <?php if ($notice->priority === 'urgent' || $notice->priority === 'high'): ?>
                                            <span class="badge bg-danger ms-2">
                                                <i class="fa fa-exclamation-circle me-1"></i><?php echo ucfirst($notice->priority); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="notice-title mb-3">
                                        <a href="<?php echo base_url('notices/' . $notice->slug); ?>" style="color: #333; text-decoration: none;">
                                            <?php echo htmlspecialchars($notice->title); ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($notice->excerpt): ?>
                                        <p class="notice-excerpt text-muted mb-3">
                                            <?php echo htmlspecialchars($notice->excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="notice-footer">
                                        <a href="<?php echo base_url('notices/' . $notice->slug); ?>" class="btn btn-sm me-2" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: #fff; border: none;">
                                            Read More <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                        <?php if (!empty($notice->attachment)): ?>
                                            <a href="<?php echo base_url('notices/download/' . $notice->slug); ?>" class="btn btn-sm btn-outline-secondary">
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
                        <h5 class="text-uppercase text-muted mb-4" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-list me-2"></i>All Notices
                        </h5>
                        
                        <?php foreach ($notices as $notice): 
                            $priority_class = '';
                            $priority_color = $primary_color;
                            if ($notice->priority === 'urgent') {
                                $priority_class = 'priority-urgent';
                                $priority_color = '#dc3545';
                            } elseif ($notice->priority === 'high') {
                                $priority_class = 'priority-high';
                                $priority_color = '#ffc107';
                            }
                        ?>
                            <div class="notice-card mb-4">
                                <div class="notice-priority <?php echo $priority_class; ?>"></div>
                                <div class="notice-content">
                                    <div class="notice-meta mb-3">
                                        <span class="notice-category badge rounded-pill px-3" style="background-color: <?php echo $primary_color; ?>;">
                                            <?php echo htmlspecialchars($notice->category); ?>
                                        </span>
                                        <span class="notice-date text-muted ms-2">
                                            <i class="fa fa-calendar me-1"></i>
                                            <?php echo date('M d, Y', strtotime($notice->created_at)); ?>
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
                                    
                                    <h3 class="notice-title mb-3">
                                        <a href="<?php echo base_url('notices/' . $notice->slug); ?>" style="color: #333; text-decoration: none;">
                                            <?php echo htmlspecialchars($notice->title); ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ($notice->excerpt): ?>
                                        <p class="notice-excerpt text-muted mb-3">
                                            <?php echo htmlspecialchars($notice->excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="notice-footer">
                                        <a href="<?php echo base_url('notices/' . $notice->slug); ?>" class="btn btn-sm me-2" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: #fff; border: none;">
                                            Read More <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                        <?php if (!empty($notice->attachment)): ?>
                                            <a href="<?php echo base_url('notices/download/' . $notice->slug); ?>" class="btn btn-sm btn-outline-secondary">
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
                            <?php echo $pagination; ?>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info py-5 text-center">
                        <div class="mb-3">
                            <i class="fa fa-bell-slash fa-4x" style="color: #ddd;"></i>
                        </div>
                        <h5 class="text-muted mb-2">No notices available</h5>
                        <p class="text-muted">Check back soon for new announcements!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3 sidebar ftco-animate">
                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                    <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-folder me-2"></i>Categories
                        </h3>
                        <ul class="quick-links-list">
                            <li>
                                <a href="<?php echo base_url('notices'); ?>" class="<?php echo !isset($category) ? 'active' : ''; ?>">
                                    <span class="quick-link-icon"><i class="fa fa-folder"></i></span>
                                    <span>All Notices</span>
                                </a>
                            </li>
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?php echo base_url('notices/category/' . urlencode($cat->category)); ?>" 
                                       class="<?php echo (isset($category) && $category === $cat->category) ? 'active' : ''; ?>">
                                        <span class="quick-link-icon"><i class="fa fa-folder-open"></i></span>
                                        <span><?php echo htmlspecialchars($cat->category); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Priority Legend -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-info-circle me-2"></i>Priority Legend
                    </h3>
                    <ul class="priority-legend">
                        <li>
                            <span class="priority-dot priority-urgent"></span>
                            <span>Urgent - Immediate attention</span>
                        </li>
                        <li>
                            <span class="priority-dot priority-high"></span>
                            <span>High - Important notice</span>
                        </li>
                        <li>
                            <span class="priority-dot priority-normal"></span>
                            <span>Normal - Regular notice</span>
                        </li>
                        <li>
                            <span class="priority-dot priority-low"></span>
                            <span>Low - Informational</span>
                        </li>
                    </ul>
                </div>

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
.notice-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    display: flex;
    overflow: hidden;
    transition: all 0.3s ease;
}

.notice-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
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
.priority-normal { background: <?php echo $primary_color; ?>; }
.priority-low { background: #6c757d; }

.notice-content {
    padding: 25px;
    flex: 1;
}

.notice-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 0.85rem;
}

.notice-date {
    color: #6c757d;
    font-size: 0.85rem;
}

.notice-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.notice-title a:hover {
    color: <?php echo $primary_color; ?> !important;
}

.notice-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
}

.notice-footer {
    display: flex;
    align-items: center;
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
    align-items: center;
    padding: 12px 15px;
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%);
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.quick-links-list a:hover,
.quick-links-list a.active {
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
}

.quick-links-list a span:last-child {
    flex: 1;
}

.priority-legend {
    list-style: none;
    padding: 0;
    margin: 0;
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
    color: <?php echo $primary_color; ?>;
}

.notices-pagination .page-item.active .page-link {
    background-color: <?php echo $primary_color; ?>;
    border-color: <?php echo $primary_color; ?>;
}

.alert-info {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #495057;
}

@media (max-width: 768px) {
    .notice-card {
        flex-direction: column;
    }
    
    .notice-priority {
        width: 100%;
        height: 5px;
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
    const cards = document.querySelectorAll('.notice-card');
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
