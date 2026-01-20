<?php
/**
 * Gallery Page - Full Photo Gallery with Lightbox
 * Tanzania Safari Tourism Website
 * 
 * Features:
 * - Filterable masonry grid
 * - GLightbox integration
 * - Responsive design
 * - AOS animations
 * 
 * Created: December 2025
 * Version: v3.0
 */
?>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- GLightbox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<!-- ============================================
     GALLERY HERO SECTION
     ============================================ -->
<section class="gallery-hero-v3" style="background-image: url('<?php echo base_url(); ?>assets/img/destinations/osiram_safari_adventure_great_migration-01.jpg');">
    <div class="gallery-hero-overlay"></div>
    
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="container">
        <div class="gallery-hero-content" data-aos="fade-up">
            <div class="hero-icon-badge" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-images"></i>
            </div>
            
            <h1 class="gallery-hero-title" data-aos="fade-up" data-aos-delay="200">
                Photo Gallery
            </h1>
            
            <p class="gallery-hero-subtitle" data-aos="fade-up" data-aos-delay="300">
                Capturing the Magic of African Safari Adventures
            </p>
            
            <nav class="gallery-hero-breadcrumb" data-aos="fade-up" data-aos-delay="400">
                <ol class="breadcrumb-v3">
                    <li class="breadcrumb-item-v3">
                        <a href="<?php echo base_url(); ?>">
                            <i class="bi bi-house-door-fill"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-divider">
                        <i class="bi bi-chevron-right"></i>
                    </li>
                    <li class="breadcrumb-item-v3 active">Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="hero-wave">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- ============================================
     GALLERY FILTER & GRID SECTION
     ============================================ -->
<section class="gallery-section-v3 py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-camera-fill me-2"></i>Our Collection
            </span>
            <h2 class="section-title-v3 mt-3">
                Explore Our Safari <span class="text-gradient">Memories</span>
            </h2>
            <p class="section-subtitle text-muted">
                Browse through stunning photographs from our unforgettable safari adventures across Tanzania
            </p>
        </div>
        
        <!-- Filter Buttons -->
        <div class="gallery-filter-wrapper mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="gallery-filter">
                <button class="filter-btn active" data-filter="all">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>All Photos
                </button>
                <button class="filter-btn" data-filter="safari">
                    <i class="bi bi-compass-fill me-2"></i>Safari
                </button>
                <button class="filter-btn" data-filter="wildlife">
                    <i class="bi bi-bug-fill me-2"></i>Wildlife
                </button>
                <button class="filter-btn" data-filter="landscapes">
                    <i class="bi bi-image-fill me-2"></i>Landscapes
                </button>
                <button class="filter-btn" data-filter="culture">
                    <i class="bi bi-people-fill me-2"></i>Culture
                </button>
                <button class="filter-btn" data-filter="accommodation">
                    <i class="bi bi-house-door-fill me-2"></i>Accommodation
                </button>
            </div>
        </div>
        
        <!-- Gallery Grid -->
         <div class="gallery-grid" id="galleryGrid">
             <?php 
             $delay = 0;
             foreach ($gallery_images as $image): 
                 $delay_value = ($delay % 6) * 100;
                 
                 // Handle both object and array formats
                 $category = is_object($image) ? $image->category : $image['category'];
                 $thumb = is_object($image) ? $image->thumb : $image['thumb'];
                 $src = is_object($image) ? $image->src : $image['src'];
                 $title = is_object($image) ? $image->title : $image['title'];
                 $description = is_object($image) ? $image->description : $image['description'];
                 
                 // Ensure images have proper base URL
                 if (!empty($thumb) && strpos($thumb, 'http') !== 0) {
                     $thumb = base_url() . $thumb;
                 }
                 if (!empty($src) && strpos($src, 'http') !== 0) {
                     $src = base_url() . $src;
                 }
             ?>
             <div class="gallery-item-wrapper" data-category="<?php echo htmlspecialchars($category); ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay_value; ?>">
                 <div class="gallery-card">
                     <div class="gallery-image-container">
                         <img src="<?php echo $thumb; ?>" 
                              alt="<?php echo htmlspecialchars($title); ?>" 
                              class="gallery-image"
                              loading="lazy">
                         <div class="gallery-overlay-v3">
                             <a href="<?php echo $src; ?>" 
                                class="glightbox gallery-zoom-btn" 
                                data-gallery="safari-gallery"
                                data-glightbox="title: <?php echo htmlspecialchars($title); ?>; description: <?php echo htmlspecialchars($description); ?>">
                                 <i class="bi bi-zoom-in"></i>
                             </a>
                             <div class="gallery-info">
                                 <span class="gallery-category-badge"><?php echo ucfirst(htmlspecialchars($category)); ?></span>
                                 <h4 class="gallery-title"><?php echo htmlspecialchars($title); ?></h4>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <?php 
             $delay++;
             endforeach; 
             ?>
         </div>
         
         <!-- Load More Button (shows when image count >= 50) -->
         <?php if (isset($use_load_more) && $use_load_more): ?>
         <div class="load-more-container text-center py-5" id="loadMoreContainer">
             <button class="load-more-btn" id="loadMoreBtn">
                 <i class="bi bi-chevron-down me-2"></i>Load More Images
                 <span class="load-count">(<?php echo $total_images - $initial_batch_size; ?> more)</span>
             </button>
         </div>
         <?php endif; ?>
         
         <!-- No Results Message -->
         <div class="no-results text-center py-5" id="noResults" style="display: none;">
             <i class="bi bi-image display-1 text-muted mb-3"></i>
             <h4 class="text-muted">No photos found in this category</h4>
             <p class="text-muted">Try selecting a different category</p>
         </div>
         </div>
         </section>

<!-- ============================================
     CALL TO ACTION SECTION
     ============================================ -->
<section class="gallery-cta-section py-5">
    <div class="container">
        <div class="cta-card" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title text-white mb-2">
                        <i class="bi bi-camera-video-fill me-2"></i>
                        Ready to Create Your Own Safari Memories?
                    </h3>
                    <p class="cta-text text-white-50 mb-0">
                        Book your Tanzania safari adventure today and experience these incredible moments firsthand.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url('packages'); ?>" class="btn btn-light btn-lg rounded-pill px-4 me-2 mb-2">
                        <i class="bi bi-box-seam me-2"></i>View Packages
                    </a>
                    <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20I'm%20interested%20in%20booking%20a%20safari" 
                       class="btn btn-outline-light btn-lg rounded-pill px-4 mb-2" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     GALLERY STYLES
     ============================================ -->
<style>
/* Hero Section */
.gallery-hero-v3 {
    position: relative;
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    overflow: hidden;
    margin-top: -1px;
}

.gallery-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(22, 33, 62, 0.85) 50%, rgba(199, 128, 92, 0.7) 100%);
    z-index: 1;
}

.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    overflow: hidden;
}

.particle {
    position: absolute;
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 15s infinite;
}

.particle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; animation-duration: 20s; }
.particle:nth-child(2) { left: 30%; top: 60%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 18s; }
.particle:nth-child(3) { left: 60%; top: 30%; width: 8px; height: 8px; animation-delay: 4s; animation-duration: 22s; }
.particle:nth-child(4) { left: 80%; top: 70%; width: 12px; height: 12px; animation-delay: 1s; animation-duration: 16s; }
.particle:nth-child(5) { left: 50%; top: 80%; animation-delay: 3s; animation-duration: 25s; }

@keyframes float {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0.3; }
    25% { transform: translateY(-100px) translateX(50px) rotate(90deg); opacity: 0.6; }
    50% { transform: translateY(-50px) translateX(-30px) rotate(180deg); opacity: 0.4; }
    75% { transform: translateY(-150px) translateX(20px) rotate(270deg); opacity: 0.5; }
}

.gallery-hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    padding: 80px 20px 120px;
}

.hero-icon-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-radius: 20px;
    margin-bottom: 25px;
    box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
    animation: pulse-glow 2s infinite;
}

.hero-icon-badge i {
    font-size: 2rem;
    color: white;
}

@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4); }
    50% { box-shadow: 0 20px 50px rgba(199, 128, 92, 0.6); }
}

.gallery-hero-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    color: white;
    margin-bottom: 15px;
    letter-spacing: -1px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.gallery-hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 30px;
    font-weight: 400;
}

.breadcrumb-v3 {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 12px 25px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    list-style: none;
    margin: 0;
}

.breadcrumb-item-v3 a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color 0.3s ease;
}

.breadcrumb-item-v3 a:hover { color: var(--primary, #C7805C); }
.breadcrumb-item-v3.active { color: white; font-weight: 600; }
.breadcrumb-divider { color: rgba(255, 255, 255, 0.4); font-size: 0.75rem; }

.hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    z-index: 5;
    line-height: 0;
}

.hero-wave svg { width: 100%; height: auto; }

/* Section Styling */
.gallery-section-v3 {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.section-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 20px;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, rgba(199, 128, 92, 0.05) 100%);
    border: 1px solid rgba(199, 128, 92, 0.2);
    border-radius: 50px;
    color: var(--primary, #C7805C);
    font-weight: 600;
    font-size: 0.9rem;
}

.section-title-v3 {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -0.5px;
}

.text-gradient {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle {
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

/* Filter Buttons */
.gallery-filter-wrapper {
    display: flex;
    justify-content: center;
}

.gallery-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    background: white;
    padding: 15px 25px;
    border-radius: 60px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    border-color: var(--primary, #C7805C);
    color: var(--primary, #C7805C);
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-color: var(--primary, #C7805C);
    color: white;
    box-shadow: 0 5px 20px rgba(199, 128, 92, 0.3);
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.gallery-item-wrapper {
    transition: all 0.4s ease;
}

.gallery-item-wrapper.hidden {
    display: none;
}

.gallery-card {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.gallery-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.gallery-image-container {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.1);
}

.gallery-overlay-v3 {
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

.gallery-card:hover .gallery-overlay-v3 {
    opacity: 1;
}

.gallery-zoom-btn {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    margin-top: auto;
    margin-bottom: auto;
    transform: scale(0.8);
}

.gallery-card:hover .gallery-zoom-btn {
    transform: scale(1);
}

.gallery-zoom-btn:hover {
    background: var(--primary, #C7805C);
    color: white;
    transform: scale(1.1) !important;
}

.gallery-info {
    text-align: center;
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.gallery-card:hover .gallery-info {
    transform: translateY(0);
}

.gallery-category-badge {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(199, 128, 92, 0.9);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.gallery-title {
    color: white;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

/* CTA Section */
.gallery-cta-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.cta-card {
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.2) 0%, rgba(168, 104, 74, 0.2) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 40px;
}

.cta-title {
    font-size: 1.5rem;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 1200px) {
    .gallery-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 992px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    
    .gallery-filter {
        padding: 12px 15px;
        border-radius: 20px;
    }
    
    .filter-btn {
        padding: 8px 16px;
        font-size: 0.85rem;
    }
}

@media (max-width: 768px) {
    .gallery-hero-v3 {
        min-height: 50vh;
        background-attachment: scroll;
    }
    
    .gallery-hero-content {
        padding: 60px 15px 100px;
    }
    
    .hero-icon-badge {
        width: 60px;
        height: 60px;
        border-radius: 15px;
    }
    
    .hero-icon-badge i { font-size: 1.5rem; }
    
    .filter-btn i { display: none; }
    
    .cta-card { padding: 25px; }
}

@media (max-width: 576px) {
    .gallery-grid { grid-template-columns: 1fr; }
    
    .gallery-filter { 
        gap: 8px;
        padding: 10px;
    }
    
    .filter-btn {
        padding: 8px 12px;
        font-size: 0.8rem;
    }
}

/* Load More Button Styles */
.load-more-container {
    margin-top: 30px;
    padding: 20px 0;
}

.load-more-btn {
    display: inline-flex;
    align-items: center;
    padding: 14px 40px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(199, 128, 92, 0.3);
}

.load-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(199, 128, 92, 0.4);
}

.load-more-btn:active {
    transform: translateY(-1px);
}

.load-more-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.load-more-btn .load-count {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-left: 8px;
}

.load-more-btn .spinner-border {
    display: none;
    width: 16px;
    height: 16px;
    margin-right: 8px;
    border-width: 2px;
}

.load-more-btn.loading .spinner-border {
    display: inline-block;
}

.load-more-btn.loading i {
    display: none;
}
</style>

<!-- ============================================
     SCRIPTS
     ============================================ -->
<!-- GLightbox JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });
    
    // Initialize GLightbox
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
        openEffect: 'zoom',
        closeEffect: 'fade',
        cssEfects: {
            fade: { in: 'fadeIn', out: 'fadeOut' },
            zoom: { in: 'zoomIn', out: 'zoomOut' }
        }
    });
    
    // Filter Functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item-wrapper');
    const noResults = document.getElementById('noResults');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.dataset.filter;
            let visibleCount = 0;
            
            galleryItems.forEach(item => {
                const itemCategory = item.dataset.category;
                
                if (filterValue === 'all' || itemCategory === filterValue) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            
            // Refresh lightbox
            lightbox.reload();
        });
    });
    
    // Load More Functionality
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        let currentOffset = <?php echo isset($initial_batch_size) ? $initial_batch_size : 0; ?>;
        const batchSize = <?php echo isset($load_batch_size) ? $load_batch_size : 12; ?>;
        const totalImages = <?php echo isset($total_images) ? $total_images : 0; ?>;
        
        loadMoreBtn.addEventListener('click', function() {
            if (this.classList.contains('loading')) return;
            
            // Show loading state
            this.classList.add('loading');
            this.disabled = true;
            
            // AJAX request to load more images
            const formData = new FormData();
            formData.append('offset', currentOffset);
            formData.append('batch_size', batchSize);
            
            fetch('<?php echo base_url("gallery/load_more"); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.images.length > 0) {
                    // Add new images to grid
                    const gallery = document.querySelector('.gallery-grid');
                    let delay = document.querySelectorAll('.gallery-item-wrapper').length % 6;
                    
                    data.images.forEach((image) => {
                        const itemHTML = createGalleryItem(image, delay);
                        gallery.insertAdjacentHTML('beforeend', itemHTML);
                        delay = (delay + 1) % 6;
                    });
                    
                    // Update offset
                    currentOffset = data.total_loaded;
                    
                    // Re-initialize lightbox for new images
                    lightbox.reload();
                    
                    // Re-initialize AOS for new items
                    AOS.refresh();
                    
                    // Update button state
                    if (!data.has_more) {
                        loadMoreBtn.style.display = 'none';
                    } else {
                        const remaining = data.total_available - data.total_loaded;
                        loadMoreBtn.querySelector('.load-count').textContent = 
                            '(' + remaining + ' more)';
                    }
                }
            })
            .catch(error => {
                console.error('Error loading more images:', error);
            })
            .finally(() => {
                // Remove loading state
                loadMoreBtn.classList.remove('loading');
                loadMoreBtn.disabled = false;
            });
        });
        
        // Helper function to create gallery item HTML
        function createGalleryItem(image, delay) {
            const delayValue = delay * 100;
            return `
                <div class="gallery-item-wrapper" data-category="${image.category}" data-aos="fade-up" data-aos-delay="${delayValue}">
                    <div class="gallery-card">
                        <div class="gallery-image-container">
                            <img src="${image.thumb}" 
                                 alt="${image.title}" 
                                 class="gallery-image"
                                 loading="lazy">
                            <div class="gallery-overlay-v3">
                                <a href="${image.src}" 
                                   class="glightbox gallery-zoom-btn" 
                                   data-gallery="safari-gallery"
                                   data-glightbox="title: ${image.title}; description: ${image.description}">
                                    <i class="bi bi-zoom-in"></i>
                                </a>
                                <div class="gallery-info">
                                    <span class="gallery-category-badge">${image.category.charAt(0).toUpperCase() + image.category.slice(1)}</span>
                                    <h4 class="gallery-title">${image.title}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }
});
</script>
