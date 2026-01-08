<?php
/**
 * Gallery Preview Section - For Homepage
 * Tanzania Safari Tourism Website
 * 
 * Features:
 * - Dynamic images from database
 * - Fallback to static images if no DB data
 * - GLightbox integration
 * - Responsive grid
 * - AOS animations
 * - View Full Gallery button
 * 
 * Created: December 2025
 * Updated: December 2025
 * Version: v4.0 - Dynamic
 */

// Use dynamic gallery images from controller, fallback to static
if (empty($gallery_images)) {
    // Fallback static images if database is empty
    $gallery_images = [
        (object)[
            'src' => 'assets/img/destinations/serengeti/serengeti-np1.jpg',
            'title' => 'Serengeti Game Drive',
            'category' => 'safari'
        ],
        (object)[
            'src' => 'assets/img/destinations/serengeti/serengeti-np3.jpg',
            'title' => 'Lions of the Serengeti',
            'category' => 'wildlife'
        ],
        (object)[
            'src' => 'assets/img/destinations/serengeti/serengeti-np4.jpg',
            'title' => 'Great Migration',
            'category' => 'wildlife'
        ],
        (object)[
            'src' => 'assets/img/destinations/tarangire/tarangire-np1.jpg',
            'title' => 'Elephant Herds',
            'category' => 'wildlife'
        ],
        (object)[
            'src' => 'assets/img/destinations/serengeti/serengeti-np5.jpg',
            'title' => 'Serengeti Sunset',
            'category' => 'landscapes'
        ],
        (object)[
            'src' => 'assets/img/destinations/kilimanjaro/kilimanjaro-np1.jpg',
            'title' => 'Mount Kilimanjaro',
            'category' => 'landscapes'
        ],
        (object)[
            'src' => 'assets/img/destinations/osiram_safari_adventures_maasai_culture-01.jpg',
            'title' => 'Maasai Village Visit',
            'category' => 'culture'
        ],
        (object)[
            'src' => 'assets/img/destinations/serengeti/serengeti-np6.jpg',
            'title' => 'Luxury Safari Lodge',
            'category' => 'accommodation'
        ],
    ];
}
?>

<!-- GLightbox CSS (if not already loaded) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<!-- ============================================
     GALLERY PREVIEW SECTION
     ============================================ -->
<section class="gallery-preview-section py-5" id="gallery-preview">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge-v3">
                <i class="bi bi-images me-2"></i>Photo Gallery
            </span>
            <h2 class="section-title-v3 mt-3">
                Captured <span class="text-gradient-v3">Moments</span>
            </h2>
            <p class="section-subtitle-v3 text-muted">
                A glimpse into the incredible experiences awaiting you on our Tanzania safaris
            </p>
        </div>
        
        <!-- Gallery Grid -->
        <div class="gallery-preview-grid">
            <?php 
            $delay = 0;
            foreach ($gallery_images as $index => $image): 
                $delay_value = ($delay % 4) * 100;
                
                // Handle both object and array formats
                $src = is_object($image) ? $image->src : $image['src'];
                $title = is_object($image) ? $image->title : $image['title'];
                $category = is_object($image) ? $image->category : $image['category'];
                
                // Build full image URL
                $image_url = (strpos($src, 'http') === 0) ? $src : base_url() . $src;
            ?>
            <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="<?php echo $delay_value; ?>">
                <div class="gallery-preview-card">
                    <img src="<?php echo $image_url; ?>" 
                         alt="<?php echo htmlspecialchars($title); ?>" 
                         class="gallery-preview-img"
                         loading="lazy">
                    <div class="gallery-preview-overlay">
                        <a href="<?php echo $image_url; ?>" 
                           class="glightbox-preview gallery-preview-zoom" 
                           data-gallery="homepage-gallery"
                           data-glightbox="title: <?php echo htmlspecialchars($title); ?>">
                            <i class="bi bi-zoom-in"></i>
                        </a>
                        <div class="gallery-preview-info">
                            <span class="gallery-preview-category"><?php echo ucfirst(htmlspecialchars($category)); ?></span>
                            <h4 class="gallery-preview-title"><?php echo htmlspecialchars($title); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            $delay++;
            endforeach; 
            ?>
        </div>
        
        <!-- View Full Gallery Button -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
            <a href="<?php echo base_url('gallery'); ?>" class="btn-gallery-full">
                <span>View Full Gallery</span>
                <i class="bi bi-arrow-right-circle-fill ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- ============================================
     GALLERY PREVIEW STYLES
     ============================================ -->
<style>
.gallery-preview-section {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.gallery-preview-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 200px;
    background: linear-gradient(180deg, rgba(199, 128, 92, 0.03) 0%, transparent 100%);
    pointer-events: none;
}

/* Section Badge */
.section-badge-v3 {
    display: inline-flex;
    align-items: center;
    padding: 8px 20px;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, rgba(199, 128, 92, 0.05) 100%);
    border: 1px solid rgba(199, 128, 92, 0.2);
    border-radius: 50px;
    color: var(--theme-primary, #C7805C);
    font-weight: 600;
    font-size: 0.9rem;
}

.section-title-v3 {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -0.5px;
}

.text-gradient-v3 {
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--theme-secondary, #90B3A7) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle-v3 {
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0.5rem auto 0;
}

/* Gallery Grid - V3 Premium Masonry Layout */
.gallery-preview-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-auto-rows: 120px;
    gap: 15px;
}

.gallery-preview-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
}

/* V3 Premium Layout: Varied sizes for visual interest */
.gallery-preview-item:nth-child(1) {
    grid-column: span 5;
    grid-row: span 3;
}

.gallery-preview-item:nth-child(2) {
    grid-column: span 4;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(3) {
    grid-column: span 3;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(4) {
    grid-column: span 3;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(5) {
    grid-column: span 4;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(6) {
    grid-column: span 5;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(7) {
    grid-column: span 6;
    grid-row: span 2;
}

.gallery-preview-item:nth-child(8) {
    grid-column: span 6;
    grid-row: span 2;
}

.gallery-preview-item.large {
    grid-row: span 3;
}

.gallery-preview-card {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.gallery-preview-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.gallery-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-preview-card:hover .gallery-preview-img {
    transform: scale(1.1);
}

.gallery-preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.2) 50%, transparent 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    opacity: 0;
    transition: all 0.4s ease;
}

.gallery-preview-card:hover .gallery-preview-overlay {
    opacity: 1;
}

.gallery-preview-zoom {
    width: 55px;
    height: 55px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.4rem;
    transition: all 0.3s ease;
    margin-top: auto;
    margin-bottom: auto;
    transform: scale(0.8);
}

.gallery-preview-card:hover .gallery-preview-zoom {
    transform: scale(1);
}

.gallery-preview-zoom:hover {
    background: var(--theme-primary, #C7805C);
    color: white;
    transform: scale(1.1) !important;
}

.gallery-preview-info {
    text-align: center;
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.gallery-preview-card:hover .gallery-preview-info {
    transform: translateY(0);
}

.gallery-preview-category {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(199, 128, 92, 0.9);
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.gallery-preview-title {
    color: white;
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
}

/* View Full Gallery Button */
.btn-gallery-full {
    display: inline-flex;
    align-items: center;
    padding: 16px 35px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
    color: white;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-gallery-full::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.btn-gallery-full:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
    color: white;
}

.btn-gallery-full:hover::before {
    left: 100%;
}

.btn-gallery-full i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.btn-gallery-full:hover i {
    transform: translateX(5px);
}

/* Responsive - V3 Premium */
@media (max-width: 1200px) {
    .gallery-preview-grid {
        grid-template-columns: repeat(6, 1fr);
        grid-auto-rows: 140px;
    }
    
    .gallery-preview-item:nth-child(1) {
        grid-column: span 4;
        grid-row: span 2;
    }
    
    .gallery-preview-item:nth-child(2),
    .gallery-preview-item:nth-child(3) {
        grid-column: span 2;
        grid-row: span 2;
    }
    
    .gallery-preview-item:nth-child(4),
    .gallery-preview-item:nth-child(5),
    .gallery-preview-item:nth-child(6) {
        grid-column: span 2;
        grid-row: span 2;
    }
    
    .gallery-preview-item:nth-child(7),
    .gallery-preview-item:nth-child(8) {
        grid-column: span 3;
        grid-row: span 2;
    }
}

@media (max-width: 992px) {
    .gallery-preview-grid {
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 150px;
    }
    
    .gallery-preview-item:nth-child(1) {
        grid-column: span 4;
        grid-row: span 2;
    }
    
    .gallery-preview-item:nth-child(n+2) {
        grid-column: span 2;
        grid-row: span 1;
    }
    
    .gallery-preview-item.large {
        grid-row: span 1;
    }
}

@media (max-width: 576px) {
    .gallery-preview-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 160px;
    }
    
    .gallery-preview-item:nth-child(1) {
        grid-column: span 2;
        grid-row: span 1;
    }
    
    .gallery-preview-item:nth-child(n+2) {
        grid-column: span 1;
        grid-row: span 1;
    }
    
    .gallery-preview-item:nth-child(n+7) {
        display: none;
    }
    
    .btn-gallery-full {
        padding: 14px 28px;
        font-size: 0.95rem;
    }
}
</style>

<!-- GLightbox JS (if not already loaded) -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize GLightbox for preview section
    if (typeof GLightbox !== 'undefined') {
        GLightbox({
            selector: '.glightbox-preview',
            touchNavigation: true,
            loop: true,
            openEffect: 'zoom',
            closeEffect: 'fade'
        });
    }
});
</script>
