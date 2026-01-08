<?php
/**
 * College Template - Contact Page
 * 
 * Contact form with information sidebar and map section.
 * Based on StudyLab design pattern.
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- ============================================
     CONTACT INFO CARDS
     ============================================ -->
<section class="ftco-section contact-info-section" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 60px 0;">
    <div class="container">
        <div class="row d-flex contact-info mb-0">
            <!-- Address Card -->
            <div class="col-md-6 col-lg-3 d-flex ftco-animate mb-4 mb-lg-0">
                <div class="align-self-stretch box p-4 text-center h-100" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; border-top: 4px solid var(--theme-primary);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: rgba(var(--theme-primary-rgb), 0.1); border-radius: 12px; margin: 0 auto;">
                        <span class="fa fa-map-marker fa-lg" style="color: var(--theme-primary);"></span>
                    </div>
                    <h5 class="mb-3 fw-bold">Address</h5>
                    <p class="text-muted mb-0"><?php echo isset($physical_address) ? $physical_address : 'Campus Address'; ?></p>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="col-md-6 col-lg-3 d-flex ftco-animate mb-4 mb-lg-0">
                <div class="align-self-stretch box p-4 text-center h-100" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; border-top: 4px solid var(--theme-secondary);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: rgba(144, 179, 167, 0.1); border-radius: 12px; margin: 0 auto;">
                        <span class="fa fa-phone fa-lg" style="color: var(--theme-secondary);"></span>
                    </div>
                    <h5 class="mb-3 fw-bold">Phone</h5>
                    <p class="text-muted mb-0"><a href="tel:<?php echo isset($phone_number) ? preg_replace('/[^0-9+]/', '', $phone_number) : ''; ?>" style="color: var(--theme-primary); text-decoration: none; font-weight: 500;"><?php echo isset($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></a></p>
                </div>
            </div>

            <!-- Email Card -->
            <div class="col-md-6 col-lg-3 d-flex ftco-animate mb-4 mb-lg-0">
                <div class="align-self-stretch box p-4 text-center h-100" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; border-top: 4px solid var(--theme-accent);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: rgba(217, 179, 155, 0.1); border-radius: 12px; margin: 0 auto;">
                        <span class="fa fa-envelope fa-lg" style="color: var(--theme-accent);"></span>
                    </div>
                    <h5 class="mb-3 fw-bold">Email</h5>
                    <p class="text-muted mb-0"><a href="mailto:<?php echo isset($email_address) ? $email_address : 'info@example.com'; ?>" style="color: var(--theme-primary); text-decoration: none; font-weight: 500;"><?php echo isset($email_address) ? $email_address : 'info@example.com'; ?></a></p>
                </div>
            </div>

            <!-- Website Card -->
            <div class="col-md-6 col-lg-3 d-flex ftco-animate mb-4 mb-lg-0">
                <div class="align-self-stretch box p-4 text-center h-100" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; border-top: 4px solid var(--theme-primary);">
                    <div class="icon d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: rgba(var(--theme-primary-rgb), 0.1); border-radius: 12px; margin: 0 auto;">
                        <span class="fa fa-globe fa-lg" style="color: var(--theme-primary);"></span>
                    </div>
                    <h5 class="mb-3 fw-bold">Website</h5>
                    <p class="text-muted mb-0"><a href="<?php echo base_url(); ?>" style="color: var(--theme-primary); text-decoration: none; font-weight: 500;"><?php echo isset($site_name) ? $site_name : 'Our Website'; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     CONTACT SECTION - Form & Info
     ============================================ -->
<section class="ftco-section contact-section" style="padding: 80px 0;">
    <div class="container">
        <div class="row no-gutters block-9">
        
        <div class="row no-gutters block-9">
            <div class="col-md-6 order-md-last d-flex ftco-animate">
                <div class="contact-info-wrap w-100 p-md-5 p-4" style="background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);">
                    <h3 class="mb-4 text-white">Get In Touch</h3>
                    <p class="text-white">We're here to answer any questions you may have about our programs, admissions, or campus life. Reach out and we'll respond as soon as we can.</p>
                    
                    <div class="dbox w-100 d-flex align-items-start">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <div class="text pl-3">
                            <p><span>Address:</span> <?php echo isset($physical_address) ? $physical_address : 'Campus Address'; ?></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-phone"></span>
                        </div>
                        <div class="text pl-3">
                            <p><span>Phone:</span> <a href="tel:<?php echo isset($phone_number) ? preg_replace('/[^0-9+]/', '', $phone_number) : ''; ?>"><?php echo isset($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></a></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-envelope"></span>
                        </div>
                        <div class="text pl-3">
                            <p><span>Email:</span> <a href="mailto:<?php echo isset($email_address) ? $email_address : 'info@example.com'; ?>"><?php echo isset($email_address) ? $email_address : 'info@example.com'; ?></a></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex align-items-start">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-globe"></span>
                        </div>
                        <div class="text pl-3">
                            <p><span>Website:</span> <a href="<?php echo base_url(); ?>"><?php echo isset($site_name) ? $site_name : 'Our Website'; ?></a></p>
                        </div>
                    </div>
                    
                    <div class="dbox w-100 d-flex align-items-center mt-4">
                        <p class="text-white mb-0"><strong>Office Hours:</strong></p>
                    </div>
                    <div class="dbox w-100">
                        <p class="text-white-50 mb-1">Monday - Friday: 8:00 AM - 5:00 PM</p>
                        <p class="text-white-50 mb-0">Saturday: 9:00 AM - 1:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 d-flex ftco-animate">
                <div class="contact-form-wrap w-100 p-md-5 p-4" style="background: white;">
                    <h3 class="mb-2">Send Us a Message</h3>
                    <p class="text-muted mb-4">Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    <?php 
                    $success = $this->session->flashdata('success');
                    $error = $this->session->flashdata('error');
                    ?>
                    
                    <?php if($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle mr-2"></i><?php echo $success; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle mr-2"></i><?php echo $error; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo base_url('contact/submit'); ?>" method="POST" id="contactForm" class="contact-form">
                        <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="full_name" class="form-label fw-500">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px;" name="full_name" id="full_name" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email_address" class="form-label fw-500">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px;" name="email_address" id="email_address" placeholder="your@email.com" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="subject" class="form-label fw-500">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px;" name="subject" id="subject" placeholder="How can we help you?" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="message" class="form-label fw-500">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; min-height: 120px;" id="message" cols="30" rows="6" placeholder="Write your message here..." required></textarea>
                                </div>
                            </div>
                            
                            <!-- Honeypot field for spam protection -->
                            <div class="col-md-12" style="display: none;" aria-hidden="true">
                                <div class="form-group">
                                    <label for="website_url">Website</label>
                                    <input type="text" class="form-control" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                                </div>
                            </div>
                            
                            <!-- College-themed CAPTCHA -->
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="safari_answer" class="form-label fw-500">
                                        <span class="text-danger">*</span>
                                        Knowledge Check
                                    </label>
                                    <?php
                                    // College CAPTCHA questions
                                    $college_questions = [
                                        ['q' => '🎓 What degree is typically earned after 4 years of undergraduate study?', 'a' => 'bachelor'],
                                        ['q' => '📚 What is the traditional color of academic robes?', 'a' => 'black'],
                                        ['q' => '📖 A period of teaching in a school year is called a...?', 'a' => 'semester'],
                                        ['q' => '✏️ What do students take to assess their knowledge?', 'a' => 'exam'],
                                        ['q' => '🔤 How many letters are in the English alphabet?', 'a' => '26'],
                                        ['q' => '📚 Are libraries good places to study? (yes/no)', 'a' => 'yes'],
                                        ['q' => '🎯 Is education important? (yes/no)', 'a' => 'yes'],
                                        ['q' => '👨‍🎓 A student who studies at university is called a...?', 'a' => 'student'],
                                        ['q' => '🧑‍🏫 A person who teaches at school is called a...?', 'a' => 'teacher'],
                                        ['q' => '🏆 What do students receive for completing a course?', 'a' => 'certificate'],
                                    ];
                                    
                                    // Get stored question or create new one
                                    $stored_answer = $this->session->userdata('safari_captcha_contact');
                                    if (empty($stored_answer)) {
                                        $random_key = array_rand($college_questions);
                                        $captcha = $college_questions[$random_key];
                                        $this->session->set_userdata('safari_captcha_contact', strtolower($captcha['a']));
                                        $this->session->set_userdata('safari_captcha_contact_key', $random_key);
                                    } else {
                                        $stored_key = $this->session->userdata('safari_captcha_contact_key');
                                        $captcha = isset($college_questions[$stored_key]) ? $college_questions[$stored_key] : $college_questions[array_rand($college_questions)];
                                    }
                                    ?>
                                    <div style="background: linear-gradient(135deg, rgba(199, 128, 92, 0.08) 0%, rgba(144, 179, 167, 0.08) 100%); padding: 16px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid var(--theme-primary);">
                                        <p style="margin: 0; font-size: 15px; font-weight: 500; color: #333;">
                                            <?php echo $captcha['q']; ?>
                                        </p>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px;" name="safari_answer" id="safari_answer" placeholder="Your answer..." required autocomplete="off">
                                    <small class="form-text text-muted mt-2">
                                        Answer this question to help us prevent spam.
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 8px; padding: 14px 40px; font-weight: 600; width: 100%; background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%); border: none;">
                                        <span class="fa fa-paper-plane me-2"></span> Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     MAP SECTION
     ============================================ -->
<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-12">
                <div class="map-wrap" style="height: 500px; width: 100%;">
                    <?php if(isset($google_maps_embed) && !empty($google_maps_embed)): ?>
                        <div style="height: 100%; width: 100%;">
                            <?php echo $google_maps_embed; ?>
                        </div>
                    <?php else: ?>
                        <div class="map-placeholder d-flex align-items-center justify-content-center" style="height: 100%; background: #f8f9fa;">
                            <div class="text-center">
                                <span class="fa fa-map-marker fa-3x mb-3 d-block"></span>
                                <h4>Visit Our Campus</h4>
                                <p><?php echo isset($physical_address) ? $physical_address : 'Campus Address'; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Testimonials -->
 <?php include VIEWPATH.'templates/college/sections/testimonials.php'; ?>

 
<!-- Partners section -->
<?php include VIEWPATH . 'templates/college/sections/partners.php'; ?>




<!-- Contact Page Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            var honeypot = document.getElementById('website_url');
            if (honeypot && honeypot.value !== '') {
                e.preventDefault();
                return false;
            }
            
            var name = document.getElementById('full_name').value.trim();
            var email = document.getElementById('email_address').value.trim();
            var subject = document.getElementById('subject').value.trim();
            var message = document.getElementById('message').value.trim();
            
            if (!name || !email || !subject || !message) {
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
        });
    }
});
</script>
