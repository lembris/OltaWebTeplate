  </main>

  <!-- Footer -->
  <footer id="footer" class="footer-16 footer position-relative bg-dark text-light">
    <!-- Main Footer Content -->
    <div class="container py-3">
      <div class="footer-main" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-start g-3">
          <!-- Brand Section -->
          <div class="col-lg-5">
            <div class="brand-section">
              <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center mb-2">
                <?php if (!empty($site_logo)): ?>
                  <img src="<?php echo base_url($site_logo); ?>" alt="<?php echo $site_name; ?>" height="60">
                <?php else: ?>
                  <span class="sitename"><?php echo $site_name; ?></span>
                <?php endif; ?>
              </a>
              <div class="brand-name mb-3">
                <h5 class="text-white mb-1" style="font-size: 1.3rem; font-weight: 700;">TIBA NA AFYA CARE</h5>
                <p class="text-muted" style="font-size: 0.85rem;">TNA CARE</p>
              </div>
              <p class="brand-description text-light" style="font-size: 0.95rem;">
                Connecting Communities to Better Health through innovative health education, outreach programs, and digital solutions across Tanzania, east and central Africa.
              </p>

              <!-- Contact Information -->
              <div class="contact-info mt-4">
                <?php if ($physical_address): ?>
                  <div class="contact-item mb-2 text-light" style="font-size: 0.9rem;">
                    <i class="bi bi-geo-alt me-2"></i>
                    <span><?php echo $physical_address; ?></span>
                  </div>
                <?php endif; ?>
                <?php if ($phone_number): ?>
                  <div class="contact-item mb-2 text-light" style="font-size: 0.9rem;">
                    <i class="bi bi-telephone me-2"></i>
                    <span><a href="tel:<?php echo $phone_number; ?>" class="text-light text-decoration-none"><?php echo $phone_number; ?></a></span>
                  </div>
                <?php endif; ?>
                <?php if ($site_email): ?>
                  <div class="contact-item text-light" style="font-size: 0.9rem;">
                    <i class="bi bi-envelope me-2"></i>
                    <span><a href="mailto:<?php echo $site_email; ?>" class="text-light text-decoration-none"><?php echo $site_email; ?></a></span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Navigation Links -->
          <div class="col-lg-7">
            <div class="footer-nav-wrapper">
              <div class="row">
                <!-- Company Links -->
                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Company</h6>
                    <nav class="footer-nav d-flex flex-column gap-2">
                      <a href="<?php echo base_url('about'); ?>" class="text-light text-decoration-none">About Us</a>
                      <a href="<?php echo base_url('about#mission'); ?>" class="text-light text-decoration-none">Vision & Mission</a>
                      <a href="<?php echo base_url('about#values'); ?>" class="text-light text-decoration-none">Core Values</a>
                      <a href="<?php echo base_url('about#team'); ?>" class="text-light text-decoration-none">Our Team</a>
                      <a href="<?php echo base_url('contact'); ?>" class="text-light text-decoration-none">Contact</a>
                    </nav>
                  </div>
                </div>

                <!-- Services Links -->
                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Services</h6>
                    <nav class="footer-nav d-flex flex-column gap-2">
                      <a href="<?php echo base_url('services#education'); ?>" class="text-light text-decoration-none">Health Education</a>
                      <a href="<?php echo base_url('services#outreach'); ?>" class="text-light text-decoration-none">Medical Outreach</a>
                      <a href="<?php echo base_url('services#corporate'); ?>" class="text-light text-decoration-none">Corporate Wellness</a>
                      <a href="<?php echo base_url('services#media'); ?>" class="text-light text-decoration-none">Media Production</a>
                      <a href="<?php echo base_url('services'); ?>" class="text-light text-decoration-none">All Services</a>
                    </nav>
                  </div>
                </div>

                <!-- Connect Links -->
                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Connect</h6>
                    <nav class="footer-nav d-flex flex-column gap-2">
                      <a href="<?php echo base_url('partners'); ?>" class="text-light text-decoration-none">Become a Partner</a>
                      <?php if (!empty($youtube)): ?>
                        <a href="<?php echo $youtube; ?>" target="_blank" rel="noopener noreferrer" class="text-light text-decoration-none">YouTube</a>
                      <?php endif; ?>
                      <?php if (!empty($facebook)): ?>
                        <a href="<?php echo $facebook; ?>" target="_blank" rel="noopener noreferrer" class="text-light text-decoration-none">Facebook</a>
                      <?php endif; ?>
                      <?php if (!empty($instagram)): ?>
                        <a href="<?php echo $instagram; ?>" target="_blank" rel="noopener noreferrer" class="text-light text-decoration-none">Instagram</a>
                      <?php endif; ?>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom border-top border-secondary py-4">
      <div class="container">
        <div class="bottom-content" data-aos="fade-up" data-aos-delay="300">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="copyright">
                <p class="mb-0 text-light" style="font-size: 0.9rem;">&copy; <?php echo date('Y'); ?> TIBA NA AFYA CARE (TNA CARE). All rights reserved.</p>
              </div>
            </div>
            <div class="col-lg-6 text-lg-end">
              <div class="legal-links d-flex gap-3 flex-wrap justify-content-lg-end">
                <a href="<?php echo base_url('privacy-policy'); ?>" class="text-light text-decoration-none" style="font-size: 0.9rem;">Privacy Policy</a>
                <a href="<?php echo base_url('terms-of-service'); ?>" class="text-light text-decoration-none" style="font-size: 0.9rem;">Terms of Service</a>
                <div class="credits text-light" style="font-size: 0.9rem;">
                  Proudly developed by <a href="https://oltanasoftworks.com/" target="_blank" rel="noopener noreferrer" class="text-light text-decoration-none">Oltana Softworks</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS - Deferred loading for performance -->
  <script src="<?php echo base_url('assets/templates/medical/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>" defer></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/aos/aos.js'); ?>" defer></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/glightbox/js/glightbox.min.js'); ?>" defer></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/purecounter/purecounter_vanilla.js'); ?>" defer></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.js'); ?>" defer></script>

  <!-- Main JS -->
  <script src="<?php echo base_url('assets/templates/medical/js/main.js'); ?>" defer></script>

  <!-- AOS Optimization: Reduce animation processing overhead -->
  <script>
    window.addEventListener('load', function() {
      if (window.AOS) {
        AOS.init({
          once: true,
          disable: 'phone',
          debounceDelay: 50,
          mirror: false,
          offset: 100,
          duration: 400
        });
      }
    });
  </script>

</body>
</html>
