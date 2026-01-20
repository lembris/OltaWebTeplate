<?php
/**
 * College Template - Event Registration Page
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Registration Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 ftco-animate">
                <!-- Event Summary Card -->
                <div class="mb-5 p-4" style="background-color: #f8f9fa; border-radius: 0.25rem;">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <?php if (!empty($event->banner)): ?>
                                <img src="<?php echo base_url($event->banner); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                            <?php elseif (!empty($event->image)): ?>
                                <img src="<?php echo base_url($event->image); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded d-flex align-items-center justify-content-center" style="height: 150px; background-color: #fff; border: 2px solid #ddd;">
                                    <?php 
                                    // Try to get site logo dynamically
                                    $CI = &get_instance();
                                    $site_logo = !empty($site_logo) ? $site_logo : null;
                                    if (!empty($site_logo)):
                                    ?>
                                        <img src="<?php echo base_url($site_logo); ?>" alt="Logo" class="img-fluid" style="max-height: 120px; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="fa fa-calendar" style="font-size: 3rem; color: #C7805C;"></i>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <h3><?php echo htmlspecialchars($event->title); ?></h3>
                            <p class="mb-2">
                                <i class="fa fa-calendar me-2" style="color: #C7805C;"></i>
                                <strong><?php echo date('F d, Y', strtotime($event->start_date)); ?></strong>
                                <?php if (!empty($event->start_time)): ?>
                                    <span class="ms-3">at <strong><?php echo date('g:i A', strtotime($event->start_time)); ?></strong></span>
                                <?php endif; ?>
                            </p>
                            <?php if (!empty($event->location)): ?>
                                <p class="mb-2">
                                    <i class="fa fa-map-marker me-2" style="color: #C7805C;"></i>
                                    <strong><?php echo htmlspecialchars($event->location); ?></strong>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($event->organizer)): ?>
                                <p class="mb-0">
                                    <i class="fa fa-building me-2" style="color: #C7805C;"></i>
                                    <strong><?php echo htmlspecialchars($event->organizer); ?></strong>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Error/Message Display -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i>
                        <?php echo $errors; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa fa-info-circle me-2"></i>
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-times-circle me-2"></i>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <div class="p-4 mb-5" style="background-color: #fff; border: 1px solid #ddd; border-radius: 0.25rem;">
                    <h3 class="mb-4 pb-3" style="border-bottom: 2px solid #C7805C; color: #333;">
                        <i class="fa fa-user-plus me-2" style="color: #C7805C;"></i>Registration Form
                    </h3>
                    
                    <form method="post" action="<?php echo base_url('events/register/' . $event->slug); ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-600">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="<?php echo set_value('first_name'); ?>" required placeholder="Enter your first name">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-600">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="<?php echo set_value('last_name'); ?>" required placeholder="Enter your last name">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-600">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #f8f9fa; border-right: none;">
                                        <i class="fa fa-envelope" style="color: #C7805C;"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo set_value('email'); ?>" required placeholder="your.email@example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-600">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #f8f9fa; border-right: none;">
                                        <i class="fa fa-phone" style="color: #C7805C;"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo set_value('phone'); ?>" placeholder="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="affiliation" class="form-label fw-600">Affiliation / Organization</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: #f8f9fa; border-right: none;">
                                    <i class="fa fa-building" style="color: #C7805C;"></i>
                                </span>
                                <input type="text" class="form-control" id="affiliation" name="affiliation" 
                                       value="<?php echo set_value('affiliation'); ?>" 
                                       placeholder="e.g., Company name, University, etc.">
                            </div>
                        </div>

                        <div class="mt-5 pt-4 d-flex gap-3" style="border-top: 1px solid #ddd;">
                            <button type="submit" class="btn btn-primary btn-lg" style="background-color: #C7805C; border-color: #C7805C;">
                                <i class="fa fa-check me-2"></i>Complete Registration
                            </button>
                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fa fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 text-center" style="background-color: #f8f9fa; border-radius: 0.25rem;">
                            <i class="fa fa-lock" style="font-size: 1.5rem; color: #C7805C; margin-bottom: 0.5rem;"></i>
                            <p class="small text-muted mt-2">Your information is secure and will not be shared.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 text-center" style="background-color: #f8f9fa; border-radius: 0.25rem;">
                            <i class="fa fa-envelope" style="font-size: 1.5rem; color: #C7805C; margin-bottom: 0.5rem;"></i>
                            <p class="small text-muted mt-2">You'll receive a confirmation email shortly.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 text-center" style="background-color: #f8f9fa; border-radius: 0.25rem;">
                            <i class="fa fa-question-circle" style="font-size: 1.5rem; color: #C7805C; margin-bottom: 0.5rem;"></i>
                            <p class="small text-muted mt-2">Questions? Contact us for support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 0.25rem;
    padding: 0.75rem;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #C7805C;
    box-shadow: 0 0 0 0.2rem rgba(199, 128, 92, 0.25);
}

.input-group-text {
    border: 1px solid #ddd;
}

.btn {
    border-radius: 0.25rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #C7805C;
    border-color: #C7805C;
}

.btn-primary:hover {
    background-color: #A0654A;
    border-color: #A0654A;
    transform: translateY(-2px);
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
}

.alert {
    border-radius: 0.25rem;
    border: none;
    border-left: 4px solid;
}

.alert-danger {
    border-left-color: #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

.alert-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
    color: #856404;
}

.alert-success {
    border-left-color: #28a745;
    background-color: #d4edda;
    color: #155724;
}

.hero-wrap {
    background-size: cover;
    background-position: center;
    position: relative;
    min-height: 300px;
}

.hero-wrap .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.slider-text {
    position: relative;
    z-index: 2;
}

.breadcrumbs {
    color: #fff;
    font-size: 0.9rem;
}

.breadcrumbs a {
    color: #fff;
    text-decoration: none;
}

.breadcrumbs a:hover {
    text-decoration: underline;
}

.breadcrumbs i {
    margin: 0 0.5rem;
}

.bread {
    color: #fff;
    font-weight: 700;
    font-size: 2.5rem;
}

@media (max-width: 768px) {
    .bread {
        font-size: 1.75rem;
    }

    .btn-lg {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
