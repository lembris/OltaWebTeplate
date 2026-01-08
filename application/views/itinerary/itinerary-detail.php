<!-- Itinerary Detail Page -->
<section class="itinerary-section py-6">
    <div class="container">
        <!-- Header -->
        <div class="itinerary-header mb-5" data-aos="fade-up">
            <h1 class="itinerary-title"><?php echo htmlspecialchars($itinerary->title); ?></h1>
            <p class="itinerary-description"><?php echo htmlspecialchars($itinerary->description); ?></p>

            <!-- Quick Info -->
            <div class="itinerary-quick-info">
                <div class="info-item">
                    <i class="bi bi-calendar-event"></i>
                    <div>
                        <strong><?php echo $itinerary->duration_days; ?> Days</strong>
                        <small>Duration</small>
                    </div>
                </div>
                <div class="info-item">
                    <i class="bi bi-graph-up"></i>
                    <div>
                        <strong><?php echo ucfirst($itinerary->difficulty_level); ?></strong>
                        <small>Difficulty</small>
                    </div>
                </div>
                <?php if ($itinerary->best_season): ?>
                    <div class="info-item">
                        <i class="bi bi-sun"></i>
                        <div>
                            <strong><?php echo htmlspecialchars($itinerary->best_season); ?></strong>
                            <small>Best Season</small>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($itinerary->altitude): ?>
                    <div class="info-item">
                        <i class="bi bi-arrow-up"></i>
                        <div>
                            <strong><?php echo htmlspecialchars($itinerary->altitude); ?></strong>
                            <small>Max Altitude</small>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($itinerary->price_per_person): ?>
                    <div class="info-item price">
                        <i class="bi bi-tag"></i>
                        <div>
                            <strong>$<?php echo number_format($itinerary->price_per_person); ?></strong>
                            <small>Per Person</small>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Day-by-Day Breakdown -->
                <?php if ($days): ?>
                    <div class="itinerary-days-section mb-5">
                        <h2 class="section-heading">Day-by-Day Itinerary</h2>
                        
                        <div class="days-timeline">
                            <?php foreach ($days as $index => $day): ?>
                                <div class="day-item" data-aos="fade-up" data-aos-delay="<?php echo ($index * 100); ?>">
                                    <div class="day-number">
                                        <span>Day <?php echo $day->day_number; ?></span>
                                    </div>
                                    
                                    <div class="day-content">
                                        <h3 class="day-title"><?php echo htmlspecialchars($day->title); ?></h3>
                                        
                                        <div class="day-meta">
                                            <?php if ($day->distance): ?>
                                                <span class="meta-item">
                                                    <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($day->distance); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($day->duration): ?>
                                                <span class="meta-item">
                                                    <i class="bi bi-clock"></i> <?php echo htmlspecialchars($day->duration); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($day->transportation): ?>
                                                <span class="meta-item">
                                                    <i class="bi bi-car-front"></i> <?php echo htmlspecialchars($day->transportation); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Day Description -->
                                        <div class="day-description">
                                            <?php echo $day->description; ?>
                                        </div>

                                        <!-- Activities -->
                                        <?php if ($day->activities): ?>
                                            <div class="day-activities">
                                                <h4>Activities</h4>
                                                <ul>
                                                    <?php 
                                                    $activities = explode("\n", $day->activities);
                                                    foreach ($activities as $activity):
                                                        if (!empty(trim($activity))):
                                                    ?>
                                                        <li><?php echo htmlspecialchars(trim($activity)); ?></li>
                                                    <?php 
                                                        endif;
                                                    endforeach; 
                                                    ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Meals & Accommodation -->
                                        <div class="day-amenities">
                                            <?php if ($day->meals): ?>
                                                <div class="amenity-item">
                                                    <i class="bi bi-cup-hot"></i>
                                                    <span><?php echo htmlspecialchars($day->meals); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($day->accommodation): ?>
                                                <div class="amenity-item">
                                                    <i class="bi bi-building"></i>
                                                    <span><?php echo htmlspecialchars($day->accommodation); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- What's Included -->
                <?php if ($itinerary->inclusions): ?>
                    <div class="itinerary-section-box mb-5">
                        <h2 class="section-heading">What's Included</h2>
                        <div class="section-content">
                            <?php echo $itinerary->inclusions; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- What's Not Included -->
                <?php if ($itinerary->exclusions): ?>
                    <div class="itinerary-section-box mb-5">
                        <h2 class="section-heading">What's Not Included</h2>
                        <div class="section-content">
                            <?php echo $itinerary->exclusions; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- What to Bring -->
                <?php if ($itinerary->what_to_bring): ?>
                    <div class="itinerary-section-box mb-5">
                        <h2 class="section-heading">What to Bring</h2>
                        <div class="section-content">
                            <?php echo $itinerary->what_to_bring; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Navigation -->
                <?php if ($prev_itinerary || $next_itinerary): ?>
                    <div class="itinerary-navigation mt-5">
                        <?php if ($prev_itinerary): ?>
                            <a href="<?php echo base_url('itinerary/view/' . $prev_itinerary->package_id); ?>" class="nav-link prev">
                                <i class="bi bi-chevron-left"></i>
                                <div>
                                    <small>Previous</small>
                                    <strong><?php echo htmlspecialchars($prev_itinerary->title); ?></strong>
                                </div>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($next_itinerary): ?>
                            <a href="<?php echo base_url('itinerary/view/' . $next_itinerary->package_id); ?>" class="nav-link next">
                                <div>
                                    <small>Next</small>
                                    <strong><?php echo htmlspecialchars($next_itinerary->title); ?></strong>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- CTA Box -->
                <div class="sidebar-cta-box">
                    <h3>Ready to Explore?</h3>
                    <?php if ($itinerary->price_per_person): ?>
                        <p class="price-text">From <strong>$<?php echo number_format($itinerary->price_per_person); ?></strong> per person</p>
                    <?php endif; ?>
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-envelope"></i> Get More Info
                    </a>
                    <a href="https://wa.me/<?php echo $this->config->item('consult_number_call'); ?>" class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-whatsapp"></i> WhatsApp Us
                    </a>
                </div>

                <!-- Quick Summary -->
                <div class="sidebar-box mt-4">
                    <h4>Trip Summary</h4>
                    <ul class="summary-list">
                        <li>
                            <strong>Duration:</strong>
                            <?php echo $itinerary->duration_days; ?> days
                        </li>
                        <li>
                            <strong>Difficulty:</strong>
                            <?php echo ucfirst($itinerary->difficulty_level); ?>
                        </li>
                        <?php if ($itinerary->best_season): ?>
                            <li>
                                <strong>Best Season:</strong>
                                <?php echo htmlspecialchars($itinerary->best_season); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($itinerary->altitude): ?>
                            <li>
                                <strong>Max Altitude:</strong>
                                <?php echo htmlspecialchars($itinerary->altitude); ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="sidebar-box mt-4">
                    <h4>Questions?</h4>
                    <p>Our travel experts are ready to help you plan your perfect safari.</p>
                    <div class="contact-methods">
                        <a href="tel:<?php echo $this->config->item('consult_number_call'); ?>" class="contact-method">
                            <i class="bi bi-telephone"></i> Call Us
                        </a>
                        <a href="<?php echo base_url('contact'); ?>" class="contact-method">
                            <i class="bi bi-envelope"></i> Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .itinerary-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 80vh;
    }

    .itinerary-header {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 40px;
    }

    .itinerary-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .itinerary-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .itinerary-quick-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .info-item i {
        font-size: 1.8rem;
        color: #0d6efd;
    }

    .info-item strong {
        display: block;
        color: #1a1a2e;
        font-size: 1.1rem;
    }

    .info-item small {
        display: block;
        color: #999;
        font-size: 0.85rem;
    }

    .info-item.price i {
        color: #28a745;
    }

    /* Days Timeline */
    .itinerary-days-section {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .section-heading {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid #0d6efd;
    }

    .days-timeline {
        position: relative;
        padding-left: 30px;
    }

    .days-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
    }

    .day-item {
        margin-bottom: 40px;
        position: relative;
    }

    .day-number {
        position: absolute;
        left: -50px;
        top: 0;
    }

    .day-number span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: #0d6efd;
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .day-content {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #0d6efd;
    }

    .day-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    .day-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
        color: #666;
    }

    .meta-item i {
        color: #0d6efd;
    }

    .day-description {
        color: #555;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .day-activities {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .day-activities h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    .day-activities ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .day-activities li {
        padding: 8px 0;
        padding-left: 25px;
        position: relative;
        color: #666;
    }

    .day-activities li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #28a745;
        font-weight: bold;
    }

    .day-amenities {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .amenity-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #666;
    }

    .amenity-item i {
        font-size: 1.2rem;
        color: #0d6efd;
    }

    /* Section Boxes */
    .itinerary-section-box {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .section-content {
        color: #555;
        line-height: 1.8;
    }

    .section-content h3 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .section-content h3:first-child {
        margin-top: 0;
    }

    .section-content ul {
        margin-left: 20px;
        margin-bottom: 15px;
    }

    .section-content li {
        margin-bottom: 8px;
    }

    /* Navigation */
    .itinerary-navigation {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: white;
        border-radius: 12px;
        text-decoration: none;
        color: #1a1a2e;
        border: 2px solid #eee;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        border-color: #0d6efd;
        box-shadow: 0 8px 20px rgba(13,110,253,0.15);
        transform: translateY(-2px);
    }

    .nav-link.prev {
        text-align: right;
    }

    .nav-link small {
        display: block;
        color: #999;
        font-size: 0.85rem;
    }

    .nav-link strong {
        display: block;
        font-size: 1rem;
        color: #0d6efd;
    }

    .nav-link i {
        font-size: 1.5rem;
        color: #0d6efd;
    }

    /* Sidebar */
    .sidebar-cta-box {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(13,110,253,0.3);
        position: sticky;
        top: 100px;
    }

    .sidebar-cta-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .price-text {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .sidebar-box {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .sidebar-box h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0d6efd;
    }

    .summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .summary-list li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        color: #666;
    }

    .summary-list li:last-child {
        border-bottom: none;
    }

    .summary-list strong {
        color: #1a1a2e;
    }

    .contact-methods {
        display: grid;
        gap: 10px;
    }

    .contact-method {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #f0f7ff;
        border-radius: 8px;
        color: #0d6efd;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .contact-method:hover {
        background: #0d6efd;
        color: white;
    }

    @media (max-width: 768px) {
        .itinerary-header {
            padding: 20px;
        }

        .itinerary-quick-info {
            grid-template-columns: repeat(2, 1fr);
        }

        .itinerary-days-section,
        .itinerary-section-box {
            padding: 20px;
        }

        .day-number {
            position: static;
            margin-bottom: 10px;
        }

        .days-timeline::before {
            left: 0;
        }

        .days-timeline {
            padding-left: 0;
        }

        .itinerary-navigation {
            grid-template-columns: 1fr;
        }

        .nav-link {
            flex-direction: column;
            text-align: center;
        }

        .nav-link.prev {
            text-align: center;
        }

        .sidebar-cta-box {
            position: static;
            margin-top: 30px;
        }
    }
</style>
