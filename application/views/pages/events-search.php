<div class="container py-5">
    <div class="mb-5">
        <h1 class="page-title">Search Results</h1>
        <p class="page-subtitle text-muted">Results for "<?php echo htmlspecialchars($keyword); ?>"</p>
    </div>

    <?php if (!empty($results) && count($results) > 0): ?>
        <div class="events-list">
            <?php foreach ($results as $event): ?>
                <div class="event-card-horizontal">
                    <div class="event-card-image-wrapper">
                        <?php if (!empty($event->banner)): ?>
                            <img src="<?php echo base_url($event->banner); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="event-card-image-horizontal">
                        <?php else: ?>
                            <div class="event-card-image-placeholder-horizontal bg-primary">
                                <i class="fas fa-calendar-alt text-white" style="font-size: 2rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="event-card-body-horizontal">
                        <span class="badge bg-primary mb-2"><?php echo ucfirst($event->event_type); ?></span>
                        <h4 class="event-title-horizontal"><?php echo htmlspecialchars($event->title); ?></h4>

                        <div class="event-meta-horizontal">
                            <?php if (!empty($event->start_date)): ?>
                                <div class="meta-item">
                                    <i class="fas fa-calendar me-1"></i>
                                    <span><?php echo date('M d, Y', strtotime($event->start_date)); ?></span>
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

                    <div class="event-card-actions-horizontal">
                        <a href="<?php echo base_url('events/view/' . $event->id); ?>" class="btn btn-outline-primary">
                            View Event
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>No events found matching "<?php echo htmlspecialchars($keyword); ?>".
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Events
        </a>
    </div>
</div>

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
    display: flex;
    align-items: center;
    justify-content: center;
}

.event-card-body-horizontal {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.event-title-horizontal {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
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
}

.event-description-horizontal {
    color: #777;
    font-size: 0.95rem;
    margin: 0;
}

.event-card-actions-horizontal {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

@media (max-width: 768px) {
    .event-card-horizontal {
        flex-direction: column;
    }
    
    .event-card-image-horizontal,
    .event-card-image-placeholder-horizontal {
        width: 100%;
    }
}
</style>
