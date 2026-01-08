<!-- Footer - Theme-Aware -->
<footer class="ftco-footer ftco-no-pt" style="background-color: var(--footer-bg, #f4f4f4); color: var(--footer-text, #333);">
    <style>
        .ftco-footer {
            --footer-bg: <?php echo isset($footer_bg_color) ? $footer_bg_color : '#f4f4f4'; ?>;
            --footer-text: <?php echo isset($footer_text_color) ? $footer_text_color : '#333'; ?>;
            --footer-link: <?php echo isset($footer_link_color) ? $footer_link_color : 'var(--theme-primary, #C7805C)'; ?>;
            --footer-heading: <?php echo isset($footer_heading_color) ? $footer_heading_color : '#333'; ?>;
        }
        
        .ftco-footer .ftco-heading-2 {
            color: var(--footer-heading);
        }
        
        .ftco-footer a {
            color: var(--footer-link);
        }
        
        .ftco-footer a:hover {
            color: var(--theme-primary, #C7805C);
            text-decoration: none;
        }
        
        .ftco-footer-social a {
            color: var(--footer-link);
            background: transparent;
            transition: all 0.3s;
        }
        
        .ftco-footer-social a:hover {
            color: white;
            background: var(--theme-primary, #C7805C);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    <div class="container">
        <div class="row mb-5">
            <!-- About Column -->
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2 class="ftco-heading-2">About <?php echo isset($site_name) ? $site_name : 'Our Institute'; ?></h2>
                    <p><?php echo isset($site_tagline) ? $site_tagline : 'Dedicated to providing quality education and nurturing future leaders through innovative learning experiences.'; ?></p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                        <?php if (!empty($facebook)): ?>
                        <li class="ftco-animate"><a href="<?php echo $facebook; ?>" target="_blank" title="Follow us on Facebook"><span class="fa fa-facebook"></span></a></li>
                        <?php endif; ?>
                        <?php if (!empty($twitter)): ?>
                        <li class="ftco-animate"><a href="<?php echo $twitter; ?>" target="_blank" title="Follow us on Twitter"><span class="fa fa-twitter"></span></a></li>
                        <?php endif; ?>
                        <?php if (!empty($instagram)): ?>
                        <li class="ftco-animate"><a href="<?php echo $instagram; ?>" target="_blank" title="Follow us on Instagram"><span class="fa fa-instagram"></span></a></li>
                        <?php endif; ?>
                        <?php if (!empty($youtube)): ?>
                        <li class="ftco-animate"><a href="<?php echo $youtube; ?>" target="_blank" title="Subscribe on YouTube"><span class="fa fa-youtube"></span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">Quick Links</h2>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo base_url(); ?>" class="py-2 d-block">Home</a></li>
                        <li><a href="<?php echo base_url('about'); ?>" class="py-2 d-block">About Us</a></li>
                        <li><a href="<?php echo base_url('programs'); ?>" class="py-2 d-block">Programs</a></li>
                        <li><a href="<?php echo base_url('admissions'); ?>" class="py-2 d-block">Admissions</a></li>
                        <li><a href="<?php echo base_url('contact'); ?>" class="py-2 d-block">Contact</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Programs -->
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2 class="ftco-heading-2">Our Programs</h2>
                    <ul class="list-unstyled">
                        <?php if (isset($footer_programs) && !empty($footer_programs)): ?>
                            <?php foreach (array_slice($footer_programs, 0, 6) as $program): ?>
                            <li><a href="<?php echo base_url('programs/' . $program->code); ?>" class="py-2 d-block"><?php echo htmlspecialchars($program->name); ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?php echo base_url('programs'); ?>" class="py-2 d-block">Computer Science</a></li>
                            <li><a href="<?php echo base_url('programs'); ?>" class="py-2 d-block">Business Studies</a></li>
                            <li><a href="<?php echo base_url('programs'); ?>" class="py-2 d-block">Engineering</a></li>
                            <li><a href="<?php echo base_url('programs'); ?>" class="py-2 d-block">Arts & Design</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2 class="ftco-heading-2">Contact Us</h2>
                    <div class="block-23 mb-3">
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
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="row" style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding-top: 20px;">
            <div class="col-md-12 text-center">
                <p style="margin: 0; color: var(--footer-text, #666);">
                    Copyright &copy; <?php echo date('Y'); ?> <strong><?php echo isset($site_name) ? $site_name : 'Institute'; ?></strong>. All rights reserved. 
                    <br class="d-md-none">
                    Designed by <a href="https://www.oltanasoftworks.com/" target="_blank">Oltana Softworks</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop" style="position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; background: var(--theme-primary, #C7805C); color: white; border-radius: 50%; display: none; align-items: center; justify-content: center; text-decoration: none; z-index: 999;">
    <i class="fa fa-arrow-up"></i>
</a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template-specific JS -->
<script src="<?php echo get_template_js('jquery.easing.1.3.js'); ?>"></script>
<script src="<?php echo get_template_js('jquery.waypoints.min.js'); ?>"></script>
<script src="<?php echo get_template_js('jquery.stellar.min.js'); ?>"></script>
<script src="<?php echo get_template_js('owl.carousel.min.js'); ?>"></script>
<script src="<?php echo get_template_js('jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?php echo get_template_js('jquery.animateNumber.min.js'); ?>"></script>
<script src="<?php echo get_template_js('scrollax.min.js'); ?>"></script>

<!-- Hide loader immediately as fallback, then load main.js -->
<script>
(function() {
    // Immediately hide loader as fallback
    var loader = document.getElementById('ftco-loader');
    if (loader) {
        setTimeout(function() {
            loader.classList.remove('show');
            loader.style.opacity = '0';
            loader.style.visibility = 'hidden';
        }, 500);
    }
})();
</script>

<script src="<?php echo get_template_js('main.js'); ?>"></script>

<script>
// Back to Top Button
document.addEventListener('DOMContentLoaded', function() {
    var backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTop.style.display = 'flex';
        } else {
            backToTop.style.display = 'none';
        }
    });
    
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>

</body>
</html>
