<?php
/**
 * College Template - Events List Page
 * Fixed: Dynamic theme colors and image visibility
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Get theme colors dynamically
$primary_color = get_theme_color('primary');
$secondary_color = get_theme_color('secondary');
$accent_color = get_theme_color('accent');
$primary_dark = darken_color($primary_color, 15);
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
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="<?php echo base_url('events/calendar'); ?>" class="btn btn-outline-primary">
                                <i class="fa fa-calendar me-2"></i>Calendar View
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <?php if (!empty($events) && count($events) > 0): ?>
                    <h3 class="mb-4" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-calendar-check me-2"></i>Upcoming Events
                    </h3>
                    
                    <div class="events-container">
                        <?php foreach ($events as $event):
                            $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                            $color = get_event_color($event->event_type);
                            $event_img = '';
                            if (!empty($event->banner)) {
                                $event_img = base_url($event->banner);
                            } elseif (!empty($event->image)) {
                                $event_img = base_url($event->image);
                            } elseif (!empty($site_logo)) {
                                $event_img = base_url($site_logo);
                            } elseif (!empty($settings['site_logo'])) {
                                $event_img = base_url('assets/images/' . $settings['site_logo']);
                            } else {
                                $event_img = base_url('assets/images/logo.png');
                            }
                        ?>
                            <div class="event-modern-card">
                                <div class="event-modern-image">
                                    <img src="<?php echo $event_img; ?>" alt="<?php echo htmlspecialchars($event->title); ?>">
                                    <div class="event-type-pill" style="background-color: <?php echo $color; ?>;">
                                        <?php echo ucfirst($event->event_type); ?>
                                    </div>
                                    <div class="event-date-overlay">
                                        <span class="day"><?php echo date('d', strtotime($event->start_date)); ?></span>
                                        <span class="month"><?php echo date('M', strtotime($event->start_date)); ?></span>
                                    </div>
                                </div>
                                <div class="event-modern-content">
                                    <h4 class="event-title">
                                        <a href="<?php echo base_url('events/view/' . $event->slug); ?>">
                                            <?php echo htmlspecialchars($event->title); ?>
                                        </a>
                                    </h4>
                                    <div class="event-info-list">
                                        <?php if (!empty($event->start_time)): ?>
                                            <div class="event-info-item">
                                                <i class="fa fa-clock" style="color: <?php echo $primary_color; ?>;"></i>
                                                <span><?php echo date('g:i A', strtotime($event->start_time)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($event->location)): ?>
                                            <div class="event-info-item">
                                                <i class="fa fa-map-marker" style="color: <?php echo $primary_color; ?>;"></i>
                                                <span><?php echo htmlspecialchars($event->location); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($event->description)): ?>
                                        <p class="event-excerpt">
                                            <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 120)); ?>...
                                        </p>
                                    <?php endif; ?>
                                    <div class="event-footer-modern">
                                        <?php if ($event->registration_required): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa fa-check-circle me-1"></i>Registration Required
                                            </span>
                                        <?php else: ?>
                                            <span class="badge" style="background-color: <?php echo $secondary_color; ?>;">
                                                <i class="fa fa-unlock me-1"></i>Open
                                            </span>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn-event-view">
                                            View Details <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Featured Events Section -->
                <?php if (!empty($featured) && count($featured) > 0): ?>
                    <div class="featured-events-section mt-5 pt-5 border-top">
                        <h3 class="mb-4" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-star me-2"></i>Featured Events
                        </h3>
                        <div class="row">
                            <?php foreach ($featured as $event): 
                                $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                                $color = get_event_color($event->event_type);
                                $event_img = '';
                                if (!empty($event->banner)) {
                                    $event_img = base_url($event->banner);
                                } elseif (!empty($event->image)) {
                                    $event_img = base_url($event->image);
                                } elseif (!empty($site_logo)) {
                                    $event_img = base_url($site_logo);
                                } else {
                                    $fallback_logo = !empty($settings['site_logo']) ? 'assets/images/' . $settings['site_logo'] : 'assets/images/logo.png';
                                    $event_img = base_url($fallback_logo);
                                }
                            ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="featured-event-card">
                                        <div class="featured-card-image">
                                            <img src="<?php echo $event_img; ?>" alt="<?php echo htmlspecialchars($event->title); ?>">
                                            <div class="featured-card-overlay">
                                                <span class="featured-badge" style="background-color: <?php echo $color; ?>;">
                                                    <i class="fa fa-star me-1"></i><?php echo ucfirst($event->event_type); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="featured-card-body">
                                            <div class="featured-card-date">
                                                <i class="fa fa-calendar me-2" style="color: <?php echo $primary_color; ?>;"></i>
                                                <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                            </div>
                                            <h5 class="featured-card-title">
                                                <a href="<?php echo base_url('events/view/' . $event->slug); ?>">
                                                    <?php echo htmlspecialchars($event->title); ?>
                                                </a>
                                            </h5>
                                            <?php if (!empty($event->location)): ?>
                                                <div class="featured-card-location">
                                                    <i class="fa fa-map-marker me-2" style="color: <?php echo $primary_color; ?>;"></i>
                                                    <?php echo htmlspecialchars(substr($event->location, 0, 30)); ?>
                                                </div>
                                            <?php endif; ?>
                                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn-featured-view">
                                                View Event <i class="fa fa-arrow-right ms-2"></i>
                                            </a>
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
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-link me-2"></i>Quick Links
                    </h3>
                    <ul class="quick-links-list">
                        <li>
                            <a href="<?php echo base_url('events'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-calendar"></i></span>
                                <span>All Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events/calendar'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-calendar-alt"></i></span>
                                <span>Event Calendar</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events?type=seminar'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-chalkboard-teacher"></i></span>
                                <span>Seminars</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events?type=workshop'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-tools"></i></span>
                                <span>Workshops</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events?type=conference'); ?>">
                                <span class="quick-link-icon"><i class="fa fa-users"></i></span>
                                <span>Conferences</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Event Categories -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-tags me-2"></i>Event Types
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
                            $color = get_event_color($key);
                        ?>
                            <a href="<?php echo base_url('events?type=' . $key); ?>" class="d-inline-block mb-2 me-2">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: <?php echo $color; ?>; color: #fff;">
                                    <?php echo $label; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Featured Events Sidebar -->
                <?php if (!empty($featured) && count($featured) > 0): ?>
                    <div class="sidebar-box p-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-star me-2"></i>Featured Events
                        </h3>
                        <?php foreach (array_slice($featured, 0, 3) as $event): 
                            $event_img = '';
                            if (!empty($event->banner)) {
                                $event_img = base_url($event->banner);
                            } elseif (!empty($event->image)) {
                                $event_img = base_url($event->image);
                            } elseif (!empty($site_logo)) {
                                $event_img = base_url($site_logo);
                            } else {
                                $fallback_logo = !empty($settings['site_logo']) ? 'assets/images/' . $settings['site_logo'] : 'assets/images/logo.png';
                                $event_img = base_url($fallback_logo);
                            }
                        ?>
                            <div class="featured-sidebar-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-2 overflow-hidden" style="width: 70px; height: 70px; background-image: url('<?php echo $event_img; ?>'); background-size: cover; background-position: center;"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars(substr($event->title, 0, 40)); ?>
                                        </a>
                                    </h6>
                                    <div class="text-muted small">
                                        <i class="fa fa-calendar me-1"></i> 
                                        <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                    </div>
                                    <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="small text-decoration-none mt-1 d-inline-block" style="color: <?php echo $primary_color; ?>;">
                                        View Event <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Recent Events -->
                <?php if (!empty($recent_events) && count($recent_events) > 0): ?>
                    <div class="sidebar-box p-4 mt-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h3 class="heading-sidebar mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-history me-2"></i>Recent Events
                        </h3>
                        <?php foreach (array_slice($recent_events, 0, 3) as $recent): 
                            $recent_img = '';
                            if (!empty($recent->banner)) {
                                $recent_img = base_url($recent->banner);
                            } elseif (!empty($recent->image)) {
                                $recent_img = base_url($recent->image);
                            } elseif (!empty($site_logo)) {
                                $recent_img = base_url($site_logo);
                            } else {
                                $fallback_logo = !empty($settings['site_logo']) ? 'assets/images/' . $settings['site_logo'] : 'assets/images/logo.png';
                                $recent_img = base_url($fallback_logo);
                            }
                        ?>
                            <div class="featured-sidebar-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-2 overflow-hidden" style="width: 70px; height: 70px; background-image: url('<?php echo $recent_img; ?>'); background-size: cover; background-position: center;"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?php echo base_url('events/view/' . $recent->slug); ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars(substr($recent->title, 0, 40)); ?>
                                        </a>
                                    </h6>
                                    <div class="text-muted small">
                                        <i class="fa fa-calendar me-1"></i> 
                                        <?php echo date('M d, Y', strtotime($recent->start_date)); ?>
                                    </div>
                                    <a href="<?php echo base_url('events/view/' . $recent->slug); ?>" class="small text-decoration-none mt-1 d-inline-block" style="color: <?php echo $primary_color; ?>;">
                                        View <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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

/* ================================
   MODERN EVENT CARD STYLES
   ================================ */
.events-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.event-modern-card {
    display: flex;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.event-modern-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.event-modern-image {
    position: relative;
    width: 280px;
    min-height: 200px;
    flex-shrink: 0;
}

.event-modern-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
}

.event-type-pill {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 6px 14px;
    border-radius: 20px;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.event-date-overlay {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.event-date-overlay .day {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: <?php echo $primary_color; ?>;
    line-height: 1;
}

.event-date-overlay .month {
    display: block;
    font-size: 0.75rem;
    color: #666;
    text-transform: uppercase;
    margin-top: 3px;
}

.event-modern-content {
    flex: 1;
    padding: 25px;
    display: flex;
    flex-direction: column;
}

.event-title {
    margin: 0 0 15px 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.event-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.event-title a:hover {
    color: <?php echo $primary_color; ?>;
}

.event-info-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 15px;
}

.event-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #666;
}

.event-info-item i {
    width: 18px;
    text-align: center;
}

.event-excerpt {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 20px 0;
    flex: 1;
}

.event-footer-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.btn-event-view {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-event-view:hover {
    background: linear-gradient(135deg, <?php echo $primary_dark; ?> 0%, <?php echo $primary_color; ?> 100%);
    color: #fff;
    transform: translateX(5px);
}

/* ================================
   FEATURED CARD STYLES
   ================================ */
.featured-events-section h3 {
    font-weight: 600;
}

.featured-event-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.featured-event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.featured-card-image {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.featured-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.featured-event-card:hover .featured-card-image img {
    transform: scale(1.1);
}

.featured-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    padding: 15px;
}

.featured-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
}

.featured-card-body {
    padding: 20px;
}

.featured-card-date {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 10px;
}

.featured-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 10px 0;
    line-height: 1.4;
}

.featured-card-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.featured-card-title a:hover {
    color: <?php echo $primary_color; ?>;
}

.featured-card-location {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-featured-view {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    background: transparent;
    color: <?php echo $primary_color; ?>;
    border: 2px solid <?php echo $primary_color; ?>;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-featured-view:hover {
    background: <?php echo $primary_color; ?>;
    color: #fff;
}

/* Sidebar Styles */
.heading-sidebar {
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
}

.categories li a:hover {
    background-color: <?php echo hex_to_rgb($primary_color); ?> !important;
    color: <?php echo $primary_color; ?> !important;
}

.featured-sidebar-item:hover h6 a {
    color: <?php echo $primary_color; ?> !important;
}

/* Quick Links Styles */
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
}

.quick-links-list a span:last-child {
    flex: 1;
}

/* Badge Styles */
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Button Styles - Dynamic Theme Colors */
.btn-primary {
    background-color: <?php echo $primary_color; ?> !important;
    border-color: <?php echo $primary_color; ?> !important;
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%) !important;
}

.btn-primary:hover {
    background-color: <?php echo $primary_dark; ?> !important;
    border-color: <?php echo $primary_dark; ?> !important;
}

.btn-outline-primary {
    color: <?php echo $primary_color; ?>;
    border-color: <?php echo $primary_color; ?>;
}

.btn-outline-primary:hover {
    background-color: <?php echo $primary_color; ?>;
    border-color: <?php echo $primary_color; ?>;
    color: #fff;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .event-modern-card {
        flex-direction: column;
    }
    
    .event-modern-image {
        width: 100%;
        height: 200px;
        min-height: auto;
    }
}

@media (max-width: 768px) {
    .bread {
        font-size: 1.75rem;
    }
    
    .event-footer-modern {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .btn-event-view {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .event-info-list {
        flex-direction: column;
        gap: 10px;
    }
    
    .event-modern-content {
        padding: 20px;
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
    const cards = document.querySelectorAll('.card, .event-modern-card, .featured-event-card');
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
