<?php
/**
 * Tourism Template - Events Page
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Get theme colors
$primary_color = get_theme_color('primary');
$secondary_color = get_theme_color('secondary');
$accent_color = get_theme_color('accent');
$primary_dark = darken_color($primary_color, 15);
?>
<section class="events-section py-6">
    <div class="container">
        <!-- Page Header -->
        <div class="mb-5">
            <h1 class="page-title">Events</h1>
            <p class="page-subtitle">Discover upcoming events and activities</p>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Search Controls -->
                <div class="row mb-5">
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
                            <i class="fa fa-calendar me-2"></i>View Calendar
                        </a>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <?php if (!empty($events) && count($events) > 0): ?>
                    <h5 class="text-uppercase text-muted mb-4" style="border-bottom: 2px solid <?php echo $primary_color; ?>; padding-bottom: 10px;">
                        <i class="fa fa-calendar-check me-2"></i>Upcoming Events
                    </h5>
                    
                    <div class="events-list">
                        <?php foreach ($events as $event):
                            $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                            $color = get_event_color($event->event_type);
                            // Build proper image URL - use site logo as fallback
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
                            <div class="event-card mb-4">
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <div class="event-image position-relative h-100" style="min-height: 200px; background-image: url('<?php echo $event_img; ?>'); background-size: cover; background-position: center;">
                                                <div class="event-type-badge position-absolute top-0 end-0 m-3">
                                                    <span class="badge rounded-pill px-3 py-2" style="background-color: <?php echo $color; ?>;">
                                                        <?php echo ucfirst($event->event_type); ?>
                                                    </span>
                                                </div>
                                                <div class="event-date position-absolute bottom-0 start-0 p-3">
                                                    <div class="text-center text-white" style="background: linear-gradient(135deg, <?php echo $color; ?> 0%, <?php echo darken_color($color, 15); ?> 100%); padding: 0.5rem 1rem; border-radius: 0 0.5rem 0 0;">
                                                        <div class="fs-4 fw-bold"><?php echo date('d', strtotime($event->start_date)); ?></div>
                                                        <div class="small"><?php echo date('M', strtotime($event->start_date)); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body d-flex flex-column h-100 p-4">
                                                <div class="mb-3">
                                                    <h3 class="card-title h4 mb-3">
                                                        <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="text-decoration-none" style="color: <?php echo $primary_color; ?>;">
                                                            <?php echo htmlspecialchars($event->title); ?>
                                                        </a>
                                                    </h3>
                                                    <div class="event-meta text-muted mb-3">
                                                        <div class="d-flex flex-wrap gap-3">
                                                            <?php if (!empty($event->start_time)): ?>
                                                                <span class="d-flex align-items-center">
                                                                    <i class="fa fa-clock me-2" style="color: <?php echo $primary_color; ?>;"></i>
                                                                    <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if (!empty($event->location)): ?>
                                                                <span class="d-flex align-items-center">
                                                                    <i class="fa fa-map-marker me-2" style="color: <?php echo $primary_color; ?>;"></i>
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
                                                    <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn btn-primary px-4">
                                                        View Details <i class="fa fa-arrow-right ms-1"></i>
                                                    </a>
                                                    <?php if ($event->registration_required): ?>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fa fa-check-circle me-1"></i>Registration Required
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge" style="background-color: <?php echo $secondary_color; ?>;">
                                                            <i class="fa fa-unlock me-1"></i>Open
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>No upcoming events</strong> - Check back soon for new events!
                    </div>
                <?php endif; ?>

                <!-- Featured Events Section -->
                <?php if (!empty($featured) && count($featured) > 0): ?>
                    <div class="featured-events mt-6 pt-5 border-top">
                        <h5 class="text-uppercase text-muted mb-4" style="border-bottom: 2px solid <?php echo $accent_color; ?>; padding-bottom: 10px;">
                            <i class="fa fa-star me-2"></i>Featured Events
                        </h5>
                        <div class="row g-4">
                            <?php foreach ($featured as $event): 
                                $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                                $color = get_event_color($event->event_type);
                                // Build proper image URL - use site logo as fallback
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
                                <div class="col-md-6 col-lg-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                        <div class="position-relative">
                                            <div class="featured-image" style="background-image: url('<?php echo $event_img; ?>'); height: 180px; background-size: cover; background-position: center;">
                                                <div class="event-type-badge position-absolute top-0 end-0 m-3">
                                                    <span class="badge rounded-pill px-3 py-1" style="background-color: <?php echo $color; ?>;">
                                                        <?php echo ucfirst($event->event_type); ?>
                                                    </span>
                                                </div>
                                                <div class="featured-overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.8) 100%);"></div>
                                                <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                                    <div style="background: linear-gradient(135deg, <?php echo $color; ?> 0%, <?php echo darken_color($color, 15); ?> 100%); padding: 0.25rem 0.75rem; border-radius: 0.5rem 0 0 0;">
                                                        <small><?php echo date('d M', strtotime($event->start_date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="text-decoration-none text-dark">
                                                    <?php echo htmlspecialchars($event->title); ?>
                                                </a>
                                            </h5>
                                            <div class="event-meta text-muted small mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa fa-calendar me-2" style="color: <?php echo $primary_color; ?>;"></i>
                                                    <span><?php echo date('M d, Y', strtotime($event->start_date)); ?></span>
                                                </div>
                                                <?php if (!empty($event->location)): ?>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-map-marker me-2" style="color: <?php echo $primary_color; ?>;"></i>
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
                                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn btn-outline-primary btn-sm w-100">
                                                View Event <i class="fa fa-arrow-right ms-1"></i>
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
            <div class="col-lg-4">
                <!-- Quick Links Box -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h5 class="mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-link me-2"></i>Quick Links
                    </h5>
                    <ul class="categories list-unstyled">
                        <li class="mb-2">
                            <a href="<?php echo base_url('events'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-calendar me-3" style="color: <?php echo $primary_color; ?>;"></i>
                                <span>All Events</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events/calendar'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-calendar-alt me-3" style="color: <?php echo $primary_color; ?>;"></i>
                                <span>Event Calendar</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events?type=seminar'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-chalkboard-teacher me-3" style="color: <?php echo $primary_color; ?>;"></i>
                                <span>Seminars</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo base_url('events?type=workshop'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-tools me-3" style="color: <?php echo $primary_color; ?>;"></i>
                                <span>Workshops</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('events?type=conference'); ?>" class="d-flex align-items-center text-decoration-none text-dark py-2 px-3 rounded-2" style="background-color: #fff; transition: all 0.3s;">
                                <i class="fa fa-users me-3" style="color: <?php echo $primary_color; ?>;"></i>
                                <span>Conferences</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Event Categories -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h5 class="mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                        <i class="fa fa-tags me-2"></i>Event Types
                    </h5>
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
                        <h5 class="mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-star me-2"></i>Featured Events
                        </h5>
                        <?php foreach (array_slice($featured, 0, 3) as $event): 
                            // Build proper image URL - use site logo as fallback
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
            </div>
        </div>
    </div>
</section>

<style>
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

/* Featured Card Styles */
.featured-image {
    transition: transform 0.5s ease;
}

.card:hover .featured-image {
    transform: scale(1.05);
}

/* Sidebar Styles */
.categories li a:hover {
    background-color: <?php echo hex_to_rgb($primary_color); ?> !important;
    color: <?php echo $primary_color; ?> !important;
}

.featured-sidebar-item:hover h6 a {
    color: <?php echo $primary_color; ?> !important;
}

/* Button Styles */
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
}

/* Responsive Styles */
@media (max-width: 768px) {
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
</style>

<script>
function shareEvent(eventUid) {
    const eventUrl = '<?php echo base_url('events/view/'); ?>' + eventUid;
    if (navigator.share) {
        navigator.share({
            title: 'Check out this event',
            url: eventUrl
        });
    } else {
        const temp = document.createElement('input');
        temp.value = eventUrl;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        alert('Event link copied to clipboard!');
    }
}
</script>
