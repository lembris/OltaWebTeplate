  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center dark-background">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <?php if (!empty($site_email)): ?>
            <i class="bi bi-envelope d-flex align-items-center p-2">
              <a href="mailto:<?php echo $site_email; ?>"><?php echo $site_email; ?></a>
            </i>
          <?php endif; ?>
          <?php if (!empty($phone_number)): ?>
            <i class="bi bi-phone d-flex align-items-center p-2">
              <a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></a>
            </i>
          <?php endif; ?>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <?php if (!empty($facebook)): ?>
          <a href="<?php echo $facebook; ?>" target="_blank" rel="noopener noreferrer" class="facebook"><i class="bi bi-facebook"></i></a>
          <?php endif; ?>
          <?php if (!empty($instagram)): ?>
          <a href="<?php echo $instagram; ?>" target="_blank" rel="noopener noreferrer" class="instagram"><i class="bi bi-instagram"></i></a>
          <?php endif; ?>
          <?php if (!empty($youtube)): ?> 
          <a href="<?php echo $youtube; ?>" target="_blank" rel="noopener noreferrer" class="youtube"><i class="bi bi-youtube"></i></a>
          <?php endif; ?>
          <?php if (!empty($linkedin)): ?>
          <a href="<?php echo $linkedin; ?>" target="_blank" rel="noopener noreferrer" class="linkedin"><i class="bi bi-linkedin"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">
          <?php if (!empty($site_logo)): ?>
          <img src="<?php echo base_url($site_logo); ?>" alt="<?php echo $site_name; ?>" height="50">
          <?php else: ?>
          <h1 class="sitename"><?php echo $site_name; ?></h1>
          <?php endif; ?>
        </a>

        <nav id="navmenu" class="navmenu">
           <ul>
              <li><a href="<?php echo base_url(); ?>" class="<?php echo uri_string() === '' || uri_string() === '/' ? 'active' : ''; ?>">Home</a></li>
              <li><a href="<?php echo base_url('about'); ?>" class="<?php echo strpos(uri_string(), 'about') === 0 ? 'active' : ''; ?>">About</a></li>
              <li><a href="<?php echo base_url('expertise'); ?>" class="<?php echo strpos(uri_string(), 'expertise') === 0 ? 'active' : ''; ?>">Expertise</a></li>
              <li><a href="<?php echo base_url('services'); ?>" class="<?php echo strpos(uri_string(), 'services') === 0 ? 'active' : ''; ?>">Services</a></li>
              <li><a href="<?php echo base_url('partners'); ?>" class="<?php echo strpos(uri_string(), 'partners') === 0 ? 'active' : ''; ?>">Partners</a></li>
              <li><a href="<?php echo base_url('blog'); ?>" class="<?php echo strpos(uri_string(), 'blog') === 0 ? 'active' : ''; ?>">Blog</a></li>
              <li><a href="<?php echo base_url('faq'); ?>" class="<?php echo strpos(uri_string(), 'faq') === 0 ? 'active' : ''; ?>">FAQ</a></li>
              <li><a href="<?php echo base_url('contact'); ?>" class="<?php echo strpos(uri_string(), 'contact') === 0 ? 'active' : ''; ?>">Contact</a></li>
             <li class="ms-lg-3">
               <a href="<?php echo base_url('#consultation'); ?>" class="nav-cta-btn">
                 <i class="bi bi-calendar-check me-2"></i><span>Get Health Support</span>
               </a>
             </li>
           </ul>
           <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>

  </header>

  <main class="main">
