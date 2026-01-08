<?php
/**
 * College Template - Events List Page
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Events Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9 ftco-animate">
                <!-- Search and Filter Controls -->
                <div class="mb-5 pb-4" style="border-bottom: 1px solid #eee;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <form method="get" action="<?php echo base_url('events/search'); ?>" class="search-form">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search events..." required>
                                    <button class="btn btn-primary" type="submit" style="background-color: #C7805C; border-color: #C7805C;">
                                        <i class="fa fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-md-4 text-md-end">
                            <a href="<php echo base_url('events/calendar'); ?>" class="btn btn-outline-primary">
                                <i class="fa fa-calendar me-2"></i>Calendar View
                            </a>
                        </div> -->
                    </div>
                </div>

              <!-- Upcoming Events -->
            <?php if (!empty($events) && count($events) > 0): ?>
                <h3 class="mb-4">Upcoming Events</h3>
                
                <div class="row">
                    <?php foreach ($events as $event):
                        $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                        $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                        $event_img = !empty($event->banner) ? base_url($event->banner) : (!empty($event->image) ? base_url($event->image) : get_template_image('image_1.jpg'));
                    ?>
                        <div class="col-lg-12 mb-4">
                            <div class="event-card card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="event-image position-relative h-100" style="background-image: url('<?php echo $event_img; ?>'); min-height: 200px; background-size: cover; background-position: center;">
                                            <div class="event-type-badge position-absolute top-0 end-0 m-3">
                                                <span class="badge rounded-pill px-3 py-2" style="background-color: <?php echo $color; ?>; color: #fff;">
                                                    <?php echo ucfirst($event->event_type); ?>
                                                </span>
                                            </div>
                                            <div class="event-date position-absolute bottom-0 start-0 p-3">
                                                <div class="text-center text-white" style="background: linear-gradient(135deg, #C7805C 0%, #A0654A 100%); padding: 0.5rem 1rem; border-radius: 0 0.5rem 0 0;">
                                                    <div class="fs-4 fw-bold"><?php echo date('d', strtotime($event->start_date)); ?></div>
                                                    <div class="small"><?php echo date('M', strtotime($event->start_date)); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex flex-column h-100 p-4">
                                            <div class="mb-3">
                                                <h3 class="card-title h4 mb-2">
                                                    <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="text-decoration-none text-dark">
                                                        <?php echo htmlspecialchars($event->title); ?>
                                                    </a>
                                                </h3>
                                                <div class="event-meta text-muted mb-3">
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <?php if (!empty($event->start_time)): ?>
                                                            <span class="d-flex align-items-center">
                                                                <i class="fa fa-clock me-2" style="color: #C7805C; width: 16px;"></i>
                                                                <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($event->location)): ?>
                                                            <span class="d-flex align-items-center">
                                                                <i class="fa fa-map-marker me-2" style="color: #C7805C; width: 16px;"></i>
                                                                <?php echo htmlspecialchars($event->location); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if (!empty($event->description)): ?>
                                                    <p class="card-text text-muted mb-4">
                                                        <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 150)); ?>...
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                                                <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="btn btn-primary px-4" style="background-color: #C7805C; border-color: #C7805C;">
                                                    View Details <i class="fa fa-arrow-right ms-1"></i>
                                                </a>
                                                <div class="social-share">
                                                    <span class="text-muted small me-2">Share:</span>
                                                    <div class="share-buttons-inline" style="display: inline-flex; gap: 0.3rem;">
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(base_url('events/view/' . $event->uid)); ?>" target="_blank" class="btn btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Share on Facebook">
                                                            <i class="fa fa-facebook"></i>
                                                        </a>
                                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(base_url('events/view/' . $event->uid)); ?>&text=<?php echo urlencode($event->title); ?>" target="_blank" class="btn btn-outline-dark rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Share on X">
                                                            <i class="fa fa-twitter"></i>
                                                        </a>
                                                        <a href="https://wa.me/?text=<?php echo urlencode($event->title . ' ' . base_url('events/view/' . $event->uid)); ?>" target="_blank" class="btn btn-outline-success rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Share on WhatsApp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa fa-calendar-times fa-4x" style="color: #ddd;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No upcoming events</h4>
                    <p class="text-muted">Check back soon for new events!</p>
                </div>
            <?php endif; ?>

                <!-- Featured Events Section -->
                <?php if (!empty($featured) && count($featured) > 0): ?>
                    <div class="featured-events mt-5 pt-5 border-top">
                        <h3 class="mb-4">Featured Events</h3>
                        <div class="row">
                            <?php foreach ($featured as $event): 
                                $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                                $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                                $event_img = !empty($event->banner) ? base_url($event->banner) : (!empty($event->image) ? base_url($event->image) : get_template_image('image_1.jpg'));
                            ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                        <div class="position-relative">
                                            <div class="featured-image" style="background-image: url('<?php echo $event_img; ?>'); height: 180px; background-size: cover; background-position: center;">
                                                <div class="event-type-badge position-absolute top-0 end-0 m-3">
                                                    <span class="badge rounded-pill px-3 py-1" style="background-color: <?php echo $color; ?>;">
                                                        <?php echo ucfirst($event->event_type); ?>
                                                    </span>
                                                </div>
                                                <div class="featured-overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.8) 100%);"></div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="text-decoration-none text-dark">
                                                    <?php echo htmlspecialchars($event->title); ?>
                                                </a>
                                            </h5>
                                            <div class="event-meta text-muted small mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa fa-calendar me-2" style="color: #C7805C;"></i>
                                                    <span><?php echo date('M d, Y', strtotime($event->start_date)); ?></span>
                                                </div>
                                                <?php if (!empty($event->location)): ?>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-map-marker me-2" style="color: #C7805C;"></i>
                                                        <span class="text-truncate"><?php echo htmlspecialchars($event->location); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($event->description)): ?>
                                                <p class="card-text text-muted small">
                                                    <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 100)); ?>...
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-transparent border-top-0 pt-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="btn btn-outline-primary btn-sm">
                                                    Read More <i class="fa fa-arrow-right ms-1"></i>
                                                </a>
                                                <div class="text-muted small">
                                                    <i class="fa fa-users me-1"></i> <?php echo $event->attendees_count ?? '0'; ?> attending
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3 sidebar ftco-animate">
                <!-- Quick Links Box -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom">
                        <i class="fa fa-link me-2" style="color: #C7805C;"></i>Quick Links
                    </h3>
                    <ul class="categories list-unstyled">
                        <li class="mb-2">
                            <a href="<?php echo base_url('events'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-calendar me-3" style="color: #C7805C;"></i>
                                <span>All Events</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events/calendar'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-calendar-alt me-3" style="color: #C7805C;"></i>
                                <span>Event Calendar</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events?type=seminar'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-chalkboard-teacher me-3" style="color: #C7805C;"></i>
                                <span>Seminars</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events?type=workshop'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-tools me-3" style="color: #C7805C;"></i>
                                <span>Workshops</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events?type=conference'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-users me-3" style="color: #C7805C;"></i>
                                <span>Conferences</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Featured Events Sidebar -->
                <?php if (!empty($featured) && count($featured) > 0): ?>
                    <div class="sidebar-box p-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom">
                            <i class="fa fa-star me-2" style="color: #C7805C;"></i>Featured Events
                        </h3>
                        <?php foreach (array_slice($featured, 0, 3) as $event): 
                            $event_img = !empty($event->banner) ? base_url($event->banner) : (!empty($event->image) ? base_url($event->image) : get_template_image('image_3.jpg'));
                        ?>
                            <div class="featured-sidebar-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-2 overflow-hidden" style="width: 70px; height: 70px; background-image: url('<?php echo $event_img; ?>'); background-size: cover; background-position: center;"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars(substr($event->title, 0, 40)); ?>...
                                        </a>
                                    </h6>
                                    <div class="text-muted small">
                                        <i class="fa fa-calendar me-1"></i> 
                                        <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                    </div>
                                    <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="small text-decoration-none mt-1 d-inline-block" style="color: #C7805C;">
                                        View Event <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Event Categories -->
                <div class="sidebar-box p-4 mt-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom">
                        <i class="fa fa-tags me-2" style="color: #C7805C;"></i>Event Types
                    </h3>
                    <div class="event-categories">
                        <?php 
                        $event_types = [
                            'seminar' => 'Seminars',
                            'workshop' => 'Workshops', 
                            'conference' => 'Conferences',
                            'webinar' => 'Webinars',
                            'social' => 'Social Events'
                        ];
                        foreach ($event_types as $key => $label): 
                            $color = isset($event_colors[$key]) ? $event_colors[$key] : '#C7805C';
                        ?>
                            <a href="<?php echo base_url('events?type=' . $key); ?>" class="d-inline-block mb-2 me-2">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: <?php echo $color; ?>; color: #fff;">
                                    <?php echo $label; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
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
.hero-wrap {
    background-size: cover;
    background-position: center;
    position: relative;
    min-height: 300px;
}

.hero-wrap .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.slider-text {
    position: relative;
    z-index: 2;
}

.breadcrumbs {
    color: #fff;
    font-size: 0.9rem;
}

.breadcrumbs a {
    color: #fff;
    text-decoration: none;
}

.breadcrumbs a:hover {
    text-decoration: underline;
}

.breadcrumbs i {
    margin: 0 0.5rem;
}

.bread {
    color: #fff;
    font-weight: 700;
    font-size: 2.5rem;
}

/* Event Card Styles */
.event-card .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.event-card .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.event-image {
    background-size: cover;
    background-position: center;
    position: relative;
}

.event-date {
    background: linear-gradient(135deg, #C7805C 0%, #A0654A 100%);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 0 0.5rem 0 0;
}

.event-date .fs-5 {
    line-height: 1.2;
}

.event-meta i {
    width: 16px;
    text-align: center;
}

/* Featured Card Styles */
.featured-image {
    transition: transform 0.5s ease;
}

.card:hover .featured-image {
    transform: scale(1.05);
}

.card-footer {
    background-color: rgba(199, 128, 92, 0.05);
}

/* Sidebar Styles */
.heading-sidebar {
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
}

.categories li a:hover {
    background-color: rgba(199, 128, 92, 0.1) !important;
    color: #C7805C !important;
}

.featured-sidebar-item:hover h6 a {
    color: #C7805C !important;
}

/* Badge Styles */
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Button Styles */
.btn-primary {
    background-color: #C7805C;
    border-color: #C7805C;
}

.btn-primary:hover {
    background-color: #A0654A;
    border-color: #A0654A;
}

.btn-outline-primary {
    color: #C7805C;
    border-color: #C7805C;
}

.btn-outline-primary:hover {
    background-color: #C7805C;
    border-color: #C7805C;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .bread {
        font-size: 1.75rem;
    }
    
    .event-card .row {
        flex-direction: column;
    }
    
    .event-card .col-md-4 {
        width: 100%;
    }
    
    .event-card .col-md-8 {
        width: 100%;
    }
    
    .event-image {
        min-height: 200px;
    }
}

@media (max-width: 576px) {
    .event-meta span {
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .event-meta span:last-child {
        margin-bottom: 0;
    }
    
    .card-footer .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .card-footer .text-muted {
        text-align: center;
    }
}

/* Animation */
.ftco-animate {
    opacity: 0;
    visibility: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });
    
    // Animate cards on scroll
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