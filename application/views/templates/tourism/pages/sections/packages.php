<!-- ============================================
     AWESOME PACKAGES SECTION - Dynamic Version
     ============================================ -->
<section class="packages-section-v3 py-6" id="packages">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <span class="section-badge" data-aos="fade-up">
                <i class="bi bi-gem me-2"></i>CURATED EXPERIENCES
            </span>
            <h2 class="section-title-v3 mt-3" data-aos="fade-up" data-aos-delay="100">
                Awesome Safari Packages
            </h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Handcrafted adventures designed to create unforgettable memories
            </p>
        </div>

        <!-- Filter Tabs - Dynamic -->
        <div class="package-filters text-center mb-5" data-aos="fade-up" data-aos-delay="300">
            <?php if(isset($package_filters) && !empty($package_filters)): ?>
                <?php foreach($package_filters as $index => $filter): ?>
                <button class="filter-btn<?php echo $index === 0 ? ' active' : ''; ?>" data-filter="<?php echo $filter['key']; ?>">
                    <?php if(!empty($filter['icon'])): ?><?php echo $filter['icon']; ?> <?php endif; ?><?php echo $filter['label']; ?>
                </button>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static filters -->
                <button class="filter-btn active" data-filter="all">All Packages</button>
                <button class="filter-btn" data-filter="popular">🔥 Popular</button>
                <button class="filter-btn" data-filter="budget">💰 Budget</button>
                <button class="filter-btn" data-filter="luxury">👑 Luxury</button>
            <?php endif; ?>
        </div>

        <!-- Packages Grid -->
        <div class="row g-4">
            <?php if(isset($packages) && !empty($packages)): ?>
                <?php 
                $delay = 100;
                $CI =& get_instance();
                $CI->load->model('Package_model');
                foreach($packages as $index => $package): 
                    $image_url = $CI->Package_model->get_package_image($package);
                    $stars = $CI->Package_model->get_stars_html($package->rating);
                    $filter_cats = $CI->Package_model->get_filter_categories_enhanced($package);
                    $is_featured = ($index < 3 || $package->is_featured);
                ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" data-category="<?php echo htmlspecialchars($filter_cats); ?>">
                    <div class="package-card-v3<?php echo $is_featured ? ' featured' : ''; ?>">
                        <div class="package-image-wrapper">
                            <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($package->name); ?>">
                            <div class="package-overlay"></div>
                            
                            <!-- Badges -->
                            <div class="package-badges">
                                <span class="<?php echo $package->badge['class']; ?>"><?php echo $package->badge['text']; ?></span>
                            </div>
                            
                            <!-- Price Tag -->
                            <div class="package-price-tag">
                                <?php if($package->old_price > $package->base_price): ?>
                                <span class="old-price">$<?php echo number_format($package->old_price); ?></span>
                                <?php endif; ?>
                                <span class="current-price">$<?php echo number_format($package->base_price); ?></span>
                                <span class="per-person">/person</span>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="package-quick-actions">
                                <button class="action-btn" title="Add to Wishlist"><i class="bi bi-heart"></i></button>
                                <button class="action-btn" title="Quick View" data-bs-toggle="modal" data-bs-target="#packageModal<?php echo $package->id; ?>"><i class="bi bi-eye"></i></button>
                                <button class="action-btn" title="Share"><i class="bi bi-share"></i></button>
                            </div>
                        </div>
                        
                        <div class="package-content">
                            <!-- Rating & Reviews -->
                            <div class="package-meta">
                                <div class="rating">
                                    <span class="stars"><?php echo $stars; ?></span>
                                    <span class="rating-score"><?php echo number_format($package->rating, 1); ?></span>
                                    <span class="reviews">(<?php echo $package->review_count; ?> reviews)</span>
                                </div>
                                <span class="duration"><i class="bi bi-clock me-1"></i><?php echo $package->duration_days; ?> Days</span>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="package-title"><?php echo htmlspecialchars($package->name); ?></h3>
                            
                            <!-- Destinations -->
                            <div class="package-destinations">
                                <?php 
                                $destinations = array_slice($package->destinations_array, 0, 3);
                                foreach($destinations as $destination): 
                                ?>
                                <span><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($destination); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Highlights -->
                            <div class="package-highlights">
                                <?php foreach($package->highlights as $highlight): ?>
                                <span class="highlight"><i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($highlight); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Footer -->
                            <div class="package-footer">
                                <a href="<?php echo base_url('packages/' . $package->slug); ?>" class="btn-package-details">
                                    View Details <i class="bi bi-arrow-right"></i>
                                </a>
                                <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn-package-book">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    $delay += 100;
                    if($delay > 300) $delay = 100;
                endforeach; 
                ?>
            <?php else: ?>
                <!-- Fallback if no packages in database -->
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        No packages available at the moment. Please check back later.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- View All Button -->
        <?php if(isset($current_page_name) && $current_page_name == 'Home'): ?>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo base_url('search'); ?>" class="btn-view-all-packages">
                <span>View All Packages</span>
                <i class="bi bi-arrow-right-circle-fill ms-2"></i>
            </a>
            <p class="mt-3 text-muted">
                <i class="bi bi-shield-check text-success me-1"></i>
                Free cancellation up to 30 days before departure
            </p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Quick View Modals -->
<?php if(isset($packages) && !empty($packages)): ?>
<?php 
$CI =& get_instance();
$CI->load->model('Package_model');
foreach($packages as $package): 
    $image_url = $CI->Package_model->get_package_image($package);
?>
<div class="modal fade" id="packageModal<?php echo $package->id; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><?php echo htmlspecialchars($package->name); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($package->name); ?>" class="img-fluid rounded-3">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-primary"><?php echo $package->duration_days; ?> Days</span>
                            <span class="badge bg-secondary"><?php echo ucfirst($package->category); ?></span>
                            <span class="text-warning">★ <?php echo number_format($package->rating, 1); ?></span>
                        </div>
                        <p class="text-muted"><?php echo htmlspecialchars($package->description); ?></p>
                        
                        <h6 class="fw-bold mt-3">Destinations:</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <?php foreach($package->destinations_array as $dest): ?>
                            <span class="badge bg-light text-dark"><i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($dest); ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <h6 class="fw-bold">Highlights:</h6>
                        <ul class="list-unstyled">
                            <?php foreach($package->highlights as $highlight): ?>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i><?php echo htmlspecialchars($highlight); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <small class="text-muted">From</small>
                                <h3 class="text-danger mb-0">$<?php echo number_format($package->base_price); ?></h3>
                                <small class="text-muted">per person</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?php echo base_url('packages/' . $package->slug); ?>" class="btn btn-outline-primary">Details</a>
                                <a href="<?php echo base_url('booking?package=' . $package->id); ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<!-- Package Styles -->
<style>
    .packages-section-v3 {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        position: relative;
    }

    .section-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .section-title-v3 {
        font-size: clamp(2rem, 5vw, 2.8rem);
        font-weight: 800;
        color: #1a1a2e;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Filter Tabs */
    .package-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .filter-btn {
        padding: 10px 24px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--theme-primary, #C7805C);
        border-color: var(--theme-primary, #C7805C);
        color: white;
    }

    /* Package Card */
    .package-card-v3 {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .package-card-v3:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .package-card-v3.featured {
        border: 2px solid #ffc107;
    }

    .package-card-v3.featured::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffc107, #ff8c00);
        z-index: 10;
    }

    /* Image Wrapper */
    .package-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .package-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .package-card-v3:hover .package-image-wrapper img {
        transform: scale(1.1);
    }

    .package-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
    }

    /* Badges */
    .package-badges {
        position: absolute;
        top: 15px;
        left: 15px;
        display: flex;
        gap: 8px;
    }

    .package-badges span {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
    }

    .badge-featured { background: linear-gradient(135deg, #dc3545, #c82333); }
    .badge-value { background: linear-gradient(135deg, #198754, #157347); }
    .badge-premium { background: linear-gradient(135deg, #ffc107, #ff8c00); color: #1a1a2e; }
    .badge-beach { background: linear-gradient(135deg, #0dcaf0, #0aa2c0); }
    .badge-culture { background: linear-gradient(135deg, #6f42c1, #5a32a3); }
    .badge-ultimate { background: linear-gradient(135deg, #1a1a2e, #16213e); }
    .badge-budget { background: linear-gradient(135deg, #20c997, #17a589); }
    .badge-adventure { background: linear-gradient(135deg, #fd7e14, #e55a00); }

    /* Price Tag */
    .package-price-tag {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: white;
        padding: 10px 16px;
        border-radius: 12px;
        text-align: right;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .package-price-tag .old-price {
        font-size: 0.85rem;
        color: #999;
        text-decoration: line-through;
        display: block;
    }

    .package-price-tag .current-price {
        font-size: 1.4rem;
        font-weight: 800;
        color: #dc3545;
    }

    .package-price-tag .per-person {
        font-size: 0.75rem;
        color: #666;
    }

    /* Quick Actions */
    .package-quick-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .package-card-v3:hover .package-quick-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }

    .action-btn:hover {
        background: var(--theme-primary, #C7805C);
        color: white;
        transform: scale(1.1);
    }

    /* Content */
    .package-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .package-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .package-meta .rating {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .package-meta .stars {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .package-meta .rating-score {
        font-weight: 700;
        color: #1a1a2e;
    }

    .package-meta .reviews {
        font-size: 0.8rem;
        color: #999;
    }

    .package-meta .duration {
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
    }

    .package-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .package-destinations {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 12px;
    }

    .package-destinations span {
        font-size: 0.8rem;
        color: var(--theme-primary, #C7805C);
        background: rgba(199, 128, 92, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
    }

    .package-highlights {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .package-highlights .highlight {
        font-size: 0.8rem;
        color: #666;
    }

    .package-highlights .highlight i {
        color: #198754;
        margin-right: 4px;
    }

    /* Footer */
    .package-footer {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
        margin-top: auto;
    }

    .btn-package-details {
        flex: 1;
        padding: 12px 16px;
        background: #f8f9fa;
        color: #1a1a2e;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-package-details:hover {
        background: #e9ecef;
        color: var(--theme-primary, #C7805C);
    }

    .btn-package-book {
        flex: 1;
        padding: 12px 16px;
        background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-package-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(199, 128, 92, 0.4);
        color: white;
    }

    /* View All Button */
    .btn-view-all-packages {
        display: inline-flex;
        align-items: center;
        padding: 16px 40px;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-view-all-packages:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(26, 26, 46, 0.3);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .package-footer {
            flex-direction: column;
        }
        
        .filter-btn {
            padding: 8px 16px;
            font-size: 0.8rem;
        }
        
        .package-price-tag {
            padding: 8px 12px;
        }
        
        .package-price-tag .current-price {
            font-size: 1.2rem;
        }
    }
</style>

<script>
// Filter functionality - supports multiple categories
function filterPackages(filter) {
    // Update active state
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    if (activeBtn) activeBtn.classList.add('active');
    
    const packages = document.querySelectorAll('[data-category]');
    
    packages.forEach(pkg => {
        const categories = pkg.dataset.category.split(' ');
        if (filter === 'all' || categories.includes(filter)) {
            pkg.style.display = 'block';
            pkg.style.animation = 'fadeIn 0.5s ease';
        } else {
            pkg.style.display = 'none';
        }
    });
}

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        filterPackages(this.dataset.filter);
    });
});

// Check URL for category parameter on page load
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash.includes('packages')) {
        // Extract category from hash (e.g., #packages?category=popular)
        const categoryMatch = hash.match(/category=(\w+)/);
        if (categoryMatch && categoryMatch[1]) {
            const category = categoryMatch[1];
            // Small delay to ensure DOM is ready and scroll happens first
            setTimeout(() => {
                filterPackages(category);
            }, 100);
        }
    }
});

// Also handle hash changes (for same-page navigation)
window.addEventListener('hashchange', function() {
    const hash = window.location.hash;
    if (hash.includes('packages')) {
        const categoryMatch = hash.match(/category=(\w+)/);
        if (categoryMatch && categoryMatch[1]) {
            filterPackages(categoryMatch[1]);
            // Scroll to packages section
            document.getElementById('packages').scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// Wishlist toggle
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const icon = this.querySelector('i');
        if (icon.classList.contains('bi-heart')) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            this.style.background = '#dc3545';
            this.style.color = 'white';
        }
    });
});
</script>
