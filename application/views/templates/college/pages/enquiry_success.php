<?php
/**
 * College Template - Enquiry/Application Success Page
 * 
 * Success message displayed after enquiry/application form submission.
 * Based on StudyLab design pattern.
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- ============================================
     SUCCESS MESSAGE SECTION
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center ftco-animate">
                <!-- Success Icon -->
                <div class="success-icon mb-4">
                    <span class="fa fa-check-circle text-success" style="font-size: 80px;"></span>
                </div>
                
                <!-- Success Message -->
                <h2 class="mb-4">Thank You for Applying!</h2>
                <p class="lead text-muted mb-4">Your application has been submitted successfully. We're excited about your interest in joining our institution!</p>
                
                <!-- Submitted Details -->
                <?php if(isset($enquiry) && is_object($enquiry)): ?>
                <div class="bg-light p-4 rounded mb-4 text-left">
                    <h5 class="mb-3"><i class="fa fa-file-text text-primary mr-2"></i> Application Details</h5>
                    <table class="table table-borderless mb-0">
                        <?php if(!empty($enquiry->name)): ?>
                        <tr>
                            <td class="text-muted" style="width: 140px;"><strong>Name:</strong></td>
                            <td><?php echo htmlspecialchars($enquiry->name); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($enquiry->email)): ?>
                        <tr>
                            <td class="text-muted"><strong>Email:</strong></td>
                            <td><?php echo htmlspecialchars($enquiry->email); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($enquiry->phone)): ?>
                        <tr>
                            <td class="text-muted"><strong>Phone:</strong></td>
                            <td><?php echo htmlspecialchars($enquiry->phone); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($enquiry->program) || !empty($enquiry->program_name)): ?>
                        <tr>
                            <td class="text-muted"><strong>Program:</strong></td>
                            <td><?php echo htmlspecialchars($enquiry->program_name ?? $enquiry->program); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($enquiry->reference_number)): ?>
                        <tr>
                            <td class="text-muted"><strong>Reference #:</strong></td>
                            <td><span class="badge badge-primary"><?php echo htmlspecialchars($enquiry->reference_number); ?></span></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($enquiry->created_at)): ?>
                        <tr>
                            <td class="text-muted"><strong>Submitted:</strong></td>
                            <td><?php echo date('F j, Y \a\t g:i A', strtotime($enquiry->created_at)); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
                
                <!-- Next Steps -->
                <div class="bg-primary text-white p-4 rounded mb-4 text-left">
                    <h5 class="mb-3 text-white"><i class="fa fa-list-ol mr-2"></i> Next Steps</h5>
                    <ol class="mb-0 pl-3 text-white-50">
                        <li class="mb-2">Our admissions team will review your application within 2-3 business days.</li>
                        <li class="mb-2">You will receive a confirmation email with your application reference number.</li>
                        <li class="mb-2">We may contact you for additional information or to schedule an interview.</li>
                        <li class="mb-0">Once processed, you will receive an official admission decision via email.</li>
                    </ol>
                </div>
                
                <!-- Important Notice -->
                <div class="alert alert-info text-left mb-4">
                    <h6 class="alert-heading"><i class="fa fa-info-circle mr-2"></i> Important</h6>
                    <p class="mb-0">Please save your reference number and check your email (including spam folder) for updates on your application status.</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary px-4 py-3 mr-2">
                        <span class="fa fa-home mr-2"></span> Back to Home
                    </a>
                    <a href="<?php echo base_url('programs'); ?>" class="btn btn-outline-primary px-4 py-3">
                        <span class="fa fa-book mr-2"></span> Explore Programs
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     ADDITIONAL INFO SECTION
     ============================================ -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">While You Wait</span>
                <h2 class="mb-4">Prepare for Your Journey</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 ftco-animate">
                <div class="services text-center bg-white p-4 rounded">
                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="fa fa-book fa-2x text-primary"></span>
                    </div>
                    <h4>Explore Programs</h4>
                    <p class="text-muted">Learn more about our courses, faculty, and curriculum.</p>
                    <a href="<?php echo base_url('programs'); ?>" class="btn btn-sm btn-outline-primary">View Programs</a>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="services text-center bg-white p-4 rounded">
                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="fa fa-university fa-2x text-primary"></span>
                    </div>
                    <h4>Campus Tour</h4>
                    <p class="text-muted">Take a virtual tour of our modern facilities and campus.</p>
                    <a href="<?php echo base_url('gallery'); ?>" class="btn btn-sm btn-outline-primary">View Gallery</a>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="services text-center bg-white p-4 rounded">
                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="fa fa-question-circle fa-2x text-primary"></span>
                    </div>
                    <h4>Have Questions?</h4>
                    <p class="text-muted">Our admissions team is here to help with any questions.</p>
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-sm btn-outline-primary">Contact Us</a>
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
                <h2>Stay Connected</h2>
                <p>Follow us on social media and stay updated with the latest news and events.</p>
                <p class="mb-0">
                    <a href="<?php echo base_url('blog'); ?>" class="btn btn-primary px-4 py-3 mr-md-2">Read Our Blog</a>
                    <a href="<?php echo base_url('about'); ?>" class="btn btn-secondary px-4 py-3">About Us</a>
                </p>
            </div>
        </div>
    </div>
</section>
