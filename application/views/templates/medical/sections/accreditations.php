<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- ============================================
     ACCREDITATIONS SECTION - REUSABLE
     ============================================ -->
<?php if (!empty($accreditations)): ?>
<section class="accreditations-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <?php if (isset($accreditations_badge)): ?>
                <span class="section-badge"><?php echo htmlspecialchars($accreditations_badge); ?></span>
                <?php else: ?>
                <span class="section-badge">Recognition</span>
                <?php endif; ?>
                <?php if (isset($accreditations_title)): ?>
                <h2 class="section-heading"><?php echo htmlspecialchars($accreditations_title); ?></h2>
                <?php else: ?>
                <h2 class="section-heading">Our Accreditations</h2>
                <?php endif; ?>
                <?php if (isset($accreditations_subtitle)): ?>
                <p class="section-subtitle"><?php echo htmlspecialchars($accreditations_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row justify-content-center g-4" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($accreditations as $index => $item): ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="fade-up" data-aos-delay="<?php echo $index * 50 + 100; ?>">
                <div class="accreditation-item">
                    <?php 
                    $logo_url = '';
                    if (!empty($item->logo)) {
                        $logo_path = FCPATH . 'assets/img/about/' . $item->logo;
                        if (file_exists($logo_path)) {
                            $logo_url = base_url('assets/img/about/' . $item->logo);
                        } else {
                            $logo_path = FCPATH . 'uploads/accreditations/' . $item->logo;
                            if (file_exists($logo_path)) {
                                $logo_url = base_url('uploads/accreditations/' . $item->logo);
                            }
                        }
                    }
                    ?>
                    <div class="accreditation-logo-wrapper">
                        <?php if (!empty($logo_url)): ?>
                        <img src="<?php echo $logo_url; ?>" alt="<?php echo htmlspecialchars($item->name); ?>" class="accreditation-logo">
                        <?php else: ?>
                        <div class="accreditation-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="accreditation-info">
                        <?php if (!empty($item->website_url)): ?>
                        <a href="<?php echo htmlspecialchars($item->website_url); ?>" target="_blank" class="accreditation-name">
                            <?php echo htmlspecialchars($item->name); ?>
                        </a>
                        <?php else: ?>
                        <span class="accreditation-name"><?php echo htmlspecialchars($item->name); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
