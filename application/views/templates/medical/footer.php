  </main>

  <footer id="footer" class="footer-16 footer position-relative">

    <div class="container">
      <div class="footer-main" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-start">
          <div class="col-lg-5">
            <div class="brand-section">
              <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center mb-4">
                <?php if (!empty($site_logo)): ?>
                <img src="<?php echo base_url($site_logo); ?>" alt="<?php echo $site_name; ?>" height="60">
                <?php else: ?>
                <span class="sitename"><?php echo $site_name; ?></span>
                <?php endif; ?>
              </a>
              <p class="brand-description">Connecting Communities to Better Health through innovative health education, outreach programs, and digital solutions across Tanzania and beyond.</p>

              <div class="contact-info mt-5">
                <div class="contact-item">
                  <i class="bi bi-geo-alt"></i>
                  <span><?php echo $physical_address; ?></span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-telephone"></i>
                  <span><?php echo $phone_number; ?></span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-envelope"></i>
                  <span><?php echo $site_email; ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="footer-nav-wrapper">
              <div class="row">
                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6>Company</h6>
                    <nav class="footer-nav">
                      <a href="<?php echo base_url('about'); ?>">About Us</a>
                      <a href="<?php echo base_url('about#mission'); ?>">Vision & Mission</a>
                      <a href="<?php echo base_url('about#values'); ?>">Core Values</a>
                      <a href="<?php echo base_url('about#team'); ?>">Our Team</a>
                      <a href="<?php echo base_url('contact'); ?>">Contact</a>
                    </nav>
                  </div>
                </div>

                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6>Services</h6>
                    <nav class="footer-nav">
                      <a href="<?php echo base_url('services#education'); ?>">Health Education</a>
                      <a href="<?php echo base_url('services#outreach'); ?>">Medical Outreach</a>
                      <a href="<?php echo base_url('services#corporate'); ?>">Corporate Wellness</a>
                      <a href="<?php echo base_url('services#media'); ?>">Media Production</a>
                      <a href="<?php echo base_url('services'); ?>">All Services</a>
                    </nav>
                  </div>
                </div>

                <div class="col-6 col-lg-4">
                  <div class="nav-column">
                    <h6>Connect</h6>
                    <nav class="footer-nav">
                      <a href="<?php echo base_url('partners'); ?>">Become a Partner</a>
                      <?php if (!empty($youtube)): ?>
                      <a href="<?php echo $youtube; ?>" target="_blank">YouTube</a>
                      <?php endif; ?>
                      <?php if (!empty($facebook)): ?>
                      <a href="<?php echo $facebook; ?>" target="_blank">Facebook</a>
                      <?php endif; ?>
                      <?php if (!empty($instagram)): ?>
                      <a href="<?php echo $instagram; ?>" target="_blank">Instagram</a>
                      <?php endif; ?>
                      <a href="<?php echo base_url('newsletter'); ?>">Newsletter</a>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="bottom-content" data-aos="fade-up" data-aos-delay="300">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <span class="sitename"><?php echo $site_name; ?></span>. All rights reserved.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="legal-links">
                <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a>
                <a href="<?php echo base_url('terms-of-service'); ?>">Terms of Service</a>
                <div class="credits">
                  Proudly developed by <a href="https://oltanasoftworks.com/" target="_blank">Oltana Softworks</a>
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

  <!-- Vendor JS -->
  <script src="<?php echo base_url('assets/templates/medical/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/aos/aos.js'); ?>"></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
  <script src="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

  <!-- Main JS -->
  <script src="<?php echo base_url('assets/templates/medical/js/main.js'); ?>"></script>

</body>
</html>
