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
                    <img src="<?php echo base_url(); ?>assets/img/sections/osiram-safari-adventure-lake-manyara-flamingo.jpg" class="img-fluid w-100" alt="Manyara National Park" style="height: 500px; object-fit: cover;">
                    <div class="destination-badge">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-feather-alt me-1"></i> Birdwatcher's Paradise
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                <div class="destination-content">
                    <span class="destination-label text-primary fw-bold text-uppercase mb-2 d-block">
                        <i class="fas fa-map-marker-alt me-2"></i>Manyara Region, Tanzania
                    </span>
                    <h1 class="display-5 fw-bold mb-4">Where Lions Climb Trees</h1>
                    <p class="lead text-muted mb-4">
                        Manyara National Park is a compact gem that offers an incredible diversity of habitats packed into a small area. From the groundwater forest at the entrance to the soda lake shore, every zone reveals new wonders.
                    </p>
                    <p class="mb-4">
                        Famous for its unique tree-climbing lions, the park also hosts large elephant herds and thousands of pink flamingos that flock to the alkaline waters. Ernest Hemingway called it "the loveliest lake in Africa."
                    </p>
                    <div class="destination-stats d-flex flex-wrap gap-4 mb-4">
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-expand-arrows-alt text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">325 km²</h5>
                            <small class="text-muted">Total Area</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-dove text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">400+</h5>
                            <small class="text-muted">Bird Species</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                            </div>
                            <h5 class="mb-0">Since 1960</h5>
                            <small class="text-muted">National Park</small>
                        </div>
                    </div>
                    <a href="<?php echo base_url('enquiry'); ?>" class="btn btn-primary btn-lg rounded-pill px-4">
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
                        Fly to Kilimanjaro International Airport or Arusha Airport. The park is just 126km from Arusha, about 1.5 hours drive along good tarmac roads.
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
                        Tree-climbing lions, elephants, hippos, giraffes, zebras, blue monkeys, olive baboons. Flamingos, pelicans, and over 400 bird species.
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
                        Game drives, tree-top walkway (360 meters), canoeing, night game drives, cultural tours, mountain biking, and bird watching.
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
                        <strong>November to April</strong> for flamingos and migratory birds. <strong>June to October</strong> for general wildlife viewing in dry season.
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
<?php $this->load->view('pages/sections/manyara-gallery-v3'); ?>
