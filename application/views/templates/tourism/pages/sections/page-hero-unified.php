<!-- ============================================
     UNIFIED PAGE HERO - Education/Academic Style
     Reusable hero for all pages with breadcrumbs
     ============================================ -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo get_template_image('bg_1.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="<?php echo base_url(); ?>">Home <i class="fa fa-chevron-right"></i></a></span>
                    <?php
                        // Generate breadcrumb from current page name
                        $page_parts = explode(' - ', $current_page_name);
                        if (count($page_parts) > 1) {
                            // Multi-level breadcrumb (e.g., "News - Blog Post Title")
                            for ($i = 0; $i < count($page_parts) - 1; $i++) {
                                echo '<span class="mr-2"><a href="#">' . htmlspecialchars($page_parts[$i]) . ' <i class="fa fa-chevron-right"></i></a></span>';
                            }
                            echo '<span>' . htmlspecialchars(end($page_parts)) . ' <i class="fa fa-chevron-right"></i></span>';
                        } else {
                            echo '<span>' . htmlspecialchars($current_page_name) . ' <i class="fa fa-chevron-right"></i></span>';
                        }
                    ?>
                </p>
                <h1 class="mb-0 bread"><?php echo htmlspecialchars($current_page_name); ?></h1>
            </div>
        </div>
    </div>
</section>

<style>
    /* Hero Section Styling */
    .hero-wrap-2 {
        min-height: 300px;
        position: relative;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hero-wrap-2 .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(92, 107, 192, 0.85) 0%, rgba(63, 81, 181, 0.8) 100%);
        z-index: 1;
    }
    
    .slider-text {
        position: relative;
        z-index: 2;
        width: 100%;
    }
    
    .breadcrumbs {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }
    
    .breadcrumbs a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        color: white;
    }
    
    .breadcrumbs i {
        font-size: 0.8rem;
    }
    
    .bread {
        font-size: clamp(2rem, 5vw, 3.5rem);
        color: white;
        font-weight: 700;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        margin: 0;
        line-height: 1.1;
    }
    
    @media (max-width: 768px) {
        .hero-wrap-2 {
            min-height: 250px;
        }
        
        .slider-text {
            padding: 2rem 1rem;
        }
        
        .pb-5 {
            padding-bottom: 1rem !important;
        }
    }
</style>
