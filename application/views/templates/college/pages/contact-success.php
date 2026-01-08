<?php
/**
 * College Template - Contact Success Page
 * 
 * Success message displayed after contact form submission.
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
                <!-- Flash Success Message -->
                <?php $success = $this->session->flashdata('success'); ?>
                <?php if($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 30px;">
                    <i class="fa fa-check-circle mr-2"></i><?php echo $success; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>
                
                <!-- Success Icon -->
                <div class="success-icon mb-4">
                    <span class="fa fa-check-circle text-success" style="font-size: 80px;"></span>
                </div>
                
                <!-- Success Message -->
                <h2 class="mb-4">Thank You for Contacting Us!</h2>
                <p class="lead text-muted mb-4">Your message has been received successfully. Our team will review your inquiry and get back to you as soon as possible.</p>
                
                <!-- Submitted Details -->
                <?php if(isset($contact) && is_object($contact)): ?>
                <div class="bg-light p-4 rounded mb-4 text-left">
                    <h5 class="mb-3"><i class="fa fa-info-circle text-primary mr-2"></i> Submission Details</h5>
                    <table class="table table-borderless mb-0">
                        <?php if(!empty($contact->name)): ?>
                        <tr>
                            <td class="text-muted" style="width: 120px;"><strong>Name:</strong></td>
                            <td><?php echo htmlspecialchars($contact->name); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($contact->email)): ?>
                        <tr>
                            <td class="text-muted"><strong>Email:</strong></td>
                            <td><?php echo htmlspecialchars($contact->email); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($contact->subject)): ?>
                        <tr>
                            <td class="text-muted"><strong>Subject:</strong></td>
                            <td><?php echo htmlspecialchars($contact->subject); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if(!empty($contact->created_at)): ?>
                        <tr>
                            <td class="text-muted"><strong>Sent:</strong></td>
                            <td><?php echo date('F j, Y \a\t g:i A', strtotime($contact->created_at)); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
                
                <!-- What's Next -->
                <div class="bg-primary text-white p-4 rounded mb-4">
                    <h5 class="mb-2"><i class="fa fa-clock-o mr-2"></i> What Happens Next?</h5>
                    <p class="mb-0 text-white-50">We typically respond within 24-48 business hours. Please check your email for our response.</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary px-4 py-3 mr-2">
                        <span class="fa fa-home mr-2"></span> Back to Home
                    </a>
                    <a href="<?php echo base_url('programs'); ?>" class="btn btn-outline-primary px-4 py-3">
                        <span class="fa fa-book mr-2"></span> View Programs
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
                <h2>Ready to Start Your Educational Journey?</h2>
                <p>While you wait for our response, explore our programs and find the perfect fit for your goals.</p>
                <p class="mb-0">
                    <a href="<?php echo base_url('enquiry'); ?>" class="btn btn-primary px-4 py-3 mr-md-2">Apply Now</a>
                    <a href="<?php echo base_url('about'); ?>" class="btn btn-secondary px-4 py-3">Learn About Us</a>
                </p>
            </div>
        </div>
    </div>
</section>
