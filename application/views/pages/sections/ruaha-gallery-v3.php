<!-- Gallery V3 Section -->
<section class="gallery-v3 py-5">
    <div class="container">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Gallery</h6>
            <h2 class="display-5 mb-4">Ruaha National Park Gallery</h2>
            <p class="text-muted">Explore Tanzania's largest national park with abundant wildlife</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-1.jpg" class="img-fluid w-100" alt="Ruaha Lions" style="height: 280px; object-fit: cover;">
                    <div class="gallery-overlay">
                        <a href="<?php echo base_url(); ?>assets/img/destinations/destination-1.jpg" class="gallery-link" data-lightbox="ruaha-gallery">
                            <i class="fas fa-search-plus fa-2x text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-2.jpg" class="img-fluid w-100" alt="Ruaha Elephants" style="height: 280px; object-fit: cover;">
                    <div class="gallery-overlay">
                        <a href="<?php echo base_url(); ?>assets/img/destinations/destination-2.jpg" class="gallery-link" data-lightbox="ruaha-gallery">
                            <i class="fas fa-search-plus fa-2x text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-3.jpg" class="img-fluid w-100" alt="Ruaha Safari" style="height: 280px; object-fit: cover;">
                    <div class="gallery-overlay">
                        <a href="<?php echo base_url(); ?>assets/img/destinations/destination-3.jpg" class="gallery-link" data-lightbox="ruaha-gallery">
                            <i class="fas fa-search-plus fa-2x text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-4.jpg" class="img-fluid w-100" alt="Ruaha Landscape" style="height: 320px; object-fit: cover;">
                    <div class="gallery-overlay">
                        <a href="<?php echo base_url(); ?>assets/img/destinations/destination-4.jpg" class="gallery-link" data-lightbox="ruaha-gallery">
                            <i class="fas fa-search-plus fa-2x text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow">
                    <img src="<?php echo base_url(); ?>assets/img/destinations/destination-5.jpg" class="img-fluid w-100" alt="Ruaha Experience" style="height: 320px; object-fit: cover;">
                    <div class="gallery-overlay">
                        <a href="<?php echo base_url(); ?>assets/img/destinations/destination-5.jpg" class="gallery-link" data-lightbox="ruaha-gallery">
                            <i class="fas fa-search-plus fa-2x text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.gallery-v3 {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
.gallery-item {
    transition: all 0.4s ease;
}
.gallery-item:hover {
    transform: translateY(-10px);
}
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(19, 53, 123, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
}
.gallery-item:hover .gallery-overlay {
    opacity: 1;
}
.gallery-link {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.gallery-link:hover {
    background: var(--primary);
    transform: scale(1.1);
}
</style>
