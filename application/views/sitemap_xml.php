<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    
    <!-- Static Pages -->
    <?php foreach($pages as $page): ?>
    <url>
        <loc><?php echo htmlspecialchars($page['loc']); ?></loc>
        <lastmod><?php echo $page['lastmod']; ?></lastmod>
        <changefreq><?php echo $page['changefreq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    
    <!-- Safari Packages / Tourism -->
    <?php if(!empty($packages)): ?>
    <?php foreach($packages as $package): ?>
    <url>
        <loc><?php echo htmlspecialchars($package['loc']); ?></loc>
        <lastmod><?php echo $package['lastmod']; ?></lastmod>
        <changefreq><?php echo $package['changefreq']; ?></changefreq>
        <priority><?php echo $package['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Destinations / Tourism -->
    <?php if(!empty($destinations)): ?>
    <?php foreach($destinations as $destination): ?>
    <url>
        <loc><?php echo htmlspecialchars($destination['loc']); ?></loc>
        <lastmod><?php echo $destination['lastmod']; ?></lastmod>
        <changefreq><?php echo $destination['changefreq']; ?></changefreq>
        <priority><?php echo $destination['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Medical Services / Specialties -->
    <?php if(!empty($specialties)): ?>
    <?php foreach($specialties as $specialty): ?>
    <url>
        <loc><?php echo htmlspecialchars($specialty['loc']); ?></loc>
        <lastmod><?php echo $specialty['lastmod']; ?></lastmod>
        <changefreq><?php echo $specialty['changefreq']; ?></changefreq>
        <priority><?php echo $specialty['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Medical Expertise -->
    <?php if(!empty($expertises)): ?>
    <?php foreach($expertises as $expertise): ?>
    <url>
        <loc><?php echo htmlspecialchars($expertise['loc']); ?></loc>
        <lastmod><?php echo $expertise['lastmod']; ?></lastmod>
        <changefreq><?php echo $expertise['changefreq']; ?></changefreq>
        <priority><?php echo $expertise['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Partner Hospitals -->
    <?php if(!empty($partners)): ?>
    <?php foreach($partners as $partner): ?>
    <url>
        <loc><?php echo htmlspecialchars($partner['loc']); ?></loc>
        <lastmod><?php echo $partner['lastmod']; ?></lastmod>
        <changefreq><?php echo $partner['changefreq']; ?></changefreq>
        <priority><?php echo $partner['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Blog Posts -->
    <?php if(!empty($blogs)): ?>
    <?php foreach($blogs as $blog): ?>
    <url>
        <loc><?php echo htmlspecialchars($blog['loc']); ?></loc>
        <lastmod><?php echo $blog['lastmod']; ?></lastmod>
        <changefreq><?php echo $blog['changefreq']; ?></changefreq>
        <priority><?php echo $blog['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
    <?php endif; ?>
    
</urlset>
