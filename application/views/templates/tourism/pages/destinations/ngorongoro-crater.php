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
                    <img src="<?php echo base_url(); ?>assets/img/sections/osiram-safari-adventure-ngorongoro-crater.jpg" class="img-fluid w-100" alt="Ngorongoro Crater" style="height: 500px; object-fit: cover;">
                    <div class="destination-badge">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-mountain me-1"></i> Volcanic Wonder
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                <div class="destination-content">
                    <span class="destination-label text-primary fw-bold text-uppercase mb-2 d-block">
                        <i class="fas fa-map-marker-alt me-2"></i>Northern Tanzania
                    </span>
                    <h1 class="display-5 fw-bold mb-4">The Eighth Wonder of the World</h1>
                    <p class="lead text-muted mb-4">
                        The Ngorongoro Crater is the world's largest intact volcanic caldera, formed when a giant volcano exploded and collapsed on itself two to three million years ago. This natural amphitheater is home to approximately 25,000 large animals.
                    </p>
                    <p class="mb-4">
                        The crater floor covers 260 square kilometers and is home to the densest concentration of wildlife in Africa. It's one of the few places in Tanzania where you can see the endangered black rhino.
                    </p>
                    <div class="destination-stats d-flex flex-wrap gap-4 mb-4">
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-circle text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">260 km²</h5>
                            <small class="text-muted">Crater Floor</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-arrow-down text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">600m</h5>
                            <small class="text-muted">Depth</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-paw text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">25,000+</h5>
                            <small class="text-muted">Animals</small>
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
                        Fly to Arusha Airport (ARK), approximately 170km away. The drive takes around 3 hours by car through stunning landscapes of the Crater Highlands.
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
                        Home to the Big Five including endangered black rhinos. Lions, elephants, buffaloes, leopards, hippos, and thousands of flamingos on the soda lake.
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
                        Half-day and full-day crater floor game drives, crater rim walks, Maasai village visits, and sunrise/sunset viewpoints from the rim lodges.
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
                        <strong>Year-round destination.</strong> Dry season (June-October) for best game viewing. Green season (November-May) for flamingos and calving.
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
<?php $this->load->view('pages/sections/ngorongoro-gallery-v3'); ?>
