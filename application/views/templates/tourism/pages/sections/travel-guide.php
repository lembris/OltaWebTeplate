<!-- ============================================
     TRAVEL GUIDE SECTION - V3 Premium Design
     ============================================ -->
<section class="travel-guide-section-v3 py-6 p-5" id="travel-guide">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <span class="section-tag">🗺️ TRAVEL GUIDE</span>
                <h2 class="section-title-v3">
                    Tanzania <span class="text-gradient">Travel Guide</span>
                </h2>
                <p class="section-subtitle mx-auto">
                    Everything you need to know for your perfect Tanzanian adventure
                </p>
            </div>
        </div>
        
        <!-- Guide Cards -->
        <div class="row g-4">
            <!-- Weather Card -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <a href="<?php echo base_url(); ?>guide/weather" class="guide-link-card">
                    <div class="guide-card-v3">
                        <div class="guide-icon-wrapper">
                            <div class="guide-icon weather">
                                🌤️
                            </div>
                        </div>
                        <h4>Weather</h4>
                        <p>Discover Tanzania's diverse climate patterns and find the perfect time to visit for your dream safari.</p>
                        <span class="guide-link">
                            Learn More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Food Card -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo base_url(); ?>guide/food" class="guide-link-card">
                    <div class="guide-card-v3">
                        <div class="guide-icon-wrapper">
                            <div class="guide-icon food">
                                🍽️
                            </div>
                        </div>
                        <h4>Food</h4>
                        <p>Savor the flavors of East Africa with authentic dishes like ugali, nyama choma, and aromatic pilau.</p>
                        <span class="guide-link">
                            Learn More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Cost Card -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo base_url(); ?>guide/cost" class="guide-link-card">
                    <div class="guide-card-v3">
                        <div class="guide-icon-wrapper">
                            <div class="guide-icon cost">
                                💰
                            </div>
                        </div>
                        <h4>Cost</h4>
                        <p>From budget camping to luxury lodges, find safari options that match your travel budget.</p>
                        <span class="guide-link">
                            Learn More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Visa Card -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <a href="<?php echo base_url(); ?>guide/visa" class="guide-link-card">
                    <div class="guide-card-v3">
                        <div class="guide-icon-wrapper">
                            <div class="guide-icon visa">
                                📋
                            </div>
                        </div>
                        <h4>Visa</h4>
                        <p>Essential visa information and requirements for a smooth entry into Tanzania.</p>
                        <span class="guide-link">
                            Learn More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ TRAVEL GUIDE SECTION V3 ============ */
.travel-guide-section-v3 {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    position: relative;
    overflow: hidden;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 500px;
}

/* Guide Link Card */
.guide-link-card {
    text-decoration: none;
    display: block;
    height: 100%;
}

/* Guide Cards */
.guide-card-v3 {
    background: white;
    padding: 35px 30px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.guide-card-v3::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--theme-primary, #C7805C), var(--primary-dark, #a86a4a));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.guide-card-v3:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.guide-card-v3:hover::before {
    transform: scaleX(1);
}

/* Icon Wrapper */
.guide-icon-wrapper {
    margin-bottom: 25px;
}

.guide-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2.5rem;
    transition: all 0.3s ease;
}

.guide-icon.weather {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    box-shadow: 0 10px 30px rgba(251,191,36,0.3);
}

.guide-icon.food {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    box-shadow: 0 10px 30px rgba(34,197,94,0.3);
}

.guide-icon.cost {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    box-shadow: 0 10px 30px rgba(59,130,246,0.3);
}

.guide-icon.visa {
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    box-shadow: 0 10px 30px rgba(168,85,247,0.3);
}

.guide-card-v3:hover .guide-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Card Content */
.guide-card-v3 h4 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 15px;
}

.guide-card-v3 p {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

/* Guide Link */
.guide-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--theme-primary, #C7805C);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.guide-link i {
    transition: transform 0.3s ease;
}

.guide-card-v3:hover .guide-link {
    color: var(--primary-dark, #a86a4a);
}

.guide-card-v3:hover .guide-link i {
    transform: translateX(5px);
}

/* Responsive */
@media (max-width: 991px) {
    .guide-card-v3 {
        padding: 30px 25px;
    }
}

@media (max-width: 768px) {
    .guide-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .guide-card-v3 h4 {
        font-size: 1.2rem;
    }
}
</style>
