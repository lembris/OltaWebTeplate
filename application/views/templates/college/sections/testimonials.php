<!-- ============================================
     TESTIMONIALS SECTION
     ============================================ -->
<section class="ftco-section testimony-section bg-light">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Testimonials</span>
                <h2 class="mb-4">What Our Students Say</h2>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl">
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">"The 2D Animation & Motion Graphics diploma completely transformed my portfolio. The hands-on training with industry-standard tools and expert instructors prepared me perfectly for my job as a motion designer. Best decision I made!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(<?php echo get_template_image('person_1.jpg'); ?>)"></div>
                                    <div class="pl-3">
                                        <p class="name">Sarah Johnson</p>
                                        <span class="position">Motion Graphics Designer | Multimedia Design (UI/UX) Graduate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">"I completed the Graphic Design & Digital Printing certificate program while working full-time. The flexible schedule and practical skills I gained helped me transition into freelance design. Now I work with major brands!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(<?php echo get_template_image('person_2.jpg'); ?>)"></div>
                                    <div class="pl-3">
                                        <p class="name">Michael Chen</p>
                                        <span class="position">Freelance Designer | Certificate Program Graduate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">"The Professional Photography certificate program gave me the technical skills and confidence to start my own photography business. The instructors' real-world experience and mentorship were invaluable!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(<?php echo get_template_image('person_3.jpg'); ?>)"></div>
                                    <div class="pl-3">
                                        <p class="name">Emily Williams</p>
                                        <span class="position">Professional Photographer | Certificate Graduate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">"As a Social Media Manager, the Social Media Management certificate was exactly what I needed. The course covered strategy, content creation, and analytics. I saw immediate results in my career growth!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(<?php echo get_template_image('person_4.jpg'); ?>)"></div>
                                    <div class="pl-3">
                                        <p class="name">David Martinez</p>
                                        <span class="position">Social Media Manager | Certificate Graduate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="mb-4">"I took the Adobe Creative Suite Masterclass workshop during my lunch breaks, and it completely upgraded my design skills in just 2 weeks! The intensive training and access to premium software was incredible for the price."</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(<?php echo get_template_image('person_5.jpg'); ?>)"></div>
                                    <div class="pl-3">
                                        <p class="name">Lisa Thompson</p>
                                        <span class="position">Content Creator | Workshop Graduate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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
