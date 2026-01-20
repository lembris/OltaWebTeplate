<?php
/**
 * Safari Search Results Page
 * Displays filtered safari packages based on search criteria
 * 
 * TODO: Make dynamic with database integration
 * 
 * Created: December 2024
 */
?>

<!-- Page Hero -->
<section class="search-hero py-5" style="background: linear-gradient(135deg, var(--dark, #3D3029) 0%, #2a211c 100%); margin-top: 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item text-white active">Search Results</li>
                    </ol>
                </nav>
                <h1 class="text-white fw-bold mb-2">
                    <?php if (!empty($destination)): ?>
                        Safari Packages in <?php echo htmlspecialchars($destination); ?>
                    <?php else: ?>
                        All Safari Packages
                    <?php endif; ?>
                </h1>
                <p class="text-white-50 mb-0">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Found <strong class="text-white"><?php echo count($packages); ?></strong> packages matching your criteria
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?php echo base_url(); ?>#hero-top" class="btn btn-outline-light rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i>New Search
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search Summary Bar -->
<section class="search-summary py-3" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted">Your Search:</span>
                    <?php if (!empty($destination)): ?>
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            <i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($destination); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($travelers)): ?>
                        <span class="badge bg-info rounded-pill px-3 py-2">
                            <i class="bi bi-people me-1"></i><?php echo htmlspecialchars($travelers); ?> Travelers
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($travel_date)): ?>
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="bi bi-calendar me-1"></i><?php echo date('M d, Y', strtotime($travel_date)); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (empty($destination) && empty($travelers) && empty($travel_date)): ?>
                        <span class="badge bg-secondary rounded-pill px-3 py-2">All Packages</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <select class="form-select form-select-sm" style="max-width: 150px;" id="sortPackages">
                        <option value="popular">Most Popular</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                        <option value="duration">Duration</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="search-results py-5">
    <div class="container">
        <?php if (!empty($packages)): ?>
            <?php $total_packages = count($packages); ?>
            <?php $initial_show = 6; ?>
            <div class="row g-4" id="packagesGrid">
                <?php foreach ($packages as $index => $package): ?>
                    <?php 
                    $destinations_display = is_array($package->destinations_array) 
                        ? implode(', ', $package->destinations_array) 
                        : '';
                    ?>
                    <div class="col-lg-6 col-xl-4 package-item <?php echo $index >= $initial_show ? 'd-none' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo min($index * 100, 300); ?>">
                        <div class="package-card h-100">
                            <!-- Image -->
                            <div class="package-image">
                                <?php 
                                $image_url = !empty($package->image) 
                                    ? base_url('assets/img/packages/' . $package->image)
                                    : base_url('assets/img/destinations/osiram_safari_adventures_package_1-01.jpg');
                                ?>
                                <img src="<?php echo $image_url; ?>" 
                                     alt="<?php echo htmlspecialchars($package->name); ?>">
                                <div class="package-overlay"></div>
                                
                                <!-- Badge -->
                                <?php if (!empty($package->badge) && is_array($package->badge)): ?>
                                <span class="package-badge <?php echo $package->badge['class']; ?>"><?php echo $package->badge['text']; ?></span>
                                <?php endif; ?>
                                
                                <!-- Wishlist -->
                                <button class="package-wishlist" title="Add to Wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                                
                                <!-- Quick Info -->
                                <div class="package-quick-info">
                                    <span><i class="bi bi-clock me-1"></i><?php echo $package->duration_days; ?> Days</span>
                                    <span><i class="bi bi-people me-1"></i>Max <?php echo $package->max_travelers ?: 12; ?></span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="package-content">
                                <!-- Rating -->
                                <div class="package-rating">
                                    <span class="stars">
                                        <?php 
                                        $rating = $package->rating ?: 4.5;
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                        for ($i = 0; $i < $fullStars; $i++) echo '★';
                                        if ($halfStar) echo '☆';
                                        ?>
                                    </span>
                                    <span class="rating-text"><?php echo $rating; ?></span>
                                    <span class="reviews">(<?php echo $package->review_count ?: rand(80, 200); ?> reviews)</span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="package-title"><?php echo htmlspecialchars($package->name); ?></h3>
                                
                                <!-- Location -->
                                <p class="package-location">
                                    <i class="bi bi-geo-alt text-primary me-1"></i>
                                    <?php echo htmlspecialchars($destinations_display); ?>
                                </p>
                                
                                <!-- Description -->
                                <p class="package-desc"><?php echo htmlspecialchars(character_limiter($package->short_description ?: $package->description, 100)); ?></p>
                                
                                <!-- Highlights -->
                                <?php if (!empty($package->highlights) && is_array($package->highlights)): ?>
                                <div class="package-highlights">
                                    <?php foreach (array_slice($package->highlights, 0, 3) as $highlight): ?>
                                        <span class="highlight-tag">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i><?php echo $highlight; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Includes -->
                                <div class="package-includes">
                                    <small class="text-muted">Includes: </small>
                                    Game Drives • Accommodation • Meals
                                </div>
                                
                                <!-- Footer -->
                                <div class="package-footer">
                                    <div class="package-price">
                                        <small>From</small>
                                        <strong>$<?php echo number_format($package->base_price ?: 0); ?></strong>
                                        <small>/person</small>
                                    </div>
                                    <div class="package-actions">
                                        <a href="<?php echo base_url('packages/' . $package->slug); ?>" 
                                           class="btn btn-outline-primary btn-sm rounded-pill">
                                            View Details
                                        </a>
                                        <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn btn-primary btn-sm rounded-pill">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Load More -->
            <?php if ($total_packages > $initial_show): ?>
            <div class="text-center mt-5" id="loadMoreContainer">
                <button class="btn btn-outline-primary btn-lg rounded-pill px-5" id="loadMoreBtn" 
                        data-shown="<?php echo $initial_show; ?>" 
                        data-total="<?php echo $total_packages; ?>"
                        data-increment="6">
                    <i class="bi bi-arrow-down-circle me-2"></i>Load More Packages 
                    <span class="badge bg-primary ms-2" id="remainingCount"><?php echo $total_packages - $initial_show; ?></span>
                </button>
            </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- No Results -->
            <div class="no-results text-center py-5">
                <div class="no-results-icon mb-4">
                    <i class="bi bi-search" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h3 class="mb-3">No packages found</h3>
                <p class="text-muted mb-4">
                    We couldn't find any packages matching your criteria.<br>
                    Try adjusting your search or explore all our packages.
                </p>
                <a href="<?php echo base_url(); ?>#hero-top" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i>Try Another Search
                </a>
                <a href="<?php echo base_url('packages'); ?>" class="btn btn-outline-primary rounded-pill px-4 ms-2">
                    View All Packages
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="search-cta py-5" style="background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white mb-4 mb-lg-0">
                <h3 class="fw-bold mb-2">Can't find what you're looking for?</h3>
                <p class="mb-0 opacity-75">Let us create a custom safari package tailored to your preferences.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo base_url('contact'); ?>#contact" class="btn btn-light btn-lg rounded-pill px-4">
                    <i class="bi bi-chat-dots me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* Search Hero */
    .search-hero {
        padding-top: 140px !important;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }
    
    /* Package Cards */
    .package-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .package-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .package-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    
    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .package-card:hover .package-image img {
        transform: scale(1.1);
    }
    
    .package-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    }
    
    .package-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .package-wishlist {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.9);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .package-wishlist:hover {
        background: #dc3545;
        color: white;
    }
    
    .package-quick-info {
        position: absolute;
        bottom: 15px;
        left: 15px;
        display: flex;
        gap: 15px;
        color: white;
        font-size: 0.85rem;
    }
    
    .package-content {
        padding: 20px;
    }
    
    .package-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .package-rating .stars {
        color: #ffc107;
    }
    
    .package-rating .rating-text {
        font-weight: 600;
        color: #333;
    }
    
    .package-rating .reviews {
        color: #999;
        font-size: 0.85rem;
    }
    
    .package-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--dark, #3D3029);
        line-height: 1.4;
    }
    
    .package-location {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }
    
    .package-desc {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .package-highlights {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .highlight-tag {
        font-size: 0.8rem;
        color: #333;
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .package-includes {
        font-size: 0.85rem;
        color: #666;
        padding: 10px 0;
        border-top: 1px solid #e9ecef;
        margin-bottom: 15px;
    }
    
    .package-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }
    
    .package-price small {
        color: #999;
        font-size: 0.8rem;
    }
    
    .package-price strong {
        font-size: 1.4rem;
        color: #dc3545;
        font-weight: 700;
    }
    
    .package-actions {
        display: flex;
        gap: 8px;
    }
    
    /* No Results */
    .no-results {
        padding: 60px 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .search-hero {
            padding-top: 120px !important;
        }
        
        .package-actions {
            flex-direction: column;
        }
        
        .package-footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
</style>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true
    });
    
    // Wishlist toggle
    document.querySelectorAll('.package-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');
        });
    });
    
    // Load More Packages
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const hiddenItems = document.querySelectorAll('.package-item.d-none');
            const increment = parseInt(this.dataset.increment) || 6;
            let shown = 0;
            
            hiddenItems.forEach((item, index) => {
                if (shown < increment) {
                    item.classList.remove('d-none');
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.4s ease';
                        item.style.opacity = '1';
                    }, index * 100);
                    shown++;
                }
            });
            
            // Update remaining count
            const newHiddenCount = document.querySelectorAll('.package-item.d-none').length;
            const remainingBadge = document.getElementById('remainingCount');
            if (remainingBadge) {
                remainingBadge.textContent = newHiddenCount;
            }
            
            // Hide button if no more items
            if (newHiddenCount === 0) {
                document.getElementById('loadMoreContainer').style.display = 'none';
            }
            
            // Refresh AOS for new items
            AOS.refresh();
        });
    }
</script>
