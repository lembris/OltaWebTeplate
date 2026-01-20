<!-- ============================================
      TESTIMONIALS SECTION - DYNAMIC FROM DATABASE
      ============================================ -->
<?php if (!empty($testimonials)): ?>
<section class="ftco-section testimony-section" style="background-color: #faf8f6; padding: 0; margin: 0;">
    <div class="container" style="padding: 0;">
        <div class="row justify-content-center" style="margin: 0;">
            <div class="col-md-12 heading-section text-center ftco-animate" style="margin: 0; padding: 0;">
                <span class="subheading" style="font-size: 12px; margin-bottom: 5px;">Testimonials</span>
                <h2 style="font-size: 28px; font-weight: 600; color: #333; margin: 0; padding: 0;">What Our Students Say</h2>
            </div>
        </div>
        <div class="row ftco-animate" style="margin: 0;">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl" style="margin: 0;">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="item">
                        <div class="testimony-wrap py-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                            <div class="text p-4">
                                <p class="mb-4" style="color: #555; line-height: 1.8;">"<?php echo htmlspecialchars($testimonial->content ?? $testimonial->message); ?>"</p>
                                <div class="d-flex align-items-center">
                                    <?php 
                                    $avatar_url = get_template_image('dmi_journey.jpg');
                                    if (!empty($testimonial->avatar)) {
                                        $avatar_path = FCPATH . 'assets/images/avatars/' . $testimonial->avatar;
                                        if (file_exists($avatar_path)) {
                                            $avatar_url = base_url('assets/images/avatars/' . $testimonial->avatar);
                                        }
                                    }
                                    ?>
                                    <div class="user-img" style="background-image: url(<?php echo $avatar_url; ?>); width: 50px; height: 50px; border-radius: 50%; background-size: cover; background-position: center;"></div>
                                    <div class="pl-3">
                                        <p class="name" style="font-weight: 600; color: #333; margin-bottom: 3px;"><?php echo htmlspecialchars($testimonial->name); ?></p>
                                        <span class="position" style="font-size: 0.85rem; color: var(--primary-color, #C7805C);"><?php echo htmlspecialchars($testimonial->role ?? 'Student'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<!-- Debug: No testimonials found - Add testimonials via admin -->
<?php endif; ?>
