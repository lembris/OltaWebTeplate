<!-- Event Detail Page -->
<section class="event-detail-section py-6">
    <div class="container">
        <div class="row">
            <!-- Event Content -->
            <div class="col-lg-8">
                <article class="event-article">
                    <!-- Event Header -->
                    <div class="event-header mb-4">
                        <div class="event-meta mb-3">
                            <span class="badge bg-info" style="background-color: var(--primary-color, #C7805C) !important;">
                                <i class="fa fa-calendar me-1"></i>
                                <?php echo ucfirst($event->event_type); ?>
                            </span>
                            
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
                        
                        <h1 class="event-title"><?php echo htmlspecialchars($event->title); ?></h1>
                        
                        <div class="event-info mt-4 mb-4 pb-4 border-bottom">
                            <div class="row g-4">
                                <div class="col-sm-6 col-md-3">
                                    <div class="info-item">
                                        <i class="fa fa-calendar-o text-muted"></i>
                                        <div class="ms-2">
                                            <small class="text-muted d-block">Date</small>
                                            <strong><?php echo date('F d, Y', strtotime($event->start_date)); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($event->start_time)): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <i class="fa fa-clock-o text-muted"></i>
                                            <div class="ms-2">
                                                <small class="text-muted d-block">Time</small>
                                                <strong><?php echo date('g:i A', strtotime($event->start_time)); ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($event->location)): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <i class="fa fa-map-marker text-muted"></i>
                                            <div class="ms-2">
                                                <small class="text-muted d-block">Location</small>
                                                <strong><?php echo htmlspecialchars($event->location); ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($event->capacity)): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <i class="fa fa-users text-muted"></i>
                                            <div class="ms-2">
                                                <small class="text-muted d-block">Capacity</small>
                                                <strong><?php echo $event->capacity; ?> people</strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Event Banner/Image -->
                    <?php if (!empty($event->banner) || !empty($event->image)): ?>
                        <div class="event-image-wrapper mb-5 rounded overflow-hidden">
                            <?php if (!empty($event->banner)): ?>
                                <img src="<?php echo base_url($event->banner); ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($event->title); ?>">
                            <?php else: ?>
                                <img src="<?php echo base_url($event->image); ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($event->title); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Event Description -->
                    <div class="event-content mb-5">
                        <h3 class="mb-3">About This Event</h3>
                        <div class="content-text">
                            <?php echo nl2br(htmlspecialchars($event->description)); ?>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="event-details mb-5">
                        <h3 class="mb-4">Event Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h5 class="text-muted text-uppercase mb-3"><i class="fa fa-info-circle me-2"></i>When</h5>
                                <div class="bg-light p-4 rounded">
                                    <p class="mb-2"><strong>Starts:</strong> <?php echo date('F d, Y - g:i A', strtotime($event->start_date . ' ' . $event->start_time)); ?></p>
                                    <?php if (!empty($event->end_date)): ?>
                                        <p class="mb-0"><strong>Ends:</strong> <?php echo date('F d, Y - g:i A', strtotime($event->end_date . ' ' . $event->end_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h5 class="text-muted text-uppercase mb-3"><i class="fa fa-map me-2"></i>Where</h5>
                                <div class="bg-light p-4 rounded">
                                    <p class="mb-0"><strong><?php echo !empty($event->location) ? htmlspecialchars($event->location) : 'Location TBD'; ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organizer Information -->
                    <?php if (!empty($event->organizer) || !empty($event->contact_person) || !empty($event->contact_email) || !empty($event->contact_phone)): ?>
                        <div class="event-organizer mb-5 p-4 bg-light rounded">
                            <h5 class="mb-3"><i class="fa fa-user-circle me-2"></i>Organizer</h5>
                            <?php if (!empty($event->organizer)): ?>
                                <p class="mb-2"><strong class="d-block mb-1">Organization:</strong> <?php echo htmlspecialchars($event->organizer); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($event->contact_person)): ?>
                                <p class="mb-2"><strong class="d-block mb-1">Contact Person:</strong> <?php echo htmlspecialchars($event->contact_person); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($event->contact_email)): ?>
                                <p class="mb-2"><strong class="d-block mb-1">Email:</strong> <a href="mailto:<?php echo htmlspecialchars($event->contact_email); ?>"><?php echo htmlspecialchars($event->contact_email); ?></a></p>
                            <?php endif; ?>
                            <?php if (!empty($event->contact_phone)): ?>
                                <p class="mb-0"><strong class="d-block mb-1">Phone:</strong> <a href="tel:<?php echo htmlspecialchars($event->contact_phone); ?>"><?php echo htmlspecialchars($event->contact_phone); ?></a></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Registrations Count -->
                    <?php if (!empty($event->registrations_count) && $event->registration_required): ?>
                        <div class="event-registrations mb-5 p-4 bg-info bg-opacity-10 rounded">
                            <i class="fa fa-users me-2"></i>
                            <strong><?php echo $event->registrations_count; ?></strong> 
                            <span><?php echo $event->registrations_count == 1 ? 'person has' : 'people have'; ?> registered for this event.</span>
                        </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="event-share mt-5 pt-4 border-top">
                        <h5 class="mb-3"><i class="fa fa-share me-2"></i>Share This Event</h5>
                        <div class="share-buttons d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-primary btn-sm" onclick="shareEvent('<?php echo $event->slug; ?>')">
                                <i class="fa fa-share-alt me-1"></i>Copy Link
                            </button>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" 
                               target="_blank" class="btn btn-primary btn-sm">
                                <i class="fa fa-facebook me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($event->title); ?>" 
                               target="_blank" class="btn btn-dark btn-sm">
                                <i class="fa fa-twitter me-1"></i>Twitter
                            </a>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-5 pt-4 border-top">
                        <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-secondary">
                            <i class="fa fa-chevron-left me-2"></i>Back to Events
                        </a>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Registration Box -->
                <?php if ($event->registration_required || !empty($event->registration_link)): ?>
                    <div class="card mb-4 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Register for This Event</h5>
                            
                            <?php if ($event->registration_required): ?>
                                <a href="<?php echo base_url('events/register/' . $event->slug); ?>" class="btn btn-lg w-100" style="background-color: var(--primary-color, #C7805C); color: #fff; border: 1px solid var(--primary-color, #C7805C);">
                                    <i class="fa fa-clipboard-list me-2"></i> Register Now
                                </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($event->registration_link)): ?>
                                <a href="<?php echo htmlspecialchars($event->registration_link); ?>" class="btn btn-outline-secondary w-100 mt-2" target="_blank">
                                    <i class="fa fa-external-link-alt me-1"></i> External Registration
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Quick Info Box -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fa fa-info-circle me-2"></i>Quick Info</h5>
                        
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Event Type</small>
                            <strong><?php echo ucfirst($event->event_type); ?></strong>
                        </div>

                        <?php if (!empty($event->category)): ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block mb-1">Category</small>
                                <strong><?php echo htmlspecialchars($event->category); ?></strong>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Status</small>
                            <strong>
                                <span class="badge" style="background-color: var(--primary-color, #C7805C);">
                                    <?php echo ucfirst($event->status); ?>
                                </span>
                            </strong>
                        </div>

                        <?php if (!empty($event->capacity)): ?>
                            <div class="mb-0">
                                <small class="text-muted d-block mb-1">Maximum Attendees</small>
                                <strong><?php echo $event->capacity; ?> people</strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Related Events -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fa fa-calendar me-2"></i>Related Events</h5>
                        <p class="text-muted small">More events coming soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.event-detail-section {
    background: #fff;
}

.event-article {
    line-height: 1.8;
}

.event-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.event-meta .badge {
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
}

.info-item i {
    margin-top: 2px;
}

.content-text {
    color: #555;
    font-size: 1.05rem;
}

.event-details h5 {
    color: #666;
    font-weight: 600;
}

.event-organizer {
    border-left: 4px solid var(--primary-color, #C7805C);
}

.event-registrations {
    color: #0c5460;
    font-size: 1rem;
}

.sticky-top {
    position: sticky;
    top: 20px;
}

.share-buttons .btn {
    transition: all 0.3s ease;
}

.share-buttons .btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .event-title {
        font-size: 1.75rem;
    }

    .sticky-top {
        position: relative;
        top: auto;
    }

    .event-info .row {
        gap: 1.5rem;
    }
}
</style>

<script>
function shareEvent(eventSlug) {
    const eventUrl = '<?php echo base_url('events/view/'); ?>' + eventSlug;
    if (navigator.share) {
        navigator.share({
            title: '<?php echo htmlspecialchars($event->title); ?>',
            text: 'Check out this event',
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
