<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->helper('theme'); ?>
  
  <!-- DNS Prefetch & Preconnect for Performance -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Primary Meta Tags -->
  <title><?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name . ' - Connecting Communities to Better Health'; ?></title>
  <meta name="title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
  <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : 'TNA CARE is a Tanzanian-registered health service company dedicated to bridging the gap between individuals and quality healthcare through education, consultation, and strategic partnerships.'; ?>">
  <meta name="theme-color" content="<?php echo get_theme_color('primary'); ?>">
  <meta name="robots" content="index, follow">
  <meta name="language" content="English">
  <meta name="author" content="<?php echo $site_name; ?>">
  
  <!-- Canonical URL -->
  <link rel="canonical" href="<?php echo isset($canonical_url) ? $canonical_url : current_url(); ?>">
  
  <!-- Sitemap -->
  <link rel="sitemap" type="application/xml" href="<?php echo base_url('sitemap.xml'); ?>">
  
  <!-- Performance Hints -->
  <link rel="preconnect" href="https://fonts.gstatic.com/">
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.js'); ?>" as="script">
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/aos/aos.js'); ?>" as="script">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo current_url(); ?>">
  <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
  <meta property="og:description" content="<?php echo isset($meta_description) ? $meta_description : 'TNA CARE - Connecting Communities to Better Health'; ?>">
  <meta property="og:image" content="<?php echo isset($og_image) ? $og_image : base_url('assets/templates/medical/img/health/tna-female-black-doctor.png'); ?>">
  <meta property="og:site_name" content="<?php echo $site_name; ?>">
  <meta property="og:locale" content="en_US">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?php echo current_url(); ?>">
  <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
  <meta name="twitter:description" content="<?php echo isset($meta_description) ? $meta_description : 'TNA CARE - Connecting Communities to Better Health'; ?>">
  <meta name="twitter:image" content="<?php echo isset($og_image) ? $og_image : base_url('assets/templates/medical/img/health/tna-female-black-doctor.png'); ?>">
  
  <!-- Favicons -->
  <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/templates/medical/img/favicon.png'); ?>
  <link rel="shortcut icon" id="favicon" href="<?php echo $favicon_url; ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_url; ?>">

  <!-- Fonts with display swap for faster rendering (optimized weights) -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS (Critical) -->
  <link href="<?php echo base_url('assets/templates/medical/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/templates/medical/css/main.css'); ?>" rel="stylesheet">

  <!-- Dynamic Theme CSS (must be loaded after main CSS to override) -->
  <?php echo get_theme_css(); ?>
  
  <!-- Non-critical CSS - Load asynchronously -->
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/aos/aos.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="<?php echo base_url('assets/templates/medical/vendor/aos/aos.css'); ?>" rel="stylesheet"></noscript>
  
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/glightbox/css/glightbox.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="<?php echo base_url('assets/templates/medical/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet"></noscript>
  
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/fontawesome-free/css/all.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="<?php echo base_url('assets/templates/medical/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet"></noscript>
  
  <link rel="preload" href="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="<?php echo base_url('assets/templates/medical/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet"></noscript>
  
  <!-- JSON-LD Structured Data -->
  <!-- Medical Organization Schema -->
  <script type="application/ld+json">
  {
      "@context": "https://schema.org",
      "@type": ["MedicalOrganization", "LocalBusiness"],
      "name": "<?php echo $site_name; ?>",
      "description": "TNA CARE is a Tanzanian-registered health service company dedicated to bridging the gap between individuals and quality healthcare through education, consultation, and strategic partnerships.",
      "url": "<?php echo base_url(); ?>",
      "telephone": "<?php echo isset($phone_number) ? $phone_number : ''; ?>",
      "email": "<?php echo isset($site_email) ? $site_email : ''; ?>",
      "address": {
          "@type": "PostalAddress",
          "streetAddress": "Dar es Salaam",
          "addressLocality": "Dar es Salaam",
          "addressRegion": "Dar es Salaam",
          "postalCode": "",
          "addressCountry": "TZ"
      },
      "areaServed": ["TZ", "KE", "UG", "RW", "BW"],
      "priceRange": "$$",
      "openingHoursSpecification": {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
          "opens": "08:00",
          "closes": "17:00"
      },
      "sameAs": [
          <?php if (!empty($facebook)): ?>
          "<?php echo $facebook; ?>",
          <?php endif; ?>
          <?php if (!empty($youtube)): ?>
          "<?php echo $youtube; ?>",
          <?php endif; ?>
          <?php if (!empty($linkedin)): ?>
          "<?php echo $linkedin; ?>"
          <?php endif; ?>
      ],
      "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "<?php echo isset($phone_number) ? $phone_number : ''; ?>",
          "contactType": "Patient Support"
      }
  }
  </script>
  
  <!-- FAQ Schema for Medical Services (Home page only) -->
  <?php if (uri_string() === '' || uri_string() === '/'): ?>
  <script type="application/ld+json">
  {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
          {
              "@type": "Question",
              "name": "What services does TNA CARE offer?",
              "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "TNA CARE offers digital health education, community health outreach programs, corporate wellness solutions, and medical consultation services across Tanzania and East Africa."
              }
          },
          {
              "@type": "Question",
              "name": "How do I request a medical consultation?",
              "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "You can request a free medical consultation by filling out our consultation form. Our medical coordinator will contact you within 24 hours to discuss your healthcare needs."
              }
          },
          {
              "@type": "Question",
              "name": "Is TNA CARE registered and licensed?",
              "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "Yes, TNA CARE is a Tanzanian-registered and licensed health service organization dedicated to providing quality healthcare solutions."
              }
          },
          {
              "@type": "Question",
              "name": "What areas does TNA CARE serve?",
              "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "We serve communities across Tanzania with expansion throughout East and Central Africa, including Kenya, Uganda, Rwanda, and Botswana."
              }
          },
          {
              "@type": "Question",
              "name": "Can corporate organizations partner with TNA CARE?",
              "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "Yes, we offer comprehensive corporate wellness programs and partnership opportunities for organizations looking to invest in employee health."
              }
          }
      ]
  }
  </script>
  <?php endif; ?>
  
  <!-- Breadcrumb Schema (for non-home pages) -->
  <?php 
  if (uri_string() !== '' && uri_string() !== '/') {
      $breadcrumbs = get_breadcrumbs();
      if (!empty($breadcrumbs)) {
          echo generate_breadcrumb_schema($breadcrumbs);
      }
  }
  ?>
  
  <?php if(!empty($google_analytics_id)): ?>
  <!-- Google Analytics - Deferred -->
  <script>
    window.addEventListener('load', function() {
      var script = document.createElement('script');
      script.src = 'https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics_id; ?>';
      script.async = true;
      document.head.appendChild(script);
      
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo $google_analytics_id; ?>');
    });
  </script>
  <?php endif; ?>
  
  <!-- JavaScript: Define base_url for frontend scripts -->
  <script>
    var base_url = "<?php echo base_url(); ?>";
  </script>
  </head>

  <body class="<?php echo isset($body_class) ? $body_class : 'index-page'; ?>">
