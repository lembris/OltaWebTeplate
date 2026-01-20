<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- ============================================
     TIMELINE SECTION - REUSABLE
     ============================================ -->
<?php 
$timeline_title = isset($timeline_title) ? $timeline_title : 'Our Journey';
$timeline_subtitle = isset($timeline_subtitle) ? $timeline_subtitle : 'Key milestones in our mission to transform healthcare access';
$timeline_items = isset($timeline_items) ? $timeline_items : [];

$default_timeline = [
    ['year' => '2019', 'title' => 'Foundation', 'description' => 'TNA CARE was established as a health media initiative starting with YouTube content.'],
    ['year' => '2020', 'title' => 'Expansion', 'description' => 'Launched community outreach programs and began partnerships with local healthcare providers.'],
    ['year' => '2021', 'title' => 'Corporate Services', 'description' => 'Introduced corporate wellness programs and employee health screening services.'],
    ['year' => '2022', 'title' => 'International Partnerships', 'description' => 'Established partnerships with leading hospitals in India and other countries.'],
    ['year' => '2023', 'title' => 'Digital Transformation', 'description' => 'Launched comprehensive digital health platform and expanded services across East Africa.']
];

if (empty($timeline_items)) {
    $timeline_items = $default_timeline;
}
?>

<section class="timeline-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <?php if (isset($timeline_badge)): ?>
                <span class="section-badge"><?php echo htmlspecialchars($timeline_badge); ?></span>
                <?php endif; ?>
                <h2 class="section-heading"><?php echo htmlspecialchars($timeline_title); ?></h2>
                <?php if ($timeline_subtitle): ?>
                <p class="section-subtitle"><?php echo htmlspecialchars($timeline_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="timeline" data-aos="fade-up">
                    <?php foreach ($timeline_items as $index => $item): 
                        $year = is_array($item) ? ($item['year'] ?? '') : ($item->year ?? '');
                        $title = is_array($item) ? ($item['title'] ?? '') : ($item->title ?? '');
                        $description = is_array($item) ? ($item['description'] ?? '') : ($item->description ?? '');
                    ?>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-year"><?php echo htmlspecialchars($year); ?></span>
                            <h4><?php echo htmlspecialchars($title); ?></h4>
                            <p><?php echo htmlspecialchars($description); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
