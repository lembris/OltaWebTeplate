<?php
/**
 * Package Detail Page - V3 Premium Design
 * 
 * Expects $package array with package data
 */

// Default values if not set
$package = $package ?? [];
?>

<!-- Page Hero -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>

<!-- ============================================
     PACKAGE HEADER - Quick Info Bar
     ============================================ -->
<section class="package-header-v3 py-4">
    <div class="container">
        <div class="package-header-card" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="package-meta">
                        <span class="package-badge-duration">
                            <i class="bi bi-clock"></i> <?php echo $package['duration'] ?? '6 Days'; ?>
                        </span>
                        <span class="package-badge-difficulty <?php echo strtolower($package['difficulty'] ?? 'easy'); ?>">
                            <?php echo $package['difficulty'] ?? 'Easy'; ?>
                        </span>
                        <div class="package-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">(<?php echo $package['reviews'] ?? '48'; ?> reviews)</span>
                        </div>
                    </div>
                    <div class="package-quick-info">
                        <div class="info-item">
                            <i class="bi bi-people"></i>
                            <span><?php echo $package['group_size'] ?? '2-8'; ?> People</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-house"></i>
                            <span><?php echo $package['accommodation'] ?? 'Mid-range Lodge'; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-geo-alt"></i>
                            <span><?php echo $package['destinations_count'] ?? '3'; ?> Destinations</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="package-price-cta">
                        <div class="price-display">
                            <span class="price-label">From</span>
                            <span class="price-amount">$<?php echo number_format($package['price_from'] ?? 2499); ?></span>
                            <span class="price-per">per person</span>
                        </div>
                        <div class="package-cta-buttons">
                            <a href="<?php echo base_url('booking?package=' . ($package['slug'] ?? '')); ?>" class="btn-book-package">
                                <i class="bi bi-calendar-check me-2"></i>Book Now
                            </a>
                            <a href="<?php echo base_url('enquiry'); ?>" class="btn-enquire-package">
                                <i class="bi bi-send me-2"></i>Get Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     PACKAGE OVERVIEW
     ============================================ -->
<section class="package-overview-v3 py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="overview-content">
                    <h2 class="section-title-v3 text-start mb-4">
                        <span class="text-gradient">Overview</span>
                    </h2>
                    <p class="overview-text">
                        <?php echo $package['description'] ?? 'Experience the magic of Tanzania on this incredible safari adventure. Witness the stunning wildlife of the Serengeti, explore the unique ecosystem of the Ngorongoro Crater, and create memories that will last a lifetime.'; ?>
                    </p>
                    
                    <!-- Highlights -->
                    <div class="package-highlights mt-4">
                        <h4><i class="bi bi-stars me-2"></i>Tour Highlights</h4>
                        <div class="highlights-grid">
                            <?php 
                            $highlights = $package['highlights'] ?? [
                                'Witness the Great Migration in Serengeti',
                                'Explore Ngorongoro Crater - UNESCO World Heritage',
                                'Spot the Big Five in their natural habitat',
                                'Professional English-speaking guide',
                                'Comfortable 4x4 safari vehicle',
                                'All park fees and taxes included'
                            ];
                            foreach ($highlights as $highlight): ?>
                            <div class="highlight-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><?php echo $highlight; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Facts Sidebar -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="quick-facts-card">
                    <h4 class="facts-title"><i class="bi bi-info-circle me-2"></i>Quick Facts</h4>
                    <ul class="facts-list">
                        <li>
                            <span class="fact-label">Best Time</span>
                            <span class="fact-value"><?php echo $package['best_time'] ?? 'June - October'; ?></span>
                        </li>
                        <li>
                            <span class="fact-label">Start Location</span>
                            <span class="fact-value"><?php echo $package['start_location'] ?? 'Arusha'; ?></span>
                        </li>
                        <li>
                            <span class="fact-label">End Location</span>
                            <span class="fact-value"><?php echo $package['end_location'] ?? 'Arusha'; ?></span>
                        </li>
                        <li>
                            <span class="fact-label">Languages</span>
                            <span class="fact-value"><?php echo $package['languages'] ?? 'English, Swahili'; ?></span>
                        </li>
                        <li>
                            <span class="fact-label">Min. Age</span>
                            <span class="fact-value"><?php echo $package['min_age'] ?? '5 years'; ?></span>
                        </li>
                        <li>
                            <span class="fact-label">Tour Type</span>
                            <span class="fact-value"><?php echo $package['tour_type'] ?? 'Private Safari'; ?></span>
                        </li>
                    </ul>
                    
                    <!-- Need Help Box -->
                    <div class="need-help-box">
                        <div class="help-icon">💬</div>
                        <h5>Need Help?</h5>
                        <p>Our safari experts are here to assist you</p>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>" class="btn-whatsapp-help" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     DAY-BY-DAY ITINERARY
     ============================================ -->
<section class="package-itinerary-v3 py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">📅 YOUR ADVENTURE</span>
            <h2 class="section-title-v3">Day-by-Day <span class="text-gradient">Itinerary</span></h2>
        </div>
        
        <div class="itinerary-timeline" data-aos="fade-up">
            <?php 
            $itinerary = $package['itinerary'] ?? [
                ['day' => 0, 'title' => 'Arrival Day', 'description' => 'Your safari adventure commences with your arrival in Arusha. You\'ll be welcomed at Kilimanjaro Airport and introduced to your guide. Dinner and overnight at the lodge.', 'meals' => 'D', 'accommodation' => 'Lodge in Arusha'],
                ['day' => 1, 'title' => 'Arusha - Serengeti National Park', 'description' => 'Early morning drive to Serengeti via Ngorongoro. Game drive en route. Arrive at camp for dinner.', 'meals' => 'B,L,D', 'accommodation' => 'Serengeti Camp'],
                ['day' => 2, 'title' => 'Full Day Serengeti Game Drive', 'description' => 'Full day exploring Serengeti\'s vast plains. Spot the Big Five and witness incredible wildlife.', 'meals' => 'B,L,D', 'accommodation' => 'Serengeti Camp'],
                ['day' => 3, 'title' => 'Serengeti - Central Serengeti', 'description' => 'Morning game drive, then head to central Serengeti for more wildlife viewing.', 'meals' => 'B,L,D', 'accommodation' => 'Central Serengeti Camp'],
                ['day' => 4, 'title' => 'Serengeti - Ngorongoro', 'description' => 'Depart Serengeti, game drive en route to Ngorongoro Crater rim.', 'meals' => 'B,L,D', 'accommodation' => 'Ngorongoro Lodge'],
                ['day' => 5, 'title' => 'Ngorongoro Crater - Karatu', 'description' => 'Descend into the crater for a full day safari. Spot wildlife in this natural wonder.', 'meals' => 'B,L,D', 'accommodation' => 'Karatu Lodge'],
                ['day' => 6, 'title' => 'Departure', 'description' => 'Morning at leisure, then transfer to Arusha or Kilimanjaro Airport.', 'meals' => 'B', 'accommodation' => '-']
            ];
            
            foreach ($itinerary as $day): ?>
            <div class="itinerary-day">
                <div class="day-marker">
                    <span class="day-number">Day <?php echo $day['day']; ?></span>
                </div>
                <div class="day-content">
                    <div class="day-header">
                        <h4><?php echo $day['title']; ?></h4>
                        <div class="day-badges">
                            <?php if (!empty($day['meals'])): ?>
                            <span class="badge-meals" title="Meals: <?php echo $day['meals']; ?>">
                                <i class="bi bi-cup-hot"></i> <?php echo $day['meals']; ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($day['accommodation']) && $day['accommodation'] !== '-'): ?>
                            <span class="badge-accommodation">
                                <i class="bi bi-house"></i> <?php echo $day['accommodation']; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="day-description"><?php echo $day['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================
     INCLUSIONS & EXCLUSIONS
     ============================================ -->
<section class="package-inclusions-v3 py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Inclusions -->
            <div class="col-lg-6" data-aos="fade-up">
                <div class="inclusion-card included">
                    <div class="card-header-v3">
                        <i class="bi bi-check-circle-fill"></i>
                        <h4>What's Included</h4>
                    </div>
                    <ul class="inclusion-list">
                        <?php 
                        $inclusions = $package['inclusions'] ?? [
                            'Airport pickup & drop-off',
                            'All park fees (for non-residents)',
                            'All accommodation as per itinerary',
                            'Private 4x4 Land Cruiser with pop-up roof',
                            'Professional English-speaking guide',
                            'All meals during safari',
                            'Drinking water during game drives',
                            'All taxes and government fees'
                        ];
                        foreach ($inclusions as $item): ?>
                        <li><i class="bi bi-check2"></i><?php echo $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Exclusions -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="inclusion-card excluded">
                    <div class="card-header-v3">
                        <i class="bi bi-x-circle-fill"></i>
                        <h4>What's Not Included</h4>
                    </div>
                    <ul class="inclusion-list">
                        <?php 
                        $exclusions = $package['exclusions'] ?? [
                            'International flights',
                            'Visa fees',
                            'Travel insurance',
                            'Tips and gratuities',
                            'Personal expenses',
                            'Optional activities (balloon safari, etc.)',
                            'Alcoholic beverages',
                            'Items of personal nature'
                        ];
                        foreach ($exclusions as $item): ?>
                        <li><i class="bi bi-x"></i><?php echo $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     PRICING TABLE
     ============================================ -->
<section class="package-pricing-v3 py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">💰 TRANSPARENT PRICING</span>
            <h2 class="section-title-v3">Safari <span class="text-gradient">Pricing</span></h2>
            <p class="section-subtitle">Prices per person based on group size and season</p>
        </div>
        
        <div class="pricing-table-wrapper" data-aos="fade-up">
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th>Season / Group Size</th>
                        <th>2 People</th>
                        <th>3-4 People</th>
                        <th>5-6 People</th>
                        <th>7+ People</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="season-name">
                            <span class="season-badge peak">Peak Season</span>
                            <small>Jul - Oct</small>
                        </td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) + 300); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) + 100); ?></td>
                        <td>$<?php echo number_format($package['price_from'] ?? 2499); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 150); ?></td>
                    </tr>
                    <tr>
                        <td class="season-name">
                            <span class="season-badge high">High Season</span>
                            <small>Jan - Mar, Dec</small>
                        </td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) + 100); ?></td>
                        <td>$<?php echo number_format($package['price_from'] ?? 2499); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 100); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 250); ?></td>
                    </tr>
                    <tr>
                        <td class="season-name">
                            <span class="season-badge mid">Mid Season</span>
                            <small>Jun, Nov</small>
                        </td>
                        <td>$<?php echo number_format($package['price_from'] ?? 2499); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 100); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 200); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 350); ?></td>
                    </tr>
                    <tr>
                        <td class="season-name">
                            <span class="season-badge low">Low Season</span>
                            <small>Apr - May</small>
                        </td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 200); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 300); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 400); ?></td>
                        <td>$<?php echo number_format(($package['price_from'] ?? 2499) - 500); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="pricing-notes mt-4" data-aos="fade-up">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="pricing-note">
                        <i class="bi bi-info-circle"></i>
                        <span>Prices include all park fees & taxes</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-note">
                        <i class="bi bi-percent"></i>
                        <span>Children under 12 get 25% discount</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-note">
                        <i class="bi bi-arrow-up-circle"></i>
                        <span>Luxury upgrades available</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     MAP
     ============================================ -->
<section class="package-map-v3 py-5">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <h3 class="section-title-v3"><i class="bi bi-map me-2"></i>Route <span class="text-gradient">Map</span></h3>
        </div>
        <div class="map-wrapper" data-aos="fade-up">
            <iframe src="https://www.google.com/maps/d/embed?mid=15Xh5ywHwB46howKqLgnHW96zk5g8uy8&ehbc=2E312F" width="100%" height="450" style="border:0; border-radius: 16px;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- ============================================
     BOOKING CTA
     ============================================ -->
<section class="package-cta-v3 py-6">
    <div class="container">
        <div class="cta-card-v3" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="cta-title">Ready to Experience This Safari?</h2>
                    <p class="cta-desc">Book now to secure your spot or get a custom quote tailored to your preferences.</p>
                    <div class="cta-features">
                        <span><i class="bi bi-check-circle-fill"></i> No hidden fees</span>
                        <span><i class="bi bi-check-circle-fill"></i> Free cancellation up to 30 days</span>
                        <span><i class="bi bi-check-circle-fill"></i> 24/7 support</span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="cta-buttons-v3">
                        <a href="<?php echo base_url('booking?package=' . ($package['slug'] ?? '')); ?>" class="btn-cta-primary">
                            <i class="bi bi-calendar-check me-2"></i>Book This Safari
                        </a>
                        <a href="<?php echo base_url('enquiry'); ?>" class="btn-cta-secondary-outline">
                            <i class="bi bi-send me-2"></i>Get Custom Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     RELATED PACKAGES
     ============================================ -->
<section class="related-packages-v3 py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">🌍 MORE ADVENTURES</span>
            <h2 class="section-title-v3">Related <span class="text-gradient">Packages</span></h2>
        </div>
        
        <div class="row g-4">
            <?php 
            $related = $package['related'] ?? [
                ['slug' => '5-days-safari-package', 'title' => '5 Days Budget Safari', 'price' => 1899, 'duration' => '5 Days', 'image' => 'serengeti.jpg'],
                ['slug' => '7-days-safari-package', 'title' => '7 Days Classic Safari', 'price' => 2899, 'duration' => '7 Days', 'image' => 'ngorongoro.jpg'],
                ['slug' => '10-days-safari-package', 'title' => '10 Days Ultimate Safari', 'price' => 4299, 'duration' => '10 Days', 'image' => 'kilimanjaro.jpg']
            ];
            foreach ($related as $idx => $rel): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $idx * 100; ?>">
                <div class="related-package-card">
                    <div class="card-image">
                        <img src="<?php echo base_url('assets/img/' . $rel['image']); ?>" alt="<?php echo $rel['title']; ?>">
                        <span class="card-duration"><i class="bi bi-clock me-1"></i><?php echo $rel['duration']; ?></span>
                    </div>
                    <div class="card-content">
                        <h4><?php echo $rel['title']; ?></h4>
                        <div class="card-footer-v3">
                            <div class="card-price">
                                <small>From</small>
                                <strong>$<?php echo number_format($rel['price']); ?></strong>
                            </div>
                            <a href="<?php echo base_url('safari/' . $rel['slug']); ?>" class="btn-view-package">
                                View <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- GLightbox for Gallery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<style>
/* ============ PACKAGE HEADER V3 ============ */
.package-header-v3 {
    background: white;
    border-bottom: 1px solid #eee;
}

.package-header-card {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 25px 30px;
}

.package-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.package-badge-duration {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    padding: 6px 14px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
}

.package-badge-difficulty {
    padding: 6px 14px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
}

.package-badge-difficulty.easy { background: #d1fae5; color: #065f46; }
.package-badge-difficulty.moderate { background: #fef3c7; color: #92400e; }
.package-badge-difficulty.challenging { background: #fee2e2; color: #991b1b; }

.package-rating .stars {
    color: #ffc107;
    font-size: 1rem;
    margin-right: 5px;
}

.package-rating .count {
    color: #666;
    font-size: 0.85rem;
}

.package-quick-info {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.package-quick-info .info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 0.9rem;
}

.package-quick-info .info-item i {
    color: var(--primary, #C7805C);
}

.package-price-cta {
    text-align: right;
}

.price-display {
    margin-bottom: 15px;
}

.price-label {
    display: block;
    color: #666;
    font-size: 0.85rem;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark, #3D3029);
    line-height: 1;
}

.price-per {
    display: block;
    color: #666;
    font-size: 0.85rem;
}

.package-cta-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-book-package {
    padding: 12px 25px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-book-package:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(199, 128, 92, 0.3);
    color: white;
}

.btn-enquire-package {
    padding: 12px 25px;
    background: transparent;
    color: var(--dark, #3D3029);
    border: 2px solid var(--dark, #3D3029);
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-enquire-package:hover {
    background: var(--dark, #3D3029);
    color: white;
}

/* ============ OVERVIEW ============ */
.overview-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
}

.package-highlights h4 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark, #3D3029);
    margin-bottom: 20px;
}

.highlights-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.highlight-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.highlight-item i {
    color: #10b981;
    font-size: 1.1rem;
    margin-top: 2px;
}

.highlight-item span {
    color: #555;
}

/* Quick Facts Card */
.quick-facts-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    position: sticky;
    top: 100px;
}

.facts-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark, #3D3029);
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.facts-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.facts-list li {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.fact-label {
    color: #888;
    font-size: 0.9rem;
}

.fact-value {
    font-weight: 600;
    color: var(--dark, #3D3029);
    font-size: 0.9rem;
}

.need-help-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

.need-help-box .help-icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

.need-help-box h5 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.need-help-box p {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 15px;
}

.btn-whatsapp-help {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #25D366;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-whatsapp-help:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
    color: white;
}

/* ============ ITINERARY ============ */
.itinerary-timeline {
    position: relative;
    padding-left: 30px;
}

.itinerary-timeline::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-radius: 3px;
}

.itinerary-day {
    position: relative;
    margin-bottom: 25px;
}

.day-marker {
    position: absolute;
    left: -30px;
    top: 0;
}

.day-number {
    display: inline-block;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    padding: 8px 15px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
    white-space: nowrap;
}

.day-content {
    background: white;
    border-radius: 16px;
    padding: 25px;
    margin-left: 80px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.day-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.day-header h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark, #3D3029);
    margin: 0;
}

.day-badges {
    display: flex;
    gap: 10px;
}

.badge-meals, .badge-accommodation {
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-meals {
    background: #fef3c7;
    color: #92400e;
}

.badge-accommodation {
    background: #dbeafe;
    color: #1e40af;
}

.day-description {
    color: #666;
    line-height: 1.7;
    margin: 0;
}

/* ============ INCLUSIONS ============ */
.inclusion-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    height: 100%;
}

.card-header-v3 {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.card-header-v3 i {
    font-size: 1.5rem;
}

.included .card-header-v3 i { color: #10b981; }
.excluded .card-header-v3 i { color: #ef4444; }

.card-header-v3 h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
}

.inclusion-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.inclusion-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f8f8f8;
}

.inclusion-list li:last-child {
    border-bottom: none;
}

.included .inclusion-list li i { color: #10b981; }
.excluded .inclusion-list li i { color: #ef4444; }

/* ============ PRICING TABLE ============ */
.pricing-table-wrapper {
    overflow-x: auto;
}

.pricing-table {
    width: 100%;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.pricing-table th, .pricing-table td {
    padding: 18px 20px;
    text-align: center;
}

.pricing-table thead {
    background: linear-gradient(135deg, var(--dark, #3D3029) 0%, #2a211c 100%);
    color: white;
}

.pricing-table thead th {
    font-weight: 600;
    font-size: 0.9rem;
}

.pricing-table tbody tr {
    border-bottom: 1px solid #f0f0f0;
}

.pricing-table tbody tr:hover {
    background: #f8f9fa;
}

.season-name {
    text-align: left !important;
}

.season-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 3px;
}

.season-badge.peak { background: #fef3c7; color: #92400e; }
.season-badge.high { background: #dbeafe; color: #1e40af; }
.season-badge.mid { background: #d1fae5; color: #065f46; }
.season-badge.low { background: #f3f4f6; color: #4b5563; }

.season-name small {
    display: block;
    font-size: 0.75rem;
    color: #888;
}

.pricing-table tbody td:not(.season-name) {
    font-weight: 700;
    color: var(--dark, #3D3029);
    font-size: 1.1rem;
}

.pricing-notes {
    background: white;
    border-radius: 12px;
    padding: 20px;
}

.pricing-note {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #666;
    font-size: 0.9rem;
}

.pricing-note i {
    color: var(--primary, #C7805C);
}

/* ============ MAP ============ */
.map-wrapper {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

/* ============ CTA ============ */
.package-cta-v3 {
    background: linear-gradient(135deg, var(--dark, #3D3029) 0%, #2a211c 100%);
}

.package-cta-v3 .cta-card-v3 {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px;
    border: 1px solid rgba(255,255,255,0.1);
}

.package-cta-v3 .cta-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    margin-bottom: 10px;
}

.package-cta-v3 .cta-desc {
    color: rgba(255,255,255,0.8);
    margin-bottom: 15px;
}

.package-cta-v3 .cta-features {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.package-cta-v3 .cta-features span {
    color: rgba(255,255,255,0.9);
    font-size: 0.9rem;
}

.package-cta-v3 .cta-features i {
    color: #25D366;
}

.cta-buttons-v3 {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-cta-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 16px 30px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-cta-secondary-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 28px;
    background: transparent;
    color: white;
    border: 2px solid rgba(255,255,255,0.5);
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cta-secondary-outline:hover {
    background: white;
    color: var(--dark, #3D3029);
    border-color: white;
}

/* ============ RELATED PACKAGES ============ */
.related-package-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.related-package-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.related-package-card .card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.related-package-card .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.related-package-card:hover .card-image img {
    transform: scale(1.1);
}

.related-package-card .card-duration {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.related-package-card .card-content {
    padding: 20px;
}

.related-package-card h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--dark, #3D3029);
}

.related-package-card .card-footer-v3 {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.related-package-card .card-price small {
    display: block;
    color: #888;
    font-size: 0.8rem;
}

.related-package-card .card-price strong {
    font-size: 1.3rem;
    color: var(--primary, #C7805C);
}

.btn-view-package {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--primary, #C7805C);
    font-weight: 600;
    text-decoration: none;
}

.btn-view-package:hover {
    color: var(--primary-dark, #A8684A);
}

/* ============ RESPONSIVE ============ */
@media (max-width: 991px) {
    .package-price-cta {
        text-align: left;
        margin-top: 20px;
    }
    
    .package-cta-buttons {
        justify-content: flex-start;
    }
    
    .highlights-grid {
        grid-template-columns: 1fr;
    }
    
    .day-content {
        margin-left: 60px;
    }
    
    .package-cta-v3 .cta-card-v3 {
        text-align: center;
    }
    
    .cta-buttons-v3 {
        align-items: center;
    }
}

@media (max-width: 576px) {
    .package-header-card {
        padding: 20px;
    }
    
    .package-cta-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-book-package, .btn-enquire-package {
        width: 100%;
        justify-content: center;
    }
    
    .day-marker {
        position: relative;
        left: 0;
        margin-bottom: 10px;
    }
    
    .day-content {
        margin-left: 0;
    }
    
    .itinerary-timeline {
        padding-left: 0;
    }
    
    .itinerary-timeline::before {
        display: none;
    }
    
    .day-header {
        flex-direction: column;
    }
    
    .pricing-table th, .pricing-table td {
        padding: 12px 10px;
        font-size: 0.85rem;
    }
}

/* Utilities */
.py-6 { padding-top: 5rem; padding-bottom: 5rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize GLightbox for gallery if exists
    if (document.querySelector('.glightbox')) {
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true
        });
    }
});
</script>
