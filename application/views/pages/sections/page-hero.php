<!-- ============================================
     INNER PAGE HERO V3 - Premium Design
     ============================================ -->
<?php
// Define page-specific backgrounds and icons
$page_backgrounds = [
    'About us' => 'osiram_safari_adventures_maasai_culture-01.jpg',
    'Contact us' => 'osiram_safari_adventure_zanzibar-01.jpg',
    'Destinations' => 'osiram_safari_adventure_great_migration-01.jpg',
    'Packages' => 'osiram_safari_adventures_package_1-01.jpg',
    'Guide' => 'osiram_safari_adventures_4x4_blue_car-01.jpg',
    'Search' => 'osiram_safari_adventure_elephant-01.jpg',
    'FAQ' => 'osiram_safari_adventure_14_days_package-01.jpg',
    'Book Your Safari' => 'osiram_safari_adventure_great_migration-01.jpg',
    'Booking Confirmed' => 'osiram_safari_adventure_elephant-01.jpg',
    'Find My Booking' => 'osiram_safari_adventure_zanzibar-01.jpg',
    'Safari Enquiry' => 'osiram_safari_adventure_great_migration-01.jpg',
    'Enquiry Submitted' => 'osiram_safari_adventure_elephant-01.jpg',
    'Blog' => 'osiram_safari_adventure_great_migration-01.jpg',
    'Travel Tips & Guides' => 'osiram_safari_adventure_great_migration-01.jpg',
];

$page_icons = [
    'About us' => 'bi-people-fill',
    'Contact us' => 'bi-envelope-fill',
    'Destinations' => 'bi-geo-alt-fill',
    'Packages' => 'bi-box-seam-fill',
    'Guide' => 'bi-book-fill',
    'Search' => 'bi-search',
    'FAQ' => 'bi-question-circle-fill',
    'Book Your Safari' => 'bi-calendar-check-fill',
    'Booking Confirmed' => 'bi-check-circle-fill',
    'Find My Booking' => 'bi-search',
    'Safari Enquiry' => 'bi-send-fill',
    'Enquiry Submitted' => 'bi-check-circle-fill',
    'Blog' => 'bi-journal-text',
    'Travel Tips & Guides' => 'bi-journal-text',
];

$page_subtitles = [
    'About us' => 'Discover Our Story & Mission',
    'Contact us' => 'Get In Touch With Us',
    'Destinations' => 'Explore Tanzania\'s Wonders',
    'Packages' => 'Curated Safari Experiences',
    'Guide' => 'Everything You Need To Know',
    'Search' => 'Find Your Perfect Safari',
    'FAQ' => 'Frequently Asked Questions',
    'Book Your Safari' => 'Start Your African Adventure',
    'Booking Confirmed' => 'Your Safari Awaits',
    'Find My Booking' => 'View Your Booking Details',
    'Safari Enquiry' => 'Plan Your Dream Safari',
    'Enquiry Submitted' => 'Your Adventure Begins Soon',
    'Blog' => 'Expert Advice For Your Safari',
    'Travel Tips & Guides' => 'Expert Advice For Your Safari',
];

$bg_image = isset($page_backgrounds[$current_page_name]) 
    ? $page_backgrounds[$current_page_name] 
    : 'osiram_safari_adventure_great_migration-01.jpg';

$page_icon = isset($page_icons[$current_page_name]) 
    ? $page_icons[$current_page_name] 
    : 'bi-globe';

$page_subtitle = isset($page_subtitles[$current_page_name]) 
    ? $page_subtitles[$current_page_name] 
    : 'Your African Adventure Awaits';
?>

<section class="inner-hero-v3" style="background-image: url('<?php echo base_url(); ?>assets/img/destinations/<?php echo $bg_image; ?>');">
    <!-- Overlay -->
    <div class="inner-hero-overlay"></div>
    
    <!-- Animated Background Elements -->
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="container">
        <div class="inner-hero-content" data-aos="fade-up">
            <!-- Icon Badge -->
            <div class="hero-icon-badge" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi <?php echo $page_icon; ?>"></i>
            </div>
            
            <!-- Page Title -->
            <h1 class="inner-hero-title" data-aos="fade-up" data-aos-delay="200">
                <?php echo str_replace('-', ' ', $current_page_name); ?>
            </h1>
            
            <!-- Subtitle -->
            <p class="inner-hero-subtitle" data-aos="fade-up" data-aos-delay="300">
                <?php echo $page_subtitle; ?>
            </p>
            
            <!-- Breadcrumb -->
            <nav class="inner-hero-breadcrumb" data-aos="fade-up" data-aos-delay="400">
                <ol class="breadcrumb-v3">
                    <li class="breadcrumb-item-v3">
                        <a href="<?php echo base_url(); ?>">
                            <i class="bi bi-house-door-fill"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-divider">
                        <i class="bi bi-chevron-right"></i>
                    </li>
                    <li class="breadcrumb-item-v3 active">
                        <?php echo str_replace('-', ' ', $current_page_name); ?>
                    </li>
                </ol>
            </nav>
            
            <!-- Scroll Indicator -->
            <div class="scroll-indicator" data-aos="fade-up" data-aos-delay="500">
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
                <span>Scroll Down</span>
            </div>
        </div>
    </div>
    
    <!-- Bottom Wave -->
    <div class="hero-wave">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F5F0E1"/>
        </svg>
    </div>
</section>

<style>
/* ============ INNER PAGE HERO V3 ============ */
.inner-hero-v3 {
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

.inner-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        135deg,
        rgba(26, 26, 46, 0.9) 0%,
        rgba(22, 33, 62, 0.85) 50%,
        rgba(199, 128, 92, 0.7) 100%
    );
    z-index: 1;
}

/* Animated Particles */
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

.particle:nth-child(1) {
    left: 10%;
    top: 20%;
    animation-delay: 0s;
    animation-duration: 20s;
}

.particle:nth-child(2) {
    left: 30%;
    top: 60%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 18s;
}

.particle:nth-child(3) {
    left: 60%;
    top: 30%;
    width: 8px;
    height: 8px;
    animation-delay: 4s;
    animation-duration: 22s;
}

.particle:nth-child(4) {
    left: 80%;
    top: 70%;
    width: 12px;
    height: 12px;
    animation-delay: 1s;
    animation-duration: 16s;
}

.particle:nth-child(5) {
    left: 50%;
    top: 80%;
    animation-delay: 3s;
    animation-duration: 25s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0) rotate(0deg);
        opacity: 0.3;
    }
    25% {
        transform: translateY(-100px) translateX(50px) rotate(90deg);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-50px) translateX(-30px) rotate(180deg);
        opacity: 0.4;
    }
    75% {
        transform: translateY(-150px) translateX(20px) rotate(270deg);
        opacity: 0.5;
    }
}

/* Content */
.inner-hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    padding: 80px 20px 120px;
}

/* Icon Badge */
.hero-icon-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
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
    0%, 100% {
        box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
    }
    50% {
        box-shadow: 0 20px 50px rgba(199, 128, 92, 0.6);
    }
}

/* Title */
.inner-hero-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    color: white;
    margin-bottom: 15px;
    text-transform: capitalize;
    letter-spacing: -1px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

/* Subtitle */
.inner-hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 30px;
    font-weight: 400;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Breadcrumb */
.inner-hero-breadcrumb {
    margin-bottom: 40px;
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

.breadcrumb-item-v3 a:hover {
    color: var(--theme-primary, #C7805C);
}

.breadcrumb-item-v3.active {
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
}

.breadcrumb-divider {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.75rem;
}

/* Scroll Indicator */
.scroll-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    animation: bounce 2s infinite;
}

.mouse {
    width: 26px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    position: relative;
}

.wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll-wheel 1.5s infinite;
}

@keyframes scroll-wheel {
    0% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateX(-50%) translateY(12px);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Bottom Wave */
.hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    z-index: 5;
    line-height: 0;
}

.hero-wave svg {
    width: 100%;
    height: auto;
}

/* Responsive */
@media (max-width: 768px) {
    .inner-hero-v3 {
        min-height: 50vh;
        background-attachment: scroll;
    }
    
    .inner-hero-content {
        padding: 60px 15px 100px;
    }
    
    .hero-icon-badge {
        width: 60px;
        height: 60px;
        border-radius: 15px;
    }
    
    .hero-icon-badge i {
        font-size: 1.5rem;
    }
    
    .inner-hero-subtitle {
        font-size: 1rem;
    }
    
    .breadcrumb-v3 {
        padding: 10px 18px;
        gap: 8px;
    }
    
    .breadcrumb-item-v3 a,
    .breadcrumb-item-v3.active {
        font-size: 0.85rem;
    }
    
    .scroll-indicator {
        display: none;
    }
}

@media (max-width: 480px) {
    .inner-hero-v3 {
        min-height: 45vh;
    }
    
    .hero-icon-badge {
        width: 50px;
        height: 50px;
        margin-bottom: 20px;
    }
    
    .hero-icon-badge i {
        font-size: 1.25rem;
    }
}
</style>
