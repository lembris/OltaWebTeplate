<?php
/**
 * College Template - Homepage v2.0 (DYNAMIC)
 * 
 * Fully dynamic layout pulling content from database
 * - Programs from academic_programs table
 * - Departments from departments table  
 * - Faculty from faculty_staff table
 * - Gallery images from gallery table
 * - Blog posts from blog table
 * - Theme colors from site_settings table
 * 
 * Features:
 * - Full-height hero with registration form
 * - Dynamic program categories
 * - Featured programs from database
 * - Department listings
 * - Faculty highlights
 * - Gallery showcase
 * - Latest news/blog posts
 * - Dynamic theme colors
 * 
 * Version: 2.0 - Dynamic Edition
 * Last Updated: January 2026
 */
?>

<!-- Schema.org Structured Data - EducationalOrganization -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "<?php echo $site_name; ?>",
    "description": "Quality education institution offering diverse programs and courses.",
    "url": "<?php echo base_url(); ?>",
    "logo": "<?php echo base_url('assets/img/logo.png'); ?>",
    "telephone": "<?php echo isset($phone_number) ? $phone_number : ''; ?>",
    "email": "<?php echo isset($site_email) ? $site_email : ''; ?>"
}
</script>

<!-- ============================================
     HERO SECTION - Full Height with Registration
     ============================================ -->
<style>
.hero-wrap {
    min-height: 750px !important;
    height: auto !important;
    position: relative;
    background-size: cover;
    background-position: center;
}
.hero-wrap.js-fullheight {
    min-height: 750px !important;
    display: flex;
    align-items: center;
}
.slider-text {
    position: relative;
    z-index: 2;
}
.slider-text .subheading {
    font-size: 18px;
    font-weight: 600;
    color: #667eea;
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 15px;
}
.slider-text h1 {
    font-size: 48px;
    font-weight: 700;
    color: white;
    line-height: 1.3;
    margin-bottom: 25px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}
.slider-text .caps {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.95);
    line-height: 1.6;
    margin-bottom: 30px;
    max-width: 600px;
    font-weight: 300;
}
.slider-text .btn {
    margin-right: 15px;
    margin-bottom: 15px;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.slider-text .btn-primary {
    background: #667eea;
    border: 2px solid #667eea;
}
.slider-text .btn-primary:hover {
    background: transparent;
    color: #667eea;
}
.slider-text .btn-white {
    background: white;
    color: #333;
    border: 2px solid white;
}
.slider-text .btn-white:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}
.hero-registration-form {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    padding: 20px 0 30px;
    margin: 0;
    z-index: 10;
}
@media (max-width: 768px) {
    .hero-wrap, .hero-wrap.js-fullheight {
        min-height: 600px !important;
    }
    .slider-text h1 {
        font-size: 32px;
    }
    .slider-text .caps {
        font-size: 16px;
    }
    .hero-registration-form {
        position: static;
        padding: 20px 0;
    }
}
</style>
<section class="hero-wrap js-fullheight" style="background-image: url('<?php echo get_template_image('dmi_home_1.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container pt-5 pb-5">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-lg-8 col-md-10 ftco-animate text-center">
                <span class="subheading">Welcome to <?php echo $site_name; ?></span>
                <h1 class="mb-4">Excel in the Digital World</h1>
                <p class="caps">Don't just navigate the future. Create it. Transform your passion for media into a powerful career with hands-on training from industry leaders.</p>
                <p class="mb-0">
                    <a href="<?php echo base_url('programs'); ?>" class="btn btn-primary">Explore Programs</a> 
                    <a href="<?php echo base_url('about'); ?>" class="btn btn-white">Learn More</a>
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-outline-light">Get in Touch</a>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Floating Registration Form - Commented out temporarily
    <div class="hero-registration-form">
        <div class="container">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <div class="login-wrap p-md-5" style="background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin-right: 15px;">
                        <h3 class="mb-4" style="color: #333;">Apply Now</h3>
                        <form action="<?php echo base_url('enquiry/submit_floating_form'); ?>" method="POST" class="signup-form" id="homeApplicationForm">
                            <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                            <div class="form-group">
                                <label class="label" for="name" style="color: #555;">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label class="label" for="email" style="color: #555;">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                            </div>
                            <div class="form-group">
                                <label class="label" for="phone" style="color: #555;">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+255 XXX XXX XXX">
                            </div>
                            <div class="form-group">
                                <label class="label" for="program_interest" style="color: #555;">Program of Interest</label>
                                <select name="program_interest" class="form-control">
                                    <option value="">Select Program</option>
                                    <?php if(!empty($programs)): ?>
                                        <?php foreach($programs as $prog): ?>
                                            <?php 
                                                $prog_code = is_object($prog) ? $prog->code : ($prog['code'] ?? '');
                                                $prog_name = is_object($prog) ? $prog->name : ($prog['name'] ?? '');
                                            ?>
                                            <option value="<?php echo $prog_code; ?>"><?php echo $prog_name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label" for="message" style="color: #555;">Message (Optional)</label>
                                <textarea name="message" class="form-control" rows="2" placeholder="Tell us more about yourself..."></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary submit" style="background: #667eea; border: none; padding: 10px 25px;">
                                    <span class="fa fa-paper-plane"></span> Submit
                                </button>
                            </div>
                        </form>
                        <div id="applicationMessage" style="margin-top: 10px; display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</section>

<!-- ============================================
     ANNOUNCEMENTS BANNER - Alert Bar
     ============================================ -->
<?php if(empty($homepage_announcements)): ?>
<section class="section py-3" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%); border-bottom: 3px solid #ffc107;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-1 text-center">
                <span class="fa fa-bullhorn fa-2x" style="color: #ff6b6b;"></span>
            </div>
            <div class="col-md-11">
                <div class="announcement-carousel">
                    <?php foreach($homepage_announcements as $announcement): ?>
                    <?php 
                        $ann_slug = is_object($announcement) ? $announcement->slug : ($announcement['slug'] ?? '');
                        $ann_title = is_object($announcement) ? $announcement->title : ($announcement['title'] ?? '');
                        $ann_content = is_object($announcement) ? $announcement->content : ($announcement['content'] ?? '');
                    ?>
                    <div class="announcement-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1" style="color: #333;">
                                <a href="<?php echo base_url('announcements/' . $ann_slug); ?>" style="color: #333; text-decoration: none;">
                                    <?php echo $ann_title; ?>
                                </a>
                            </h5>
                            <p class="mb-0 small" style="color: #555;">
                                <?php echo word_limiter(strip_tags($ann_content), 20); ?>
                            </p>
                        </div>
                        <a href="<?php echo base_url('announcements/' . $ann_slug); ?>" class="btn btn-sm btn-primary ml-3">Read More</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ============================================
     EVENTS & NOTICES - Combined Section
     ============================================ -->
<?php if(!empty($upcoming_events) || !empty($latest_notices)): ?>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <!-- Events Column -->
            <?php if(!empty($upcoming_events)): ?>
            <div class="col-md-6">
                <div class="heading-section">
                    <span class="subheading">Campus Activity</span>
                    <h3 class="mb-3"><span class="fa fa-calendar mr-2" style="color: var(--theme-primary);"></span>Upcoming Events</h3>
                </div>
                <div class="events-list">
                    <?php foreach(array_slice($upcoming_events, 0, 4) as $event): ?>
                    <?php 
                        $event_id = is_object($event) ? $event->id : ($event['id'] ?? '');
                        $event_uid = is_object($event) ? $event->uid : ($event['uid'] ?? '');
                        $event_title = is_object($event) ? $event->title : ($event['title'] ?? '');
                        $event_date = is_object($event) ? $event->start_date : ($event['start_date'] ?? '');
                        $event_time = is_object($event) ? ($event->start_time ?? '') : ($event['start_time'] ?? '');
                        $event_location = is_object($event) ? ($event->location ?? '') : ($event['location'] ?? '');
                        $event_desc = is_object($event) ? ($event->description ?? '') : ($event['description'] ?? '');
                    ?>
                    <div class="event-card p-3 mb-3" style="background: white; border-left: 4px solid var(--theme-primary); border-radius: 4px; transition: all 0.3s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex: 1;">
                                <h5 class="mb-2">
                                    <a href="<?php echo base_url('events/' . $event_uid); ?>" style="text-decoration: none; color: #333;">
                                        <?php echo $event_title; ?>
                                    </a>
                                </h5>
                                <div class="meta-info small text-muted mb-2">
                                    <span class="fa fa-calendar mr-2"></span><?php echo date('M d, Y', strtotime($event_date)); ?>
                                    <?php if(!empty($event_time)): ?>
                                        <span class="mx-2">|</span>
                                        <span class="fa fa-clock-o mr-2"></span><?php echo $event_time; ?>
                                    <?php endif; ?>
                                </div>
                                <?php if(!empty($event_location)): ?>
                                <div class="small text-muted mb-2">
                                    <span class="fa fa-map-marker mr-2"></span><?php echo $event_location; ?>
                                </div>
                                <?php endif; ?>
                                <p class="small mb-0"><?php echo word_limiter(strip_tags($event_desc), 15); ?></p>
                            </div>
                            <a href="<?php echo base_url('events/' . $event_uid); ?>" class="btn btn-sm btn-outline-primary ml-2" style="white-space: nowrap;">Details</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-primary">View All Events</a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Notices Column -->
            <?php if(!empty($latest_notices)): ?>
            <div class="col-md-6 mb-4">
                <div class="heading-section mb-4">
                    <span class="subheading">Stay Informed</span>
                    <h3 class="mb-3"><span class="fa fa-newspaper-o mr-2" style="color: var(--theme-primary, #C7805C);"></span>Latest Notices</h3>
                </div>
                <div class="notices-list">
                    <?php foreach(array_slice($latest_notices, 0, 4) as $notice): ?>
                    <?php 
                        $notice_slug = is_object($notice) ? $notice->slug : ($notice['slug'] ?? '');
                        $notice_title = is_object($notice) ? $notice->title : ($notice['title'] ?? '');
                        $notice_content = is_object($notice) ? $notice->content : ($notice['content'] ?? '');
                        $notice_date = is_object($notice) ? $notice->created_at : ($notice['created_at'] ?? '');
                        $notice_category = is_object($notice) ? ($notice->category ?? '') : ($notice['category'] ?? '');
                        $notice_priority = is_object($notice) ? ($notice->priority ?? 1) : ($notice['priority'] ?? 1);
                    ?>
                    <div class="notice-card p-3 mb-3" style="background: white; border-left: 4px solid <?php echo ($notice_priority > 2) ? '#ff6b6b' : 'var(--primary, #5c6bc0)'; ?>; border-radius: 4px; transition: all 0.3s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex: 1;">
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="mb-0">
                                        <a href="<?php echo base_url('notices/' . $notice_slug); ?>" style="text-decoration: none; color: #333;">
                                            <?php echo $notice_title; ?>
                                        </a>
                                    </h5>
                                    <?php if(!empty($notice_category)): ?>
                                    <span class="badge badge-info ml-2"><?php echo $notice_category; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="small text-muted mb-2">
                                    <span class="fa fa-clock-o mr-2"></span><?php echo date('M d, Y', strtotime($notice_date)); ?>
                                </div>
                                <p class="small mb-0"><?php echo word_limiter(strip_tags($notice_content), 15); ?></p>
                            </div>
                            <a href="<?php echo base_url('notices/' . $notice_slug); ?>" class="btn btn-sm btn-outline-primary ml-2" style="white-space: nowrap;">Read</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?php echo base_url('notices'); ?>" class="btn btn-outline-primary">View All Notices</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>



<!-- STUDENT WORK SHOWCASE -->
<?php include VIEWPATH . 'templates/college/sections/student_work.php'; ?>

<!-- Featured Programs section -->
<?php include VIEWPATH . 'templates/college/sections/featured_programs.php'; ?>


<!-- Department Faculty section -->
<!-- <php include VIEWPATH . 'templates/college/sections/department_faculty.php'; ?> -->

<!-- ============================================
     EQUIPMENT & FACILITIES SECTION
     ============================================ -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Professional-Grade Facilities</span>
                <h2 class="mb-4">Industry-Standard Equipment</h2>
                <p class="lead mb-5">Train with the same tools used by professionals in the industry</p>
            </div>
        </div>
        
        <div class="row">
            <!-- Studio Facilities -->
            <div class="col-md-6 mb-4">
                <div class="facility-card p-4 h-100" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-round mr-3" style="background: var(--theme-primary); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="fa fa-video-camera fa-2x text-white"></span>
                        </div>
                        <h4 class="mb-0">Film & Production Studio</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>4K Cinema Cameras (Sony FX6, Blackmagic)</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Professional Lighting Kits (Aputure)</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Sound Recording Studio with Boom Mics</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Green Screen & Chroma Key Setup</li>
                        <li><span class="fa fa-check text-success mr-2"></span>Live Streaming Equipment</li>
                    </ul>
                </div>
            </div>
            
            <!-- Editing Labs -->
            <div class="col-md-6 mb-4">
                <div class="facility-card p-4 h-100" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-round mr-3" style="background: var(--theme-secondary); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="fa fa-desktop fa-2x text-white"></span>
                        </div>
                        <h4 class="mb-0">Editing & Design Labs</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>High-Spec iMac & PC Workstations</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Full Adobe Creative Suite (Photoshop, Premiere, After Effects)</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>DaVinci Resolve Editing Consoles</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Wacom Tablets for Digital Art</li>
                        <li><span class="fa fa-check text-success mr-2"></span>3D Animation Software (Blender, Maya)</li>
                    </ul>
                </div>
            </div>
            
            <!-- Photography Studio -->
            <div class="col-md-6 mb-4">
                <div class="facility-card p-4 h-100" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-round mr-3" style="background: var(--accent-color); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="fa fa-camera fa-2x text-white"></span>
                        </div>
                        <h4 class="mb-0">Photography Studio</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Professional DSLR & Mirrorless Cameras</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Studio Lighting with Softboxes & Reflectors</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Portrait & Product Photography Setup</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Drone for Aerial Photography</li>
                        <li><span class="fa fa-check text-success mr-2"></span>Photo Printing & Editing Station</li>
                    </ul>
                </div>
            </div>
            
            <!-- Audio & Podcasting -->
            <div class="col-md-6 mb-4">
                <div class="facility-card p-4 h-100" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-round mr-3" style="background: #6c5ce7; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="fa fa-microphone fa-2x text-white"></span>
                        </div>
                        <h4 class="mb-0">Audio & Podcast Studio</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Soundproof Recording Booth</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Professional Condenser Microphones</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Audio Mixing Console & Software</li>
                        <li class="mb-2"><span class="fa fa-check text-success mr-2"></span>Podcast Recording Setup</li>
                        <li><span class="fa fa-check text-success mr-2"></span>Sound Effects & Music Library</li>
                    </ul>
                </div>
            </div>
        </div>        
    </div>
</section>


<!-- ============================================
     FEATURED FACULTY - Dynamic Section
     ============================================ -->
<?php if(!empty($featured_faculty)): ?>
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Meet Our Experts</span>
                    <h2 class="mb-4">Distinguished Faculty Members</h2>
                </div>
            </div>
            <div class="row">
                <?php foreach($featured_faculty as $faculty): ?>
                <?php 
                    // Handle faculty data (both object and array)
                    // Note: faculty_staff table uses first_name, last_name, photo (not name, image)
                    $faculty_id = is_object($faculty) ? $faculty->id : ($faculty['id'] ?? '');
                    $faculty_first = is_object($faculty) ? $faculty->first_name : ($faculty['first_name'] ?? '');
                    $faculty_last = is_object($faculty) ? $faculty->last_name : ($faculty['last_name'] ?? '');
                    $faculty_name = $faculty_first . ' ' . $faculty_last;
                    $faculty_title = is_object($faculty) ? ($faculty->title ?? 'Instructor') : ($faculty['title'] ?? 'Instructor');
                    $faculty_image = is_object($faculty) ? ($faculty->photo ?? '') : ($faculty['photo'] ?? '');
                    $faculty_bio = is_object($faculty) ? ($faculty->bio ?? '') : ($faculty['bio'] ?? '');
                    $faculty_department = is_object($faculty) ? ($faculty->department_name ?? '') : ($faculty['department_name'] ?? '');
                ?>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staffcard">
                        <div class="img img-3" style="background-image: url(<?php echo !empty($faculty_image) ? base_url($faculty_image) : base_url('assets/images/placeholder-avatar.png'); ?>);"></div>
                        <div class="stafftext p-3 text-center">
                            <h3><?php echo trim($faculty_name); ?></h3>
                            <p class="staff-position"><?php echo $faculty_title; ?></p>
                            <p class="text-muted"><?php echo $faculty_department; ?></p>
                            <p class="text-sm"><?php echo word_limiter(strip_tags($faculty_bio), 15, '...'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>



<!-- Gallery section -->
<?php include VIEWPATH . 'templates/college/sections/gallery.php'; ?>


<!-- ============================================
     ADMISSIONS & ENROLMENT SECTION
     ============================================ -->
<section class="section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 pr-md-4 ftco-animate">
                <h2 class="mb-4">Ready to Start Your Journey?</h2>
                <p class="lead">Join thousands of students who have transformed their careers through our quality education programs.</p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-3">
                        <span class="fa fa-check mr-2"></span>
                        <strong>Simple Application Process</strong> - Complete your application online in minutes
                    </li>
                    <li class="mb-3">
                        <span class="fa fa-check mr-2"></span>
                        <strong>Flexible Admission Dates</strong> - Multiple intake periods throughout the year
                    </li>
                    <li class="mb-3">
                        <span class="fa fa-check mr-2"></span>
                        <strong>Financial Support Available</strong> - Scholarships and payment plans
                    </li>
                    <li class="mb-3">
                        <span class="fa fa-check mr-2"></span>
                        <strong>Personal Guidance</strong> - Admissions counselors to assist you
                    </li>
                </ul>
                <p class="mt-4">
                    <a href="<?php echo base_url('enquiry'); ?>" class="btn btn-primary px-4">Start Your Application</a>
                    <a href="<?php echo base_url('about'); ?>" class="btn btn-outline-secondary px-4 ml-2">Learn More</a>
                </p>
            </div>
            <div class="col-md-6 ftco-animate">
                <img src="<?php echo get_template_image('dmi_journey.jpg'); ?>" alt="Student Success" class="img-fluid" style="border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     STATISTICS SECTION
     ============================================ -->


<!-- ============================================
     LATEST NEWS/UPDATES SECTION - Dynamic
     ============================================ -->
<?php if(!empty($latest_blogs)): ?>
<section class="section bg-light">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Campus News & Events</span>
                <h2 class="mb-4">Latest Updates</h2>
            </div>
        </div>
        <div class="row d-flex">
            <?php foreach($latest_blogs as $blog): ?>
            <?php
                // Handle both object and array data
                $blog_slug = is_object($blog) ? $blog->slug : ($blog['slug'] ?? '');
                $blog_image = is_object($blog) ? ($blog->featured_image ?? $blog->image ?? '') : ($blog['featured_image'] ?? $blog['image'] ?? '');
                $blog_title = is_object($blog) ? $blog->title : ($blog['title'] ?? '');
                $blog_content = is_object($blog) ? $blog->content : ($blog['content'] ?? '');
                $blog_author = is_object($blog) ? ($blog->author ?? 'Admin') : ($blog['author'] ?? 'Admin');
                $blog_date = is_object($blog) ? $blog->created_at : ($blog['created_at'] ?? date('Y-m-d'));
            ?>
            <div class="col-lg-4 ftco-animate">
                <div class="blog-entry">
                    <a href="<?php echo base_url('blog/' . $blog_slug); ?>" class="block-20" style="background-image: url('<?php echo base_url($blog_image); ?>');"></a>
                    <div class="text d-block">
                        <div class="meta">
                            <p>
                                <a href="#"><span class="fa fa-calendar mr-2"></span><?php echo date('M d, Y', strtotime($blog_date)); ?></a>
                                <a href="#"><span class="fa fa-user mr-2"></span><?php echo $blog_author; ?></a>
                            </p>
                        </div>
                        <h3 class="heading"><a href="<?php echo base_url('blog/' . $blog_slug); ?>"><?php echo $blog_title; ?></a></h3>
                        <p><?php echo word_limiter(strip_tags($blog_content), 20); ?></p>
                        <p><a href="<?php echo base_url('blog/' . $blog_slug); ?>" class="btn btn-secondary py-2 px-3">Read more</a></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="<?php echo base_url('blog'); ?>" class="btn btn-primary">View All News</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Partners section -->
<?php include VIEWPATH . 'templates/college/sections/partners.php'; ?>

<!-- Gallery section -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>
   

<!-- College Homepage Scripts -->
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

        // Home Application Form Handler
        const appForm = document.getElementById('homeApplicationForm');
        console.log('Form found:', appForm ? 'YES' : 'NO');
        
        if (appForm) {
            appForm.addEventListener('submit', function(e) {
                console.log('Form submit event triggered');
                e.preventDefault();
                
                const formData = new FormData(this);
                const messageDiv = document.getElementById('applicationMessage');
                const submitBtn = this.querySelector('button[type="submit"]');
                
                // Log form data for debugging
                console.log('Form Data:', Object.fromEntries(formData));
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="fa fa-spinner fa-spin"></span> Processing...';
                
                const submitUrl = '<?php echo base_url('enquiry/submit_floating_form'); ?>';
                console.log('Submitting to:', submitUrl);
                
                fetch(submitUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    messageDiv.style.display = 'block';
                    if (data.success) {
                        messageDiv.innerHTML = '<div class="alert alert-success" role="alert">Thank you! Your application has been submitted successfully. We will contact you shortly.</div>';
                        appForm.reset();
                    } else {
                        messageDiv.innerHTML = '<div class="alert alert-warning" role="alert">' + (data.message || 'Application submitted. Please check your email for confirmation.') + '</div>';
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="fa fa-paper-plane"></span> Submit Application';
                    
                    // Hide message after 5 seconds
                    setTimeout(() => {
                        messageDiv.style.display = 'none';
                    }, 5000);
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    messageDiv.style.display = 'block';
                    messageDiv.innerHTML = '<div class="alert alert-danger" role="alert">Error: ' + error.message + '</div>';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="fa fa-paper-plane"></span> Submit Application';
                    
                    setTimeout(() => {
                        messageDiv.style.display = 'none';
                    }, 5000);
                });
            });
        }
    });
</script>
