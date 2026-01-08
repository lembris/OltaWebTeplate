<!-- ============================================
     GALLERY SHOWCASE - Dynamic Images
     ============================================ -->
<style>
.gallery-img {
    height: 300px;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.gallery-img:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}
.gallery-img::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    z-index: 1;
}
.gallery-img:hover::before {
    background: rgba(0, 0, 0, 0.5);
}
.gallery-img .icon {
    width: 100%;
    height: 100%;
    font-size: 48px;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2;
    position: relative;
}
.gallery-img:hover .icon {
    opacity: 1;
}
</style>

<!-- GALLERY - Digital Media Focus -->
<!-- <div class="row">
    <div class="col-md-3 ftco-animate">
        <a href="https://localhost/institute/assets/img/gallery/film-production.jpg" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('https://localhost/institute/assets/img/gallery/film-production.jpg');">
            <div class="overlay-text">
                <h5>Film Production Class</h5>
                <p>Students shooting with professional cameras</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 ftco-animate">
        <a href="https://localhost/institute/assets/img/gallery/animation-lab.jpg" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('https://localhost/institute/assets/img/gallery/animation-lab.jpg');">
            <div class="overlay-text">
                <h5>Animation Workshop</h5>
                <p>Working on 3D character modeling</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 ftco-animate">
        <a href="https://localhost/institute/assets/img/gallery/design-studio.jpg" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('https://localhost/institute/assets/img/gallery/design-studio.jpg');">
            <div class="overlay-text">
                <h5>Design Studio</h5>
                <p>Graphic design students at work</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 ftco-animate">
        <a href="https://localhost/institute/assets/img/gallery/graduation-showcase.jpg" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('https://localhost/institute/assets/img/gallery/graduation-showcase.jpg');">
            <div class="overlay-text">
                <h5>Graduate Showcase</h5>
                <p>Student film screening event</p>
            </div>
        </a>
    </div>
</div> -->

<?php if(!empty($gallery_images)): ?>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Campus Life</span>
                <h2 class="mb-4">Gallery & Highlights</h2>
            </div>
        </div>
        <div class="row">
            <?php $counter = 0; foreach($gallery_images as $image): ?>
            <?php 
                // Handle gallery data (both object and array)
                // Note: gallery_images table uses 'src' field for image URL
                $gallery_image = is_object($image) ? ($image->src ?? '') : ($image['src'] ?? '');
                $gallery_title = is_object($image) ? ($image->title ?? 'Campus') : ($image['title'] ?? 'Campus');
                $gallery_category = is_object($image) ? ($image->category ?? '') : ($image['category'] ?? '');
            ?>
            <div class="col-md-3 ftco-animate">
                <a href="<?php echo base_url($gallery_image); ?>" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('<?php echo base_url($gallery_image); ?>');">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
            </div>
            <!-- <div class="col-md-3 ftco-animate">
                <a href="https://localhost/institute/assets/img/gallery/film-production.jpg" class="gallery-img d-flex align-items-center justify-content-center" style="background-image: url('https://localhost/institute/assets/img/gallery/film-production.jpg');">
                    <div class="overlay-text">
                        <h5>Film Production Class</h5>
                        <p>Students shooting with professional cameras</p>
                    </div>
                </a>
            </div> -->
            <?php $counter++; if($counter >= 8) break; endforeach; ?>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="<?php echo base_url('gallery'); ?>" class="btn btn-primary">View Full Gallery</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>