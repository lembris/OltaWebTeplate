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
    
    <!-- Safari Packages -->
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
    
    <!-- Destinations -->
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
