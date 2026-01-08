<section class="hero-wrap js-fullheight" style="background-image: url('<?php echo get_template_image('bg_1.jpg'); ?>');">
    <div class="overlay" style="background: rgba(0, 0, 0, 0.5);"></div>
    <div class="container pt-5 pb-5">
        <div class="row no-gutters slider-text align-items-center">
            <div class="col-md-7 ftco-animate">
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
    
    <!-- Floating Registration Form -->
    <!-- Commented out temporarily
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