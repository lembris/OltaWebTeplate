<!-- Page Hero V3 Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero V3 End -->

<?php 
// Ensure destination data is available
$dest = isset($destination) ? $destination : null;
if (!$dest) {
    echo '<div class="container py-5"><div class="alert alert-warning">Destination not found.</div></div>';
    return;
}
?>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Destination Detail V3 Premium Section -->
<section class="destination-detail-v3 py-6">
    <div class="container">
        <!-- Main Hero Content -->
        <div class="dest-hero-wrapper" data-aos="fade-up">
            <div class="row g-5 align-items-center">
                <!-- Image Column -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="dest-hero-image">
                        <img src="<?php echo $dest->image_url; ?>" 
                             alt="<?php echo htmlspecialchars($dest->name); ?>"
                             class="main-image">
                        <div class="image-overlay"></div>
                        
                        <!-- Floating Badge -->
                        <?php if (!empty($dest->badge_label)): ?>
                        <div class="floating-badge">
                            <i class="bi bi-award-fill me-2"></i><?php echo htmlspecialchars($dest->badge_label); ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Rating Badge -->
                        <div class="rating-badge">
                            <span class="stars">★★★★★</span>
                            <span class="score"><?php echo number_format($dest->rating, 1); ?></span>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="deco-circle deco-1"></div>
                        <div class="deco-circle deco-2"></div>
                    </div>
                </div>
                
                <!-- Content Column -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="dest-hero-content">
                        <!-- Location Tag -->
                        <div class="location-tag">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span><?php echo htmlspecialchars($dest->location_label ?: $dest->country); ?></span>
                        </div>
                        
                        <!-- Title -->
                        <h1 class="dest-title"><?php echo htmlspecialchars($dest->headline ?: $dest->name); ?></h1>
                        
                        <!-- Intro Text -->
                        <p class="dest-intro">
                            <?php echo htmlspecialchars($dest->intro_text ?: character_limiter($dest->description, 250)); ?>
                        </p>
                        
                        <!-- Quick Stats -->
                        <div class="quick-stats-row">
                            <?php if (!empty($dest->area_size)): ?>
                            <div class="quick-stat">
                                <div class="stat-icon">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </div>
                                <div class="stat-info">
                                    <strong><?php echo htmlspecialchars($dest->area_size); ?></strong>
                                    <span>Park Size</span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($dest->duration_label)): ?>
                            <div class="quick-stat">
                                <div class="stat-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div class="stat-info">
                                    <strong><?php echo htmlspecialchars($dest->duration_label); ?></strong>
                                    <span>Recommended</span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="quick-stat">
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                                <div class="stat-info">
                                    <strong><?php echo htmlspecialchars($dest->best_time ?: 'Year-round'); ?></strong>
                                    <span>Best Time</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="dest-cta-buttons">
                            <a href="<?php echo base_url('enquiry'); ?>" class="btn-dest-primary">
                                <i class="bi bi-send-fill me-2"></i>Enquire Now
                            </a>
                            <a href="<?php echo base_url('packages'); ?>?destination=<?php echo urlencode($dest->name); ?>" class="btn-dest-secondary">
                                <i class="bi bi-box-seam me-2"></i>View Packages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards Section -->
        <div class="info-cards-section mt-6">
            <div class="section-header-v3 text-center mb-5">
                <span class="section-tag" data-aos="fade-up">📋 ESSENTIAL INFO</span>
                <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">
                    Everything You Need to <span class="text-gradient">Know</span>
                </h2>
            </div>
            
            <div class="row g-4">
                <!-- How to Get There -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-card-v3">
                        <div class="info-card-icon icon-blue">
                            <i class="bi bi-airplane-fill"></i>
                        </div>
                        <h4>How to Get There</h4>
                        <p><?php echo htmlspecialchars($dest->how_to_get_there ?: 'Fly to Kilimanjaro International Airport or Arusha Airport. Scheduled flights and road transfers available.'); ?></p>
                    </div>
                </div>
                
                <!-- Wildlife -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-card-v3">
                        <div class="info-card-icon icon-green">
                            <i class="bi bi-bug-fill"></i>
                        </div>
                        <h4>Wildlife</h4>
                        <p><?php echo htmlspecialchars($dest->wildlife_text ?: 'Home to diverse wildlife including the Big Five: lion, leopard, elephant, buffalo, and rhino.'); ?></p>
                    </div>
                </div>
                
                <!-- Activities -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-card-v3">
                        <div class="info-card-icon icon-orange">
                            <i class="bi bi-signpost-2-fill"></i>
                        </div>
                        <h4>Activities</h4>
                        <p><?php 
                        if (!empty($dest->activities) && is_array($dest->activities)) {
                            echo htmlspecialchars(implode(', ', array_slice($dest->activities, 0, 6)));
                        } else {
                            echo htmlspecialchars($dest->activities_text ?: 'Game drives, nature walks, bird watching, photography, and cultural experiences.');
                        }
                        ?></p>
                    </div>
                </div>
                
                <!-- Best Time -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="info-card-v3">
                        <div class="info-card-icon icon-purple">
                            <i class="bi bi-sun-fill"></i>
                        </div>
                        <h4>Best Time to Visit</h4>
                        <p>
                            <strong><?php echo htmlspecialchars($dest->best_time ?: 'June - October'); ?></strong><br>
                            <?php echo htmlspecialchars($dest->best_time_note ?: 'Dry season offers excellent wildlife viewing.'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Highlights Section -->
        <?php if (!empty($dest->highlights) && is_array($dest->highlights)): ?>
        <div class="highlights-section mt-6" data-aos="fade-up">
            <div class="section-header-v3 text-center mb-5">
                <span class="section-tag">⭐ HIGHLIGHTS</span>
                <h2 class="section-title-v3">
                    What Makes This <span class="text-gradient">Special</span>
                </h2>
            </div>
            
            <div class="highlights-grid">
                <?php foreach ($dest->highlights as $index => $highlight): ?>
                <div class="highlight-item" data-aos="zoom-in" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                    <div class="highlight-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <span><?php echo htmlspecialchars($highlight); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- About Section -->
        <?php if (!empty($dest->description)): ?>
        <div class="about-section mt-6" data-aos="fade-up">
            <div class="about-card">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="about-header">
                            <span class="about-tag">📖 ABOUT</span>
                            <h3>Discover <?php echo htmlspecialchars($dest->name); ?></h3>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="about-content">
                            <p><?php echo nl2br(htmlspecialchars($dest->full_description ?: $dest->description)); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Related Destinations Section -->
<?php if (!empty($related_destinations)): ?>
<section class="related-section-v3 py-6 bg-light">
    <div class="container">
        <div class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">🧭 EXPLORE MORE</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">
                Other Amazing <span class="text-gradient">Destinations</span>
            </h2>
        </div>
        
        <div class="row g-4">
            <?php 
            $delay = 100;
            foreach ($related_destinations as $related): 
                $related->slug = isset($related->slug) && !empty($related->slug) 
                    ? $related->slug 
                    : url_title($related->name, 'dash', TRUE);
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <a href="<?php echo base_url('destinations/' . $related->slug); ?>" class="related-card-v3">
                    <div class="related-image">
                        <img src="<?php echo $this->Destination_model->get_destination_image($related); ?>" 
                             alt="<?php echo htmlspecialchars($related->name); ?>">
                        <div class="related-overlay"></div>
                    </div>
                    <div class="related-content">
                        <h4><?php echo htmlspecialchars($related->name); ?></h4>
                        <span class="related-location">
                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($related->country); ?>
                        </span>
                    </div>
                    <div class="related-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            <?php 
                $delay += 100;
            endforeach; 
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="cta-section-v3 py-6">
    <div class="container">
        <div class="cta-card-v3" data-aos="zoom-in">
            <div class="cta-bg-pattern"></div>
            <div class="row align-items-center position-relative">
                <div class="col-lg-8">
                    <div class="cta-content">
                        <span class="cta-tag">🎯 READY TO EXPLORE?</span>
                        <h3>Start Planning Your <?php echo htmlspecialchars($dest->name); ?> Adventure</h3>
                        <p>Let our expert safari planners create your perfect itinerary. Free consultation, no obligations.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="cta-buttons">
                        <a href="<?php echo base_url('enquiry'); ?>" class="btn-cta-primary">
                            <i class="bi bi-send-fill me-2"></i>Get Free Quote
                        </a>
                        <a href="https://wa.me/<?php echo $consult_number_call ?? ''; ?>?text=Hi! I'm interested in visiting <?php echo urlencode($dest->name); ?>" 
                           class="btn-cta-whatsapp" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ DESTINATION DETAIL V3 PREMIUM ============ */
.destination-detail-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
}

.py-6 { padding-top: 5rem; padding-bottom: 5rem; }
.mt-6 { margin-top: 5rem; }

/* Section Header */
.section-header-v3 { margin-bottom: 40px; }

.section-tag {
    display: inline-block;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, rgba(199, 128, 92, 0.05) 100%);
    color: var(--primary, #C7805C);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.section-title-v3 {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #1a1a2e;
}

.text-gradient {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ============ HERO IMAGE ============ */
.dest-hero-image {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 80px rgba(0,0,0,0.15);
}

.dest-hero-image .main-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.dest-hero-image:hover .main-image {
    transform: scale(1.05);
}

.dest-hero-image .image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, transparent 50%);
}

.floating-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
}

.rating-badge {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: white;
    padding: 10px 18px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.rating-badge .stars {
    color: #ffc107;
    font-size: 0.9rem;
}

.rating-badge .score {
    font-weight: 700;
    color: #1a1a2e;
}

.deco-circle {
    position: absolute;
    border-radius: 50%;
    z-index: -1;
}

.deco-1 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.2) 0%, transparent 100%);
    top: -30px;
    right: -30px;
}

.deco-2 {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(168, 104, 74, 0.2) 0%, transparent 100%);
    bottom: -20px;
    left: -20px;
}

/* ============ HERO CONTENT ============ */
.dest-hero-content {
    padding-left: 20px;
}

.location-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(199, 128, 92, 0.1);
    color: var(--primary, #C7805C);
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 20px;
}

.dest-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.2;
    margin-bottom: 20px;
}

.dest-intro {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.7;
    margin-bottom: 30px;
}

/* Quick Stats */
.quick-stats-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.quick-stat {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 15px 20px;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    flex: 1;
    min-width: 150px;
}

.quick-stat .stat-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.quick-stat .stat-info strong {
    display: block;
    font-size: 1rem;
    color: #1a1a2e;
}

.quick-stat .stat-info span {
    font-size: 0.8rem;
    color: #888;
}

/* CTA Buttons */
.dest-cta-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.btn-dest-primary {
    display: inline-flex;
    align-items: center;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.3);
}

.btn-dest-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-dest-secondary {
    display: inline-flex;
    align-items: center;
    padding: 14px 28px;
    background: white;
    color: #1a1a2e;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-dest-secondary:hover {
    border-color: var(--primary, #C7805C);
    color: var(--primary, #C7805C);
    transform: translateY(-3px);
}

/* ============ INFO CARDS V3 ============ */
.info-card-v3 {
    background: white;
    padding: 30px;
    border-radius: 20px;
    height: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.info-card-v3:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}

.info-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.info-card-icon.icon-blue {
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.15) 0%, rgba(199, 128, 92, 0.05) 100%);
    color: var(--primary, #C7805C);
}

.info-card-icon.icon-green {
    background: linear-gradient(135deg, rgba(40,167,69,0.15) 0%, rgba(40,167,69,0.05) 100%);
    color: #28a745;
}

.info-card-icon.icon-orange {
    background: linear-gradient(135deg, rgba(253,126,20,0.15) 0%, rgba(253,126,20,0.05) 100%);
    color: #fd7e14;
}

.info-card-icon.icon-purple {
    background: linear-gradient(135deg, rgba(168, 104, 74, 0.15) 0%, rgba(168, 104, 74, 0.05) 100%);
    color: var(--primary-dark, #A8684A);
}

.info-card-v3 h4 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 12px;
}

.info-card-v3 p {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

/* ============ HIGHLIGHTS ============ */
.highlights-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: white;
    padding: 15px 25px;
    border-radius: 50px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.highlight-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.highlight-icon {
    color: #28a745;
    font-size: 1.2rem;
}

.highlight-item span {
    font-weight: 600;
    color: #1a1a2e;
}

/* ============ ABOUT SECTION ============ */
.about-card {
    background: white;
    padding: 50px;
    border-radius: 24px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.08);
}

.about-tag {
    display: inline-block;
    background: rgba(199, 128, 92, 0.1);
    color: var(--primary, #C7805C);
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.about-header h3 {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1a1a2e;
}

.about-content p {
    color: #555;
    font-size: 1.05rem;
    line-height: 1.8;
    margin: 0;
}

/* ============ RELATED CARDS V3 ============ */
.related-card-v3 {
    display: block;
    position: relative;
    height: 280px;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
}

.related-card-v3:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

.related-card-v3 .related-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.related-card-v3 .related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.related-card-v3:hover .related-image img {
    transform: scale(1.1);
}

.related-card-v3 .related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
}

.related-card-v3 .related-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    color: white;
    z-index: 2;
}

.related-card-v3 h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: white;
}

.related-location {
    font-size: 0.9rem;
    opacity: 0.8;
}

.related-arrow {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary, #C7805C);
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 2;
}

.related-card-v3:hover .related-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* ============ CTA SECTION ============ */
.cta-card-v3 {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 50px;
    border-radius: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.cta-bg-pattern {
    position: absolute;
    top: -50%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(199, 128, 92, 0.3) 0%, transparent 70%);
    border-radius: 50%;
}

.cta-tag {
    display: inline-block;
    background: rgba(255,255,255,0.1);
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.cta-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.cta-content p {
    opacity: 0.8;
    margin: 0;
    font-size: 1.05rem;
}

.cta-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-cta-primary {
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
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
}

.btn-cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.5);
    color: white;
}

.btn-cta-whatsapp {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 28px;
    background: #25D366;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cta-whatsapp:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(37,211,102,0.4);
    color: white;
}

/* ============ RESPONSIVE ============ */
@media (max-width: 991px) {
    .dest-hero-content {
        padding-left: 0;
        margin-top: 30px;
    }
    
    .dest-hero-image .main-image {
        height: 400px;
    }
    
    .cta-card-v3 {
        text-align: center;
    }
    
    .cta-buttons {
        align-items: center;
    }
    
    .about-card {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .dest-title {
        font-size: 1.8rem;
    }
    
    .dest-hero-image .main-image {
        height: 300px;
    }
    
    .quick-stats-row {
        flex-direction: column;
    }
    
    .quick-stat {
        min-width: 100%;
    }
    
    .dest-cta-buttons {
        flex-direction: column;
    }
    
    .btn-dest-primary,
    .btn-dest-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .cta-card-v3 {
        padding: 30px;
    }
}

@media (max-width: 576px) {
    .py-6 {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
    
    .mt-6 {
        margin-top: 3rem;
    }
    
    .info-card-v3 {
        padding: 25px;
    }
    
    .about-card {
        padding: 25px;
    }
    
    .about-header h3 {
        font-size: 1.4rem;
    }
}
</style>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });
});
</script>
