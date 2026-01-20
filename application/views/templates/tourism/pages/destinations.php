<!-- Page Hero V3 Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero V3 End -->

<!-- Destinations V3 Section - Premium Design -->
<section class="destinations-page-v3 py-6">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">🌍 EXPLORE TANZANIA</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">
                Our Safari <span class="text-gradient">Destinations</span>
            </h2>
            <p class="section-desc" data-aos="fade-up" data-aos-delay="200">
                Discover the breathtaking landscapes and incredible wildlife of Tanzania's most iconic national parks and conservation areas
            </p>
        </div>

        <!-- Destinations Grid - V3 Premium Cards -->
        <div class="row g-4">
            <?php if (isset($destinations) && !empty($destinations)): ?>
                <?php 
                $delay = 100;
                foreach ($destinations as $dest): 
                    // Enrich destination data
                    $dest->slug = isset($dest->slug) && !empty($dest->slug) 
                        ? $dest->slug 
                        : url_title($dest->name, 'dash', TRUE);
                    $dest->image_url = $this->Destination_model->get_destination_image($dest);
                    $dest->badge_text = isset($dest->badge_text) && !empty($dest->badge_text) 
                        ? $dest->badge_text 
                        : 'Safari Destination';
                    $dest->badge_icon = isset($dest->badge_icon) ? $dest->badge_icon : '🌍';
                    $dest->badge_class = isset($dest->badge_class) && !empty($dest->badge_class) 
                        ? $dest->badge_class 
                        : '';
                    $dest->location_label = isset($dest->location_label) && !empty($dest->location_label) 
                        ? $dest->location_label 
                        : $dest->country;
                    $dest->rating = isset($dest->rating) ? (float)$dest->rating : 4.8;
                    $dest->duration_label = isset($dest->duration_label) ? $dest->duration_label : '';
                    $dest->short_description = isset($dest->short_description) && !empty($dest->short_description)
                        ? $dest->short_description
                        : character_limiter($dest->description, 80);
                ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <a href="<?php echo base_url('destinations/' . $dest->slug); ?>" class="dest-card-v3-page">
                        <div class="dest-image">
                            <img src="<?php echo $dest->image_url; ?>" 
                                 alt="<?php echo htmlspecialchars($dest->name); ?> - Safari Destination"
                                 loading="lazy">
                            <div class="dest-overlay"></div>
                        </div>
                        <div class="dest-badge <?php echo $dest->badge_class; ?>">
                            <?php echo $dest->badge_icon; ?> <?php echo htmlspecialchars($dest->badge_text); ?>
                        </div>
                        <div class="dest-content">
                            <div class="dest-rating">
                                <span class="stars">★★★★★</span>
                                <span class="count"><?php echo number_format($dest->rating, 1); ?></span>
                            </div>
                            <h3 class="dest-title"><?php echo htmlspecialchars($dest->name); ?></h3>
                            <p class="dest-desc"><?php echo htmlspecialchars($dest->short_description); ?></p>
                            <div class="dest-meta">
                                <span><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($dest->location_label); ?></span>
                                <?php if (!empty($dest->duration_label)): ?>
                                <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($dest->duration_label); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="dest-explore">
                            <span>Explore</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <?php 
                    $delay += 50;
                    if ($delay > 400) $delay = 100;
                endforeach; 
                ?>
            <?php else: ?>
                <!-- No destinations found -->
                <div class="col-12 text-center py-5">
                    <div class="no-results-v3">
                        <div class="no-results-icon">🌍</div>
                        <h4>No Destinations Available</h4>
                        <p class="text-muted">Please check back soon for our amazing safari destinations.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- CTA Section -->
        <div class="cta-section-v3 mt-5" data-aos="fade-up" data-aos-delay="300">
            <div class="cta-card-destinations">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="cta-content">
                            <span class="cta-tag">🎯 NEED HELP DECIDING?</span>
                            <h3>Can't Decide Which Destination?</h3>
                            <p>Let our safari experts help you plan the perfect Tanzania adventure based on your interests and travel dates.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <a href="<?php echo base_url('enquiry'); ?>" class="btn-cta-v3">
                            <i class="bi bi-chat-dots me-2"></i>Get Expert Advice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ DESTINATIONS PAGE V3 - Premium ============ */
.destinations-page-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

/* Section Header */
.section-header-v3 {
    margin-bottom: 50px;
}

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
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 15px;
}

.text-gradient {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-desc {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Destination Card V3 Page */
.dest-card-v3-page {
    display: block;
    position: relative;
    height: 380px;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
}

.dest-card-v3-page:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
}

.dest-card-v3-page .dest-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.dest-card-v3-page .dest-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.dest-card-v3-page:hover .dest-image img {
    transform: scale(1.1);
}

.dest-card-v3-page .dest-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        180deg, 
        transparent 0%, 
        transparent 30%, 
        rgba(0,0,0,0.85) 100%
    );
    transition: all 0.3s ease;
}

.dest-card-v3-page:hover .dest-overlay {
    background: linear-gradient(
        180deg, 
        rgba(199, 128, 92, 0.2) 0%, 
        rgba(0,0,0,0.9) 100%
    );
}

/* Badge */
.dest-card-v3-page .dest-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: white;
    color: #1a1a2e;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    z-index: 2;
}

.dest-card-v3-page .dest-badge.badge-popular {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.badge-wildlife,
.dest-card-v3-page .dest-badge.bg-success {
    background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.badge-adventure,
.dest-card-v3-page .dest-badge.bg-info {
    background: linear-gradient(135deg, #339af0 0%, #228be6 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.bg-warning {
    background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
    color: #1a1a2e;
}

.dest-card-v3-page .dest-badge.bg-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #fa5252 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.bg-dark {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.bg-secondary {
    background: linear-gradient(135deg, #868e96 0%, #495057 100%);
    color: white;
}

.dest-card-v3-page .dest-badge.bg-primary {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
}

/* Content */
.dest-card-v3-page .dest-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    z-index: 2;
    color: white;
}

.dest-card-v3-page .dest-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.dest-card-v3-page .dest-rating .stars {
    color: #ffc107;
    font-size: 0.9rem;
    letter-spacing: 2px;
}

.dest-card-v3-page .dest-rating .count {
    background: rgba(255,255,255,0.2);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.dest-card-v3-page .dest-title {
    font-size: 1.4rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: white;
}

.dest-card-v3-page .dest-desc {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 12px;
    line-height: 1.5;
}

.dest-card-v3-page .dest-meta {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    opacity: 0.8;
}

.dest-card-v3-page .dest-meta i {
    margin-right: 5px;
}

/* Explore Button */
.dest-card-v3-page .dest-explore {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.95);
    color: var(--primary, #C7805C);
    padding: 10px 18px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 2;
}

.dest-card-v3-page:hover .dest-explore {
    opacity: 1;
    transform: translateX(0);
}

.dest-card-v3-page .dest-explore i {
    transition: transform 0.3s ease;
}

.dest-card-v3-page:hover .dest-explore i {
    transform: translateX(5px);
}

/* No Results */
.no-results-v3 {
    padding: 60px 20px;
}

.no-results-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-results-v3 h4 {
    color: #1a1a2e;
    margin-bottom: 10px;
}

/* CTA Section */
.cta-card-destinations {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 50px;
    border-radius: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.cta-card-destinations::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(199, 128, 92, 0.3) 0%, transparent 70%);
    border-radius: 50%;
}

.cta-content {
    position: relative;
    z-index: 1;
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
    margin-bottom: 0;
    font-size: 1.05rem;
}

.btn-cta-v3 {
    display: inline-flex;
    align-items: center;
    padding: 16px 32px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
}

.btn-cta-v3:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.5);
    color: white;
}

/* Responsive */
@media (max-width: 991px) {
    .cta-card-destinations {
        padding: 35px;
        text-align: center;
    }
    
    .cta-content h3 {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .dest-card-v3-page {
        height: 320px;
    }
    
    .dest-card-v3-page .dest-content {
        padding: 20px;
    }
    
    .dest-card-v3-page .dest-title {
        font-size: 1.2rem;
    }
    
    .dest-card-v3-page .dest-explore {
        display: none;
    }
}

@media (max-width: 576px) {
    .dest-card-v3-page {
        height: 300px;
    }
    
    .section-title-v3 {
        font-size: 1.6rem;
    }
    
    .cta-card-destinations {
        padding: 25px;
    }
    
    .btn-cta-v3 {
        width: 100%;
        justify-content: center;
    }
}

/* Utility */
.py-6 {
    padding-top: 5rem;
    padding-bottom: 5rem;
}
</style>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
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
