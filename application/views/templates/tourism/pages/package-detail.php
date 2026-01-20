<?php
/**
 * Package Detail Page - Dynamic Version
 * Works with database objects from Package_model
 */

// Get model instance for helper methods
$CI =& get_instance();
$CI->load->model('Package_model');

// Parse JSON fields
$destinations = is_string($package->destinations) ? json_decode($package->destinations, true) : ($package->destinations_array ?? []);
$highlights = is_string($package->highlights) ? json_decode($package->highlights, true) : ($package->highlights ?? []);
$inclusions = is_string($package->inclusions) ? json_decode($package->inclusions, true) : [];
$exclusions = is_string($package->exclusions) ? json_decode($package->exclusions, true) : [];
$gallery = is_string($package->gallery) ? json_decode($package->gallery, true) : [];

// Get image URL
$image_url = $CI->Package_model->get_package_image($package);
?>

<!-- Page Hero -->
<section class="package-hero" style="background-image: url('<?php echo $image_url; ?>');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center text-white">
                <nav aria-label="breadcrumb" data-aos="fade-down">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('packages'); ?>">Packages</a></li>
                        <li class="breadcrumb-item active"><?php echo htmlspecialchars($package->name); ?></li>
                    </ol>
                </nav>
                <h1 class="hero-title" data-aos="fade-up"><?php echo htmlspecialchars($package->name); ?></h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                    <?php echo htmlspecialchars($package->short_description ?? ''); ?>
                </p>
                <div class="hero-badges" data-aos="fade-up" data-aos-delay="200">
                    <span class="badge-item"><i class="bi bi-clock"></i> <?php echo $package->duration_days; ?> Days</span>
                    <span class="badge-item"><i class="bi bi-geo-alt"></i> <?php echo count($destinations); ?> Destinations</span>
                    <span class="badge-item"><i class="bi bi-star-fill"></i> <?php echo number_format($package->rating ?? 4.8, 1); ?> Rating</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package Header Bar -->
<section class="package-header-bar py-4">
    <div class="container">
        <div class="header-card" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="package-meta-row">
                        <span class="meta-badge duration">
                            <i class="bi bi-clock"></i> <?php echo $package->duration_days; ?> Days / <?php echo ($package->duration_nights ?? $package->duration_days - 1); ?> Nights
                        </span>
                        <span class="meta-badge difficulty <?php echo strtolower($package->difficulty ?? 'easy'); ?>">
                            <?php echo ucfirst($package->difficulty ?? 'Easy'); ?>
                        </span>
                        <div class="rating-display">
                            <span class="stars">★★★★★</span>
                            <span class="count">(<?php echo $package->review_count ?? 48; ?> reviews)</span>
                        </div>
                    </div>
                    <div class="quick-info-row">
                        <div class="info-item">
                            <i class="bi bi-people"></i>
                            <span><?php echo ($package->group_size_min ?? 2); ?>-<?php echo ($package->group_size_max ?? 8); ?> People</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-house"></i>
                            <span><?php echo htmlspecialchars($package->accommodation_type ?? 'Mid-range Lodge'); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-geo-alt"></i>
                            <span><?php echo implode(', ', array_slice($destinations, 0, 3)); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="price-cta-box">
                        <div class="price-display">
                            <span class="label">From</span>
                            <span class="amount">$<?php echo number_format($package->base_price ?? 0); ?></span>
                            <span class="per">per person</span>
                        </div>
                        <div class="cta-buttons">
                            <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn-book">
                                <i class="bi bi-calendar-check me-2"></i>Book Now
                            </a>
                            <a href="<?php echo base_url('enquiry'); ?>" class="btn-enquire">
                                <i class="bi bi-send me-2"></i>Get Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package Overview -->
<section class="package-overview py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="overview-content">
                    <h2 class="section-title"><span class="highlight">Overview</span></h2>
                    <p class="overview-text"><?php echo nl2br(htmlspecialchars($package->description ?? '')); ?></p>
                    
                    <!-- Highlights -->
                    <?php if (!empty($highlights)): ?>
                    <div class="highlights-section mt-4">
                        <h4><i class="bi bi-stars me-2"></i>Tour Highlights</h4>
                        <div class="highlights-grid">
                            <?php foreach ($highlights as $highlight): ?>
                            <div class="highlight-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><?php echo htmlspecialchars($highlight); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Destinations -->
                    <?php if (!empty($destinations)): ?>
                    <div class="destinations-section mt-4">
                        <h4><i class="bi bi-geo-alt me-2"></i>Destinations</h4>
                        <div class="destinations-list">
                            <?php foreach ($destinations as $dest): ?>
                            <span class="destination-tag"><?php echo htmlspecialchars($dest); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Gallery Section -->
            <?php if (!empty($gallery)): ?>
            <div class="col-lg-8" data-aos="fade-up">
                <div class="gallery-section">
                    <h2 class="section-title mt-5"><span class="highlight">Photo Gallery</span></h2>
                    
                    <!-- Gallery Grid -->
                    <div class="gallery-grid">
                        <?php foreach ($gallery as $index => $img): ?>
                        <div class="gallery-item" data-image="<?= htmlspecialchars($img) ?>" data-index="<?= $index ?>">
                            <img src="<?= base_url('assets/img/packages/gallery/' . $img) ?>" 
                                 alt="Gallery Image <?= $index + 1 ?>" 
                                 class="gallery-img"
                                 loading="lazy">
                            <div class="gallery-overlay">
                                <button class="gallery-btn" onclick="openGalleryLightbox(<?= $index ?>)">
                                    <i class="bi bi-zoom-in"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Gallery Lightbox -->
            <div id="galleryLightbox" class="gallery-lightbox">
                <button class="lightbox-close" onclick="closeGalleryLightbox()">×</button>
                <button class="lightbox-prev" onclick="prevGalleryImage()">❮</button>
                <img id="lightboxImage" src="" alt="Gallery Image" class="lightbox-image">
                <button class="lightbox-next" onclick="nextGalleryImage()">❯</button>
                <div class="lightbox-counter">
                    <span id="galleryCounter">1 / <?= count($gallery) ?></span>
                </div>
                <div class="lightbox-thumbnails">
                    <?php foreach ($gallery as $index => $img): ?>
                    <img src="<?= base_url('assets/img/packages/gallery/' . $img) ?>" 
                         alt="Thumb <?= $index + 1 ?>" 
                         class="thumb-img" 
                         onclick="goToGalleryImage(<?= $index ?>)">
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="quick-facts-card">
                    <h4 class="card-title"><i class="bi bi-info-circle me-2"></i>Quick Facts</h4>
                    <ul class="facts-list">
                        <li>
                            <span class="label">Best Time</span>
                            <span class="value"><?php echo htmlspecialchars($package->best_time ?? 'June - October'); ?></span>
                        </li>
                        <li>
                            <span class="label">Start Location</span>
                            <span class="value"><?php echo htmlspecialchars($package->start_location ?? 'Arusha'); ?></span>
                        </li>
                        <li>
                            <span class="label">End Location</span>
                            <span class="value"><?php echo htmlspecialchars($package->end_location ?? 'Arusha'); ?></span>
                        </li>
                        <li>
                            <span class="label">Group Size</span>
                            <span class="value"><?php echo ($package->group_size_min ?? 2); ?>-<?php echo ($package->group_size_max ?? 8); ?> people</span>
                        </li>
                        <li>
                            <span class="label">Category</span>
                            <span class="value"><?php echo ucfirst($package->category ?? 'Wildlife'); ?></span>
                        </li>
                    </ul>
                    
                    <!-- Help Box -->
                    <div class="help-box">
                        <div class="icon">💬</div>
                        <h5>Need Help?</h5>
                        <p>Our safari experts are here to assist you</p>
                        <a href="https://wa.me/<?php echo $consult_number_call ?? '255787033777'; ?>" class="btn-whatsapp" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Inclusions & Exclusions -->
<section class="package-inclusions py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Inclusions -->
            <div class="col-lg-6" data-aos="fade-up">
                <div class="inclusion-card included">
                    <div class="card-header">
                        <i class="bi bi-check-circle-fill"></i>
                        <h4>What's Included</h4>
                    </div>
                    <ul class="list">
                        <?php 
                        $default_inclusions = ['Airport transfers', 'All park fees', 'Accommodation', '4x4 Safari vehicle', 'Professional guide', 'All meals on safari', 'Drinking water'];
                        $inc_list = !empty($inclusions) ? $inclusions : $default_inclusions;
                        foreach ($inc_list as $item): ?>
                        <li><i class="bi bi-check2"></i><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Exclusions -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="inclusion-card excluded">
                    <div class="card-header">
                        <i class="bi bi-x-circle-fill"></i>
                        <h4>What's Not Included</h4>
                    </div>
                    <ul class="list">
                        <?php 
                        $default_exclusions = ['International flights', 'Visa fees', 'Travel insurance', 'Tips', 'Personal expenses', 'Alcoholic beverages'];
                        $exc_list = !empty($exclusions) ? $exclusions : $default_exclusions;
                        foreach ($exc_list as $item): ?>
                        <li><i class="bi bi-x"></i><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking CTA -->
<section class="booking-cta py-5">
    <div class="container">
        <div class="cta-card" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3>Ready to Book This Safari?</h3>
                    <p class="mb-lg-0">Secure your spot now and start your African adventure!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn-cta-book">
                        <i class="bi bi-calendar-check me-2"></i>Book Now - $<?php echo number_format($package->base_price ?? 0); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Packages -->
<?php if (!empty($related_packages)): ?>
<section class="related-packages py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Related <span class="highlight">Packages</span></h2>
            <p>You might also like these safaris</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($related_packages as $related): 
                $rel_image = $CI->Package_model->get_package_image($related);
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="package-card">
                    <div class="card-image">
                        <img src="<?php echo $rel_image; ?>" alt="<?php echo htmlspecialchars($related->name); ?>">
                        <div class="overlay"></div>
                        <div class="price-tag">
                            <span class="price">$<?php echo number_format($related->base_price ?? 0); ?></span>
                            <span class="per">/person</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="meta">
                            <span><i class="bi bi-clock"></i> <?php echo $related->duration_days; ?> Days</span>
                            <span class="rating">★ <?php echo number_format($related->rating ?? 4.8, 1); ?></span>
                        </div>
                        <h4><?php echo htmlspecialchars($related->name); ?></h4>
                        <a href="<?php echo base_url('packages/' . $related->slug); ?>" class="btn-view">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Styles -->
<style>
/* Package Hero */
.package-hero {
    position: relative;
    padding: 180px 0 120px;
    background-size: cover;
    background-position: center;
}

.package-hero .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26,26,46,0.85) 0%, rgba(22,33,62,0.8) 100%);
}

.package-hero .container {
    position: relative;
    z-index: 2;
}

.package-hero .breadcrumb {
    background: transparent;
    margin-bottom: 20px;
}

.package-hero .breadcrumb-item a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
}

.package-hero .breadcrumb-item.active {
    color: #ffc107;
}

.package-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}

.package-hero .hero-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: white;
    margin-bottom: 15px;
}

.package-hero .hero-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 25px;
}

.hero-badges {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
}

.badge-item {
    background: rgba(255,255,255,0.15);
    padding: 10px 20px;
    border-radius: 50px;
    color: white;
    font-weight: 500;
    backdrop-filter: blur(5px);
}

.badge-item i {
    margin-right: 8px;
    color: #ffc107;
}

/* Header Bar */
.package-header-bar {
    background: white;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    position: relative;
    z-index: 10;
    margin-top: -40px;
}

.header-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.package-meta-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.meta-badge {
    padding: 8px 16px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
}

.meta-badge.duration {
    background: #e3f2fd;
    color: #1565c0;
}

.meta-badge.difficulty {
    background: #e8f5e9;
    color: #2e7d32;
}

.meta-badge.difficulty.moderate {
    background: #fff3e0;
    color: #ef6c00;
}

.meta-badge.difficulty.challenging {
    background: #ffebee;
    color: #c62828;
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 8px;
}

.rating-display .stars {
    color: #ffc107;
}

.rating-display .count {
    color: #666;
    font-size: 0.9rem;
}

.quick-info-row {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
}

.quick-info-row .info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
}

.quick-info-row .info-item i {
    color: var(--primary, #C7805C);
}

.price-cta-box {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 30px;
}

.price-display {
    text-align: right;
}

.price-display .label {
    display: block;
    font-size: 0.85rem;
    color: #666;
}

.price-display .amount {
    font-size: 2rem;
    font-weight: 800;
    color: #dc3545;
}

.price-display .per {
    display: block;
    font-size: 0.85rem;
    color: #666;
}

.cta-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-book {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-enquire {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    background: transparent;
    color: #1a1a2e;
    border: 2px solid #1a1a2e;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-enquire:hover {
    background: #1a1a2e;
    color: white;
}

/* Section Title */
.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
}

.section-title .highlight {
    background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Overview */
.overview-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
}

.highlights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.highlight-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
}

.highlight-item i {
    color: #28a745;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.destinations-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

.destination-tag {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Quick Facts Card */
.quick-facts-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    position: sticky;
    top: 100px;
}

.quick-facts-card .card-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1a1a2e;
}

.facts-list {
    list-style: none;
    padding: 0;
    margin: 0 0 25px 0;
}

.facts-list li {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.facts-list li:last-child {
    border-bottom: none;
}

.facts-list .label {
    color: #666;
}

.facts-list .value {
    font-weight: 600;
    color: #1a1a2e;
}

.help-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 25px;
    text-align: center;
}

.help-box .icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.help-box h5 {
    font-weight: 700;
    margin-bottom: 8px;
}

.help-box p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 15px;
}

.btn-whatsapp {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: #25D366;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-whatsapp:hover {
    background: #128C7E;
    color: white;
    transform: translateY(-2px);
}

/* Inclusions */
.inclusion-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    height: 100%;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.inclusion-card .card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}

.inclusion-card.included .card-header i {
    color: #28a745;
    font-size: 1.5rem;
}

.inclusion-card.excluded .card-header i {
    color: #dc3545;
    font-size: 1.5rem;
}

.inclusion-card .card-header h4 {
    font-weight: 700;
    margin: 0;
}

.inclusion-card .list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.inclusion-card .list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
}

.inclusion-card .list li:last-child {
    border-bottom: none;
}

.inclusion-card.included .list i {
    color: #28a745;
}

.inclusion-card.excluded .list i {
    color: #dc3545;
}

/* Booking CTA */
.booking-cta {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.booking-cta .cta-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 40px;
    color: white;
}

.booking-cta h3 {
    font-weight: 700;
    margin-bottom: 10px;
}

.booking-cta p {
    opacity: 0.8;
}

.btn-cta-book {
    display: inline-flex;
    align-items: center;
    padding: 16px 32px;
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    color: #1a1a2e;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cta-book:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255,193,7,0.4);
    color: #1a1a2e;
}

/* Related Packages */
.package-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.package-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.package-card .card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.package-card .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.package-card:hover .card-image img {
    transform: scale(1.1);
}

.package-card .card-image .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
}

.package-card .price-tag {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: white;
    padding: 8px 16px;
    border-radius: 10px;
}

.package-card .price-tag .price {
    font-size: 1.2rem;
    font-weight: 800;
    color: #dc3545;
}

.package-card .price-tag .per {
    font-size: 0.75rem;
    color: #666;
}

.package-card .card-content {
    padding: 20px;
}

.package-card .meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #666;
    font-size: 0.9rem;
}

.package-card .meta .rating {
    color: #ffc107;
}

.package-card h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #1a1a2e;
}

.package-card .btn-view {
    display: block;
    text-align: center;
    padding: 12px;
    background: #f8f9fa;
    color: #1a1a2e;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.package-card .btn-view:hover {
    background: var(--primary, #C7805C);
    color: white;
}

/* Gallery Section */
.gallery-section {
    margin-top: 50px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    height: 200px;
    cursor: pointer;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-btn {
    background: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.gallery-btn:hover {
    background: #ffc107;
    transform: scale(1.1);
}

/* Lightbox Styles */
.gallery-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.95);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.gallery-lightbox.active {
    display: flex;
}

.lightbox-image {
    max-width: 90%;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 10px;
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 30px;
    background: none;
    border: none;
    color: white;
    font-size: 3rem;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    transition: color 0.3s ease;
}

.lightbox-close:hover {
    color: #ffc107;
}

.lightbox-prev,
.lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    font-size: 2rem;
    padding: 15px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 5px;
}

.lightbox-prev:hover,
.lightbox-next:hover {
    background: rgba(255,193,7,0.8);
    color: black;
}

.lightbox-prev {
    left: 20px;
}

.lightbox-next {
    right: 20px;
}

.lightbox-counter {
    position: absolute;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
}

.lightbox-thumbnails {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    max-width: 90%;
    overflow-x: auto;
    padding: 10px;
}

.thumb-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.thumb-img:hover,
.thumb-img.active {
    border-color: #ffc107;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 991px) {
    .package-header-bar {
        margin-top: 0;
    }
    
    .price-cta-box {
        flex-direction: column;
        align-items: stretch;
        margin-top: 25px;
    }
    
    .price-display {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .cta-buttons {
        flex-direction: row;
    }
    
    .cta-buttons a {
        flex: 1;
    }
}

@media (max-width: 576px) {
    .package-hero {
        padding: 140px 0 80px;
    }
    
    .header-card {
        padding: 20px;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
    
    .hero-badges {
        flex-direction: column;
        align-items: center;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    
    .lightbox-prev,
    .lightbox-next {
        padding: 10px 15px;
        font-size: 1.5rem;
    }
}
</style>

<script>
let currentGalleryIndex = 0;
const galleryImages = <?php echo json_encode($gallery ?? []); ?>;

function openGalleryLightbox(index) {
    currentGalleryIndex = index;
    updateLightboxImage();
    document.getElementById('galleryLightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeGalleryLightbox() {
    document.getElementById('galleryLightbox').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function updateLightboxImage() {
    if (galleryImages.length === 0) return;
    
    const image = galleryImages[currentGalleryIndex];
    const imgElement = document.getElementById('lightboxImage');
    const counterElement = document.getElementById('galleryCounter');
    
    imgElement.src = '<?= base_url('assets/img/packages/gallery/') ?>' + image;
    counterElement.textContent = (currentGalleryIndex + 1) + ' / ' + galleryImages.length;
    
    // Update thumbnail highlight
    document.querySelectorAll('.thumb-img').forEach((thumb, idx) => {
        thumb.classList.toggle('active', idx === currentGalleryIndex);
    });
}

function nextGalleryImage() {
    currentGalleryIndex = (currentGalleryIndex + 1) % galleryImages.length;
    updateLightboxImage();
}

function prevGalleryImage() {
    currentGalleryIndex = (currentGalleryIndex - 1 + galleryImages.length) % galleryImages.length;
    updateLightboxImage();
}

function goToGalleryImage(index) {
    currentGalleryIndex = index;
    updateLightboxImage();
}

// Keyboard navigation
document.addEventListener('keydown', function(event) {
    const lightbox = document.getElementById('galleryLightbox');
    if (!lightbox.classList.contains('active')) return;
    
    if (event.key === 'ArrowLeft') prevGalleryImage();
    if (event.key === 'ArrowRight') nextGalleryImage();
    if (event.key === 'Escape') closeGalleryLightbox();
});

// Close lightbox on background click
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('galleryLightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) closeGalleryLightbox();
        });
    }
});
</script>
