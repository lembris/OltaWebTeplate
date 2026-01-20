<?php
/**
 * College Template - Event Detail Page
 * Fixed: Dynamic theme colors
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

<!-- Event Content Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Success Message -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 ftco-animate">
                <div class="event-detail">
                    <!-- Event Meta Information -->
                    <div class="post-meta mb-4">
                        <span class="mr-3">
                            <i class="fa fa-calendar"></i> 
                            <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                        </span>
                        <?php if (!empty($event->start_time)): ?>
                            <span class="mr-3">
                                <i class="fa fa-clock"></i> 
                                <?php echo date('g:i A', strtotime($event->start_time)); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($event->location)): ?>
                            <span class="mr-3">
                                <i class="fa fa-map-marker"></i> 
                                <?php echo htmlspecialchars($event->location); ?>
                            </span>
                        <?php endif; ?>
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

                    <!-- Event Banner/Image -->
                    <?php 
                    // Build proper image URL - use site logo as fallback
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
                    <?php if (!empty($event_img)): ?>
                        <div class="mb-4">
                            <img src="<?php echo $event_img; ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="img-fluid mb-4" style="width: 100%; border-radius: 12px;">
                        </div>
                    <?php endif; ?>

                    <!-- Event Title -->
                    <h1 class="event-title mb-4" style="color: <?php echo $primary_color; ?>;">
                        <?php echo htmlspecialchars($event->title); ?>
                    </h1>

                    <!-- Event Description -->
                    <div class="post-content">
                        <?php echo $event->description; ?>
                    </div>

                    <!-- Event Details -->
                    <?php if (!empty($event->organizer) || !empty($event->contact_person) || !empty($event->contact_email) || !empty($event->contact_phone)): ?>
                        <div class="about-author d-flex p-4 mb-5 mt-5" style="background-color: #f8f9fa; border-left: 4px solid <?php echo $primary_color; ?>;">
                            <div class="desc align-self-md-center">
                                <h4 style="color: <?php echo $primary_color; ?>;">
                                    <i class="fa fa-user-circle me-2"></i>Event Organizer
                                </h4>
                                <?php if (!empty($event->organizer)): ?>
                                    <p class="mb-2"><strong>Organization:</strong> <?php echo htmlspecialchars($event->organizer); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($event->contact_person)): ?>
                                    <p class="mb-2"><strong>Contact Person:</strong> <?php echo htmlspecialchars($event->contact_person); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($event->contact_email)): ?>
                                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($event->contact_email); ?>" style="color: <?php echo $primary_color; ?>;"><?php echo htmlspecialchars($event->contact_email); ?></a></p>
                                <?php endif; ?>
                                <?php if (!empty($event->contact_phone)): ?>
                                    <p class="mb-0"><strong>Phone:</strong> <a href="tel:<?php echo htmlspecialchars($event->contact_phone); ?>" style="color: <?php echo $primary_color; ?>;"><?php echo htmlspecialchars($event->contact_phone); ?></a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Registrations Count -->
                    <?php if (!empty($registrations_count) && $event->registration_required): ?>
                        <div class="mb-5 p-4" style="background-color: #f8f9fa; border-left: 4px solid <?php echo $primary_color; ?>;">
                            <i class="fa fa-users me-2" style="color: <?php echo $primary_color; ?>;"></i>
                            <strong><?php echo $registrations_count; ?></strong> 
                            <span><?php echo $registrations_count == 1 ? 'person has' : 'people have'; ?> registered for this event.</span>
                        </div>
                    <?php endif; ?>

                    <!-- Share Buttons -->
                    <div class="share-buttons mb-5 mt-5 pt-5" style="border-top: 1px solid #ddd;">
                        <h5>Share this event:</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" target="_blank" class="share-btn-circle share-btn-facebook" title="Share on Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($event->title); ?>" target="_blank" class="share-btn-circle share-btn-twitter" title="Share on X">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>&title=<?php echo urlencode($event->title); ?>" target="_blank" class="share-btn-circle share-btn-linkedin" title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode($event->title . ' ' . current_url()); ?>" target="_blank" class="share-btn-circle share-btn-whatsapp" title="Share on WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4">
                        <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-primary">
                            <i class="fa fa-chevron-left me-2"></i>Back to Events
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Registration Box -->
                <?php if ($event->registration_required || !empty($event->registration_link)): ?>
                    <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <h5 class="mb-4 pb-2 border-bottom" style="color: <?php echo $primary_color; ?>;">
                            <i class="fa fa-clipboard-list me-2"></i>Register for This Event
                        </h5>
                        
                        <?php if ($event->registration_required): ?>
                            <a href="<?php echo base_url('events/register/' . $event->slug); ?>" class="btn btn-primary w-100 mb-3">
                                <i class="fa fa-clipboard-list me-2"></i>Register Now
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($event->registration_link)): ?>
                            <a href="<?php echo htmlspecialchars($event->registration_link); ?>" class="btn btn-outline-secondary w-100" target="_blank">
                                <i class="fa fa-external-link-alt me-1"></i>External Registration
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Quick Info Box -->
                <div class="sidebar-box p-4 mb-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h5 class="heading-sidebar mb-3">
                        <i class="fa fa-info-circle me-2" style="color: <?php echo $primary_color; ?>;"></i>Quick Info
                    </h5>
                    
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #ddd;">
                        <small class="text-muted d-block mb-1">Event Type</small>
                        <strong><?php echo ucfirst($event->event_type); ?></strong>
                    </div>

                    <?php if (!empty($event->category)): ?>
                        <div class="mb-3 pb-3" style="border-bottom: 1px solid #ddd;">
                            <small class="text-muted d-block mb-1">Category</small>
                            <strong><?php echo htmlspecialchars($event->category); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #ddd;">
                        <small class="text-muted d-block mb-1">Status</small>
                        <strong><span class="badge" style="background-color: <?php echo $primary_color; ?>;"><?php echo ucfirst($event->status); ?></span></strong>
                    </div>

                    <?php if (!empty($event->capacity)): ?>
                        <div class="mb-0">
                            <small class="text-muted d-block mb-1">Maximum Attendees</small>
                            <strong><?php echo $event->capacity; ?> people</strong>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- When & Where Box -->
                <div class="sidebar-box p-4 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                    <h5 class="heading-sidebar mb-3">
                        <i class="fa fa-calendar me-2" style="color: <?php echo $primary_color; ?>;"></i>When & Where
                    </h5>
                    
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #ddd;">
                        <small class="text-muted d-block mb-1">Date</small>
                        <strong><?php echo date('F d, Y', strtotime($event->start_date)); ?></strong>
                        <?php if (!empty($event->start_time)): ?>
                            <small class="d-block text-muted mt-1"><?php echo date('g:i A', strtotime($event->start_time)); ?></small>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($event->location)): ?>
                        <div class="mb-0">
                            <small class="text-muted d-block mb-1">Location</small>
                            <strong><?php echo htmlspecialchars($event->location); ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

<style>
.event-detail {
    line-height: 1.8;
}

.event-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.post-meta {
    font-size: 0.95rem;
    color: #666;
    border-bottom: 1px solid #ddd;
    padding-bottom: 1rem;
}

.post-meta span {
    display: inline-block;
    margin-right: 1.5rem;
}

.post-meta i {
    margin-right: 0.5rem;
    color: <?php echo $primary_color; ?>;
}

.post-content {
    font-size: 1.05rem;
    color: #555;
    line-height: 1.8;
}

.post-content h2,
.post-content h3 {
    color: #1a1a1a;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.share-buttons h5 {
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
}

.share-btn-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.share-btn-facebook { background: #1877f2; }
.share-btn-twitter { background: #1da1f2; }
.share-btn-linkedin { background: #0077b5; }
.share-btn-whatsapp { background: #25d366; }

.share-btn-circle:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    color: #fff;
}

.sidebar-box {
    border-radius: 0.5rem;
}

.sidebar-box h5 {
    font-weight: 600;
    color: #333;
}

.heading-sidebar {
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
}

.badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    font-size: 0.85rem;
    border-radius: 0.25rem;
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

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

.alert {
    border-radius: 0.25rem;
    border: none;
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
    background-color: #d4edda;
    color: #155724;
}

@media (max-width: 768px) {
    .post-meta {
        display: flex;
        flex-wrap: wrap;
    }

    .post-meta span {
        display: block;
        margin-right: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .event-title {
        font-size: 1.5rem;
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
