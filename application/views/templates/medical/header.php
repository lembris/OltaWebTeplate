<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' | TNA CARE' : 'TNA CARE - Connecting Communities to Better Health'; ?></title>
  <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : 'TNA CARE is a Tanzanian health service facilitator providing digital health education, corporate wellness, medical outreach, and media solutions'; ?>">
  <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : 'TNA CARE, healthcare Tanzania, health education, medical outreach, corporate wellness, digital health'; ?>">
  <?php $this->load->helper('theme'); ?>
  <meta name="theme-color" content="<?php echo get_theme_color('primary'); ?>">

  <!-- Favicons -->
  <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/templates/medical/img/favicon.png'); ?>
  <link rel="shortcut icon" id="favicon" href="<?php echo $favicon_url; ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_url; ?>">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="<?php echo base_url('assets/templates/medical/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/aos/aos.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

  <!-- Main CSS -->
  <link href="<?php echo base_url('assets/templates/medical/css/main.css'); ?>" rel="stylesheet">

  <!-- Dynamic Theme CSS (must be loaded after main CSS to override) -->
  <?php echo get_theme_css(); ?>
  
  <!-- JavaScript: Define base_url for frontend scripts -->
  <script>
    var base_url = "<?php echo base_url(); ?>";
  </script>
  </head>

  <body class="<?php echo isset($body_class) ? $body_class : 'index-page'; ?>">
