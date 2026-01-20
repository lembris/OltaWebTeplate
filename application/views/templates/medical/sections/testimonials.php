<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- ============================================
     TESTIMONIALS SECTION - REUSABLE
     ============================================ -->
<?php 
$testimonials_title = isset($testimonials_title) ? $testimonials_title : 'What Our Patients Say';
$testimonials_subtitle = isset($testimonials_subtitle) ? $testimonials_subtitle : 'Real stories from people who have experienced our healthcare services';
$testimonials = isset($testimonials) ? $testimonials : [];
?>

<?php if (!empty($testimonials)): ?>
<section class="testimonials-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <?php if (isset($testimonials_badge)): ?>
                <span class="section-badge"><?php echo htmlspecialchars($testimonials_badge); ?></span>
                <?php endif; ?>
                <h2 class="section-heading"><?php echo htmlspecialchars($testimonials_title); ?></h2>
                <?php if ($testimonials_subtitle): ?>
                <p class="section-subtitle"><?php echo htmlspecialchars($testimonials_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper init-swiper">
                    <div class="swiper-config" style="display: none;">
                        {
                            "slidesPerView": 1,
                            "spaceBetween": 30,
                            "loop": true,
                            "pagination": {
                                "el": ".swiper-pagination",
                                "clickable": true
                            },
                            "breakpoints": {
                                "320": {"slidesPerView": 1},
                                "768": {"slidesPerView": 2},
                                "992": {"slidesPerView": 3}
                            }
                        }
                    </div>
                    <div class="swiper-wrapper">
                        <?php foreach ($testimonials as $testimonial): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <?php echo htmlspecialchars($testimonial->content ?? $testimonial->message ?? ''); ?>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    <div class="testimonial-author">
                                        <h4><?php echo htmlspecialchars($testimonial->name); ?></h4>
                                        <span><?php echo htmlspecialchars($testimonial->role ?? 'Patient'); ?></span>
                                    </div>
                                    <div class="testimonial-stars">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
