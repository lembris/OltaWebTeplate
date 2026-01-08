<!-- ============================================
     PACKAGES LISTING PAGE - Dynamic Version
     ============================================ -->

<!-- Page Hero V3 -->
<?php include 'sections/page-hero-v3.php'; ?>

<!-- Packages Section -->
<section class="packages-listing-section py-5">
    <div class="container">
        
        <!-- Filter Bar -->
        <div class="filter-bar mb-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="filter-buttons">
                        <?php if(isset($package_filters) && !empty($package_filters)): ?>
                            <?php foreach($package_filters as $filter): ?>
                            <a href="<?php echo base_url('packages'); ?><?php echo $filter['key'] !== 'all' ? '?category=' . $filter['key'] : ''; ?>" 
                               class="filter-btn <?php echo (isset($active_category) && $active_category === $filter['key']) ? 'active' : ''; ?>">
                                <?php if(!empty($filter['icon'])): ?><?php echo $filter['icon']; ?> <?php endif; ?>
                                <?php echo $filter['label']; ?>
                                <?php if($filter['count'] > 0): ?>
                                <span class="count"><?php echo $filter['count']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sort-options text-lg-end mt-3 mt-lg-0">
                        <select class="form-select form-select-sm d-inline-block w-auto" id="sortPackages">
                            <option value="featured">Sort by: Featured</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="duration">Duration</option>
                            <option value="rating">Rating</option>
                        </select>
                    </div>
                </div>
            </div>
            </div>

            <?php 
            $total_packages = isset($packages) ? count($packages) : 0;
            $initial_show = 6;
            ?>

            <!-- Results Info -->
            <div class="results-info mb-4">
                <p class="text-muted mb-0">
                    Showing <strong id="visibleCount"><?php echo min($initial_show, $total_packages); ?></strong> of <strong><?php echo $total_packages; ?></strong> packages
                    <?php if(isset($active_category) && $active_category !== 'all'): ?>
                        in <strong><?php echo ucfirst($active_category); ?></strong>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Packages Grid -->
        <div class="row g-4" id="packagesGrid">
            <?php if(isset($packages) && !empty($packages)): ?>
                <?php 
                $delay = 100;
                foreach($packages as $index => $package): 
                    $image_url = $this->Package_model->get_package_image($package);
                    $stars = $this->Package_model->get_stars_html($package->rating);
                    $filter_cats = $this->Package_model->get_filter_categories_enhanced($package);
                ?>
                <div class="col-lg-4 col-md-6 package-item <?php echo $index >= $initial_show ? 'd-none' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" 
                     data-category="<?php echo htmlspecialchars($filter_cats); ?>"
                     data-price="<?php echo $package->base_price; ?>"
                     data-duration="<?php echo $package->duration_days; ?>"
                     data-rating="<?php echo $package->rating; ?>">
                    <div class="package-card-v3<?php echo $package->is_featured ? ' featured' : ''; ?>">
                        <div class="package-image-wrapper">
                            <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($package->name); ?>" loading="lazy">
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
                            <!-- Rating & Duration -->
                            <div class="package-meta">
                                <div class="rating">
                                    <span class="stars"><?php echo $stars; ?></span>
                                    <span class="rating-score"><?php echo number_format($package->rating, 1); ?></span>
                                    <span class="reviews">(<?php echo $package->review_count; ?>)</span>
                                </div>
                                <span class="duration"><i class="bi bi-clock me-1"></i><?php echo $package->duration_days; ?> Days</span>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="package-title"><?php echo htmlspecialchars($package->name); ?></h3>
                            
                            <!-- Description -->
                            <p class="package-desc"><?php echo character_limiter($package->description, 100); ?></p>
                            
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
                    $delay += 50;
                    if($delay > 300) $delay = 100;
                endforeach; 
                ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-packages-found text-center py-5">
                        <div class="empty-icon mb-4">🦁</div>
                        <h3>No packages found</h3>
                        <p class="text-muted">We couldn't find any packages matching your criteria.</p>
                        <a href="<?php echo base_url('packages'); ?>" class="btn btn-primary mt-3">View All Packages</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More (if needed) -->
        <?php if($total_packages > $initial_show): ?>
        <div class="text-center mt-5" data-aos="fade-up" id="loadMoreContainer">
            <button class="btn-load-more" id="loadMorePackages"
                    data-shown="<?php echo $initial_show; ?>"
                    data-total="<?php echo $total_packages; ?>"
                    data-increment="6">
                <i class="bi bi-plus-circle me-2"></i>Load More Packages
                <span class="badge bg-dark ms-2" id="remainingCount"><?php echo $total_packages - $initial_show; ?></span>
            </button>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA Section -->
<section class="packages-cta-section py-5">
    <div class="container">
        <div class="cta-card" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3>Can't find what you're looking for?</h3>
                    <p class="mb-lg-0">Let us create a custom safari tailored to your preferences and budget.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url('enquiry'); ?>" class="btn-custom-safari">
                        <i class="bi bi-pencil-square me-2"></i>Request Custom Safari
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick View Modals -->
<?php if(isset($packages) && !empty($packages)): ?>
<?php foreach($packages as $package): 
    $image_url = $this->Package_model->get_package_image($package);
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

<!-- Styles -->
<style>
/* Page Hero */
.page-hero-packages {
    position: relative;
    padding: 160px 0 100px;
    background: url('<?php echo base_url(); ?>assets/img/destinations/osiram_safari_adventure_great_migration-01.jpg') center/cover no-repeat;
}

.page-hero-packages .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(61,48,41,0.9) 0%, rgba(42,33,28,0.85) 100%);
}

.page-hero-packages .container {
    position: relative;
    z-index: 2;
}

.page-hero-packages .breadcrumb {
    background: transparent;
    margin-bottom: 20px;
}

.page-hero-packages .breadcrumb-item a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
}

.page-hero-packages .breadcrumb-item a:hover {
    color: white;
}

.page-hero-packages .breadcrumb-item.active {
    color: var(--primary, #C7805C);
}

.page-hero-packages .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}

.page-hero-packages .hero-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 15px;
}

.page-hero-packages .hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
}

.hero-stats {
    display: inline-flex;
    align-items: center;
    gap: 30px;
    background: rgba(255,255,255,0.1);
    padding: 20px 40px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
}

.hero-stats .stat-item {
    text-align: center;
}

.hero-stats .stat-item strong {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
}

.hero-stats .stat-item span {
    font-size: 0.85rem;
    opacity: 0.8;
}

.hero-stats .stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255,255,255,0.3);
}

/* Filter Bar */
.filter-bar {
    background: white;
    padding: 20px 25px;
    border-radius: 16px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.08);
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #f8f9fa;
    color: var(--dark, #3D3029);
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary, #C7805C);
    color: white;
}

.filter-btn .count {
    background: rgba(0,0,0,0.1);
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.75rem;
}

.filter-btn.active .count {
    background: rgba(255,255,255,0.2);
}

/* Package Cards - Inherit from sections/packages.php */
.packages-listing-section {
    background: #f8f9fa;
}

.package-desc {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 12px;
    line-height: 1.5;
}

/* No Packages Found */
.no-packages-found {
    background: white;
    border-radius: 20px;
    padding: 60px 40px;
}

.no-packages-found .empty-icon {
    font-size: 4rem;
}

/* Load More Button */
.btn-load-more {
    display: inline-flex;
    align-items: center;
    padding: 15px 40px;
    background: white;
    color: var(--dark, #3D3029);
    border: 2px solid var(--dark, #3D3029);
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-load-more:hover {
    background: var(--dark, #3D3029);
    color: white;
}

/* CTA Section */
.packages-cta-section {
    background: linear-gradient(135deg, var(--dark, #3D3029) 0%, #2a211c 100%);
}

.cta-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 40px;
    color: white;
}

.cta-card h3 {
    font-weight: 700;
    margin-bottom: 10px;
}

.cta-card p {
    opacity: 0.8;
}

.btn-custom-safari {
    display: inline-flex;
    align-items: center;
    padding: 15px 30px;
    background: linear-gradient(135deg, var(--primary-light, #D9B39B) 0%, var(--primary, #C7805C) 100%);
    color: var(--dark, #3D3029);
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-custom-safari:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.4);
    color: var(--dark, #3D3029);
}

/* Responsive */
@media (max-width: 768px) {
    .page-hero-packages {
        padding: 120px 0 60px;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 15px;
        padding: 20px 30px;
    }
    
    .hero-stats .stat-divider {
        width: 60px;
        height: 1px;
    }
    
    .filter-buttons {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
        -webkit-overflow-scrolling: touch;
    }
    
    .filter-btn {
        white-space: nowrap;
    }
    
    .cta-card {
        text-align: center;
    }
    
    .btn-custom-safari {
        margin-top: 20px;
    }
}
</style>

<!-- Include package card styles -->
<style>
    /* Package Card Styles (same as homepage) */
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
        border: 2px solid var(--primary, #C7805C);
    }
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
    .package-badges {
        position: absolute;
        top: 15px;
        left: 15px;
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
    .badge-premium { background: linear-gradient(135deg, var(--primary-light, #D9B39B), var(--primary, #C7805C)); color: var(--dark, #3D3029); }
    .badge-beach { background: linear-gradient(135deg, #0dcaf0, #0aa2c0); }
    .badge-culture { background: linear-gradient(135deg, #6f42c1, #5a32a3); }
    .badge-ultimate { background: linear-gradient(135deg, var(--dark, #3D3029), #2a211c); }
    .badge-budget { background: linear-gradient(135deg, #20c997, #17a589); }
    .badge-adventure { background: linear-gradient(135deg, #fd7e14, #e55a00); }
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
        background: var(--primary, #C7805C);
        color: white;
    }
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
        color: var(--primary, #C7805C);
        font-size: 0.9rem;
    }
    .package-meta .rating-score {
        font-weight: 700;
        color: var(--dark, #3D3029);
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
        color: var(--dark, #3D3029);
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
        color: var(--primary, #C7805C);
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
        color: var(--dark, #3D3029);
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }
    .btn-package-details:hover {
        background: #e9ecef;
        color: var(--primary, #C7805C);
    }
    .btn-package-book {
        flex: 1;
        padding: 12px 16px;
        background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to packages grid if filter is active
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('category')) {
        const packagesSection = document.querySelector('.packages-listing-section');
        if (packagesSection) {
            setTimeout(() => {
                packagesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
    
    // Sort functionality
    const sortSelect = document.getElementById('sortPackages');
    const grid = document.getElementById('packagesGrid');
    
    if (sortSelect && grid) {
        sortSelect.addEventListener('change', function() {
            const packages = Array.from(grid.querySelectorAll('[data-price]'));
            
            packages.sort((a, b) => {
                switch(this.value) {
                    case 'price-low':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price-high':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    case 'duration':
                        return parseInt(a.dataset.duration) - parseInt(b.dataset.duration);
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    default:
                        return 0;
                }
            });
            
            packages.forEach(pkg => grid.appendChild(pkg));
        });
    }
    
    // Wishlist toggle
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            if (icon && icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                this.style.background = '#dc3545';
                this.style.color = 'white';
            }
        });
    });
    
    // Load More Packages
    const loadMoreBtn = document.getElementById('loadMorePackages');
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
            
            // Update visible count
            const visibleCount = document.querySelectorAll('.package-item:not(.d-none)').length;
            const visibleCountEl = document.getElementById('visibleCount');
            if (visibleCountEl) {
                visibleCountEl.textContent = visibleCount;
            }
            
            // Hide button if no more items
            if (newHiddenCount === 0) {
                document.getElementById('loadMoreContainer').style.display = 'none';
            }
            
            // Refresh AOS for new items
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    }
});
</script>
