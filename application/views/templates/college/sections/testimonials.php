<!-- ============================================
      TESTIMONIALS SECTION
      ============================================ -->
<?php if (!empty($testimonials)): ?>
<section class="ftco-section testimony-section bg-light">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Testimonials</span>
                <h2 class="mb-4" style="color: #333;">What Our Students Say</h2>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl">
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
                                    <div class="user-img" style="background-image: url(<?php echo $avatar_url; ?>); width: 60px; height: 60px; border-radius: 50%; background-size: cover; background-position: center;"></div>
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
<?php endif; ?>


<!-- About Page Scripts --> 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated Counters
    const counters = document.querySelectorAll('.number');
    const observerOptions = { threshold: 0.5 };

    const counterObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-number'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
                counterObserver.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => counterObserver.observe(counter));

    // Testimonial Carousel
    if(typeof jQuery !== 'undefined' && jQuery.fn.owlCarousel) {
        jQuery('.carousel-testimony').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            navText: ['<span class="fa fa-chevron-left"></span>', '<span class="fa fa-chevron-right"></span>'],
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                992: { items: 3 }
            }
        });
    }

    // Video Popup
    if(typeof jQuery !== 'undefined' && jQuery.fn.magnificPopup) {
        jQuery('.popup-vimeo').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    }
});
</script>
