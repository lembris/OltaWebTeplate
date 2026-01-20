<!-- ============================================
     BOOKING CTA SECTION - Links to Real Booking System
     ============================================ -->
<section class="booking-cta-section py-6" id="booking">
    <div class="container">
        <div class="booking-cta-wrapper" data-aos="fade-up">
            <div class="row align-items-center g-5">
                <!-- Left Content -->
                <div class="col-lg-6">
                    <span class="section-tag">📅 BOOK YOUR SAFARI</span>
                    <h2 class="booking-cta-title">
                        Ready to Start Your <span class="text-gradient">Safari Adventure?</span>
                    </h2>
                    <p class="booking-cta-desc">
                        Book your dream African safari in just a few minutes. Select your package, choose your dates, and secure your spot with our easy online booking system.
                    </p>
                    
                    <!-- Features -->
                    <div class="booking-features-grid">
                        <div class="booking-feature">
                            <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                            <div class="feature-text">
                                <strong>Real-Time Availability</strong>
                                <span>Check dates instantly</span>
                            </div>
                        </div>
                        <div class="booking-feature">
                            <div class="feature-icon"><i class="bi bi-calculator"></i></div>
                            <div class="feature-text">
                                <strong>Instant Pricing</strong>
                                <span>See total cost upfront</span>
                            </div>
                        </div>
                        <div class="booking-feature">
                            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="feature-text">
                                <strong>Secure Booking</strong>
                                <span>100% safe & protected</span>
                            </div>
                        </div>
                        <div class="booking-feature">
                            <div class="feature-icon"><i class="bi bi-calendar-x"></i></div>
                            <div class="feature-text">
                                <strong>Free Cancellation</strong>
                                <span>Up to 30 days before</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="booking-cta-buttons">
                        <a href="<?php echo base_url('booking'); ?>" class="btn-book-now-main">
                            <i class="bi bi-calendar-plus me-2"></i>
                            <span>Book Online Now</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20I'd%20like%20to%20book%20a%20safari" class="btn-whatsapp-book" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>
                            <span>Book via WhatsApp</span>
                        </a>
                    </div>
                    
                    <p class="booking-note">
                        <i class="bi bi-info-circle me-1"></i>
                        Need help? Call us at <a href="tel:<?php echo $consult_number_call; ?>"><?php echo !empty($phone_number) ? $phone_number : '+255 787 033 777'; ?></a>
                    </p>
                </div>
                
                <!-- Right Side - Booking Preview Card -->
                <div class="col-lg-6">
                    <div class="booking-preview-card" data-aos="fade-left" data-aos-delay="200">
                        <div class="preview-header">
                            <span class="preview-badge"><i class="bi bi-lightning-fill"></i> Quick Book</span>
                            <h3>Start Your Booking</h3>
                        </div>
                        
                        <div class="preview-packages">
                            <p class="preview-label">Popular Packages:</p>
                            <div class="package-quick-links">
                                <a href="<?php echo base_url('booking?package=serengeti'); ?>" class="package-quick-link">
                                    <span class="pkg-icon">🦁</span>
                                    <span class="pkg-name">Serengeti Safari</span>
                                    <span class="pkg-price">From $2,499</span>
                                </a>
                                <a href="<?php echo base_url('booking?package=kilimanjaro'); ?>" class="package-quick-link">
                                    <span class="pkg-icon">🏔️</span>
                                    <span class="pkg-name">Kilimanjaro Trek</span>
                                    <span class="pkg-price">From $1,899</span>
                                </a>
                                <a href="<?php echo base_url('booking?package=zanzibar'); ?>" class="package-quick-link">
                                    <span class="pkg-icon">🏖️</span>
                                    <span class="pkg-name">Zanzibar Escape</span>
                                    <span class="pkg-price">From $1,299</span>
                                </a>
                                <a href="<?php echo base_url('booking?package=ngorongoro'); ?>" class="package-quick-link">
                                    <span class="pkg-icon">🦏</span>
                                    <span class="pkg-name">Ngorongoro Crater</span>
                                    <span class="pkg-price">From $1,599</span>
                                </a>
                            </div>
                        </div>
                        
                        <div class="preview-footer">
                            <a href="<?php echo base_url('booking'); ?>" class="btn-view-all-packages">
                                View All Packages & Book
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="preview-trust">
                            <div class="trust-item">
                                <i class="bi bi-star-fill text-warning"></i>
                                <span>4.9/5 Rating</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-people-fill text-primary"></i>
                                <span>500+ Travelers</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-patch-check-fill text-success"></i>
                                <span>Verified</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ BOOKING CTA SECTION ============ */
.booking-cta-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    position: relative;
    overflow: hidden;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.booking-cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 20px 20px;
    opacity: 0.03;
}

.booking-cta-wrapper {
    position: relative;
    z-index: 1;
}

.booking-cta-section .section-tag {
    background: rgba(255,255,255,0.1);
    color: #ffc107;
    display: inline-block;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.booking-cta-title {
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
    line-height: 1.2;
}

.booking-cta-title .text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}

.booking-cta-desc {
    color: rgba(255,255,255,0.8);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

/* Features Grid */
.booking-features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 35px;
}

.booking-feature {
    display: flex;
    align-items: center;
    gap: 15px;
}

.booking-feature .feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.booking-feature .feature-icon i {
    color: white !important;
}

.booking-feature .feature-text {
    display: flex;
    flex-direction: column;
}

.booking-feature .feature-text strong {
    color: white;
    font-size: 0.95rem;
    font-weight: 600;
}

.booking-feature .feature-text span {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
}

/* CTA Buttons */
.booking-cta-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.btn-book-now-main {
    display: inline-flex;
    align-items: center;
    padding: 18px 32px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
}

.btn-book-now-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.5);
    color: white;
}

.btn-whatsapp-book {
    display: inline-flex;
    align-items: center;
    padding: 18px 28px;
    background: #25D366;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-whatsapp-book:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
    color: white;
}

.booking-note {
    color: rgba(255,255,255,0.7);
    font-size: 0.95rem;
    margin: 0;
}

.booking-note a {
    color: #ffc107;
    text-decoration: none;
    font-weight: 600;
}

.booking-note a:hover {
    text-decoration: underline;
}

/* Preview Card */
.booking-preview-card {
    background: white;
    border-radius: 24px;
    padding: 35px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.preview-header {
    text-align: center;
    margin-bottom: 25px;
}

.preview-badge {
    display: inline-block;
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: #1a1a2e;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.preview-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
}

.preview-packages {
    margin-bottom: 25px;
}

.preview-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 600;
    margin-bottom: 15px;
}

.package-quick-links {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.package-quick-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.package-quick-link:hover {
    background: #fdf5f0;
    border-color: var(--theme-primary, #C7805C);
    transform: translateX(5px);
}

.package-quick-link .pkg-icon {
    font-size: 1.5rem;
}

.package-quick-link .pkg-name {
    flex: 1;
    font-weight: 600;
    color: #1a1a2e;
}

.package-quick-link .pkg-price {
    font-size: 0.9rem;
    color: var(--theme-primary, #C7805C);
    font-weight: 700;
}

.preview-footer {
    margin-bottom: 20px;
}

.btn-view-all-packages {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-view-all-packages:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26, 26, 46, 0.4);
    color: white;
}

.preview-trust {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #666;
}

.trust-item i {
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 991px) {
    .booking-features-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .booking-preview-card {
        margin-top: 20px;
    }
}

@media (max-width: 576px) {
    .booking-features-grid {
        grid-template-columns: 1fr;
    }
    
    .booking-cta-buttons {
        flex-direction: column;
    }
    
    .btn-book-now-main,
    .btn-whatsapp-book {
        width: 100%;
        justify-content: center;
    }
    
    .preview-trust {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .booking-preview-card {
        padding: 25px;
    }
}
</style>
