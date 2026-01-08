<!-- ============================================
     PARTNERS SECTION - V3 Premium Design
     ============================================ -->
<section class="partners-section-v3 py-6" id="partners">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">🤝 TRUSTED BY</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">
                Our <span class="text-gradient">Partners</span> & Certifications
            </h2>
            <p class="section-desc" data-aos="fade-up" data-aos-delay="200">
                Proudly affiliated with leading tourism organizations for responsible travel
            </p>
        </div>
        
        <!-- Partners Logo Grid -->
        <div class="partners-grid-v3" data-aos="fade-up" data-aos-delay="300">
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-1.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-2.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-3.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-4.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-5.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-6.png" alt="Partner Logo">
            </div>
            <div class="partner-item">
                <img src="<?php echo base_url(); ?>assets/img/partners/sutonl-logo-fig-7.png" alt="Partner Logo">
            </div>
        </div>
        
        <!-- Trust Indicators -->
        <div class="partners-trust-bar" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="trust-indicator">
                        <div class="trust-icon">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div class="trust-text">
                            <strong>Licensed</strong>
                            <span>Tourism Operator</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-indicator">
                        <div class="trust-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="trust-text">
                            <strong>Insured</strong>
                            <span>Full Coverage</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-indicator">
                        <div class="trust-icon">
                            <i class="bi bi-tree"></i>
                        </div>
                        <div class="trust-text">
                            <strong>Eco-Friendly</strong>
                            <span>Sustainable Tourism</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-indicator">
                        <div class="trust-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div class="trust-text">
                            <strong>Award Winning</strong>
                            <span>Top Rated 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ PARTNERS SECTION V3 - Premium ============ */
.partners-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    padding-bottom: 0 !important;
    margin-bottom: 0;
}

/* Partners Logo Grid */
.partners-grid-v3 {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 20px;
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    margin-bottom: 40px;
}

.partner-item {
    flex: 0 0 auto;
    padding: 20px 30px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.partner-item:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.partner-item img {
    max-height: 60px;
    max-width: 140px;
    width: auto;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: all 0.3s ease;
}

.partner-item:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

/* Trust Indicators Bar */
.partners-trust-bar {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 40px 50px;
    border-radius: 20px 20px 0 0;
    margin-bottom: 0;
}

.trust-indicator {
    display: flex;
    align-items: center;
    gap: 15px;
}

.trust-icon {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--theme-primary, #C7805C);
    font-size: 1.5rem;
    flex-shrink: 0;
}

.trust-text {
    display: flex;
    flex-direction: column;
}

.trust-text strong {
    color: white;
    font-size: 1rem;
    font-weight: 700;
}

.trust-text span {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 991px) {
    .partners-grid-v3 {
        padding: 30px;
        gap: 15px;
    }
    
    .partner-item {
        padding: 15px 20px;
    }
    
    .partner-item img {
        max-height: 50px;
        max-width: 120px;
    }
    
    .partners-trust-bar {
        padding: 30px;
    }
}

@media (max-width: 576px) {
    .partners-grid-v3 {
        padding: 20px;
    }
    
    .partner-item {
        padding: 12px 15px;
    }
    
    .partner-item img {
        max-height: 40px;
        max-width: 100px;
    }
    
    .trust-indicator {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .trust-icon {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
}
</style>
