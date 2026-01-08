<?php $this->load->helper('theme'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    

    <!-- Change these lines in <head> -->
    <!-- <title>Digital Media Training Tanzania | Film, Design, Animation | DMI</title>
    <meta name="description" content="Professional digital media training in Tanzania. Learn film production, graphic design, animation, and digital marketing with hands-on training and industry internships.">
    <meta name="keywords" content="digital media institute tanzania, film school dar es salaam, graphic design course, animation training, video production tanzania, social media marketing course"> -->
    
    <!-- Primary Meta Tags -->
    <title><?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name . ' | ' . $site_tag; ?></title>
    <meta name="title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
    <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : 'Welcome to ' . $site_name . ' - Your gateway to quality education and learning excellence.'; ?>">
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : 'college, education, courses, learning, university, programs, study'; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="<?php echo get_theme_color('primary'); ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="author" content="<?php echo $site_name; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo isset($canonical_url) ? $canonical_url : current_url(); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo current_url(); ?>">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
    <meta property="og:description" content="<?php echo isset($meta_description) ? $meta_description : 'Welcome to ' . $site_name . ' - Your gateway to quality education.'; ?>">
    <meta property="og:image" content="<?php echo isset($og_image) ? $og_image : get_template_image('bg_1.jpg'); ?>">
    <meta property="og:site_name" content="<?php echo $site_name; ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo current_url(); ?>">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . $site_name : $site_name; ?>">
    <meta name="twitter:description" content="<?php echo isset($meta_description) ? $meta_description : 'Welcome to ' . $site_name . ' - Your gateway to quality education.'; ?>">
    <meta name="twitter:image" content="<?php echo isset($og_image) ? $og_image : get_template_image('bg_1.jpg'); ?>">

    <!-- Favicon -->
    <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/favicon.png'); ?>
    <link rel="shortcut icon" id="favicon" href="<?php echo $favicon_url; ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_url; ?>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Template Stylesheets -->
    <link rel="stylesheet" href="<?php echo get_template_css('animate.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('magnific-popup.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('bootstrap-datepicker.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('jquery.timepicker.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('flaticon.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_css('style.css'); ?>">
    
    <!-- Shared Assets (from main assets folder) -->
    <link href="<?php echo base_url(); ?>assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/events.css" rel="stylesheet">
    
    <!-- Dynamic Theme CSS (must be loaded FIRST before template overrides) -->
    <?php $this->load->helper('theme'); echo get_theme_css(); ?>
    
    <!-- Template Override CSS (applies college styling to shared content) -->
    <link rel="stylesheet" href="<?php echo get_template_css('template-overrides.css'); ?>" />
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "<?php echo $site_name; ?>",
        "description": "<?php echo isset($meta_description) ? $meta_description : 'Quality education institution'; ?>",
        "url": "<?php echo base_url(); ?>",
        "telephone": "<?php echo isset($site_phone) ? $site_phone : ''; ?>",
        "email": "<?php echo isset($site_email) ? $site_email : ''; ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo isset($site_address) ? $site_address : ''; ?>",
            "addressCountry": "TZ"
        }
    }
    </script>
    
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
</head>
