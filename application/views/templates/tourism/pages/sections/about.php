<!-- ============================================
     ABOUT SECTION - V3 Premium Design
     ============================================ -->
<section class="about-section-v3 py-6" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Image Column with Overlays -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <div class="about-main-image">
                        <img src="<?php echo base_url(); ?>assets/img/sections/osiram-safari-adventure-zebraz-drinking-water-in-the-river-01.jpg" alt="Osiram Safari Adventure" class="img-fluid rounded-4">
                    </div>
                    <!-- Experience Badge -->
                    <div class="about-experience-badge">
                        <span class="exp-number">15+</span>
                        <span class="exp-text">Years<br>Experience</span>
                    </div>
                    <!-- Floating Stats Card -->
                    <div class="about-stats-card">
                        <div class="stats-icon">🦁</div>
                        <div class="stats-content">
                            <strong>500+</strong>
                            <span>Happy Travelers</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Column -->
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-tag">✨ ABOUT US</span>
                <h2 class="section-title-v3 text-start mb-4">
                    Discover Tanzania's Wonders With <span class="text-gradient">Osiram Safari</span>
                </h2>
                <p class="about-lead-text mb-4">
                    Nestled in the heart of East Africa, far from the hustle and bustle, there lies the enchanting land of Tanzania. Here, in the realm of natural wonders, we invite you to embark on an unforgettable journey.
                </p>
                <p class="text-muted mb-4">
                    Just as the Serengeti's rivers sustain the land's magnificent creatures, our passion for exploration nourishes your travel experiences. Tanzania is a paradise waiting to be explored, where every adventure unveils new layers of beauty and wonder.
                </p>
                
                <!-- Features List -->
                <div class="about-features-grid mb-4">
                    <div class="about-feature-item">
                        <div class="feature-icon-sm bg-primary-soft">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Award Winning</strong>
                            <span>Certified Tour Operator</span>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="feature-icon-sm bg-success-soft">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Expert Guides</strong>
                            <span>Local & Experienced</span>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="feature-icon-sm bg-warning-soft">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Safe & Secure</strong>
                            <span>100% Safety Guaranteed</span>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="feature-icon-sm bg-danger-soft">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="feature-text">
                            <strong>Personalized</strong>
                            <span>Tailored Experiences</span>
                        </div>
                    </div>
                </div>
                
                <?php if($current_page_name == 'Home'): ?>
                <a href="<?php echo base_url(); ?>about" class="btn-about-cta">
                    <span>Read More About Us</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($current_page_name != 'Home'): ?>
        <!-- Extended About Content (Only on About Page) -->
        <div class="row mt-6">
            <div class="col-12" data-aos="fade-up">
                <div class="about-story-card">
                    <div class="story-header">
                        <span class="section-tag">🌍 OUR STORY</span>
                        <h3>How <span class="text-primary">Osiram Safari Adventure</span> Came to Life</h3>
                    </div>
                    <div class="row g-4 mt-4">
                        <div class="col-md-6">
                            <p>
                                Welcome to Osiram Safari Adventure, a Tanzanian-based safari tour company founded by Michael, Lembris, and Dr. Vicky. Our team is a unique blend of diverse backgrounds and skillsets, united by our passion for sharing the beauty and wonder of Tanzania with travelers from around the world.
                            </p>
                            <p>
                                Together, we're committed to providing sustainable and responsible tourism experiences that have a positive impact on the local community and environment. We believe that travel should be a transformative experience that connects people across cultures.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                Michael, driven by his ambition to showcase Tanzania's natural beauty, attended Tourism school in Arusha to learn about the industry and wildlife in the country's national parks. After completing his studies, he gained extensive experience organizing safaris with several tourism companies.
                            </p>
                            <p>
                                Finally, Michael met Vicky and Lembris, and together they founded Osiram Safari Adventure. With his dream realized, Michael now shares his extensive knowledge of Tanzania's wildlife and Maasai history with visitors worldwide.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our Values -->
        <div class="row mt-5 g-4">
            <div class="col-12 text-center mb-3" data-aos="fade-up">
                <span class="section-tag">💎 OUR VALUES</span>
                <h3 class="section-title-v3">What Drives Us Forward</h3>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card-v3">
                    <div class="value-icon">🌱</div>
                    <h4>Sustainability</h4>
                    <p>We prioritize eco-friendly practices and support local conservation efforts to preserve Tanzania's natural heritage.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card-v3">
                    <div class="value-icon">🤝</div>
                    <h4>Community</h4>
                    <p>We work closely with local communities, ensuring tourism benefits those who call this beautiful land home.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card-v3">
                    <div class="value-icon">⭐</div>
                    <h4>Excellence</h4>
                    <p>Every safari is crafted with attention to detail, ensuring unforgettable memories for every traveler.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* ============ ABOUT SECTION V3 ============ */
.about-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.about-image-wrapper {
    position: relative;
    padding: 20px;
}

.about-main-image img {
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.about-experience-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.4);
    animation: float 3s ease-in-out infinite;
}

.about-experience-badge .exp-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
}

.about-experience-badge .exp-text {
    font-size: 0.85rem;
    opacity: 0.9;
    line-height: 1.3;
}

.about-stats-card {
    position: absolute;
    bottom: 0;
    left: 0;
    background: white;
    padding: 18px 24px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    animation: float 3s ease-in-out infinite 1.5s;
}

.about-stats-card .stats-icon {
    font-size: 2.5rem;
}

.about-stats-card .stats-content {
    display: flex;
    flex-direction: column;
}

.about-stats-card .stats-content strong {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1a1a2e;
}

.about-stats-card .stats-content span {
    font-size: 0.85rem;
    color: #666;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.about-lead-text {
    font-size: 1.1rem;
    color: #444;
    line-height: 1.8;
}

/* About Features Grid */
.about-features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.about-feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.about-feature-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.feature-icon-sm {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.feature-text {
    display: flex;
    flex-direction: column;
}

.feature-text strong {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1a1a2e;
}

.feature-text span {
    font-size: 0.8rem;
    color: #888;
}

/* About CTA Button */
.btn-about-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.3);
}

.btn-about-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-about-cta i {
    transition: transform 0.3s ease;
}

.btn-about-cta:hover i {
    transform: translateX(5px);
}

/* Story Card */
.about-story-card {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.story-header h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-top: 15px;
}

.about-story-card p {
    color: #555;
    line-height: 1.8;
    margin-bottom: 15px;
}

/* Value Cards */
.value-card-v3 {
    background: white;
    padding: 35px 30px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.value-card-v3:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}

.value-card-v3 .value-icon {
    font-size: 3rem;
    margin-bottom: 20px;
}

.value-card-v3 h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 12px;
    color: #1a1a2e;
}

.value-card-v3 p {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
}

/* Utility */
.mt-6 { margin-top: 5rem; }

/* Responsive */
@media (max-width: 991px) {
    .about-image-wrapper {
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .about-experience-badge {
        top: 10px;
        right: 10px;
        padding: 15px 20px;
    }
    
    .about-experience-badge .exp-number {
        font-size: 2rem;
    }
    
    .about-stats-card {
        left: 10px;
        bottom: 10px;
    }
}

@media (max-width: 768px) {
    .about-features-grid {
        grid-template-columns: 1fr;
    }
    
    .about-story-card {
        padding: 25px;
    }
}
</style>
