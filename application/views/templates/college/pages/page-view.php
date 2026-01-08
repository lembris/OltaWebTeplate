<?php
/**
 * College Template - Dynamic Page View
 * 
 * Used for custom pages created in the admin panel
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Page Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <?php if (!empty($page->template) && $page->template === 'sidebar'): ?>
            <!-- With Sidebar Layout -->
            <div class="col-lg-8 ftco-animate">
                <div class="page-content">
                    <?php if (!empty($page->featured_image)): ?>
                    <img src="<?php echo base_url($page->featured_image); ?>" alt="<?php echo htmlspecialchars($page->title); ?>" class="img-fluid mb-4">
                    <?php endif; ?>
                    
                    <?php echo $page->content; ?>
                </div>
            </div>
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Contact Info -->
                <div class="sidebar-box bg-light p-4">
                    <h3 class="heading-sidebar">Contact Us</h3>
                    <div class="block-23">
                        <ul>
                            <?php if (!empty($physical_address)): ?>
                            <li><span class="icon fa fa-map-marker"></span><span class="text"><?php echo $physical_address; ?></span></li>
                            <?php endif; ?>
                            <?php if (!empty($phone_number)): ?>
                            <li><a href="tel:<?php echo $consult_number_call ?? ''; ?>"><span class="icon fa fa-phone"></span><span class="text"><?php echo $phone_number; ?></span></a></li>
                            <?php endif; ?>
                            <?php if (!empty($email_address)): ?>
                            <li><a href="mailto:<?php echo $email_address; ?>"><span class="icon fa fa-paper-plane"></span><span class="text"><?php echo $email_address; ?></span></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Quick Links</h3>
                    <ul class="categories">
                        <li><a href="<?php echo base_url('programs'); ?>">Our Programs</a></li>
                        <li><a href="<?php echo base_url('about'); ?>">About Us</a></li>
                        <li><a href="<?php echo base_url('contact'); ?>">Contact</a></li>
                        <li><a href="<?php echo base_url('enquiry'); ?>">Apply Now</a></li>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <!-- Full Width Layout -->
            <div class="col-lg-12 ftco-animate">
                <div class="page-content">
                    <?php if (!empty($page->featured_image)): ?>
                    <img src="<?php echo base_url($page->featured_image); ?>" alt="<?php echo htmlspecialchars($page->title); ?>" class="img-fluid mb-4">
                    <?php endif; ?>
                    
                    <?php echo $page->content; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center py-5 bg-light">
            <div class="col-md-8 text-center">
                <h2>Have Questions?</h2>
                <p class="mb-4">We're here to help you with any inquiries about our programs and admissions.</p>
                <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary px-4 py-3">Contact Us</a>
            </div>
        </div>
    </div>
</section>
