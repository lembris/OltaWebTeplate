<?php
/**
 * Package Detail Page - V4 Dynamic Version with Tabbed Layout
 * Organized into tabs for better UX
 */

$CI =& get_instance();
$CI->load->model('Package_model');

if (empty($package)) {
    echo "Package not found";
    return;
}

// Parse JSON fields
$destinations = is_string($package->destinations) ? json_decode($package->destinations, true) : [];
$highlights = !empty($package->highlights) ? (is_string($package->highlights) ? json_decode($package->highlights, true) : $package->highlights) : [];
$inclusions = !empty($package->inclusions) ? (is_string($package->inclusions) ? json_decode($package->inclusions, true) : $package->inclusions) : [];
$exclusions = !empty($package->exclusions) ? (is_string($package->exclusions) ? json_decode($package->exclusions, true) : $package->exclusions) : [];
$gallery = !empty($package->gallery) ? (is_string($package->gallery) ? json_decode($package->gallery, true) : $package->gallery) : [];

// Get itinerary days
$itinerary = $CI->db->where('package_id', $package->id)
    ->order_by('day_number', 'ASC')
    ->get('package_itinerary')
    ->result_array();

// Get pricing tiers
$pricing_tiers = $CI->db->where('package_id', $package->id)
    ->where('is_active', 1)
    ->order_by('season', 'ASC')
    ->get('package_pricing')
    ->result_array();

$image_url = $CI->Package_model->get_package_image($package);
$related_packages = $CI->Package_model->get_related_packages($package->id, $package->category, 3);
?>

<!-- Hero Section -->
<section class="pkg-hero" style="background-image: url('<?php echo $image_url; ?>');">
    <div class="hero-overlay"></div>
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('packages'); ?>">Packages</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($package->name); ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?php echo htmlspecialchars($package->name); ?></h1>
        <div class="hero-meta" data-aos="fade-up" data-aos-delay="100">
            <span><i class="bi bi-clock"></i> <?php echo $package->duration_days; ?> Days</span>
            <span><i class="bi bi-geo-alt"></i> <?php echo count($destinations); ?> Destinations</span>
            <span><i class="bi bi-star-fill"></i> 4.8</span>
            <span class="price-tag">From <strong>$<?php echo number_format($package->base_price ?? 0); ?></strong></span>
        </div>
        <div class="hero-cta" data-aos="fade-up" data-aos-delay="200">
            <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn-primary-cta">
                <i class="bi bi-calendar-check"></i> Book Now
            </a>
            <a href="<?php echo base_url('enquiry'); ?>" class="btn-outline-cta">
                <i class="bi bi-send"></i> Get Quote
            </a>
        </div>
    </div>
</section>

<!-- Sticky Tab Navigation -->
<nav class="pkg-tabs-nav" id="pkgTabsNav">
    <div class="container">
        <ul class="nav nav-pills" id="packageTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#overview" type="button">
                    <i class="bi bi-info-circle"></i> Overview
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#itinerary" type="button">
                    <i class="bi bi-calendar3"></i> Itinerary
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#included" type="button">
                    <i class="bi bi-check-circle"></i> Included
                </button>
            </li>
            <?php if (!empty($pricing_tiers)): ?>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pricing" type="button">
                    <i class="bi bi-tag"></i> Pricing
                </button>
            </li>
            <?php endif; ?>
            <?php if (!empty($gallery)): ?>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#gallery" type="button">
                    <i class="bi bi-images"></i> Gallery
                </button>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#map" type="button">
                    <i class="bi bi-map"></i> Map
                </button>
            </li>
        </ul>
    </div>
</nav>

<!-- Tab Content -->
<div class="tab-content pkg-tab-content" id="packageTabsContent">
    
    <!-- OVERVIEW TAB -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-card">
                        <h2>About This Safari</h2>
                        <p class="lead"><?php echo nl2br(htmlspecialchars($package->description ?? '')); ?></p>
                        
                        <?php if (!empty($highlights)): ?>
                        <h4 class="mt-4"><i class="bi bi-stars text-warning"></i> Tour Highlights</h4>
                        <div class="highlights-list">
                            <?php foreach ($highlights as $h): ?>
                            <div class="highlight-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span><?php echo htmlspecialchars($h); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($destinations)): ?>
                        <h4 class="mt-4"><i class="bi bi-geo-alt text-primary"></i> Destinations</h4>
                        <div class="destination-tags">
                            <?php foreach ($destinations as $d): ?>
                            <span class="dest-tag"><?php echo htmlspecialchars($d); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="sidebar-card">
                        <h4><i class="bi bi-info-circle"></i> Quick Facts</h4>
                        <ul class="quick-facts">
                            <li><span>Duration</span><strong><?php echo $package->duration_days; ?> Days / <?php echo ($package->duration_nights ?? $package->duration_days - 1); ?> Nights</strong></li>
                            <li><span>Difficulty</span><strong><?php echo ucfirst($package->difficulty ?? 'Easy'); ?></strong></li>
                            <li><span>Group Size</span><strong><?php echo ($package->group_size_min ?? 2); ?>-<?php echo ($package->group_size_max ?? 8); ?> People</strong></li>
                            <li><span>Accommodation</span><strong><?php echo htmlspecialchars($package->accommodation_type ?? 'Lodge'); ?></strong></li>
                            <li><span>Best Time</span><strong><?php echo htmlspecialchars($package->best_time ?? 'June - October'); ?></strong></li>
                            <li><span>Start/End</span><strong><?php echo htmlspecialchars($package->start_location ?? 'Arusha'); ?></strong></li>
                        </ul>
                        
                        <div class="help-cta">
                            <p>💬 Questions? Chat with us!</p>
                            <a href="https://wa.me/<?php echo $consult_number_call ?? '255787033777'; ?>" class="btn-whatsapp" target="_blank">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ITINERARY TAB -->
    <div class="tab-pane fade" id="itinerary" role="tabpanel">
        <div class="container py-5">
            <h2 class="tab-title"><i class="bi bi-calendar3"></i> Day-by-Day Itinerary</h2>
            
            <?php if (!empty($itinerary)): ?>
            <div class="timeline">
                <?php foreach ($itinerary as $day): ?>
                <div class="timeline-item">
                    <div class="timeline-marker">Day <?php echo $day['day_number']; ?></div>
                    <div class="timeline-content">
                        <h4><?php echo htmlspecialchars($day['title']); ?></h4>
                        <p><?php echo nl2br(htmlspecialchars($day['description'])); ?></p>
                        <?php if (!empty($day['meals']) || (!empty($day['accommodation']) && $day['accommodation'] !== '-')): ?>
                        <div class="day-meta">
                            <?php if (!empty($day['meals'])): ?>
                            <span class="meta-badge meals"><i class="bi bi-cup-hot"></i> <?php echo $day['meals']; ?></span>
                            <?php endif; ?>
                            <?php if (!empty($day['accommodation']) && $day['accommodation'] !== '-'): ?>
                            <span class="meta-badge accom"><i class="bi bi-house"></i> <?php echo htmlspecialchars($day['accommodation']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-muted">Detailed itinerary coming soon. Contact us for more information.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- INCLUDED TAB -->
    <div class="tab-pane fade" id="included" role="tabpanel">
        <div class="container py-5">
            <h2 class="tab-title"><i class="bi bi-list-check"></i> What's Included & Excluded</h2>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="inc-card included">
                        <h4><i class="bi bi-check-circle-fill"></i> Included</h4>
                        <ul>
                            <?php 
                            $inc_list = !empty($inclusions) ? $inclusions : ['Airport transfers', 'All park fees', 'Accommodation', '4x4 Safari vehicle', 'Professional guide', 'All meals', 'Drinking water'];
                            foreach ($inc_list as $item): ?>
                            <li><i class="bi bi-check2"></i> <?php echo htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="inc-card excluded">
                        <h4><i class="bi bi-x-circle-fill"></i> Not Included</h4>
                        <ul>
                            <?php 
                            $exc_list = !empty($exclusions) ? $exclusions : ['International flights', 'Visa fees', 'Travel insurance', 'Tips', 'Personal expenses', 'Alcoholic beverages'];
                            foreach ($exc_list as $item): ?>
                            <li><i class="bi bi-x"></i> <?php echo htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- PRICING TAB -->
    <?php if (!empty($pricing_tiers)): ?>
    <div class="tab-pane fade" id="pricing" role="tabpanel">
        <div class="container py-5">
            <h2 class="tab-title"><i class="bi bi-tag"></i> Safari Pricing</h2>
            <p class="text-muted mb-4">Transparent pricing based on season. All prices per person.</p>
            
            <div class="table-responsive">
                <table class="pricing-table">
                    <thead>
                        <tr>
                            <th>Season</th>
                            <th>Base Price</th>
                            <th>Per Person</th>
                            <th>Min Travelers</th>
                            <th>Child Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $season_labels = ['low' => 'Low Season', 'mid' => 'Mid Season', 'high' => 'High Season', 'peak' => 'Peak Season'];
                        $season_dates = ['low' => 'Apr - May', 'mid' => 'Jun, Nov', 'high' => 'Jan - Mar, Dec', 'peak' => 'Jul - Oct'];
                        foreach ($pricing_tiers as $tier): ?>
                        <tr>
                            <td>
                                <span class="season-badge <?php echo $tier['season']; ?>"><?php echo $season_labels[$tier['season']] ?? ucfirst($tier['season']); ?></span>
                                <small class="d-block text-muted"><?php echo $season_dates[$tier['season']] ?? ''; ?></small>
                            </td>
                            <td><strong>$<?php echo number_format($tier['base_price']); ?></strong></td>
                            <td>$<?php echo number_format($tier['price_per_person']); ?></td>
                            <td><?php echo $tier['min_travelers']; ?>+ people</td>
                            <td><span class="discount-badge"><?php echo $tier['child_discount_percent']; ?>% off</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="pricing-notes">
                <span><i class="bi bi-check-circle"></i> All park fees included</span>
                <span><i class="bi bi-percent"></i> Children discounts apply</span>
                <span><i class="bi bi-arrow-up-circle"></i> Upgrades available</span>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- GALLERY TAB -->
    <?php if (!empty($gallery)): ?>
    <div class="tab-pane fade" id="gallery" role="tabpanel">
        <div class="container py-5">
            <h2 class="tab-title"><i class="bi bi-images"></i> Photo Gallery</h2>
            
            <!-- Gallery Carousel -->
            <div class="gallery-carousel-wrapper">
                <div class="gallery-carousel" id="galleryCarousel">
                    <!-- Main Display -->
                    <div class="carousel-main">
                        <div class="carousel-slide-container">
                            <img id="carouselMainImage" src="" alt="Safari experience gallery image" class="carousel-image" loading="lazy">
                            <div class="carousel-controls">
                                <button class="carousel-btn carousel-prev" onclick="galleryPrevSlide()">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="carousel-btn carousel-next" onclick="galleryNextSlide()">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                            <div class="carousel-playback">
                                <button class="carousel-play-btn" id="carouselPlayBtn" onclick="galleryToggleAutoplay()">
                                    <i class="bi bi-play-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="carousel-info">
                            <span class="image-counter"><span id="currentImageNum">1</span> / <span id="totalImageNum"><?php echo count($gallery); ?></span></span>
                            <div class="carousel-progress">
                                <div class="progress-bar" id="carouselProgress"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="carousel-thumbnails-wrapper">
                        <div class="carousel-thumbnails" id="carouselThumbnails">
                            <?php foreach ($gallery as $idx => $img): 
                                $img_url = (strpos($img, 'http') === 0) ? $img : base_url('assets/img/packages/gallery/' . $img);
                            ?>
                            <div class="thumbnail-item" onclick="galleryGoToSlide(<?php echo $idx; ?>)" data-index="<?php echo $idx; ?>">
                                <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($package->name); ?> - Gallery image <?php echo ($idx + 1); ?>" loading="lazy">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grid View Toggle -->
            <div class="gallery-view-toggle">
                <button class="toggle-btn active" onclick="galleryToggleView('carousel')" title="Carousel View">
                    <i class="bi bi-film"></i>
                </button>
                <button class="toggle-btn" onclick="galleryToggleView('grid')" title="Grid View">
                    <i class="bi bi-grid-3x3"></i>
                </button>
            </div>
            
            <!-- Grid View -->
            <div class="gallery-grid" id="galleryGrid" style="display: none;">
                <?php foreach ($gallery as $idx => $img): 
                    $img_url = (strpos($img, 'http') === 0) ? $img : base_url('assets/img/packages/gallery/' . $img);
                ?>
                <a href="<?php echo $img_url; ?>" class="gallery-item" data-lightbox="package-gallery" data-title="<?php echo htmlspecialchars($package->name); ?>" onclick="galleryGoToSlide(<?php echo $idx; ?>)">
                    <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($package->name); ?> - African safari experience - Image <?php echo ($idx + 1); ?>" loading="lazy" width="600" height="450">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Gallery Data with SEO Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ImageGallery",
      "name": "<?php echo htmlspecialchars($package->name); ?> - Photo Gallery",
      "description": "High-quality photo gallery of <?php echo htmlspecialchars($package->name); ?> safari experience",
      "image": <?php echo json_encode(array_map(function($img) {
          return (strpos($img, 'http') === 0) ? $img : base_url('assets/img/packages/gallery/' . $img);
      }, $gallery ?? [])); ?>,
      "associatedWith": {
        "@type": "TouristAttraction",
        "name": "<?php echo htmlspecialchars($package->name); ?>"
      }
    }
    </script>
    
    <script>
        const galleryImages = <?php echo json_encode(array_map(function($img) {
            return (strpos($img, 'http') === 0) ? $img : base_url('assets/img/packages/gallery/' . $img);
        }, $gallery ?? [])); ?>;
    </script>
    
    <!-- MAP TAB -->
    <div class="tab-pane fade" id="map" role="tabpanel">
        <div class="container py-5">
            <h2 class="tab-title"><i class="bi bi-map"></i> Route Map</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/d/embed?mid=15Xh5ywHwB46howKqLgnHW96zk5g8uy8&ehbc=2E312F" width="100%" height="500" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Booking CTA Bar -->
<section class="booking-bar">
    <div class="container">
        <div class="booking-bar-inner">
            <div class="booking-info">
                <span class="pkg-name"><?php echo htmlspecialchars($package->name); ?></span>
                <span class="pkg-price">From <strong>$<?php echo number_format($package->base_price ?? 0); ?></strong> /person</span>
            </div>
            <div class="booking-actions">
                <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn-book">Book Now</a>
                <a href="https://wa.me/<?php echo $consult_number_call ?? '255787033777'; ?>" class="btn-wa" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Related Packages -->
<?php if (!empty($related_packages)): ?>
<section class="related-section py-5 bg-light">
    <div class="container">
        <h3 class="text-center mb-4">You May Also Like</h3>
        <div class="row g-4">
            <?php foreach ($related_packages as $rel): 
                $rel_img = $CI->Package_model->get_package_image($rel);
            ?>
            <div class="col-lg-4 col-md-6">
                <a href="<?php echo base_url('packages/' . $rel->slug); ?>" class="related-card">
                    <img src="<?php echo $rel_img; ?>" alt="<?php echo htmlspecialchars($rel->name); ?> safari package - <?php echo $rel->duration_days; ?> days" loading="lazy" width="400" height="280">
                    <div class="card-overlay">
                        <span class="duration"><?php echo $rel->duration_days; ?> Days</span>
                        <h4><?php echo htmlspecialchars($rel->name); ?></h4>
                        <span class="price">From $<?php echo number_format($rel->base_price ?? 0); ?></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
/* ========== HERO ========== */
.pkg-hero {
    position: relative;
    padding: 180px 0 80px;
    background-size: cover;
    background-position: center;
    text-align: center;
    color: white;
}
.pkg-hero .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.7) 100%);
}
.pkg-hero .container { position: relative; z-index: 2; }
.pkg-hero .breadcrumb { justify-content: center; background: transparent; margin-bottom: 15px; }
.pkg-hero .breadcrumb a { color: rgba(255,255,255,0.8); text-decoration: none; }
.pkg-hero .breadcrumb-item.active { color: #ffc107; }
.pkg-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.5); }
.pkg-hero h1 { 
    font-size: clamp(2rem, 5vw, 3.2rem); 
    font-weight: 800; 
    margin-bottom: 20px; 
    color: #ffffff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}
.hero-meta { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-bottom: 25px; }
.hero-meta span { background: rgba(255,255,255,0.15); padding: 8px 18px; border-radius: 50px; font-size: 0.9rem; backdrop-filter: blur(5px); }
.hero-meta .price-tag { background: #ffc107; color: #1a1a2e; font-weight: 600; }
.hero-meta i { margin-right: 6px; }
.hero-cta { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
.btn-primary-cta { padding: 14px 30px; background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A)); color: white; border-radius: 50px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; }
.btn-primary-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(199, 128, 92, 0.4); color: white; }
.btn-outline-cta { padding: 14px 30px; background: transparent; color: white; border: 2px solid white; border-radius: 50px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; }
.btn-outline-cta:hover { background: white; color: #1a1a2e; }

/* ========== STICKY TABS ========== */
.pkg-tabs-nav {
    background: white;
    border-bottom: 1px solid #eee;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.pkg-tabs-nav .nav { display: flex; gap: 5px; padding: 10px 0; overflow-x: auto; flex-wrap: nowrap; }
.pkg-tabs-nav .nav-link {
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    color: #555;
    background: #f8f9fa;
    border: none;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;
}
.pkg-tabs-nav .nav-link:hover { background: #e9ecef; }
.pkg-tabs-nav .nav-link.active { background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A)); color: white; }
.pkg-tabs-nav .nav-link i { font-size: 1rem; }

/* ========== TAB CONTENT ========== */
.pkg-tab-content { min-height: 50vh; }
.tab-title { font-size: 1.6rem; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
.tab-title i { color: #0d6efd; }

/* Content Cards */
.content-card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.06); }
.content-card h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 15px; }
.content-card .lead { color: #555; line-height: 1.8; }
.content-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 15px; }

.highlights-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px; }
.highlight-item { display: flex; align-items: flex-start; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 10px; }
.highlight-item i { flex-shrink: 0; margin-top: 3px; }

.destination-tags { display: flex; flex-wrap: wrap; gap: 10px; }
.dest-tag { background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white; padding: 8px 18px; border-radius: 50px; font-size: 0.9rem; }

/* Sidebar */
.sidebar-card { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 5px 25px rgba(0,0,0,0.06); position: sticky; top: 80px; }
.sidebar-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
.quick-facts { list-style: none; padding: 0; margin: 0 0 20px; }
.quick-facts li { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; }
.quick-facts li span { color: #888; }
.quick-facts li strong { color: #1a1a2e; }
.help-cta { background: #f0fdf4; border-radius: 12px; padding: 20px; text-align: center; }
.help-cta p { margin-bottom: 12px; font-weight: 600; }
.btn-whatsapp { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #25D366; color: white; border-radius: 50px; font-weight: 600; text-decoration: none; }
.btn-whatsapp:hover { background: #128C7E; color: white; }

/* ========== TIMELINE ========== */
.timeline { position: relative; padding-left: 30px; }
.timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, var(--primary, #C7805C), var(--primary-dark, #A8684A)); border-radius: 3px; }
.timeline-item { position: relative; margin-bottom: 25px; }
.timeline-marker { position: absolute; left: -30px; background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A)); color: white; padding: 6px 12px; border-radius: 50px; font-weight: 700; font-size: 0.8rem; white-space: nowrap; }
.timeline-content { background: white; border-radius: 12px; padding: 20px; margin-left: 60px; box-shadow: 0 3px 15px rgba(0,0,0,0.05); border-left: 3px solid var(--primary, #C7805C); }
.timeline-content h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
.timeline-content p { color: #666; line-height: 1.7; margin-bottom: 12px; }
.day-meta { display: flex; flex-wrap: wrap; gap: 10px; }
.meta-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
.meta-badge.meals { background: #fef3c7; color: #92400e; }
.meta-badge.accom { background: #dbeafe; color: #1e40af; }

/* ========== INCLUSIONS ========== */
.inc-card { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 5px 25px rgba(0,0,0,0.06); height: 100%; }
.inc-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; padding-bottom: 15px; border-bottom: 2px solid #eee; }
.inc-card.included h4 i { color: #10b981; }
.inc-card.excluded h4 i { color: #ef4444; }
.inc-card ul { list-style: none; padding: 0; margin: 0; }
.inc-card li { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
.inc-card li:last-child { border-bottom: none; }
.inc-card.included li i { color: #10b981; }
.inc-card.excluded li i { color: #ef4444; }

/* ========== PRICING ========== */
.pricing-table { width: 100%; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 25px rgba(0,0,0,0.06); }
.pricing-table th, .pricing-table td { padding: 15px; text-align: center; }
.pricing-table thead { background: linear-gradient(135deg, #1a1a2e, #16213e); color: white; }
.pricing-table tbody tr { border-bottom: 1px solid #f0f0f0; }
.pricing-table tbody tr:hover { background: #f8f9fa; }
.season-badge { display: inline-block; padding: 5px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
.season-badge.peak { background: #fef3c7; color: #92400e; }
.season-badge.high { background: #dbeafe; color: #1e40af; }
.season-badge.mid { background: #d1fae5; color: #065f46; }
.season-badge.low { background: #f3f4f6; color: #4b5563; }
.discount-badge { background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
.pricing-notes { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; }
.pricing-notes span { display: flex; align-items: center; gap: 8px; color: #666; font-size: 0.9rem; }
.pricing-notes i { color: var(--primary, #C7805C); }

/* ========== MAP ========== */
.map-container { border-radius: 12px; overflow: hidden; box-shadow: 0 5px 25px rgba(0,0,0,0.08); }

/* ========== GALLERY CAROUSEL ========== */
.gallery-carousel-wrapper {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.gallery-carousel {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.carousel-main {
    width: 100%;
}

.carousel-slide-container {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
    overflow: hidden;
    background: #f0f0f0;
    margin-bottom: 15px;
}

.carousel-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.carousel-controls {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    pointer-events: none;
}

.carousel-btn {
    pointer-events: auto;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.5rem;
    color: #1a1a2e;
}

.carousel-btn:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.carousel-playback {
    position: absolute;
    bottom: 20px;
    left: 20px;
    z-index: 10;
}

.carousel-play-btn {
    background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A));
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(199, 128, 92, 0.4);
}

.carousel-play-btn:hover {
    transform: scale(1.1);
}

.carousel-play-btn.playing {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.carousel-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
}

.image-counter {
    font-weight: 600;
    color: #1a1a2e;
    font-size: 1rem;
}

.carousel-progress {
    flex: 1;
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    margin: 0 15px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary, #C7805C), var(--primary-dark, #A8684A));
    width: 0%;
    transition: width 0.3s ease;
    border-radius: 2px;
}

/* Thumbnails */
.carousel-thumbnails-wrapper {
    width: 100%;
    overflow-x: auto;
}

.carousel-thumbnails {
    display: flex;
    gap: 10px;
    padding: 5px 0;
    scroll-behavior: smooth;
}

.thumbnail-item {
    flex-shrink: 0;
    width: 100px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
    opacity: 0.6;
}

.thumbnail-item:hover {
    opacity: 1;
    border-color: var(--primary, #C7805C);
}

.thumbnail-item.active {
    opacity: 1;
    border-color: var(--primary, #C7805C);
    box-shadow: 0 0 0 2px white, 0 0 8px rgba(199, 128, 92, 0.6);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* View Toggle */
.gallery-view-toggle {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
}

.toggle-btn {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    padding: 10px 20px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    color: #666;
}

.toggle-btn:hover {
    border-color: var(--primary, #C7805C);
    color: var(--primary, #C7805C);
}

.toggle-btn.active {
    background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A));
    color: white;
    border-color: var(--primary, #C7805C);
}

/* ========== GALLERY GRID ========== */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}
.gallery-item {
    position: relative;
    display: block;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 4/3;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}
.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.gallery-item:hover img {
    transform: scale(1.1);
}
.gallery-item .gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.gallery-item:hover .gallery-overlay {
    opacity: 1;
}
.gallery-item .gallery-overlay i {
    font-size: 2rem;
    color: white;
}

/* ========== BOOKING BAR ========== */
.booking-bar { background: linear-gradient(135deg, #1a1a2e, #16213e); padding: 15px 0; position: sticky; bottom: 0; z-index: 100; }
.booking-bar-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
.booking-info { color: white; }
.pkg-name { display: block; font-weight: 600; font-size: 0.9rem; opacity: 0.8; }
.pkg-price { font-size: 1.2rem; }
.pkg-price strong { color: #ffc107; }
.booking-actions { display: flex; gap: 10px; }
.btn-book { padding: 12px 28px; background: linear-gradient(135deg, var(--primary, #C7805C), var(--primary-dark, #A8684A)); color: white; border-radius: 50px; font-weight: 600; text-decoration: none; }
.btn-book:hover { box-shadow: 0 8px 20px rgba(199, 128, 92, 0.4); color: white; }
.btn-wa { width: 48px; height: 48px; background: #25D366; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; text-decoration: none; }
.btn-wa:hover { background: #128C7E; color: white; }

/* ========== RELATED ========== */
.related-card { display: block; position: relative; border-radius: 16px; overflow: hidden; height: 280px; text-decoration: none; }
.related-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
.related-card:hover img { transform: scale(1.1); }
.card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; color: white; }
.card-overlay .duration { background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; width: fit-content; margin-bottom: 8px; }
.card-overlay h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 5px; }
.card-overlay .price { color: #ffc107; font-weight: 600; }

/* ========== RESPONSIVE ========== */
@media (max-width: 991px) {
    .pkg-hero { padding: 140px 0 60px; }
    .pkg-hero h1 { font-size: 1.6rem; }
    .sidebar-card { position: static; margin-top: 20px; }
    .timeline-content { margin-left: 50px; }
    .carousel-slide-container { aspect-ratio: 4/3; }
}
@media (max-width: 576px) {
    .pkg-hero { padding: 120px 0 50px; }
    .hero-meta { gap: 10px; }
    .hero-meta span { padding: 6px 14px; font-size: 0.8rem; }
    .pkg-tabs-nav .nav-link { padding: 8px 14px; font-size: 0.85rem; }
    .timeline { padding-left: 0; }
    .timeline::before { display: none; }
    .timeline-marker { position: relative; left: 0; margin-bottom: 10px; }
    .timeline-content { margin-left: 0; }
    .booking-bar-inner { justify-content: center; text-align: center; }
    .booking-info { text-align: center; width: 100%; }
    .carousel-slide-container { aspect-ratio: 4/3; }
    .carousel-btn { width: 40px; height: 40px; font-size: 1.2rem; }
    .carousel-thumbnails { gap: 5px; }
    .thumbnail-item { width: 70px; height: 50px; }
}
</style>

<script>
// Gallery Carousel Variables
let galleryCurrentIndex = 0;
let galleryAutoplayActive = false;
let galleryAutoplayInterval = null;
const GALLERY_AUTOPLAY_INTERVAL = 4000; // 4 seconds per image

// Initialize Gallery
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for tab changes
    const tabButtons = document.querySelectorAll('#packageTabs button');
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            setTimeout(() => {
                window.scrollTo({ top: document.querySelector('.pkg-tabs-nav').offsetTop, behavior: 'smooth' });
            }, 100);
        });
    });
    
    // Initialize gallery carousel if images exist
    if (galleryImages && galleryImages.length > 0) {
        galleryInitialize();
    }
});

// Initialize Gallery Carousel
function galleryInitialize() {
    galleryCurrentIndex = 0;
    galleryUpdateSlide();
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('galleryCarousel') && getGalleryVisibility()) {
            if (e.key === 'ArrowLeft') galleryPrevSlide();
            if (e.key === 'ArrowRight') galleryNextSlide();
        }
    });
    
    // Touch/Swipe support
    let touchStartX = 0;
    const carouselContainer = document.querySelector('.carousel-slide-container');
    if (carouselContainer) {
        carouselContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        });
        carouselContainer.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 50) galleryNextSlide();
            if (touchEndX - touchStartX > 50) galleryPrevSlide();
        });
    }
}

// Get gallery visibility (check if gallery tab is visible)
function getGalleryVisibility() {
    const carousel = document.getElementById('galleryCarousel');
    return carousel && carousel.offsetParent !== null;
}

// Navigate to specific slide
function galleryGoToSlide(index) {
    galleryCurrentIndex = index;
    galleryStopAutoplay(); // Stop autoplay when user manually selects
    galleryUpdateSlide();
}

// Next slide
function galleryNextSlide() {
    galleryCurrentIndex = (galleryCurrentIndex + 1) % galleryImages.length;
    galleryUpdateSlide();
}

// Previous slide
function galleryPrevSlide() {
    galleryCurrentIndex = (galleryCurrentIndex - 1 + galleryImages.length) % galleryImages.length;
    galleryUpdateSlide();
}

// Update slide display
function galleryUpdateSlide() {
    const mainImage = document.getElementById('carouselMainImage');
    const currentNum = document.getElementById('currentImageNum');
    const progressBar = document.getElementById('carouselProgress');
    
    if (mainImage && galleryImages[galleryCurrentIndex]) {
        mainImage.src = galleryImages[galleryCurrentIndex];
        if (currentNum) currentNum.textContent = galleryCurrentIndex + 1;
        
        // Update progress bar
        if (progressBar) {
            const percentage = ((galleryCurrentIndex + 1) / galleryImages.length) * 100;
            progressBar.style.width = percentage + '%';
        }
        
        // Update thumbnail highlights
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        thumbnails.forEach((thumb, idx) => {
            thumb.classList.toggle('active', idx === galleryCurrentIndex);
            // Scroll thumbnail into view
            if (idx === galleryCurrentIndex) {
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });
    }
}

// Toggle autoplay
function galleryToggleAutoplay() {
    if (galleryAutoplayActive) {
        galleryStopAutoplay();
    } else {
        galleryStartAutoplay();
    }
}

// Start autoplay
function galleryStartAutoplay() {
    if (galleryAutoplayActive) return;
    
    galleryAutoplayActive = true;
    const playBtn = document.getElementById('carouselPlayBtn');
    if (playBtn) {
        playBtn.classList.add('playing');
        playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    }
    
    galleryAutoplayInterval = setInterval(() => {
        galleryNextSlide();
    }, GALLERY_AUTOPLAY_INTERVAL);
}

// Stop autoplay
function galleryStopAutoplay() {
    if (!galleryAutoplayActive) return;
    
    galleryAutoplayActive = false;
    const playBtn = document.getElementById('carouselPlayBtn');
    if (playBtn) {
        playBtn.classList.remove('playing');
        playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    }
    
    if (galleryAutoplayInterval) {
        clearInterval(galleryAutoplayInterval);
        galleryAutoplayInterval = null;
    }
}

// Toggle between carousel and grid view
function galleryToggleView(view) {
    const carousel = document.getElementById('galleryCarousel');
    const grid = document.getElementById('galleryGrid');
    const buttons = document.querySelectorAll('.toggle-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if (view === 'carousel') {
        carousel.style.display = 'flex';
        grid.style.display = 'none';
        event.target.closest('.toggle-btn').classList.add('active');
    } else {
        carousel.style.display = 'none';
        grid.style.display = 'grid';
        event.target.closest('.toggle-btn').classList.add('active');
    }
}
</script>
