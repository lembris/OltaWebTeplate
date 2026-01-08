<!-- Itineraries Listing Page -->
<section class="itineraries-section py-6">
    <div class="container">
        <!-- Header -->
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-tag">📋 DETAILED ITINERARIES</span>
            <h1 class="section-title-v3">Our Tour Itineraries</h1>
            <p class="section-subtitle">Complete day-by-day breakdown of each safari adventure</p>
        </div>

        <!-- Itineraries Grid -->
        <?php if ($itineraries): ?>
            <div class="itineraries-grid">
                <?php foreach ($itineraries as $itinerary): ?>
                    <div class="itinerary-card" data-aos="fade-up">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="<?php echo base_url('itinerary/view/' . $itinerary->package_id); ?>">
                                    <?php echo htmlspecialchars($itinerary->title); ?>
                                </a>
                            </h3>
                        </div>

                        <div class="card-body">
                            <p class="card-description">
                                <?php echo htmlspecialchars(substr($itinerary->description, 0, 150)); ?>...
                            </p>

                            <!-- Quick Info -->
                            <div class="card-info">
                                <div class="info-badge">
                                    <i class="bi bi-calendar-event"></i>
                                    <span><?php echo $itinerary->duration_days; ?> Days</span>
                                </div>
                                <div class="info-badge">
                                    <i class="bi bi-graph-up"></i>
                                    <span><?php echo ucfirst($itinerary->difficulty_level); ?></span>
                                </div>
                                <?php if ($itinerary->best_season): ?>
                                    <div class="info-badge">
                                        <i class="bi bi-sun"></i>
                                        <span><?php echo htmlspecialchars($itinerary->best_season); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Price -->
                            <?php if ($itinerary->price_per_person): ?>
                                <div class="card-price">
                                    From <strong>$<?php echo number_format($itinerary->price_per_person); ?></strong> /person
                                </div>
                            <?php endif; ?>

                            <!-- CTA -->
                            <a href="<?php echo base_url('itinerary/view/' . $itinerary->package_id); ?>" class="btn-view-itinerary">
                                View Full Itinerary <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i>
                No itineraries available yet.
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .itineraries-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 80vh;
    }

    .section-header {
        margin-bottom: 50px;
    }

    .section-tag {
        display: inline-block;
        color: #0d6efd;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .section-title-v3 {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 15px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }

    .itineraries-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .itinerary-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .itinerary-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 25px;
        border-bottom: 4px solid #0a58ca;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
    }

    .card-title a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .card-title a:hover {
        color: #e9ecef;
    }

    .card-body {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-description {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.6;
        flex-grow: 1;
    }

    .card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }

    .info-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f0f7ff;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #0d6efd;
        border-left: 3px solid #0d6efd;
    }

    .info-badge i {
        font-size: 1.1rem;
    }

    .card-price {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #666;
        font-size: 0.95rem;
    }

    .card-price strong {
        color: #0d6efd;
        font-size: 1.2rem;
    }

    .btn-view-itinerary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .btn-view-itinerary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13,110,253,0.3);
        color: white;
    }

    .alert {
        background: #f0f7ff;
        border: 1px solid #d4e7ff;
        color: #003f87;
        padding: 30px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .alert i {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .itineraries-grid {
            grid-template-columns: 1fr;
        }

        .card-info {
            grid-template-columns: 1fr;
        }
    }
</style>
