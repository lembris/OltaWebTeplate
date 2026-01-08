<?php
/**
 * College Template - About Page
 * 
 * About us page with hero section, intro, counters, testimonials,
 * why choose us, and call-to-action sections.
 * 
 * Based on StudyLab design pattern.
 */
?>

<!-- Schema.org Structured Data - AboutPage -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "About <?php echo $site_name; ?>",
    "description": "Learn about our institution, our mission, values, and commitment to quality education.",
    "url": "<?php echo current_url(); ?>",
    "mainEntity": {
        "@type": "EducationalOrganization",
        "name": "<?php echo $site_name; ?>",
        "telephone": "<?php echo isset($phone_number) ? $phone_number : ''; ?>",
        "email": "<?php echo isset($email_address) ? $email_address : ''; ?>",
        "address": "<?php echo isset($physical_address) ? $physical_address : ''; ?>"
    }
}
</script>


<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>


<!-- ============================================
     ABOUT INTRO SECTION - NEW CENTERED LAYOUT
     ============================================ -->
<section class="ftco-section ftco-about ftco-no-pt pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <div class="heading-section ftco-animate mx-auto">
                        <span class="subheading">Welcome to <?php echo $site_name; ?></span>
                        <h2 class="mb-4">Shaping Tomorrow's Creators Through Quality Education</h2>
                    </div>
                </div>
                
                <div class="content-block mb-5 ftco-animate">
                    <p class="lead text-justify">At <?php echo $site_name; ?>, we believe in empowering the next generation of Tanzania's digital creators, storytellers, and innovators.</p>
                    <p class="text-justify">Founded to bridge the critical skills gap in East Africa's booming creative economy, we provide hands-on, industry-relevant training that transforms passion into profession.</p>
                    <p class="text-justify">With state-of-the-art facilities, experienced experts, and a supportive learning environment, we create opportunities to explore, innovate, and excel in creativity.</p>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6 mb-4 ftco-animate">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon icon-primary mr-3">
                                    <span class="flaticon-graduation-cap fa-2x text-primary"></span>
                                </div>
                                <div>
                                    <h4 class="mb-3">Our Mission</h4>
                                    <p>To deliver accessible, practical, and high-quality digital media education that equips students with both technical expertise and creative thinking—enabling them to thrive as employees, entrepreneurs, and leaders in the digital age.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 ftco-animate">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon icon-primary mr-3">
                                    <span class="flaticon-telescope fa-2x text-primary"></span>
                                </div>
                                <div>
                                    <h4 class="mb-3">Our Vision</h4>
                                    <p>To be the leading center of excellence for digital media and creative technology education in Tanzania and beyond, recognized for producing job-ready graduates who shape the future of media, design, and digital communication.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistical facts -->
<?php include VIEWPATH . 'templates/college/sections/statistical_facts.php'; ?>


<!-- Core Values Section -->
<?php include VIEWPATH . 'templates/college/sections/core_values.php'; ?>



<!-- ============================================
     WHY CHOOSE US SECTION
     ============================================ -->
<section class="section ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="text-center">
                    <div class="heading-section ftco-animate">
                        <span class="subheading">Why Choose Us</span>
                        <h2 class="mb-4">What Makes <?php echo $site_name; ?> Different</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: #667eea; border-radius: 50%; margin: 0 auto;"><span class="fa fa-user fa-2x" style="color: white;"></span></div>
                    <div class="media-body text-center">
                        <h3 class="heading mb-3">Expert Faculty</h3>
                        <p>Learn from industry professionals and experienced academics who bring real-world insights to the classroom.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: #667eea; border-radius: 50%; margin: 0 auto;"><span class="fa fa-book fa-2x" style="color: white;"></span></div>
                    <div class="media-body text-center">
                        <h3 class="heading mb-3">Modern Curriculum</h3>
                        <p>Our programs are regularly updated to reflect industry trends and employer needs.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: #667eea; border-radius: 50%; margin: 0 auto;"><span class="fa fa-building fa-2x" style="color: white;"></span></div>
                    <div class="media-body text-center">
                        <h3 class="heading mb-3">Modern Facilities</h3>
                        <p>State-of-the-art labs, libraries, and learning spaces equipped with the latest technology.</p>
                    </div>
                </div>      
            </div>
            <div class="col-md-6 mb-4 ftco-animate">
                <div class="services p-4">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: #667eea; border-radius: 50%; margin: 0 auto;"><span class="fa fa-briefcase fa-2x" style="color: white;"></span></div>
                    <div class="media-body text-center">
                        <h3 class="heading mb-3">Career Support</h3>
                        <p>Comprehensive job placement assistance and career counseling services for all students.</p>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
 <?php include VIEWPATH.'templates/college/sections/testimonials.php'; ?>


<!-- ============================================
     CONTACT INFO SECTION
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Get In Touch</span>
                <h2 class="mb-4">Contact Information</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-map-marker"></span>
                    </div>
                    <div class="text">
                        <p><span>Address:</span> <?php echo isset($physical_address) ? $physical_address : 'Campus Address Here'; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-phone"></span>
                    </div>
                    <div class="text">
                        <p><span>Phone:</span> <a href="tel:<?php echo isset($phone_number) ? $phone_number : ''; ?>"><?php echo isset($phone_number) ? $phone_number : 'Phone Number Here'; ?></a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="dbox w-100 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-envelope"></span>
                    </div>
                    <div class="text">
                        <p><span>Email:</span> <a href="mailto:<?php echo isset($email_address) ? $email_address : ''; ?>"><?php echo isset($email_address) ? $email_address : 'email@example.com'; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Gallery section -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

