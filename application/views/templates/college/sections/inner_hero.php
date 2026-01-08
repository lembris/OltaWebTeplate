<!-- ============================================
     HERO SECTION - Page Header with Breadcrumbs
     ============================================ -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo get_template_image('dmi_inner_hero_one.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="<?php echo base_url(); ?>">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span><?php echo isset($current_page_name) ? $current_page_name : ''; ?> <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread"><?php echo isset($current_page_name) ? $current_page_name : ''; ?></h1>
            </div>
        </div>
    </div>
</section>