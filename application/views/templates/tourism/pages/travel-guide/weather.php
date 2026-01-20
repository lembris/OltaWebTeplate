<!-- Page hero Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero End -->

<!-- ============================================
     WEATHER SECTION - V3 Premium Design
     ============================================ -->
<section class="guide-section-v3 py-6" id="weather-guide">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <span class="section-tag">🌤️ WEATHER GUIDE</span>
                <h2 class="section-title-v3">
                    Tanzania <span class="text-gradient">Weather</span>
                </h2>
                <p class="section-subtitle mx-auto">
                    Discover the diverse climate patterns across Tanzania's remarkable landscapes
                </p>
            </div>
        </div>
        
        <!-- Main Content Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="guide-card-v3 h-100">
                    <div class="guide-card-icon">
                        <i class="bi bi-sun-fill"></i>
                    </div>
                    <h3>Experience Diverse Weather</h3>
                    <p>
                        Tanzania's weather is as diverse as its wildlife, promising a truly unique experience for tourists. 
                        The country's weather can be categorized into two main seasons: the dry season and the wet season, 
                        with regional variations adding further complexity.
                    </p>
                    <p>
                        The dry season, which occurs from June to October, is the prime time for safaris. During this period, 
                        the weather is comfortably cool and relatively dry, creating ideal conditions for wildlife viewing 
                        in renowned national parks like the Serengeti and Ngorongoro Crater.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="guide-card-v3 h-100">
                    <div class="guide-card-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h3>Regional Weather Contrasts</h3>
                    <p>
                        The weather in Tanzania varies significantly by region. The coastal areas, including Zanzibar, 
                        tend to be hot and humid year-round, making them perfect for beach lovers.
                    </p>
                    <p>
                        In contrast, the highlands around Arusha and Mount Kilimanjaro experience milder temperatures, 
                        while the central plateau and the Serengeti can get quite chilly during the evenings and early mornings. 
                        Rainfall patterns also differ by region, with the eastern coastal strip having its wettest season 
                        from March to May and the northern parks experiencing rains from November to May.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Season Cards -->
        <div class="row g-4 mb-5">
            <div class="col-12 text-center mb-3" data-aos="fade-up">
                <span class="section-tag">📅 SEASONS</span>
                <h3 class="section-title-v3">Best Times to Visit</h3>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="season-card-v3">
                    <div class="season-icon dry">
                        <i class="bi bi-brightness-high-fill"></i>
                    </div>
                    <h4>Dry Season</h4>
                    <span class="season-months">June - October</span>
                    <p>Perfect for wildlife safaris with clear skies and excellent game viewing opportunities.</p>
                    <ul class="season-highlights">
                        <li><i class="bi bi-check-circle-fill"></i> Great Migration river crossings</li>
                        <li><i class="bi bi-check-circle-fill"></i> Ideal safari conditions</li>
                        <li><i class="bi bi-check-circle-fill"></i> Cool, comfortable temperatures</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="season-card-v3">
                    <div class="season-icon wet">
                        <i class="bi bi-cloud-rain-fill"></i>
                    </div>
                    <h4>Green Season</h4>
                    <span class="season-months">November - May</span>
                    <p>Lush landscapes, baby animals, and fewer tourists make this a unique experience.</p>
                    <ul class="season-highlights">
                        <li><i class="bi bi-check-circle-fill"></i> Calving season in Serengeti</li>
                        <li><i class="bi bi-check-circle-fill"></i> Birdwatching paradise</li>
                        <li><i class="bi bi-check-circle-fill"></i> Lower safari prices</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="season-card-v3">
                    <div class="season-icon shoulder">
                        <i class="bi bi-thermometer-half"></i>
                    </div>
                    <h4>Shoulder Season</h4>
                    <span class="season-months">November & March</span>
                    <p>Best of both worlds with manageable weather and good wildlife viewing.</p>
                    <ul class="season-highlights">
                        <li><i class="bi bi-check-circle-fill"></i> Good value packages</li>
                        <li><i class="bi bi-check-circle-fill"></i> Fewer crowds</li>
                        <li><i class="bi bi-check-circle-fill"></i> Scenic green landscapes</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Planning Tips -->
        <div class="row">
            <div class="col-12" data-aos="fade-up">
                <div class="guide-tip-card">
                    <div class="tip-header">
                        <span class="section-tag">💡 PLANNING TIP</span>
                        <h3>Choosing the Right Time to Visit</h3>
                    </div>
                    <p>
                        For a rewarding Tanzanian adventure, it's crucial to time your visit according to your preferences. 
                        Whether you're aiming to witness the Great Migration in the Serengeti, lounge on Zanzibar's beaches, 
                        or tackle Mount Kilimanjaro, understanding Tanzania's weather patterns is key. Be sure to plan your 
                        journey based on your chosen activities and destinations, and remember that flexibility can be your 
                        best friend when exploring Tanzania's climatic diversity.
                    </p>
                    <a href="<?php echo base_url(); ?>contact" class="btn-guide-cta">
                        <span>Get Expert Advice</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guide Section V3 Styles -->
<style>
/* ============ GUIDE SECTION V3 ============ */
.guide-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
}

/* Guide Cards */
.guide-card-v3 {
    background: white;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.guide-card-v3:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}

.guide-card-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.3);
}

.guide-card-icon i {
    font-size: 1.8rem;
    color: white;
}

.guide-card-v3 h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark, #3D3029);
    margin-bottom: 15px;
}

.guide-card-v3 p {
    color: #555;
    line-height: 1.8;
    margin-bottom: 15px;
}

.guide-card-v3 p:last-child {
    margin-bottom: 0;
}

/* Season Cards */
.season-card-v3 {
    background: white;
    padding: 35px 30px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
}

.season-card-v3:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}

.season-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
}

.season-icon.dry {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(245,158,11,0.3);
}

.season-icon.wet {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(16,185,129,0.3);
}

.season-icon.shoulder {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(139,92,246,0.3);
}

.season-card-v3 h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark, #3D3029);
    margin-bottom: 8px;
}

.season-months {
    display: inline-block;
    background: rgba(199, 128, 92, 0.1);
    color: var(--primary, #C7805C);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.season-card-v3 p {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

.season-highlights {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.season-highlights li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 0.9rem;
    color: #555;
    border-top: 1px solid #f0f0f0;
}

.season-highlights li:first-child {
    border-top: none;
}

.season-highlights i {
    color: #10b981;
    font-size: 0.9rem;
}

/* Tip Card */
.guide-tip-card {
    background: linear-gradient(135deg, var(--dark, #3D3029) 0%, #2A231D 100%);
    padding: 40px;
    border-radius: 20px;
    color: white;
}

.tip-header {
    margin-bottom: 20px;
}

.tip-header .section-tag {
    background: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.9);
}

.tip-header h3 {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 15px;
}

.guide-tip-card p {
    color: rgba(255,255,255,0.85);
    font-size: 1.05rem;
    line-height: 1.8;
    margin-bottom: 25px;
}

.btn-guide-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.3);
}

.btn-guide-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-guide-cta i {
    transition: transform 0.3s ease;
}

.btn-guide-cta:hover i {
    transform: translateX(5px);
}

/* Responsive */
@media (max-width: 768px) {
    .guide-card-v3,
    .guide-tip-card {
        padding: 25px;
    }
    
    .guide-card-icon {
        width: 60px;
        height: 60px;
    }
    
    .guide-card-icon i {
        font-size: 1.5rem;
    }
}
</style>

<!-- Process Start -->
<?php $this->load->view('pages/sections/travel-guide'); ?>
<!-- Process Start -->

<!-- Team Start -->
<?php $this->load->view('pages/sections/team'); ?>
<!-- Team End -->

<!-- Testimonials Start -->
<?php $this->load->view('pages/sections/testimonials'); ?>
<!-- Testimonials End -->
