<section class="events-section py-6">
    <div class="container">
        <!-- Page Header -->
        <div class="mb-5">
            <h1 class="page-title">Events</h1>
            <p class="page-subtitle">Discover upcoming events and activities</p>
        </div>

        <!-- Search Controls -->
        <div class="row mb-5">
            <div class="col-md-6">
                <form method="get" action="<?php echo base_url('events/search'); ?>" class="search-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search events..." required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?php echo base_url('events/calendar'); ?>" class="btn btn-outline-primary">
                    <i class="fa fa-calendar me-2"></i>View Calendar
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        <?php if (!empty($events) && count($events) > 0): ?>
            <div class="events-list">
                <h5 class="text-uppercase text-muted mb-3">
                    <i class="fa fa-calendar-check me-2"></i>Upcoming Events
                </h5>
                
                <?php foreach ($events as $event):
                    $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                    $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                ?>
                    <div class="event-card">
                        <!-- Type Badge -->
                        <div class="event-type-badge" style="background-color: <?php echo $color; ?>;">
                            <?php echo ucfirst($event->event_type); ?>
                        </div>

                        <!-- Content -->
                        <div class="event-card-content">
                            <div class="event-meta">
                                <span class="event-date">
                                    <i class="fa fa-calendar me-1"></i>
                                    <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                </span>
                                
                                <?php if (!empty($event->start_time)): ?>
                                    <span class="event-time">
                                        <i class="fa fa-clock me-1"></i>
                                        <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($event->location)): ?>
                                    <span class="event-location">
                                        <i class="fa fa-map-marker-alt me-1"></i>
                                        <?php echo htmlspecialchars($event->location); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($event->registration_required): ?>
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="fa fa-check-circle me-1"></i>Registration Required
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success ms-2">
                                        <i class="fa fa-unlock me-1"></i>Open
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h3 class="event-title">
                                <a href="<?php echo base_url('events/view/' . $event->id); ?>">
                                    <?php echo htmlspecialchars($event->title); ?>
                                </a>
                            </h3>

                            <?php if (!empty($event->description)): ?>
                                <p class="event-excerpt">
                                    <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 150)) . '...'; ?>
                                </p>
                            <?php endif; ?>

                            <div class="event-footer">
                                <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="btn btn-sm btn-outline-primary">
                                    View Event <i class="fa fa-arrow-right ms-1"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="shareEvent('<?php echo $event->uid; ?>')" title="Share Event">
                                    <i class="fa fa-share-alt me-1"></i>Share
                                </button>
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

        <!-- Featured Events Section (if any) -->
        <?php if (!empty($featured) && count($featured) > 0): ?>
            <div class="featured-events mt-6 pt-5 border-top">
                <h5 class="text-uppercase text-muted mb-3">
                    <i class="fa fa-star me-2"></i>Featured Events
                </h5>
                <div class="row g-4">
                    <?php foreach ($featured as $event): 
                        $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                        $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="event-card-featured" style="border-left: 4px solid <?php echo $color; ?>;">
                                <div class="event-card-featured-content">
                                    <div class="event-featured-header">
                                        <span class="event-featured-badge" style="background-color: <?php echo $color; ?>;">
                                            <?php echo ucfirst($event->event_type); ?>
                                        </span>
                                        <span class="event-featured-date">
                                            <i class="fa fa-calendar me-1"></i>
                                            <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                        </span>
                                    </div>
                                    
                                    <h4 class="event-featured-title">
                                        <a href="<?php echo base_url('events/view/' . $event->uid); ?>">
                                            <?php echo htmlspecialchars($event->title); ?>
                                        </a>
                                    </h4>
                                    
                                    <p class="event-featured-description">
                                        <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 100)) . '...'; ?>
                                    </p>
                                    
                                    <div class="event-featured-actions">
                                        <button class="btn-icon-small" title="Share" onclick="shareEvent('<?php echo $event->uid; ?>')">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="btn-featured-action" style="color: <?php echo $color; ?>;">
                                            View Event
                                            <i class="fa fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function shareEvent(eventUid) {
    const eventUrl = '<?php echo base_url('events/view/'); ?>' + eventUid;
    if (navigator.share) {
        navigator.share({
            title: 'Check out this event',
            url: eventUrl
        });
    } else {
        // Fallback: Copy to clipboard
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
