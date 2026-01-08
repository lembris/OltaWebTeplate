<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    
    <!-- Primary Meta Tags -->
    <title><?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name . ' | ' . $site_tag; ?></title>
    <meta name="title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : 'African Safari Tours & Wildlife Adventures in Tanzania | ' . $site_name; ?>">
    <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : 'Experience unforgettable African safari tours in Tanzania. Expert guides, luxury camping, Big Five wildlife guaranteed. 500+ happy travelers. Book your adventure today!'; ?>">
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : 'safari tours, African wildlife, Tanzania safari, guided tours, luxury camping, Serengeti, Kilimanjaro, Ngorongoro, Big Five, African adventure'; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a2e">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="author" content="<?php echo $site_name; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo isset($canonical_url) ? $canonical_url : current_url(); ?>">
    
    <!-- Sitemap -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo base_url('sitemap.xml'); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo current_url(); ?>">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : 'African Safari Tours & Wildlife Adventures in Tanzania | ' . $site_name; ?>">
    <meta property="og:description" content="<?php echo isset($meta_description) ? $meta_description : 'Experience unforgettable African safari tours in Tanzania. Expert guides, luxury camping, Big Five wildlife guaranteed.'; ?>">
    <meta property="og:image" content="<?php echo isset($og_image) ? $og_image : base_url() . 'assets/img/hero-bg.jpg'; ?>">
    <meta property="og:site_name" content="<?php echo $site_name; ?>">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo current_url(); ?>">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : 'African Safari Tours & Wildlife Adventures in Tanzania | ' . $site_name; ?>">
    <meta name="twitter:description" content="<?php echo isset($meta_description) ? $meta_description : 'Experience unforgettable African safari tours in Tanzania. Expert guides, luxury camping, Big Five wildlife guaranteed.'; ?>">
    <meta name="twitter:image" content="<?php echo isset($og_image) ? $og_image : base_url() . 'assets/img/hero-bg.jpg'; ?>">

    <!-- Favicon -->
    <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/favicon.png'); ?>
    <link rel="shortcut icon" id="favicon" href="<?php echo $favicon_url; ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_url; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicon_url; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon_url; ?>">



    <!-- Preconnect to external resources for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Ensure font-display: swap is applied */
        @font-face { font-display: swap; }
    </style>

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    
    <!-- Blog Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/css/blog.css" rel="stylesheet">
    
    <!-- Dynamic Theme CSS -->
    <?php $this->load->helper('theme'); echo get_theme_css(); ?>
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "TravelAgency",
        "name": "<?php echo $site_name; ?>",
        "description": "Premium African safari tours and wildlife adventures in Tanzania",
        "url": "<?php echo base_url(); ?>",
        "telephone": "+255<?php echo isset($consult_number_call) ? $consult_number_call : ''; ?>",
        "email": "<?php echo isset($site_email) ? $site_email : 'info@osiramsafari.com'; ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Arusha",
            "addressLocality": "Arusha",
            "addressRegion": "Arusha Region",
            "postalCode": "00000",
            "addressCountry": "TZ"
        },
        "image": "<?php echo base_url(); ?>assets/img/hero-bg.jpg",
        "priceRange": "$$",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "500",
            "bestRating": "5",
            "worstRating": "1"
        },
        "areaServed": {
            "@type": "Country",
            "name": "Tanzania"
        },
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Safari Tours",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "TouristTrip",
                        "name": "Serengeti Safari"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "TouristTrip",
                        "name": "Ngorongoro Crater Tour"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "TouristTrip",
                        "name": "Kilimanjaro Trekking"
                    }
                }
            ]
        },
        "sameAs": [
            "https://facebook.com/osiramsafari",
            "https://instagram.com/osiramsafari",
            "https://twitter.com/osiramsafari"
        ]
    }
    </script>
    
    <?php if(isset($schema_markup)): ?>
    <script type="application/ld+json">
    <?php echo $schema_markup; ?>
    </script>
    <?php endif; ?>
    
    <?php if(!empty($google_analytics_id)): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics_id; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo $google_analytics_id; ?>');
    </script>
    <?php endif; ?>
    
    <?php if(!empty($google_tag_manager_id)): ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $google_tag_manager_id; ?>');</script>
    <?php endif; ?>
</head>