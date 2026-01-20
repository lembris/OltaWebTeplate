<!-- ============================================
     ACCREDITATIONS SECTION - REUSABLE
     ============================================ -->
<?php if (!empty($accreditations)): ?>
<section class="ftco-section pb-3" style="background-color: white;">
    <div class="container">
        <div class="row justify-content-center pb-1">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading" style="font-size: 12px; margin-bottom: 5px;">Recognition</span>
                <h2 style="color: #333; font-size: 28px; font-weight: 600;">Our Accreditations</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($accreditations as $item): ?>
            <div class="col-md-2 col-sm-4 col-6 ftco-animate">
                <div class="accreditation-item text-center p-3" style="background: #faf8f6; border-radius: 12px; transition: transform 0.3s ease; height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <?php 
                    $logo_url = '';
                    if (!empty($item->logo)) {
                        $logo_path = FCPATH . 'assets/img/about/' . $item->logo;
                        if (file_exists($logo_path)) {
                            $logo_url = base_url('assets/img/about/' . $item->logo);
                        }
                    }
                    ?>
                    <div style="width: 80px; height: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <?php if (!empty($logo_url)): ?>
                        <img src="<?php echo $logo_url; ?>" alt="<?php echo htmlspecialchars($item->name); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        <?php else: ?>
                        <div style="width: 60px; height: 60px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <span class="fa fa-certificate fa-2x" style="color: var(--primary-color, #C7805C);"></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($item->website_url)): ?>
                    <a href="<?php echo htmlspecialchars($item->website_url); ?>" target="_blank" style="color: var(--primary-color, #C7805C); font-size: 0.8rem; text-decoration: none;">
                        <?php echo htmlspecialchars($item->name); ?>
                    </a>
                    <?php else: ?>
                    <span style="color: #555; font-size: 0.8rem;"><?php echo htmlspecialchars($item->name); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
