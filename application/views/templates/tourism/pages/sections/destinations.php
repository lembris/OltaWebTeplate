<!-- ============================================
     DESTINATIONS SECTION - V3 Premium Design (Dynamic)
     ============================================ -->
<section class="destinations-section-v3 py-6" id="destinations">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">🌍 WHAT WE SERVE</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100">
                Explore Our Top <span class="text-gradient">Destinations</span>
            </h2>
            <p class="section-desc" data-aos="fade-up" data-aos-delay="200">
                From pristine beaches to majestic mountains, discover Tanzania's most breathtaking locations
            </p>
        </div>
        
        <!-- Destinations Grid - Dynamic from Database -->
        <div class="destinations-grid-v3">
            <?php 
            // Check if we have destinations from database
            if (isset($featured_destinations) && !empty($featured_destinations)):
                $grid_classes = ['dest-large', 'dest-medium', 'dest-medium', 'dest-tall'];
                $delay = 100;
                $index = 0;
                
                foreach ($featured_destinations as $destination):
                    // Get grid class based on position (cycle through if more than 4)
                    $grid_class = $grid_classes[$index % 4];
                    
                    // Get image URL
                    $image_url = $this->Destination_model->get_destination_image($destination);
                    
                    // Build destination URL (SEO-friendly)
                    $dest_url = base_url('destinations/' . $destination->slug);
            ?>
            <div class="dest-item <?php echo $grid_class; ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <a href="<?php echo $dest_url; ?>" class="dest-card-v3">
                    <div class="dest-image">
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($destination->name); ?> - Safari Destination"
                             loading="lazy">
                        <div class="dest-overlay"></div>
                    </div>
                    <div class="dest-badge <?php echo $destination->badge_class; ?>">
                        <?php echo $destination->badge_icon; ?> <?php echo $destination->badge_text; ?>
                    </div>
                    <div class="dest-content">
                        <div class="dest-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count"><?php echo number_format($destination->rating, 1); ?></span>
                        </div>
                        <h3 class="dest-title"><?php echo htmlspecialchars($destination->name); ?></h3>
                        <p class="dest-desc"><?php echo htmlspecialchars($destination->short_description); ?></p>
                        <div class="dest-meta">
                            <span><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($destination->location_label); ?></span>
                            <?php if (!empty($destination->duration_label)): ?>
                            <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($destination->duration_label); ?></span>
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
                    $delay += 100;
                    $index++;
                endforeach;
            else:
                // Fallback to static content if no database data
            ?>
            <!-- Main Featured - Zanzibar (Large) -->
            <div class="dest-item dest-large" data-aos="fade-up" data-aos-delay="100">
                <a href="<?php echo base_url(); ?>destinations/zanzibar" class="dest-card-v3">
                    <div class="dest-image">
                        <img src="<?php echo base_url(); ?>assets/img/home/osiram_safari_adventure_zanzibar-01.jpg" alt="Zanzibar Beach Paradise">
                        <div class="dest-overlay"></div>
                    </div>
                    <div class="dest-badge">🏖️ Beach Paradise</div>
                    <div class="dest-content">
                        <div class="dest-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">4.9</span>
                        </div>
                        <h3 class="dest-title">Zanzibar</h3>
                        <p class="dest-desc">Crystal clear waters & pristine beaches</p>
                        <div class="dest-meta">
                            <span><i class="bi bi-geo-alt"></i> Indian Ocean</span>
                            <span><i class="bi bi-clock"></i> 4-7 Days</span>
                        </div>
                    </div>
                    <div class="dest-explore">
                        <span>Explore</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <!-- Serengeti -->
            <div class="dest-item dest-medium" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo base_url(); ?>destinations/serengeti-national-park" class="dest-card-v3">
                    <div class="dest-image">
                        <img src="<?php echo base_url(); ?>assets/img/home/osiram_safari_adventure_animal_crossing_river-01.jpg" alt="Serengeti National Park">
                        <div class="dest-overlay"></div>
                    </div>
                    <div class="dest-badge badge-popular">🦁 Most Popular</div>
                    <div class="dest-content">
                        <div class="dest-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">5.0</span>
                        </div>
                        <h3 class="dest-title">Serengeti</h3>
                        <p class="dest-desc">Witness the Great Migration</p>
                        <div class="dest-meta">
                            <span><i class="bi bi-geo-alt"></i> Northern Tanzania</span>
                        </div>
                    </div>
                    <div class="dest-explore">
                        <span>Explore</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <!-- Ngorongoro -->
            <div class="dest-item dest-medium" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo base_url(); ?>destinations/ngorongoro-conservation-area" class="dest-card-v3">
                    <div class="dest-image">
                        <img src="<?php echo base_url(); ?>assets/img/home/osiram_safari_adventure_leopard-01.jpg" alt="Ngorongoro Conservation Area">
                        <div class="dest-overlay"></div>
                    </div>
                    <div class="dest-badge badge-wildlife">🐆 Wildlife Haven</div>
                    <div class="dest-content">
                        <div class="dest-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">4.8</span>
                        </div>
                        <h3 class="dest-title">Ngorongoro</h3>
                        <p class="dest-desc">World's largest volcanic caldera</p>
                        <div class="dest-meta">
                            <span><i class="bi bi-geo-alt"></i> Crater Highlands</span>
                        </div>
                    </div>
                    <div class="dest-explore">
                        <span>Explore</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <!-- Kilimanjaro (Tall) -->
            <div class="dest-item dest-tall" data-aos="fade-up" data-aos-delay="400">
                <a href="<?php echo base_url(); ?>destinations/kilimanjaro-national-park" class="dest-card-v3">
                    <div class="dest-image">
                        <img src="<?php echo base_url(); ?>assets/img/home/osiram_safari_adventure_kilimanjaro_banner-01.jpg" alt="Mount Kilimanjaro">
                        <div class="dest-overlay"></div>
                    </div>
                    <div class="dest-badge badge-adventure">🏔️ Adventure</div>
                    <div class="dest-content">
                        <div class="dest-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">4.9</span>
                        </div>
                        <h3 class="dest-title">Kilimanjaro</h3>
                        <p class="dest-desc">Roof of Africa - 5,895m Summit</p>
                        <div class="dest-meta">
                            <span><i class="bi bi-geo-alt"></i> Northeastern TZ</span>
                            <span><i class="bi bi-graph-up"></i> Challenging</span>
                        </div>
                    </div>
                    <div class="dest-explore">
                        <span>Explore</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Quick Stats -->
        <div class="destinations-quick-stats mt-5" data-aos="fade-up" data-aos-delay="500">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="quick-stat-item">
                        <div class="stat-icon-circle">
                            <i class="bi bi-compass"></i>
                        </div>
                        <div class="stat-info">
                            <strong>25+</strong>
                            <span>Destinations</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="quick-stat-item">
                        <div class="stat-icon-circle">
                            <i class="bi bi-tree"></i>
                        </div>
                        <div class="stat-info">
                            <strong>16</strong>
                            <span>National Parks</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="quick-stat-item">
                        <div class="stat-icon-circle">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="stat-info">
                            <strong>7</strong>
                            <span>UNESCO Sites</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="quick-stat-item">
                        <div class="stat-icon-circle">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div class="stat-info">
                            <strong>500+</strong>
                            <span>Happy Visitors</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View More Button -->
        <?php if($current_page_name == 'Home'): ?>
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="600">
            <a href="<?php echo base_url(); ?>destinations" class="btn-destinations-cta">
                <span>View All Destinations</span>
                <span class="btn-badge">25+</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* ============ DESTINATIONS V3 - Premium ============ */
.destinations-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

/* Destinations Grid Layout */
.destinations-grid-v3 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(2, 250px);
    gap: 20px;
}

.dest-item.dest-large {
    grid-column: span 2;
    grid-row: span 1;
}

.dest-item.dest-medium {
    grid-column: span 1;
    grid-row: span 1;
}

.dest-item.dest-tall {
    grid-column: span 2;
    grid-row: span 2;
}

/* Destination Card */
.dest-card-v3 {
    display: block;
    position: relative;
    height: 100%;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
}

.dest-card-v3:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

.dest-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.dest-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.dest-card-v3:hover .dest-image img {
    transform: scale(1.1);
}

.dest-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        180deg, 
        transparent 0%, 
        transparent 40%, 
        rgba(0,0,0,0.8) 100%
    );
    transition: all 0.3s ease;
}

.dest-card-v3:hover .dest-overlay {
    background: linear-gradient(
        180deg, 
        rgba(199, 128, 92, 0.2) 0%, 
        rgba(0,0,0,0.85) 100%
    );
}

/* Badge */
.dest-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: white;
    color: var(--dark, #3D3029);
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    z-index: 2;
}

.dest-badge.badge-popular {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
    color: white;
}

.dest-badge.badge-wildlife {
    background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
    color: white;
}

.dest-badge.badge-adventure {
    background: linear-gradient(135deg, #339af0 0%, #228be6 100%);
    color: white;
}

/* Content */
.dest-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    z-index: 2;
    color: white;
}

.dest-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.dest-rating .stars {
    color: #ffc107;
    font-size: 0.9rem;
    letter-spacing: 2px;
}

.dest-rating .count {
    background: rgba(255,255,255,0.2);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.dest-title {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 5px;
    color: white;
}

.dest-desc {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 12px;
}

.dest-meta {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    opacity: 0.8;
}

.dest-meta i {
    margin-right: 5px;
}

/* Explore Button */
.dest-explore {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.95);
    color: var(--theme-primary, #C7805C);
    padding: 10px 18px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 2;
}

.dest-card-v3:hover .dest-explore {
    opacity: 1;
    transform: translateX(0);
}

.dest-explore i {
    transition: transform 0.3s ease;
}

.dest-card-v3:hover .dest-explore i {
    transform: translateX(5px);
}

/* Quick Stats */
.destinations-quick-stats {
    background: white;
    padding: 30px 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.quick-stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-info strong {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dark, #3D3029);
}

.stat-info span {
    font-size: 0.85rem;
    color: #888;
}

/* CTA Button */
.btn-destinations-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.3);
}

.btn-destinations-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-destinations-cta .btn-badge {
    background: rgba(255,255,255,0.2);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.btn-destinations-cta i {
    transition: transform 0.3s ease;
}

.btn-destinations-cta:hover i {
    transform: translateX(5px);
}

/* Responsive */
@media (max-width: 991px) {
    .destinations-grid-v3 {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto;
    }
    
    .dest-item.dest-large,
    .dest-item.dest-tall {
        grid-column: span 2;
        grid-row: span 1;
    }
    
    .dest-item.dest-medium {
        grid-column: span 1;
    }
    
    .dest-item {
        min-height: 280px;
    }
}

@media (max-width: 576px) {
    .destinations-grid-v3 {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .dest-item.dest-large,
    .dest-item.dest-medium,
    .dest-item.dest-tall {
        grid-column: span 1;
        min-height: 300px;
    }
    
    .dest-content {
        padding: 20px;
    }
    
    .dest-title {
        font-size: 1.3rem;
    }
    
    .dest-explore {
        display: none;
    }
    
    .destinations-quick-stats {
        padding: 20px;
    }
    
    .quick-stat-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .stat-icon-circle {
        width: 50px;
        height: 50px;
        font-size: 1.1rem;
    }
    
    .stat-info strong {
        font-size: 1.3rem;
    }
}
</style>
