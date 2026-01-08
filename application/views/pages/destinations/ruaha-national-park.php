<!-- Page Hero V3 Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero V3 End -->

<!-- Destination V3 Section -->
<section class="destination-v3 py-5">
    <div class="container">
        <!-- Main Content -->
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="destination-image position-relative overflow-hidden rounded-4 shadow-lg">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-1.jpg" class="img-fluid w-100" alt="Ruaha National Park" style="height: 500px; object-fit: cover;">
                    <div class="destination-badge">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-crown me-1"></i> Largest National Park
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                <div class="destination-content">
                    <span class="destination-label text-primary fw-bold text-uppercase mb-2 d-block">
                        <i class="fas fa-map-marker-alt me-2"></i>Central Tanzania
                    </span>
                    <h1 class="display-5 fw-bold mb-4">Tanzania's Largest National Park</h1>
                    <p class="lead text-muted mb-4">
                        Ruaha National Park, spanning an impressive 20,226 km² in central Tanzania, is the country's largest national park. Named after the Great Ruaha River which flows along its southeastern boundary, it offers a truly remote and unspoiled African wilderness experience.
                    </p>
                    <p class="mb-4">
                        The park is renowned for its large elephant population, one of the largest in East Africa. The diverse landscape of baobab-studded plains, rocky escarpments, and river valleys supports an exceptional variety of wildlife, including lions, leopards, cheetahs, wild dogs, hippos, and crocodiles.
                    </p>
                    <div class="destination-stats d-flex flex-wrap gap-4 mb-4">
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-expand-arrows-alt text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">20,226 km²</h5>
                            <small class="text-muted">Park Size</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-elephant text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">Large Herds</h5>
                            <small class="text-muted">Elephants</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-water text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">Great Ruaha</h5>
                            <small class="text-muted">River</small>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>contact#contact" class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="fas fa-paper-plane me-2"></i>Enquire Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row g-4 mt-5">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="info-card h-100 p-4 rounded-4 shadow-sm border-0 bg-white">
                    <div class="info-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-plane-departure text-primary fa-2x"></i>
                    </div>
                    <h4 class="mb-3">How to Get There</h4>
                    <p class="text-muted mb-0">
                        Scheduled flights from Dar es Salaam or Arusha to Msembe airstrip, taking approximately 1.5-2 hours. The park can also be accessed by road from Iringa, about 130 km away.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="info-card h-100 p-4 rounded-4 shadow-sm border-0 bg-white">
                    <div class="info-icon bg-success bg-opacity-10 rounded-circle p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-paw text-success fa-2x"></i>
                    </div>
                    <h4 class="mb-3">Wildlife</h4>
                    <p class="text-muted mb-0">
                        Home to large elephant herds, lions, leopards, cheetahs, African wild dogs, hippos, and crocodiles. The Great Ruaha River attracts incredible concentrations of wildlife during the dry season.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="info-card h-100 p-4 rounded-4 shadow-sm border-0 bg-white">
                    <div class="info-icon bg-warning bg-opacity-10 rounded-circle p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-hiking text-warning fa-2x"></i>
                    </div>
                    <h4 class="mb-3">Activities</h4>
                    <p class="text-muted mb-0">
                        Game drives, walking safaris, exceptional bird watching with over 570 species, fly camping under the stars, and photography safaris in this remote wilderness.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="info-card h-100 p-4 rounded-4 shadow-sm border-0 bg-white">
                    <div class="info-icon bg-info bg-opacity-10 rounded-circle p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-sun text-info fa-2x"></i>
                    </div>
                    <h4 class="mb-3">Best Time to Visit</h4>
                    <p class="text-muted mb-0">
                        <strong>June to November</strong> (Dry season) offers the best wildlife viewing as animals congregate around the Great Ruaha River and other water sources.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.destination-v3 {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}
.destination-image {
    position: relative;
}
.destination-badge {
    position: absolute;
    top: 20px;
    left: 20px;
}
.destination-stats .stat-item {
    min-width: 100px;
}
.info-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05) !important;
}
.info-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}
.info-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- Gallery Section -->
<?php $this->load->view('pages/sections/ruaha-gallery-v3'); ?>
