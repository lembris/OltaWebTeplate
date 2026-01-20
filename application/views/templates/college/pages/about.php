<?php
/**
 * College Template - About Page
 * 
 * About us page with hero section, intro, counters, testimonials,
 * why choose us, and call-to-action sections.
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>


<!-- ============================================
     ABOUT INTRO SECTION
     ============================================ -->
<section class="ftco-section ftco-about ftco-no-pt pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <div class="heading-section ftco-animate mx-auto">
                        <span class="subheading">Welcome to <?php echo $site_name; ?></span>
                        <h2 class="mb-4">Shaping Tomorrow's Creators Through Quality Education</h2>
                    </div>
                </div>
                
                <div class="content-block mb-5 ftco-animate">
                    <p class="lead text-center" style="font-size: 1.2rem; color: #555; max-width: 800px; margin: 0 auto 20px;">At <?php echo $site_name; ?>, we believe in empowering the next generation of Tanzania's digital creators, storytellers, and innovators.</p>
                    <p class="text-justify" style="color: #666; max-width: 900px; margin: 0 auto;">Founded to bridge the critical skills gap in East Africa's booming creative economy, we provide hands-on, industry-relevant training that transforms passion into profession. With state-of-the-art facilities, experienced experts, and a supportive learning environment, we create opportunities to explore, innovate, and excel in creativity.</p>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6 mb-4 ftco-animate">
                        <div class="card border-0 shadow-sm p-4 h-100" style="border-left: 4px solid var(--primary-color, #C7805C) !important;">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon mr-3" style="width: 50px; height: 50px; background: var(--primary-color, #C7805C); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span class="fa fa-bullseye fa-lg" style="color: white;"></span>
                                </div>
                                <div>
                                    <h4 class="mb-3" style="color: var(--primary-color, #C7805C);">Our Mission</h4>
                                    <p style="color: #555; line-height: 1.7;">To deliver accessible, practical, and high-quality digital media education that equips students with both technical expertise and creative thinking—enabling them to thrive as employees, entrepreneurs, and leaders in the digital age.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 ftco-animate">
                        <div class="card border-0 shadow-sm p-4 h-100" style="border-left: 4px solid var(--secondary-color, #90B3A7) !important;">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon mr-3" style="width: 50px; height: 50px; background: var(--secondary-color, #90B3A7); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span class="fa fa-eye fa-lg" style="color: white;"></span>
                                </div>
                                <div>
                                    <h4 class="mb-3" style="color: var(--secondary-color, #90B3A7);">Our Vision</h4>
                                    <p style="color: #555; line-height: 1.7;">To be the leading center of excellence for digital media and creative technology education in Tanzania and beyond, recognized for producing job-ready graduates who shape the future of media, design, and digital communication.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================
     STATISTICS SECTION
     ============================================ -->
<section class="ftco-section ftco-counter" id="section-counter" style="background-color: var(--primary-color, #C7805C);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center text-white">
                            <div class="text">
                                <strong class="number" data-number="15" style="font-size: 3rem; font-weight: 700;">0</strong>
                                <span style="font-size: 1rem; opacity: 0.9;">Programs Offered</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center text-white">
                            <div class="text">
                                <strong class="number" data-number="500" style="font-size: 3rem; font-weight: 700;">0</strong>
                                <span style="font-size: 1rem; opacity: 0.9;">Students Enrolled</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center text-white">
                            <div class="text">
                                <strong class="number" data-number="20" style="font-size: 3rem; font-weight: 700;">0</strong>
                                <span style="font-size: 1rem; opacity: 0.9;">Expert Instructors</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center text-white">
                            <div class="text">
                                <strong class="number" data-number="50" style="font-size: 3rem; font-weight: 700;">0</strong>
                                <span style="font-size: 1rem; opacity: 0.9;">Industry Partners</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================
     CORE VALUES SECTION - FROM SECTION FILE
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/core_values.php'; ?>


<!-- ============================================
     WHY CHOOSE US SECTION
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="text-center">
                    <div class="heading-section ftco-animate">
                        <span class="subheading">Why Choose Us</span>
                        <h2 class="mb-4" style="color: #333;">What Makes <?php echo $site_name; ?> Different</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color, #C7805C), var(--primary-dark, #A0654A)); border-radius: 50%;">
                        <span class="fa fa-user fa-2x" style="color: white;"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading mb-3" style="color: #333;">Expert Faculty</h3>
                        <p style="color: #666; line-height: 1.7;">Learn from industry professionals and experienced academics who bring real-world insights to the classroom.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--secondary-color, #90B3A7), #6B8E82); border-radius: 50%;">
                        <span class="fa fa-book fa-2x" style="color: white;"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading mb-3" style="color: #333;">Modern Curriculum</h3>
                        <p style="color: #666; line-height: 1.7;">Our programs are regularly updated to reflect industry trends and employer needs.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color, #C7805C), var(--primary-dark, #A0654A)); border-radius: 50%;">
                        <span class="fa fa-building fa-2x" style="color: white;"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading mb-3" style="color: #333;">Modern Facilities</h3>
                        <p style="color: #666; line-height: 1.7;">State-of-the-art labs, libraries, and learning spaces equipped with the latest technology.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--secondary-color, #90B3A7), #6B8E82); border-radius: 50%;">
                        <span class="fa fa-briefcase fa-2x" style="color: white;"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading mb-3" style="color: #333;">Career Support</h3>
                        <p style="color: #666; line-height: 1.7;">Comprehensive job placement assistance and career counseling services for all students.</p>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section>


<!-- ============================================
     REUSABLE SECTIONS: TIMELINE, ACCREDITATIONS, FAQ
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/about_timeline.php'; ?>

<?php include VIEWPATH . 'templates/college/sections/about_accreditations.php'; ?>

<?php include VIEWPATH . 'templates/college/sections/about_faq.php'; ?>


<!-- ============================================
     TEAM/LEADERSHIP SECTION
     ============================================ -->
<?php if (!empty($team_members)): ?>
<section class="ftco-section" style="background-color: white;">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Our Team</span>
                <h2 class="mb-4" style="color: #333;">Meet Our Leadership & Faculty</h2>
            </div>
        </div>
        <div class="row">
            <?php foreach ($team_members as $member): ?>
            <div class="col-md-3 col-sm-6 ftco-animate">
                <div class="team-card text-center p-3" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <?php 
                    $photo_url = '';
                    if (!empty($member->photo)) {
                        $photo_path = FCPATH . 'assets/images/faculty/' . $member->photo;
                        if (file_exists($photo_path)) {
                            $photo_url = base_url('assets/images/faculty/' . $member->photo);
                        }
                    }
                    if (empty($photo_url)) {
                        $photo_url = get_template_image('dmi_journey.jpg');
                    }
                    ?>
                    <div class="team-photo mb-3" style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; overflow: hidden; border: 4px solid var(--primary-color, #C7805C);">
                        <img src="<?php echo $photo_url; ?>" alt="<?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h5 style="color: #333; margin-bottom: 5px; font-weight: 600;"><?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?></h5>
                    <?php if (!empty($member->title)): ?>
                    <p class="team-title" style="color: var(--primary-color, #C7805C); font-size: 0.9rem; margin-bottom: 5px;"><?php echo htmlspecialchars($member->title); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($member->department_name)): ?>
                    <p class="team-dept" style="color: #888; font-size: 0.8rem;"><?php echo htmlspecialchars($member->department_name); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($member->email)): ?>
                    <a href="mailto:<?php echo htmlspecialchars($member->email); ?>" style="color: var(--secondary-color, #90B3A7); font-size: 0.85rem; text-decoration: none;">
                        <i class="fa fa-envelope" style="margin-right: 5px;"></i><?php echo htmlspecialchars($member->email); ?>
                    </a>
                    <?php endif; ?>
                    <div class="mt-3">
                        <a href="<?php echo base_url('faculty/view/' . $member->slug); ?>" class="btn btn-sm" style="background: var(--primary-color, #C7805C); color: white; border-radius: 20px; padding: 5px 15px;">View Profile</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row justify-content-center mt-5">
            <a href="<?php echo base_url('faculty'); ?>" class="btn btn-outline-primary px-5" style="border-radius: 25px;">View All Team Members</a>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ============================================
     TESTIMONIALS SECTION - DYNAMIC FROM DATABASE
     ============================================ -->
<?php if (!empty($testimonials)): ?>
<section class="ftco-section testimony-section" style="background-color: #faf8f6;">
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


<!-- ============================================
     CONTACT INFO SECTION
     ============================================ -->
<section class="ftco-section" style="background: white;">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Get In Touch</span>
                <h2 class="mb-4" style="color: #333;">Contact Information</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center p-4" style="background: #faf8f6; border-radius: 12px;">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: var(--primary-color, #C7805C); border-radius: 50%; margin: 0 auto;">
                        <span class="fa fa-map-marker fa-lg" style="color: white;"></span>
                    </div>
                    <div class="text">
                        <p class="mb-1" style="font-weight: 600; color: #333;">Address</p>
                        <p style="color: #666;"><?php echo isset($physical_address) ? htmlspecialchars($physical_address) : 'Campus Address Here'; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center p-4" style="background: #faf8f6; border-radius: 12px;">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: var(--secondary-color, #90B3A7); border-radius: 50%; margin: 0 auto;">
                        <span class="fa fa-phone fa-lg" style="color: white;"></span>
                    </div>
                    <div class="text">
                        <p class="mb-1" style="font-weight: 600; color: #333;">Phone</p>
                        <p><a href="tel:<?php echo isset($phone_number) ? $phone_number : ''; ?>" style="color: var(--primary-color, #C7805C); text-decoration: none;"><?php echo isset($phone_number) ? htmlspecialchars($phone_number) : 'Phone Number Here'; ?></a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center p-4" style="background: #faf8f6; border-radius: 12px;">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: var(--primary-color, #C7805C); border-radius: 50%; margin: 0 auto;">
                        <span class="fa fa-envelope fa-lg" style="color: white;"></span>
                    </div>
                    <div class="text">
                        <p class="mb-1" style="font-weight: 600; color: #333;">Email</p>
                        <p><a href="mailto:<?php echo isset($email_address) ? $email_address : ''; ?>" style="color: var(--primary-color, #C7805C); text-decoration: none;"><?php echo isset($email_address) ? htmlspecialchars($email_address) : 'email@example.com'; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================
     FINAL CTA SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>


<!-- ============================================
     PAGE SCRIPTS
     ============================================ -->
<script>
// Global FAQ toggle function
function toggleFaq(element) {
    const answer = element.nextElementSibling;
    const chevron = element.querySelector('.fa-chevron-down');
    const parent = element.closest('.faq-list');
    
    // Close all other answers in this category
    parent.querySelectorAll('.faq-answer').forEach(a => {
        if (a !== answer) {
            a.style.display = 'none';
        }
    });
    parent.querySelectorAll('.fa-chevron-down').forEach(c => {
        if (c !== chevron) {
            c.style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle current answer
    if (answer.style.display === 'none' || answer.style.display === '') {
        answer.style.display = 'block';
        if (chevron) {
            chevron.style.transform = 'rotate(180deg)';
        }
    } else {
        answer.style.display = 'none';
        if (chevron) {
            chevron.style.transform = 'rotate(0deg)';
        }
    }
}

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
    if (typeof jQuery !== 'undefined' && jQuery.fn.owlCarousel) {
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
});
</script>
