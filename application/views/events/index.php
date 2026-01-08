<div class="container py-5">
    <!-- Page Header -->
    <div class="mb-5">
        <h1 class="page-title"><?php echo $page_title; ?></h1>
        <p class="page-subtitle text-muted">Upcoming events and announcements</p>
    </div>

    <!-- Featured Events Section -->
    <?php if (!empty($featured) && count($featured) > 0): ?>
        <section class="featured-events mb-6 pb-5">
            <h2 class="mb-4">Featured Events</h2>
            <div class="row g-4">
                <?php foreach ($featured as $event): 
                    $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                    $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="event-card featured" style="border-left: 4px solid <?php echo $color; ?>;">
                            <?php if (!empty($event->banner)): ?>
                                <img src="<?php echo base_url($event->banner); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="event-card-image">
                            <?php else: ?>
                                <div class="event-card-image-placeholder" style="background-color: <?php echo $color; ?>;">
                                    <i class="fas fa-calendar"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="event-card-content">
                                <div class="event-header">
                                    <span class="event-badge" style="background-color: <?php echo $color; ?>;">
                                        <?php echo ucfirst($event->event_type); ?>
                                    </span>
                                    <span class="event-date"><?php echo date('M d, Y', strtotime($event->start_date)); ?></span>
                                </div>
                                
                                <h4 class="event-title"><?php echo htmlspecialchars($event->title); ?></h4>
                                
                                <p class="event-description"><?php echo substr(htmlspecialchars($event->description), 0, 100) . '...'; ?></p>
                                
                                <div class="event-actions">
                                    <button class="btn-icon-small" title="Share" onclick="shareEvent(<?php echo $event->id; ?>)">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <a href="<?php echo base_url('events/view/' . $event->id); ?>" class="btn-action" style="color: <?php echo $color; ?>;">
                                        View Event
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Search and Calendar Controls -->
    <div class="row mb-5 pb-4 border-bottom">
        <div class="col-md-6 mb-3 mb-md-0">
            <form method="get" action="<?php echo base_url('events/search'); ?>" class="search-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search events..." required>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?php echo base_url('events/calendar'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-calendar-grid me-2"></i>View Calendar
            </a>
        </div>
    </div>

    <!-- Upcoming Events -->
    <section class="upcoming-events">
        <h2 class="mb-4">All Events</h2>
        <?php if (!empty($events) && count($events) > 0): ?>
            <div class="events-list">
                <?php foreach ($events as $event):
                    $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                    $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $event_colors['default'];
                ?>
                    <div class="event-card-horizontal" style="border-left: 5px solid <?php echo $color; ?>;">
                        <!-- Image Section -->
                        <div class="event-card-image-wrapper">
                            <?php if (!empty($event->banner)): ?>
                                <img src="<?php echo base_url($event->banner); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="event-card-image-horizontal">
                            <?php else: ?>
                                <div class="event-card-image-placeholder-horizontal" style="background-color: <?php echo $color; ?>;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content Section -->
                        <div class="event-card-body-horizontal">
                            <div class="event-badge-type" style="background-color: <?php echo $color; ?>;">
                                <?php echo ucfirst($event->event_type); ?>
                            </div>

                            <h4 class="event-title-horizontal"><?php echo htmlspecialchars($event->title); ?></h4>

                            <div class="event-meta-horizontal">
                                <?php if (!empty($event->start_date)): ?>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar me-1"></i>
                                        <span><?php echo date('M d, Y', strtotime($event->start_date)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($event->start_time)): ?>
                                    <div class="meta-item">
                                        <i class="fas fa-clock me-1"></i>
                                        <span><?php echo date('g:i A', strtotime($event->start_time)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($event->location)): ?>
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <span><?php echo htmlspecialchars($event->location); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="event-description-horizontal"><?php echo substr(htmlspecialchars($event->description), 0, 120) . '...'; ?></p>
                        </div>

                        <!-- Price/Status and Actions -->
                        <div class="event-card-actions-horizontal">
                            <div class="event-status">
                                <?php if ($event->registration_required): ?>
                                    <span class="badge bg-warning text-dark">Registration Required</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Open</span>
                                <?php endif; ?>
                            </div>

                            <div class="event-action-buttons">
                                <button class="btn-icon-action" title="Share Event" onclick="shareEvent(<?php echo $event->id; ?>)">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <a href="<?php echo base_url('events/view/' . $event->id); ?>" class="btn-action-horizontal" style="color: <?php echo $color; ?>;">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>No upcoming events at this time.
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
function shareEvent(eventId) {
    const eventUrl = '<?php echo base_url('events/view/'); ?>' + eventId;
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

function getEventColor(eventType) {
    const colors = {
        'workshop': '#3498db',
        'academic': '#e74c3c',
        'conference': '#f39c12',
        'cultural': '#9b59b6',
        'sports': '#27ae60',
        'seminar': '#2980b9',
        'default': '#34495e'
    };
    return colors[eventType.toLowerCase()] || colors['default'];
}
</script>

<style>
.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #666;
}

/* Featured Events Cards (Grid) */
.event-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.event-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transform: translateY(-4px);
}

.event-card.featured {
    border-top: 3px solid;
}

.event-card-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.event-card-image-placeholder,
.event-card-image-placeholder-horizontal {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
}

.event-card-image-placeholder {
    height: 180px;
}

.event-card-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    gap: 1rem;
}

.event-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.event-date {
    font-size: 0.85rem;
    color: #999;
    white-space: nowrap;
}

.event-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.event-description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: auto;
    line-height: 1.4;
}

.event-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.btn-icon-small {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    color: #999;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.btn-icon-small:hover {
    color: #333;
    background-color: #f5f5f5;
}

.btn-action {
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-action:hover {
    opacity: 0.8;
}

/* Horizontal Events Cards (List) */
.events-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.event-card-horizontal {
    background: #fff;
    border-radius: 8px;
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    align-items: flex-start;
}

.event-card-horizontal:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.event-card-image-wrapper {
    flex-shrink: 0;
}

.event-card-image-horizontal {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 6px;
}

.event-card-image-placeholder-horizontal {
    width: 180px;
    height: 180px;
    border-radius: 6px;
    font-size: 2rem;
}

.event-card-body-horizontal {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.event-badge-type {
    display: inline-block;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    width: fit-content;
}

.event-title-horizontal {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
}

.event-meta-horizontal {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    font-size: 0.9rem;
    color: #666;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.meta-item i {
    min-width: 14px;
}

.event-description-horizontal {
    color: #777;
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.5;
}

.event-card-actions-horizontal {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-end;
    text-align: right;
}

.event-status {
    display: flex;
    gap: 0.5rem;
}

.event-action-buttons {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.btn-icon-action {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    color: #999;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.btn-icon-action:hover {
    color: #333;
    background-color: #f5f5f5;
}

.btn-action-horizontal {
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.6rem 1.2rem;
    border: 2px solid currentColor;
    border-radius: 4px;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-action-horizontal:hover {
    background-color: currentColor;
    color: white !important;
}

/* Responsive */
@media (max-width: 768px) {
    .event-card-horizontal {
        flex-direction: column;
        gap: 1rem;
    }

    .event-card-image-wrapper {
        width: 100%;
    }

    .event-card-image-horizontal {
        width: 100%;
    }

    .event-card-image-placeholder-horizontal {
        width: 100%;
    }

    .event-card-actions-horizontal {
        width: 100%;
        align-items: stretch;
        text-align: left;
    }

    .event-action-buttons {
        justify-content: space-between;
    }

    .event-meta-horizontal {
        gap: 1rem;
    }

    .page-title {
        font-size: 1.75rem;
    }
}
</style>
