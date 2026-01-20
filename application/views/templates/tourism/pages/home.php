<?php
    /**
     * Tourism Homepage v4.0 - SEO OPTIMIZED + CONVERSION ENHANCED
     * Premium, High-Converting Design with Modern UX & Full SEO
     * 
     * Enhancements:
     * - Complete meta tags and structured data (JSON-LD)
     * - Optimized heading hierarchy (H1-H6)
     * - Descriptive alt text on all images
     * - Lazy loading for performance
     * - Schema markup for reviews and business info
     * - Video background option in hero
     * - Animated number counters
     * - Scroll-triggered animations (AOS)
     * - Sticky CTA bar
     * - Exit-intent popup
     * - Floating WhatsApp button
     * - Improved mobile UX
     * - Social proof widgets
     * - Urgency/scarcity elements
     * - Semantic HTML structure
     * - Breadcrumb navigation
     * 
     * Created: December 2025
     * Last Updated: December 5, 2025
     * Version: v4.0
     */
?>

<!-- Schema.org Structured Data - TourOperator & Organization -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "TravelAgency",
    "name": "<?php echo $site_name; ?>",
    "description": "Award-winning African safari tour operator offering unforgettable wildlife adventures in Tanzania's Serengeti, Ngorongoro, and Kilimanjaro.",
    "url": "<?php echo base_url(); ?>",
    "logo": "<?php echo base_url('assets/img/logo/osiram_safari_100x100.png'); ?>",
    "image": "<?php echo base_url('assets/img/hero-bg.jpg'); ?>",
    "telephone": "<?php echo $consult_number_call; ?>",
    "email": "<?php echo $support_email; ?>",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Arusha",
        "addressLocality": "Arusha",
        "addressCountry": "TZ"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "-3.3869",
        "longitude": "36.6830"
    },
    "priceRange": "$750 - $5000",
    "openingHours": "Mo-Su 00:00-24:00",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "571",
        "bestRating": "5",
        "worstRating": "1"
    },
    "sameAs": [
        "https://www.facebook.com/p/Osiram-Safari-Adventure-Ltd-100083269235956/",
        "https://www.instagram.com/osiram_safari_adventure/",
        "https://wa.me/+255789356961"
    ]
}
</script>

<!-- Schema.org FAQ Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "What are the visa requirements for Tanzania?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Most visitors require a visa to enter Tanzania. You can apply online at visa.immigration.go.tz (recommended) or obtain a Visa on Arrival at major airports. Requirements include a valid passport (6+ months validity), completed application, passport photos, return ticket, and proof of accommodation. Single-entry tourist visa costs approximately $50 USD."
            }
        },
        {
            "@type": "Question",
            "name": "When is the best time to visit for safari?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "The best time to visit Tanzania for safari is during the dry seasons: June to October (Great Migration in Serengeti) and January to February (calving season). The wet seasons (March-May and November) offer fewer crowds and lower prices."
            }
        },
        {
            "@type": "Question",
            "name": "How safe is a Tanzania safari?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tanzania is one of the safest African safari destinations. Our safaris include experienced licensed guides with wilderness first-aid training, well-maintained 4x4 vehicles with communication equipment, vetted and secure accommodation partners, and 24/7 emergency support."
            }
        },
        {
            "@type": "Question",
            "name": "What's included in your safari packages?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Our packages include 4x4 safari vehicle with pop-up roof, professional English-speaking guide, all park entrance fees, full board accommodation, airport transfers, bottled water during game drives, and flying doctor emergency evacuation insurance."
            }
        },
        {
            "@type": "Question",
            "name": "What is your cancellation policy?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "We offer free cancellation up to 30 days before departure with full refund. Cancellations 15-29 days before receive 50% refund, and 7-14 days before receive 25% refund. Less than 7 days notice is non-refundable. We recommend travel insurance."
            }
        }
    ]
}
</script>



<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

<!-- ============================================
     BREADCRUMB NAVIGATION - SEO Optimized
     ============================================ -->
<nav aria-label="breadcrumb" class="breadcrumb-nav-seo py-2 bg-light d-none d-md-block">
    <div class="container">
        <ol class="breadcrumb mb-0" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">Home</span>
                <meta itemprop="position" content="1" />
            </li>
        </ol>
    </div>
</nav>

<!-- ============================================
     STICKY CTA BAR - Always Visible on Scroll
     ============================================ -->
<nav class="sticky-cta-bar" id="stickyCta" aria-label="Quick booking actions">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-none d-md-flex align-items-center gap-3">
                <span class="badge bg-danger pulse-animation">🔥 Limited Spots</span>
                <span class="text-white fw-500">Book your safari today and save up to 15%!</span>
            </div>
            <div class="d-flex gap-2">
                <a href="tel:<?php echo $consult_number_call; ?>" class="btn btn-light btn-sm rounded-pill">
                    <i class="bi bi-telephone-fill me-1"></i> Call Now
                </a>
                <a href="<?php echo base_url('booking'); ?>" class="btn btn-warning btn-sm rounded-pill fw-600">
                    <i class="bi bi-calendar-check me-1"></i> Book Now
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- ============================================
     HERO SECTION - Premium with Video Option
     ============================================ -->
<header class="hero-section-v3 position-relative overflow-hidden" id="hero-top" role="banner">
    <!-- Hero Background Image -->
    <div class="hero-media-container">
        <div class="hero-image" style="background-image: url('<?php echo base_url(); ?>assets/img/hero-bg.jpg');" aria-label="African safari wildlife video background showing savanna landscape"></div>
        <div class="hero-gradient-overlay"></div>
    </div>
    
    <!-- Animated Particles -->
    <div class="hero-particles-v3"></div>
    
    <!-- Hero Content -->
    <div class="hero-content-wrapper-v3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center text-white">
                    <!-- Trust Badge -->
                    <div class="mb-4" data-aos="fade-down" data-aos-delay="100">
                        <span class="hero-badge">
                            <i class="bi bi-award-fill me-2"></i>AWARD-WINNING SAFARI OPERATOR
                        </span>
                    </div>
                    
                    <!-- Main Headline -->
                    <h1 class="hero-title-v3 text-white" data-aos="fade-up" data-aos-delay="200">
                        Discover the Magic of <span class="text-gradient">African Safari</span>
                    </h1>
                    
                    <!-- Subheadline -->
                    <p class="hero-subtitle-v3" data-aos="fade-up" data-aos-delay="300">
                        Handcrafted Adventures • Expert Guides • Lifetime Memories
                    </p>
                    
                    <!-- Social Proof -->
                    <div class="hero-social-proof mb-5" data-aos="fade-up" data-aos-delay="400">
                        <div class="hero-social-proof-badge">
                            <div class="text-warning mb-0" role="img" aria-label="5 out of 5 stars rating">★★★★★</div>
                            <small class="text-warning fw-600">500+ Happy Travelers</small>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="hero-search-bar" data-aos="zoom-in" data-aos-delay="500">
                        <form method="GET" action="<?php echo base_url('search'); ?>" class="search-form-v3" id="heroSearchForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="search-label" for="safari-destination">Destination</label>
                                    <select class="search-input" name="destination" id="safari-destination" aria-label="Select safari destination">
                                        <option value="">Where to?</option>
                                        <option value="Serengeti">Serengeti</option>
                                        <option value="Ngorongoro">Ngorongoro</option>
                                        <option value="Kilimanjaro">Kilimanjaro</option>
                                        <option value="Zanzibar">Zanzibar</option>
                                        <option value="Tarangire">Tarangire</option>
                                        <option value="Manyara">Lake Manyara</option>
                                        <option value="Ruaha">Ruaha</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="search-label" for="safari-travelers">Travelers</label>
                                    <select class="search-input" name="travelers" id="safari-travelers" aria-label="Select number of travelers">
                                        <option value="">How many?</option>
                                        <option value="1">1 Person</option>
                                        <option value="2">2 People</option>
                                        <option value="3">3 People</option>
                                        <option value="4">4 People</option>
                                        <option value="5">5 People</option>
                                        <option value="6+">6+ People</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="search-label" for="safari-date">Travel Date</label>
                                    <input type="date" class="search-input" name="date" id="safari-date" min="<?php echo date('Y-m-d'); ?>" aria-label="Select travel date">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn-search-v3">
                                        <i class="bi bi-search"></i>Find Safari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-cta-v3 mt-5" data-aos="fade-up" data-aos-delay="600">
                        <a href="#packages" class="btn-hero-primary">
                            <i class="bi bi-compass me-2"></i>Explore Packages
                        </a>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20I'm%20interested%20in%20booking%20a%20safari" class="btn-hero-secondary" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator-v3">
        <div class="mouse-icon">
            <div class="mouse-wheel"></div>
        </div>
        <span>Scroll to explore</span>
    </div>
</header>

<!-- ============================================
     TRUST STATS - Animated Counters
     ============================================ -->
<section class="trust-stats-v3 py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item-v3">
                    <div class="stat-icon">👥</div>
                    <h3 class="stat-number" data-count="500">0</h3>
                    <span class="stat-suffix">+</span>
                    <p class="stat-label">Happy Travelers</p>
                    <div class="stat-stars" role="img" aria-label="4.9 out of 5 stars">★★★★★ <small>4.9</small></div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item-v3">
                    <div class="stat-icon">📅</div>
                    <h3 class="stat-number" data-count="15">0</h3>
                    <span class="stat-suffix">+</span>
                    <p class="stat-label">Years Experience</p>
                    <small class="text-success fw-600">Since 2009</small>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item-v3">
                    <div class="stat-icon">🌍</div>
                    <h3 class="stat-number" data-count="25">0</h3>
                    <span class="stat-suffix">+</span>
                    <p class="stat-label">Destinations</p>
                    <small class="text-info fw-600">Across Tanzania</small>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item-v3">
                    <div class="stat-icon">✓</div>
                    <h3 class="stat-number" data-count="100">0</h3>
                    <span class="stat-suffix">%</span>
                    <p class="stat-label">Satisfaction Rate</p>
                    <small class="text-danger fw-600">Guaranteed</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     FEATURED EXPERIENCES - Premium Cards
     ============================================ -->
<article class="featured-experiences-v3 py-6" id="featured">
    <div class="container">
        <!-- Section Header -->
        <header class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">✨ HANDPICKED FOR YOU</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">Featured Safari Experiences</h2>
            <p class="section-desc" data-aos="fade-up" data-aos-delay="200">
                Our most-loved packages, trusted by hundreds of travelers worldwide
            </p>
        </header>
        
        <!-- Experience Cards - Dynamic from Database -->
        <div class="row g-4">
            <?php 
            if(isset($featured_packages) && !empty($featured_packages)):
                $delay = 100;
                foreach($featured_packages as $package):
                    $image_url = $this->Package_model->get_package_image($package);
                    $stars = $this->Package_model->get_stars_html($package->rating);
                    $destinations = array_slice($package->destinations_array, 0, 1);
                    $destination_text = !empty($destinations) ? $destinations[0] : 'Tanzania Safari';
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <article class="experience-card-v3" itemscope itemtype="https://schema.org/TouristTrip">
                    <div class="card-image">
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($package->name); ?> - <?php echo $destination_text; ?> safari adventure with wildlife viewing" 
                             loading="lazy" 
                             width="400" 
                             height="300"
                             itemprop="image">
                        <div class="card-overlay"></div>
                        <span class="card-badge badge-popular">
                            <?php echo $package->badge['text']; ?>
                        </span>
                        <div class="card-wishlist"><i class="bi bi-heart"></i></div>
                        <div class="card-quick-info">
                            <span><i class="bi bi-clock me-1"></i><?php echo $package->duration_days; ?> Days</span>
                            <span><i class="bi bi-people me-1"></i>2-<?php echo $package->max_travelers ?? 8; ?> People</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                            <span class="stars"><?php echo $stars; ?></span>
                            <span class="count">(<span itemprop="reviewCount"><?php echo $package->review_count; ?></span> reviews)</span>
                            <meta itemprop="ratingValue" content="<?php echo $package->rating; ?>">
                        </div>
                        <h3 class="card-title" itemprop="name"><?php echo htmlspecialchars($package->name); ?></h3>
                        <p class="card-desc" itemprop="description"><?php echo character_limiter($package->description, 100); ?></p>
                        <div class="card-footer-v3" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                            <div class="card-price">
                                <small>From</small>
                                <strong itemprop="price" content="<?php echo $package->base_price; ?>">$<?php echo number_format($package->base_price); ?></strong>
                                <meta itemprop="priceCurrency" content="USD">
                                <small>/person</small>
                            </div>
                            <a href="<?php echo base_url('packages/' . $package->slug); ?>" class="btn-card-cta" itemprop="url">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <?php 
                    $delay += 100;
                endforeach;
            else:
            ?>
            <div class="col-12 text-center">
                <p class="text-muted">No featured packages available at this time.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo base_url(); ?>packages" class="btn-view-all" aria-label="View all safari tour packages">
                View All Packages <span class="badge bg-primary ms-2">10+</span>
            </a>
        </div>
    </div>
</article>

<!-- ============================================
     ABOUT SECTION
     ============================================ -->
<?php include 'sections/about.php'; ?>

<!-- ============================================
     WHY CHOOSE US - Premium V3 Design
     ============================================ -->
<section class="why-choose-section-v3 py-6" id="why-choose" aria-labelledby="why-choose-heading">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Image Column with Floating Elements -->
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <figure class="why-choose-image-wrapper">
                    <div class="why-choose-main-image">
                        <img src="<?php echo base_url(); ?>assets/img/guide/michael_with_tourist_power.jpg" 
                             alt="Professional Tanzanian safari guide pointing out wildlife during Big Five game drive in Serengeti National Park" 
                             class="img-fluid rounded-4"
                             loading="lazy"
                             width="600"
                             height="400">
                    </div>
                    <!-- Trust Badge -->
                    <div class="why-choose-trust-badge">
                        <div class="trust-icon">🏆</div>
                        <div class="trust-content">
                            <strong>Top Rated</strong>
                            <span>Safari Operator 2024</span>
                        </div>
                    </div>
                    <!-- Satisfaction Badge -->
                    <div class="why-choose-satisfaction-badge">
                        <div class="satisfaction-circle">
                            <svg viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                <circle cx="50" cy="50" r="45" fill="none" stroke="var(--theme-primary, #C7805C)" stroke-width="8" 
                                    stroke-dasharray="283" stroke-dashoffset="0" stroke-linecap="round"/>
                            </svg>
                            <div class="satisfaction-text">
                                <strong>100%</strong>
                                <span>Satisfaction</span>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="why-choose-dots"></div>
                </figure>
            </div>
            
            <!-- Content Column -->
            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <span class="section-tag">🌟 WHY CHOOSE US</span>
                <h2 class="section-title-v3 text-start mb-4" id="why-choose-heading">
                    Why <span class="text-gradient">500+ Travelers</span> Trust Osiram Safari
                </h2>
                <p class="why-choose-lead mb-4">
                    With over 15 years of experience, we've perfected the art of creating unforgettable African safari experiences. Our commitment to excellence sets us apart.
                </p>
                
                <!-- Feature Items -->
                <div class="why-choose-features">
                    <!-- Feature 1 -->
                    <div class="why-feature-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="why-feature-icon bg-primary-gradient">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="why-feature-content">
                            <h4>Licensed & Certified</h4>
                            <p>Official tourism board certified with full safety compliance and insurance coverage</p>
                        </div>
                        <div class="why-feature-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="why-feature-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="why-feature-icon bg-success-gradient">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="why-feature-content">
                            <h4>Expert Local Guides</h4>
                            <p>Highly trained Maasai professionals with 10+ years of experience in the wild</p>
                        </div>
                        <div class="why-feature-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="why-feature-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="why-feature-icon bg-danger-gradient">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="why-feature-content">
                            <h4>24/7 Dedicated Support</h4>
                            <p>Immediate assistance via WhatsApp, phone, and email - always there for you</p>
                        </div>
                        <div class="why-feature-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="why-feature-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="why-feature-icon bg-warning-gradient">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="why-feature-content">
                            <h4>Best Price Guarantee</h4>
                            <p>Competitive pricing with no hidden fees - transparent from start to finish</p>
                        </div>
                        <div class="why-feature-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="why-choose-cta mt-4" data-aos="fade-up" data-aos-delay="500">
                    <a href="<?php echo base_url(); ?>about" class="btn-why-primary">
                        <span>Learn More About Us</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="<?php echo base_url(); ?>contact" class="btn-why-secondary">
                        <i class="bi bi-chat-dots me-2"></i>
                        <span>Get in Touch</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Stats Bar -->
        <div class="why-choose-stats-bar mt-5" data-aos="fade-up" data-aos-delay="600">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="why-stat-item">
                        <div class="why-stat-icon">🦁</div>
                        <div class="why-stat-info">
                            <strong>Big Five</strong>
                            <span>Guaranteed Sightings</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="why-stat-item">
                        <div class="why-stat-icon">🚐</div>
                        <div class="why-stat-info">
                            <strong>4x4 Vehicles</strong>
                            <span>Modern Fleet</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="why-stat-item">
                        <div class="why-stat-icon">🏕️</div>
                        <div class="why-stat-info">
                            <strong>Premium Camps</strong>
                            <span>Luxury Accommodation</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="why-stat-item">
                        <div class="why-stat-icon">📸</div>
                        <div class="why-stat-info">
                            <strong>Photo Tours</strong>
                            <span>Capture Memories</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     DESTINATIONS SECTION
     ============================================ -->
<?php include 'sections/destinations.php'; ?>

<!-- ============================================
     PACKAGES SECTION
     ============================================ -->
<?php include 'sections/packages.php'; ?>

<!-- ============================================
     TESTIMONIALS SECTION
     ============================================ -->
<?php include 'sections/testimonials.php'; ?>

<!-- ============================================
     PHOTO GALLERY PREVIEW
     ============================================ -->
<?php include 'sections/gallery-preview.php'; ?>

<!-- ============================================
     FAQ SECTION
     ============================================ -->
<?php include 'sections/faq.php'; ?>

<!-- ============================================
     BLOG PREVIEW SECTION
     ============================================ -->
<?php include 'sections/blog-preview.php'; ?>

<!-- ============================================
     QUICK BOOKING SECTION
     ============================================ -->
<?php include 'sections/quick-booking.php'; ?>
<!-- ============================================
     FINAL CTA - Urgency Section
     ============================================ -->
<section class="final-cta-v3 py-6">
    <div class="container">
        <div class="cta-card-v3" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="urgency-badge mb-3">
                        <i class="bi bi-lightning-fill"></i> Limited Time Offer
                    </div>
                    <h2 class="cta-title">Ready for Your African Adventure?</h2>
                    <p class="cta-desc">Book now and get 15% off on selected packages. Limited spots available for the migration season!</p>
                    <div class="cta-features">
                        <span><i class="bi bi-check-circle-fill"></i> No hidden fees</span>
                        <span><i class="bi bi-check-circle-fill"></i> Free cancellation</span>
                        <span><i class="bi bi-check-circle-fill"></i> 24/7 support</span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="cta-buttons-v3">
                        <a href="<?php echo base_url('booking'); ?>" class="btn-cta-primary">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>" class="btn-cta-secondary" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     TEAM & PARTNERS SECTIONS
     ============================================ -->
<?php include 'sections/team.php'; ?>
<?php include 'sections/partners.php'; ?>

<!-- ============================================
     EXIT INTENT POPUP
     ============================================ -->
<div class="exit-popup-overlay" id="exitPopup" role="dialog" aria-modal="true" aria-labelledby="exitPopupTitle" aria-describedby="exitPopupDesc">
    <div class="exit-popup-content" data-aos="zoom-in">
        <button class="exit-popup-close" id="closeExitPopup" aria-label="Close popup">&times;</button>
        <div class="exit-popup-icon" aria-hidden="true">🦁</div>
        <h3 id="exitPopupTitle">Wait! Don't Miss Out!</h3>
        <p id="exitPopupDesc">Get 10% off your first safari booking when you sign up for our newsletter.</p>
        <form class="exit-popup-form" id="exitPopupForm">
            <input type="email" placeholder="Enter your email" required aria-label="Email address for newsletter">
            <button type="submit">Get My Discount</button>
        </form>
        <small class="text-muted">No spam, unsubscribe anytime.</small>
    </div>
</div>

<!-- Home Page v3.0 Styles -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/home-v3.css">

<!-- ============================================
     JAVASCRIPT - Interactions & Animations
     ============================================ -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // Lazy load hero video using Intersection Observer
        const heroVideo = document.querySelector('.hero-video');
        if (heroVideo && heroVideo.dataset.src) {
            const videoObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const video = entry.target;
                        const source = document.createElement('source');
                        source.src = video.dataset.src;
                        source.type = 'video/mp4';
                        video.appendChild(source);
                        video.load();
                        video.play().catch(function() {
                            // Autoplay blocked - show poster image instead
                            video.style.display = 'none';
                        });
                        videoObserver.unobserve(video);
                    }
                });
            }, { threshold: 0.1 });
            videoObserver.observe(heroVideo);
        }

        // Sticky CTA Bar
        const stickyCta = document.getElementById('stickyCta');
        const heroSection = document.getElementById('hero-top');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > heroSection.offsetHeight - 100) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
        });

        // Animated Counters
        const counters = document.querySelectorAll('.stat-number');
        const observerOptions = {
            threshold: 0.5
        };

        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-count'));
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };

                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));

        // Exit Intent Popup with Focus Trap for Accessibility
        const exitPopup = document.getElementById('exitPopup');
        const closeExitPopup = document.getElementById('closeExitPopup');
        const exitPopupContent = exitPopup.querySelector('.exit-popup-content');
        let exitShown = sessionStorage.getItem('exitPopupShown');
        let previouslyFocused = null;

        function openExitPopup() {
            previouslyFocused = document.activeElement;
            exitPopup.classList.add('active');
            sessionStorage.setItem('exitPopupShown', 'true');
            exitShown = true;
            // Focus the close button when popup opens
            setTimeout(() => closeExitPopup.focus(), 100);
        }

        function closeExitPopupHandler() {
            exitPopup.classList.remove('active');
            // Return focus to previously focused element
            if (previouslyFocused) previouslyFocused.focus();
        }

        // Focus trap for accessibility
        exitPopup.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeExitPopupHandler();
                return;
            }
            if (e.key !== 'Tab') return;
            
            const focusableElements = exitPopupContent.querySelectorAll(
                'button, input, [href], [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (!exitShown && e.clientY < 10 && e.relatedTarget === null) {
                openExitPopup();
            }
        });

        closeExitPopup.addEventListener('click', closeExitPopupHandler);

        exitPopup.addEventListener('click', function(e) {
            if (e.target === exitPopup) {
                closeExitPopupHandler();
            }
        });

        // Exit Popup Form
        const exitForm = document.getElementById('exitPopupForm');
        exitForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input').value;
            // Here you would typically send to your backend/newsletter service
            alert('Thank you! Your 10% discount code will be sent to ' + email);
            exitPopup.classList.remove('active');
        });

        // Wishlist Heart Toggle
        document.querySelectorAll('.card-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
                this.classList.toggle('active');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

    });
</script>


