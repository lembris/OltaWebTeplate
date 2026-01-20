<?php
/**
 * Tourism Homepage Redesign v2
 * Modern, Client-Attractive Design
 * Follows Tourism Industry Standards
 * 
 * Created: December 2024
 * Status: Enhanced Version with Modern Tourism Standards
 */
?>

<!-- ============================================
     HERO SECTION - Premium Full-Screen Display
     ============================================ -->
<section class="hero-section-premium position-relative overflow-hidden" id="hero-top">
    <!-- Background Carousel -->
    <div class="hero-carousel" id="heroCarousel" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('<?php echo base_url(); ?>assets/img/hero-bg.jpg') center/cover;">
        <!-- Multiple background images would rotate here -->
    </div>
    
    <!-- Hero Content Overlay -->
    <div class="hero-content-wrapper d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
            <!-- Main Tagline -->
            <div class="hero-content-inner">
                <h1 class="hero-title display-2 fw-bold mb-3 animated fadeInDown">
                    Unforgettable African Experiences
                </h1>
                <p class="hero-subtitle fs-5 mb-4 animated fadeInUp">
                    Handcrafted Safari Adventures, Authentic Encounters, Lifetime Memories
                </p>
                
                <!-- Advanced Search/Booking Bar -->
                <div class="search-bar-container mt-5 animated fadeInUp">
                    <div class="search-bar-modern p-4 bg-white rounded-3" style="max-width: 700px; margin: 0 auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                        <form method="GET" action="<?php echo base_url(); ?>booking" class="search-form">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-lg border-0" placeholder="Destination" name="destination" style="background: #f5f5f5;">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-lg border-0" name="duration" style="background: #f5f5f5;">
                                        <option selected>Duration</option>
                                        <option value="3">3 Days</option>
                                        <option value="5">5 Days</option>
                                        <option value="7">7 Days</option>
                                        <option value="10">10+ Days</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control form-control-lg border-0" name="date" style="background: #f5f5f5;">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-2" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); border: none;">
                                        <i class="bi bi-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="hero-cta-buttons mt-5">
                    <a href="#packages" class="btn btn-lg btn-primary rounded-pill px-5 me-3 animated slideInLeft">
                        Explore Packages
                    </a>
                    <a href="<?php echo base_url(); ?>contact#contact" class="btn btn-lg btn-outline-light rounded-pill px-5 animated slideInRight">
                        Get Consultation
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator position-absolute bottom-3 start-50 translate-middle-x">
        <i class="bi bi-chevron-down text-white fs-4 animate-bounce"></i>
    </div>
</section>

<!-- ============================================
     TRUST & CREDIBILITY SECTION
     ============================================ -->
<section class="trust-stats-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h3 class="text-primary fs-2 fw-bold">500+</h3>
                    <p class="text-muted mb-0">Happy Travelers</p>
                    <small class="text-success">⭐ 4.8/5 Rating</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h3 class="text-primary fs-2 fw-bold">15+</h3>
                    <p class="text-muted mb-0">Years Experience</p>
                    <small class="text-success">✓ Since 2009</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h3 class="text-primary fs-2 fw-bold">24/7</h3>
                    <p class="text-muted mb-0">Professional Support</p>
                    <small class="text-success">✓ Always Available</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h3 class="text-primary fs-2 fw-bold">100%</h3>
                    <p class="text-muted mb-0">Safe & Certified</p>
                    <small class="text-success">✓ Licensed Operator</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     FEATURED EXPERIENCES SECTION
     ============================================ -->
<section class="featured-experiences py-5" id="featured">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Safari Experiences</h2>
            <p class="fs-5 text-muted" style="max-width: 600px; margin: 0 auto;">
                Discover our handpicked selection of premium safari packages designed for unforgettable adventures
            </p>
        </div>
        
        <div class="row g-4">
            <!-- Experience Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="experience-card rounded-3 overflow-hidden shadow-lg transition-transform" style="transform: translateY(0); transition: all 0.3s ease;">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="<?php echo base_url(); ?>assets/img/serengeti.jpg" alt="Serengeti" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(13,110,253,0.6) 0%, rgba(220,53,69,0.6) 100%); opacity: 0; transition: opacity 0.3s;" class="hover-overlay"></div>
                        <span class="badge bg-danger position-absolute top-3 end-3">Popular</span>
                    </div>
                    <div class="p-4">
                        <h3 class="mb-2 fs-5 fw-bold">Serengeti Safari Adventure</h3>
                        <div class="rating mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <span class="text-muted ms-2">(245 reviews)</span>
                        </div>
                        <p class="text-muted small mb-3">Experience the great wildebeest migration and witness nature's most spectacular event</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-info">7 Days</span>
                            <span class="text-danger fw-bold">$2,499</span>
                        </div>
                        <button class="btn btn-primary w-100 rounded-2">Quick View</button>
                        <a href="#booking" class="btn btn-outline-primary w-100 rounded-2 mt-2">Book Now</a>
                    </div>
                </div>
            </div>
            
            <!-- Experience Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="experience-card rounded-3 overflow-hidden shadow-lg transition-transform">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="<?php echo base_url(); ?>assets/img/kilimanjaro.jpg" alt="Kilimanjaro" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                        <span class="badge bg-success position-absolute top-3 end-3">Adventure</span>
                    </div>
                    <div class="p-4">
                        <h3 class="mb-2 fs-5 fw-bold">Mount Kilimanjaro Trek</h3>
                        <div class="rating mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                            <span class="text-muted ms-2">(189 reviews)</span>
                        </div>
                        <p class="text-muted small mb-3">Climb Africa's highest peak and stand atop the world at 5,895m above sea level</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-warning text-dark">5 Days</span>
                            <span class="text-danger fw-bold">$1,899</span>
                        </div>
                        <button class="btn btn-primary w-100 rounded-2">Quick View</button>
                        <a href="#booking" class="btn btn-outline-primary w-100 rounded-2 mt-2">Book Now</a>
                    </div>
                </div>
            </div>
            
            <!-- Experience Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="experience-card rounded-3 overflow-hidden shadow-lg transition-transform">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="<?php echo base_url(); ?>assets/img/zanzibar.jpg" alt="Zanzibar" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                        <span class="badge bg-info position-absolute top-3 end-3">Beach</span>
                    </div>
                    <div class="p-4">
                        <h3 class="mb-2 fs-5 fw-bold">Zanzibar Paradise Escape</h3>
                        <div class="rating mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <span class="text-muted ms-2">(312 reviews)</span>
                        </div>
                        <p class="text-muted small mb-3">Relax on pristine beaches, explore coral reefs, and immerse in rich Swahili culture</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-success">4 Days</span>
                            <span class="text-danger fw-bold">$1,299</span>
                        </div>
                        <button class="btn btn-primary w-100 rounded-2">Quick View</button>
                        <a href="#booking" class="btn btn-outline-primary w-100 rounded-2 mt-2">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     ABOUT SECTION - Enhanced
     ============================================ -->
<?php include 'sections/about.php'; ?>

<!-- ============================================
     WHY CHOOSE US - Trust Indicators
     ============================================ -->
<section class="why-choose-us py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Why Choose Osiram Safari Adventure</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-shield-check text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">100% Licensed & Certified</h4>
                        <p class="text-muted">Tanzania's official tourism board certified operator with full safety compliance</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #198754, #157347); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-people-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">Expert Guides & Drivers</h4>
                        <p class="text-muted">Highly trained professionals with 10+ years of wildlife and hospitality experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-chat-dots-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">24/7 Customer Support</h4>
                        <p class="text-muted">Immediate assistance via WhatsApp, phone, and email at any time during your journey</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ffc107, #ffb300); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-hand-thumbs-up-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">Satisfaction Guarantee</h4>
                        <p class="text-muted">Money-back guarantee if you're not satisfied with any aspect of your tour</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #17a2b8, #138496); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-tree-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">Sustainable Tourism</h4>
                        <p class="text-muted">Committed to conservation and supporting local communities in Tanzania</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-item d-flex gap-3 mb-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #6f42c1, #5a32a3); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-gift-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-2">Customizable Packages</h4>
                        <p class="text-muted">Tailor-made itineraries designed to match your budget, interests, and timeline</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     DESTINATIONS GRID - Enhanced
     ============================================ -->
<?php include 'sections/destinations.php'; ?>

<!-- ============================================
     PACKAGES SECTION - Enhanced
     ============================================ -->
<?php include 'sections/packages.php'; ?>

<!-- ============================================
     QUICK BOOKING SECTION
     ============================================ -->
<?php include 'sections/quick-booking.php'; ?>

<!-- ============================================
     TESTIMONIALS - Social Proof
     ============================================ -->
<?php include 'sections/testimonials.php'; ?>

<!-- ============================================
     CTA SECTION - Final Conversion
     ============================================ -->
<section class="final-cta-section py-5" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);">
    <div class="container text-center text-white">
        <h2 class="display-4 fw-bold mb-3">Ready to Start Your Safari Adventure?</h2>
        <p class="fs-5 mb-5">Join 500+ travelers who've experienced the magic of African safaris with Osiram</p>
        <a href="<?php echo base_url(); ?>contact#contact" class="btn btn-light btn-lg px-5 rounded-pill me-3">
            Get Free Consultation
        </a>
        <a href="<?php echo base_url(); ?>#booking" class="btn btn-outline-light btn-lg px-5 rounded-pill">
            Browse Packages
        </a>
    </div>
</section>

<!-- ============================================
     TEAM & PARTNERS
     ============================================ -->
<?php include 'sections/team.php'; ?>
<?php include 'sections/partners.php'; ?>

<!-- ============================================
     CSS ANIMATIONS & STYLES
     ============================================ -->
<style>
    /* Hero Section Styles */
    .hero-section-premium {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        margin-top: -120px;
        padding-top: 120px;
    }

    .hero-carousel {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        animation: zoomIn 15s ease-in-out forwards;
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        padding: 0 20px;
    }

    .hero-title {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        font-weight: 800;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
        font-weight: 300;
        letter-spacing: 1px;
    }

    .search-bar-modern {
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        backdrop-filter: blur(10px);
    }

    .search-bar-modern input,
    .search-bar-modern select {
        border: none !important;
        background: #f5f5f5 !important;
        padding: 15px 20px !important;
        font-weight: 500;
    }

    .search-bar-modern input:focus,
    .search-bar-modern select:focus {
        background: white !important;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1) !important;
    }

    .scroll-indicator {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(10px); }
    }

    @keyframes zoomIn {
        from { transform: scale(1.05); }
        to { transform: scale(1); }
    }

    /* Experience Card Styles */
    .experience-card {
        background: white;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .experience-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important;
    }

    .experience-card:hover .hover-overlay {
        opacity: 1 !important;
    }

    .experience-card .badge {
        font-weight: 600;
        padding: 8px 12px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rating {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    /* Trust Stats Section */
    .stat-card {
        background: white;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .stat-card h3 {
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    /* Feature Items */
    .feature-item {
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateX(10px);
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border: none;
        transition: all 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
    }

    .btn-outline-primary {
        border: 2px solid #0d6efd;
        color: #0d6efd;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background: #0d6efd;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .search-bar-modern {
            padding: 2rem 1rem !important;
        }

        .search-bar-modern .row {
            flex-direction: column;
        }

        .hero-cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hero-cta-buttons .btn {
            width: 100%;
        }
    }

    /* Animations */
    .animated {
        animation-duration: 1s;
    }

    .fadeInDown {
        animation: fadeInDown 1s ease-out;
    }

    .fadeInUp {
        animation: fadeInUp 1s ease-out;
    }

    .slideInLeft {
        animation: slideInLeft 1s ease-out;
    }

    .slideInRight {
        animation: slideInRight 1s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
