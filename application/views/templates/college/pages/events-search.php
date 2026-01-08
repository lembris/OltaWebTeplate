<?php
/**
 * College Template - Event Search Results Page
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Search Results Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ftco-animate">
                <div class="mb-5">
                    <h2 class="heading mb-2">Results for "<?php echo htmlspecialchars($keyword); ?>"</h2>
                    <p class="text-muted">
                        <?php if (!empty($results) && count($results) > 0): ?>
                            Found <strong><?php echo count($results); ?></strong> event<?php echo count($results) > 1 ? 's' : ''; ?>
                        <?php else: ?>
                            No events found
                        <?php endif; ?>
                    </p>
                </div>

                <?php if (!empty($results) && count($results) > 0): ?>
                    <div class="events-search-list">
                        <?php foreach ($results as $event): 
                            $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                            $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : '#C7805C';
                        ?>
                            <article class="blog-entry ftco-animate mb-4 pb-4" style="border-bottom: 1px solid #ddd;">
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <?php if (!empty($event->banner)): ?>
                                            <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="block-20" style="background-image: url('<?php echo base_url($event->banner); ?>'); border-left: 4px solid <?php echo $color; ?>;"></a>
                                        <?php elseif (!empty($event->image)): ?>
                                            <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="block-20" style="background-image: url('<?php echo base_url($event->image); ?>'); border-left: 4px solid <?php echo $color; ?>;"></a>
                                        <?php else: ?>
                                            <div class="block-20 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa; border-left: 4px solid <?php echo $color; ?>;">
                                                <?php 
                                                // Fallback to logo
                                                if (!empty($site_logo)):
                                                ?>
                                                    <img src="<?php echo base_url($site_logo); ?>" alt="Logo" class="img-fluid" style="max-height: 80px; max-width: 90%; object-fit: contain;">
                                                <?php else: ?>
                                                    <i class="fa fa-calendar" style="font-size: 2.5rem; color: <?php echo $color; ?>;"></i>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-5">
                                        <span class="badge mb-2" style="background-color: <?php echo $color; ?>; color: #fff;">
                                            <?php echo ucfirst($event->event_type); ?>
                                        </span>
                                        <h3 class="heading mt-2">
                                            <a href="<?php echo base_url('events/view/' . $event->uid); ?>">
                                                <?php echo htmlspecialchars($event->title); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="meta-search">
                                            <?php if (!empty($event->start_date)): ?>
                                                <span class="me-3">
                                                    <i class="fa fa-calendar me-1" style="color: <?php echo $color; ?>;"></i>
                                                    <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if (!empty($event->location)): ?>
                                                <span>
                                                    <i class="fa fa-map-marker me-1" style="color: <?php echo $color; ?>;"></i>
                                                    <?php echo htmlspecialchars($event->location); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <p class="text mt-3">
                                            <?php echo htmlspecialchars(substr(strip_tags($event->description), 0, 150)); ?>...
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <a href="<?php echo base_url('events/view/' . $event->uid); ?>" class="more-link">
                                            View Event <i class="fa fa-arrow-right ms-2"></i>
                                        </a>
                                        <div class="share-buttons-inline d-flex gap-2 mt-3" style="justify-content: flex-end;">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(base_url('events/view/' . $event->uid)); ?>" target="_blank" class="share-btn-circle-sm share-btn-facebook" title="Share on Facebook">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(base_url('events/view/' . $event->uid)); ?>&text=<?php echo urlencode($event->title); ?>" target="_blank" class="share-btn-circle-sm share-btn-twitter" title="Share on X">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(base_url('events/view/' . $event->uid)); ?>&title=<?php echo urlencode($event->title); ?>" target="_blank" class="share-btn-circle-sm share-btn-linkedin" title="Share on LinkedIn">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                            <a href="https://wa.me/?text=<?php echo urlencode($event->title . ' ' . base_url('events/view/' . $event->uid)); ?>" target="_blank" class="share-btn-circle-sm share-btn-whatsapp" title="Share on WhatsApp">
                                                <i class="fa fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>No events found</strong> matching "<?php echo htmlspecialchars($keyword); ?>". Try searching with different keywords or <a href="<?php echo base_url('events'); ?>" class="alert-link">view all events</a>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Back to Events -->
                <div class="mt-5 pt-4" style="border-top: 1px solid #ddd;">
                    <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-primary">
                        <i class="fa fa-chevron-left me-2"></i>Back to All Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.heading {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.heading a {
    color: #1a1a1a;
    text-decoration: none;
}

.heading a:hover {
    color: #C7805C;
}

.meta-search {
    font-size: 0.9rem;
    color: #666;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.more-link {
    color: #C7805C;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}

.more-link:hover {
    color: #A0654A;
}

.block-20 {
    height: 180px;
    background-size: cover;
    background-position: center;
    display: block;
    border-radius: 0.25rem;
}

.badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    font-size: 0.85rem;
    font-weight: 500;
}

.alert {
    border-radius: 0.25rem;
    border: none;
    border-left: 4px solid #0c5460;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
}

.text {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
}

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

@media (max-width: 768px) {
    .bread {
        font-size: 1.75rem;
    }

    .text-md-end {
        text-align: left !important;
        margin-top: 1rem;
    }

    .meta-search {
        flex-direction: column;
        gap: 0.5rem;
    }

    .block-20 {
        width: 100%;
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
