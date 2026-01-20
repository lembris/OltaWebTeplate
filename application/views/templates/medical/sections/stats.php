<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- ============================================
     STATISTICS SECTION - REUSABLE
     ============================================ -->
<?php 
$stats_data = isset($stats) ? $stats : [];
$stats_title = isset($stats_title) ? $stats_title : 'Our Impact in Numbers';
$stats_subtitle = isset($stats_subtitle) ? $stats_subtitle : 'Making a difference in healthcare across Tanzania and East Africa';

// Default stats if none provided
if (empty($stats_data)) {
    $stats_data = [
        ['icon' => 'bi-people', 'number' => '1M+', 'label' => 'People Reached'],
        ['icon' => 'bi-youtube', 'number' => '19.7K', 'label' => 'YouTube Subscribers'],
        ['icon' => 'bi-hospital', 'number' => '50+', 'label' => 'Hospital Partners'],
        ['icon' => 'bi-calendar', 'number' => '5+', 'label' => 'Years of Service']
    ];
}
?>

<section class="stats-section">
    <div class="container">
        <?php if ($stats_title || $stats_subtitle): ?>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <?php if ($stats_title): ?>
                <h2 class="section-heading"><?php echo htmlspecialchars($stats_title); ?></h2>
                <?php endif; ?>
                <?php if ($stats_subtitle): ?>
                <p class="section-subtitle"><?php echo htmlspecialchars($stats_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($stats_data as $index => $stat): ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $index * 100 + 100; ?>">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon">
                            <i class="bi <?php echo htmlspecialchars($stat['icon'] ?? 'bi-graph-up'); ?>"></i>
                        </div>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo htmlspecialchars($stat['number']); ?></div>
                        <div class="stat-label"><?php echo htmlspecialchars($stat['label']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
