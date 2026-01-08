<!-- ============================================
     FOOTER V3 - Premium Design
     ============================================ -->
<footer class="footer-v3">
    <!-- Footer Top - CTA Banner -->
    <div class="footer-cta-banner">
        <div class="container">
            <div class="cta-content">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h3>Ready to Start Your Safari Adventure?</h3>
                        <p>Get personalized quotes and expert advice for your dream Tanzania trip</p>
                    </div>
                    <div class="col-lg-5 d-flex align-items-center justify-content-lg-end justify-content-center">
                        <a href="<?php echo base_url(); ?>contact" class="btn-footer-cta">
                            <i class="bi bi-calendar-check me-2"></i>Plan My Safari
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Main -->
    <div class="footer-main">
        <div class="container">
            <div class="row g-5">
                <!-- Column 1: About -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <img src="<?php echo base_url(); ?>assets/img/logo/Last-white-logo.png" alt="Osiram Safari Adventure" class="footer-logo">
                        <p class="footer-about-text">
                            Your trusted partner for authentic African safari experiences. We create unforgettable adventures through Tanzania's breathtaking landscapes and wildlife.
                        </p>
                        <div class="footer-social">
                            <?php if (!empty($facebook)): ?>
                            <a href="<?php echo $facebook; ?>" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($instagram)): ?>
                            <a href="<?php echo $instagram; ?>" target="_blank" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($twitter)): ?>
                            <a href="<?php echo $twitter; ?>" target="_blank" title="Twitter">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($youtube)): ?>
                            <a href="<?php echo $youtube; ?>" target="_blank" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($tripadvisor)): ?>
                            <a href="<?php echo $tripadvisor; ?>" target="_blank" title="TripAdvisor">
                                <i class="bi bi-star-fill"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><a href="<?php echo base_url(); ?>about">About Us</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations">Destinations</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Safari Packages</a></li>
                        <li><a href="<?php echo base_url(); ?>contact">Contact Us</a></li>
                        <li><a href="<?php echo base_url(); ?>blog">Travel Blog</a></li>
                    </ul>
                </div>
                
                <!-- Column 3: Safari Types -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Safari Types</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url(); ?>packages">Wildlife Safari</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Beach & Safari</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Kilimanjaro Trek</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Cultural Tours</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Honeymoon Safari</a></li>
                        <li><a href="<?php echo base_url(); ?>packages">Budget Safari</a></li>
                    </ul>
                </div>
                
                <!-- Column 4: Destinations -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Top Destinations</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url(); ?>destinations/destination/serengeti-national-park">Serengeti</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations/destination/ngorongoro-conservation-area">Ngorongoro</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations/destination/kilimanjaro-national-park">Kilimanjaro</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations/destination/zanzibar">Zanzibar</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations/destination/tarangire-national-park">Tarangire</a></li>
                        <li><a href="<?php echo base_url(); ?>destinations/destination/lake-manyara-national-park">Lake Manyara</a></li>
                    </ul>
                </div>
                
                <!-- Column 5: Pages/Policies -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Information</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url(); ?>page/terms-conditions">Terms & Conditions</a></li>
                        <li><a href="<?php echo base_url(); ?>page/privacy-policy">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url(); ?>page/cancellation-policy">Cancellation Policy</a></li>
                        <li><a href="<?php echo base_url(); ?>page/faq">Frequently Asked Questions</a></li>
                    </ul>
                </div>
                
                <!-- Column 6: Contact Info -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Contact Us</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span><?php echo $physical_address; ?></span>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <span><?php echo $phone_number; ?></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <span><?php echo $email_address; ?></span>
                        </li>
                        <li>
                            <i class="bi bi-clock"></i>
                            <span>24/7 Available</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Newsletter Section (Full Width) -->
        <div class="footer-newsletter-wrapper">
            <div class="container">
            <!-- Newsletter Section -->
            <div class="footer-newsletter">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h4><i class="bi bi-envelope-heart me-2"></i>Subscribe to Our Newsletter</h4>
                        <p>Get exclusive deals, travel tips, and safari inspiration delivered to your inbox</p>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form" action="#" method="POST">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter your email address" required>
                                <button type="submit" class="btn-newsletter">
                                    Subscribe <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
            
        <!-- Trust Badges -->
        <div class="footer-trust-badges-wrapper">
            <div class="container">
            <!-- Trust Badges -->
            <div class="footer-trust-badges">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="trust-badges-wrapper">
                            <div class="trust-badge">
                                <i class="bi bi-shield-check"></i>
                                <span>Secure Payments</span>
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-patch-check"></i>
                                <span>Licensed Operator</span>
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-trophy"></i>
                                <span>Award Winning</span>
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-headset"></i>
                                <span>24/7 Support</span>
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>Free Cancellation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-3 mb-lg-0">
                    <p class="copyright-text">
                        &copy; <?php echo date('Y'); ?> <strong><?php echo isset($site_name) ? $site_name : 'Osiram Safari Adventure'; ?></strong>. All Rights Reserved.
                    </p>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="footer-bottom-links">
                        <?php if (!empty($footer_pages)): ?>
                            <?php foreach ($footer_pages as $footer_page): ?>
                                <a href="<?php echo base_url(); ?>page/<?php echo $footer_page->slug; ?>">
                                    <?php echo ($footer_page->title === 'Frequently Asked Questions') ? 'FAQs' : $footer_page->title; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <a href="<?php echo base_url(); ?>page/privacy-policy">Privacy Policy</a>
                            <a href="<?php echo base_url(); ?>page/terms-conditions">Terms & Conditions</a>
                            <a href="<?php echo base_url(); ?>page/faq">FAQs</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="developer-credit">
                        Designed & Developed with ❤️ by <a href="https://www.oltanasoftworks.com/" target="_blank">Oltana Softworks</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top-v3" id="backToTop">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hello!%20I'm%20interested%20in%20booking%20a%20safari" class="whatsapp-float" target="_blank">
    <i class="bi bi-whatsapp"></i>
    <span class="whatsapp-tooltip">Chat with us!</span>
</a>

<style>
/* ============ FOOTER V3 - Premium ============ */
.footer-v3 {
    background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1a 100%);
    color: #ffffff;
    position: relative;
}

/* CTA Banner */
.footer-cta-banner {
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    padding: 50px 0;
    margin-top: 0;
}

.footer-cta-banner .container {
    width: 100%;
    max-width: 1320px;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

.footer-cta-banner .cta-content {
    background: rgba(255,255,255,0.1);
    padding: 40px 50px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    width: 100%;
    box-sizing: border-box;
}

.footer-cta-banner h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.footer-cta-banner p {
    font-size: 1.05rem;
    opacity: 0.9;
    margin: 0;
}

.btn-footer-cta {
    display: inline-flex;
    align-items: center;
    padding: 16px 35px;
    background: white;
    color: var(--theme-primary, #C7805C);
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.btn-footer-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    color: var(--theme-primary, #C7805C);
}

/* Footer Main */
.footer-main {
    padding: 80px 0 50px;
}

/* Footer Brand */
.footer-brand {
    margin-bottom: 30px;
}

.footer-logo {
    max-height: 80px;
    max-width: 200px;
    margin-bottom: 20px;
}

.footer-about-text {
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 25px;
    font-size: 0.95rem;
}

/* Social Links */
.footer-social {
    display: flex;
    gap: 12px;
}

.footer-social a {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.footer-social a:hover {
    background: var(--theme-primary, #C7805C);
    transform: translateY(-3px);
}

/* Footer Titles */
.footer-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 25px;
    color: white;
    position: relative;
    padding-bottom: 12px;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: var(--theme-primary, #C7805C);
    border-radius: 2px;
}

/* Footer Links */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.footer-links a::before {
    content: '→';
    margin-right: 8px;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.footer-links a:hover {
    color: var(--theme-primary, #C7805C);
    padding-left: 5px;
}

.footer-links a:hover::before {
    opacity: 1;
    transform: translateX(0);
}

/* Footer Contact */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 15px;
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}

.footer-contact i {
    color: var(--theme-primary, #C7805C);
    font-size: 1rem;
    margin-top: 3px;
}

/* Newsletter Wrapper */
.footer-newsletter-wrapper {
    background: rgba(255,255,255,0.03);
    padding: 50px 0;
    border-top: 1px solid rgba(255,255,255,0.1);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

/* Newsletter */
.footer-newsletter {
    background: rgba(255,255,255,0.05);
    padding: 40px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}

.footer-newsletter h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.footer-newsletter p {
    color: rgba(255,255,255,0.7);
    margin: 0;
    font-size: 0.95rem;
}

.newsletter-form .input-group {
    max-width: 500px;
    margin-left: auto;
}

.newsletter-form .form-control {
    padding: 16px 20px;
    border: none;
    border-radius: 50px 0 0 50px;
    font-size: 1rem;
    background: white;
}

.newsletter-form .form-control:focus {
    box-shadow: none;
}

.btn-newsletter {
    padding: 16px 30px;
    background: var(--theme-primary, #C7805C);
    color: white;
    border: none;
    border-radius: 0 50px 50px 0;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.btn-newsletter:hover {
    background: var(--primary-dark, #A8684A);
}

/* Trust Badges Wrapper */
.footer-trust-badges-wrapper {
    background: rgba(255,255,255,0.02);
    padding: 40px 0;
    border-top: 1px solid rgba(255,255,255,0.1);
}

/* Trust Badges */
.footer-trust-badges {
    padding: 0;
}

.trust-badges-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.trust-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
}

.trust-badge i {
    font-size: 1.3rem;
    color: var(--theme-primary, #C7805C);
}

/* Footer Bottom */
.footer-bottom {
    background: rgba(0,0,0,0.3);
    padding: 25px 0;
}

.copyright-text {
    color: rgba(255,255,255,0.6);
    margin: 0;
    font-size: 0.9rem;
}

.footer-bottom-links {
    display: flex;
    gap: 25px;
    justify-content: flex-end;
}

.footer-bottom-links a {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-bottom-links a:hover {
    color: var(--theme-primary, #C7805C);
}

.developer-credit {
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
    margin: 0;
}

.developer-credit a {
    color: var(--theme-primary, #C7805C);
    text-decoration: none;
    font-weight: 600;
}

.developer-credit a:hover {
    text-decoration: underline;
}

/* Back to Top */
.back-to-top-v3 {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    text-decoration: none;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 999;
    box-shadow: 0 5px 20px rgba(199, 128, 92, 0.4);
}

.back-to-top-v3.visible {
    opacity: 1;
    visibility: visible;
}

.back-to-top-v3:hover {
    transform: translateY(-5px);
    color: white;
}

/* WhatsApp Float */
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #25D366;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    text-decoration: none;
    z-index: 1000;
    box-shadow: 0 5px 25px rgba(37, 211, 102, 0.5);
    transition: all 0.3s ease;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    color: white;
}

.whatsapp-tooltip {
    position: absolute;
    right: 70px;
    background: #1a1a2e;
    color: white;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 0.85rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.whatsapp-float:hover .whatsapp-tooltip {
    opacity: 1;
    visibility: visible;
}

/* Responsive */
@media (max-width: 991px) {
    .footer-cta-banner .cta-content {
        padding: 30px;
        text-align: center;
    }
    
    .footer-newsletter {
        padding: 30px;
        text-align: center;
    }
    
    .newsletter-form .input-group {
        max-width: 100%;
        margin: 20px auto 0;
    }
    
    .footer-bottom-links {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .footer-main {
        padding: 60px 0 40px;
    }
    
    .footer-cta-banner h3 {
        font-size: 1.4rem;
    }
    
    .newsletter-form .form-control,
    .btn-newsletter {
        border-radius: 50px;
    }
    
    .newsletter-form .input-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .trust-badges-wrapper {
        gap: 20px;
    }
    
    .trust-badge {
        flex-direction: column;
        text-align: center;
        gap: 5px;
    }
    
    .footer-bottom-links {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 55px;
        height: 55px;
    }
    
    .back-to-top-v3 {
        bottom: 90px;
        right: 20px;
        width: 45px;
        height: 45px;
    }
}
</style>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/lib/wow/wow.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/easing/easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/waypoints/waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>

<!-- Back to Top Script -->
<script>
    // Back to Top Button
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

<!-- ============================================
     GLOBAL PAGE PROTECTION - Disable Inspect & Right Click
     ============================================ -->
<style>
    body {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
<script>
(function() {
    // Disable right-click context menu
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });

    // Disable keyboard shortcuts for DevTools
    document.addEventListener('keydown', function(e) {
        // F12
        if (e.key === 'F12' || e.keyCode === 123) {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+I (Inspect)
        if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.keyCode === 73)) {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+J (Console)
        if (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j' || e.keyCode === 74)) {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+C (Element picker)
        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c' || e.keyCode === 67)) {
            e.preventDefault();
            return false;
        }
        // Ctrl+U (View Source)
        if (e.ctrlKey && (e.key === 'U' || e.key === 'u' || e.keyCode === 85)) {
            e.preventDefault();
            return false;
        }
        // Ctrl+S (Save)
        if (e.ctrlKey && (e.key === 'S' || e.key === 's' || e.keyCode === 83)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable text selection
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
        return false;
    });

    // Disable drag
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
        return false;
    });

    // Disable copy
    document.addEventListener('copy', function(e) {
        e.preventDefault();
        return false;
    });

    // Disable cut
    document.addEventListener('cut', function(e) {
        e.preventDefault();
        return false;
    });
})();
</script>

</body>
</html>
