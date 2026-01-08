<?php
/**
 * College Template - Enquiry/Application Page
 * 
 * Application form for prospective students with contact info sidebar.
 * Based on StudyLab design pattern.
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- ============================================
     ENQUIRY SECTION - Form & Sidebar
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content - Enquiry Form -->
            <div class="col-lg-8 ftco-animate">
                <div class="p-4 p-md-5 bg-light">
                    <h3 class="mb-4">Student Application Form</h3>
                    <p class="text-muted mb-4">Take the first step towards your future. Fill out the form below and our admissions team will get back to you shortly.</p>
                    
                    <?php if(isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success_message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo base_url('enquiry/submit'); ?>" method="POST" id="enquiryForm" class="enquiry-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Full Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="+255 XXX XXX XXX" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="program">Program of Interest <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program" required>
                                        <option value="">Select a Program</option>
                                        <?php if(!empty($programs)): ?>
                                            <?php foreach($programs as $program): ?>
                                                <option value="<?php echo htmlspecialchars($program->id ?? $program->code ?? ''); ?>">
                                                    <?php echo htmlspecialchars($program->name ?? $program->title ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="certificate">Certificate Programs</option>
                                            <option value="diploma">Diploma Programs</option>
                                            <option value="degree">Degree Programs</option>
                                            <option value="masters">Masters Programs</option>
                                            <option value="other">Other / Not Sure</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Additional Information</label>
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="5" placeholder="Tell us about your educational background, interests, or any questions you have..."></textarea>
                                </div>
                            </div>
                            
                            <!-- Honeypot field for spam protection -->
                            <div class="col-md-12" style="display: none;" aria-hidden="true">
                                <div class="form-group">
                                    <label for="website_url">Website</label>
                                    <input type="text" class="form-control" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary py-3 px-5">
                                        <span class="fa fa-paper-plane mr-2"></span> Submit Application
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Contact Info Box -->
                <div class="sidebar-box bg-primary text-white p-4 mb-4">
                    <h3 class="heading-sidebar text-white">Contact Information</h3>
                    <div class="dbox w-100 d-flex align-items-start mb-3">
                        <div class="icon d-flex align-items-center justify-content-center mr-3">
                            <span class="fa fa-map-marker text-white"></span>
                        </div>
                        <div class="text">
                            <p class="mb-0 text-white-50"><?php echo isset($physical_address) ? $physical_address : 'Campus Address'; ?></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start mb-3">
                        <div class="icon d-flex align-items-center justify-content-center mr-3">
                            <span class="fa fa-phone text-white"></span>
                        </div>
                        <div class="text">
                            <p class="mb-0"><a href="tel:<?php echo isset($phone_number) ? preg_replace('/[^0-9+]/', '', $phone_number) : ''; ?>" class="text-white-50"><?php echo isset($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></a></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start mb-3">
                        <div class="icon d-flex align-items-center justify-content-center mr-3">
                            <span class="fa fa-envelope text-white"></span>
                        </div>
                        <div class="text">
                            <p class="mb-0"><a href="mailto:<?php echo isset($email_address) ? $email_address : 'admissions@example.com'; ?>" class="text-white-50"><?php echo isset($email_address) ? $email_address : 'admissions@example.com'; ?></a></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start">
                        <div class="icon d-flex align-items-center justify-content-center mr-3">
                            <span class="fa fa-clock-o text-white"></span>
                        </div>
                        <div class="text">
                            <p class="mb-0 text-white-50">Mon - Fri: 8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Facts Box -->
                <div class="sidebar-box bg-light p-4 mb-4">
                    <h3 class="heading-sidebar">Quick Facts</h3>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-3">
                            <span class="icon d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-graduation-cap"></i>
                            </span>
                            <span><?php echo isset($programs_count) ? $programs_count : '50+'; ?> Programs Available</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <span class="icon d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-users"></i>
                            </span>
                            <span><?php echo isset($students_count) ? $students_count : '5000+'; ?> Students Enrolled</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <span class="icon d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-trophy"></i>
                            </span>
                            <span><?php echo isset($years_experience) ? $years_experience : '25+'; ?> Years of Excellence</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="icon d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-briefcase"></i>
                            </span>
                            <span><?php echo isset($employment_rate) ? $employment_rate : '95%'; ?> Employment Rate</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Need Help Box -->
                <div class="sidebar-box bg-secondary text-white p-4">
                    <h3 class="heading-sidebar text-white">Need Help?</h3>
                    <p class="text-white-50">Our admissions team is here to guide you through the application process.</p>
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-light btn-block">
                        <span class="fa fa-comments mr-2"></span> Contact Admissions
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     CTA SECTION
     ============================================ -->
<section class="ftco-section ftco-intro" style="background-image: url('<?php echo get_template_image('bg_2.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center ftco-animate">
                <h2>Have Questions About Our Programs?</h2>
                <p>Explore our wide range of programs designed to prepare you for success in your chosen field.</p>
                <p class="mb-0">
                    <a href="<?php echo base_url('programs'); ?>" class="btn btn-primary px-4 py-3 mr-md-2">View Programs</a>
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-secondary px-4 py-3">Contact Us</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Enquiry Page Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var enquiryForm = document.getElementById('enquiryForm');
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', function(e) {
            var honeypot = document.getElementById('website_url');
            if (honeypot && honeypot.value !== '') {
                e.preventDefault();
                return false;
            }
            
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var phone = document.getElementById('phone').value.trim();
            var program = document.getElementById('program').value;
            
            if (!name || !email || !phone || !program) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return false;
            }
            
            var phoneRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
            if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
                e.preventDefault();
                alert('Please enter a valid phone number.');
                return false;
            }
        });
    }
});
</script>
