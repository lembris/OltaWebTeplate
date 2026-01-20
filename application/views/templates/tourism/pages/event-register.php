<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-5">
                <h1 class="page-title">Register for Event</h1>
                <p class="page-subtitle text-muted"><?php echo htmlspecialchars($event->title); ?></p>
            </div>

            <!-- Event Summary Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <?php if (!empty($event->banner)): ?>
                                <img src="<?php echo base_url($event->banner); ?>" alt="<?php echo htmlspecialchars($event->title); ?>" class="img-fluid rounded">
                            <?php else: ?>
                                <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                    <i class="fas fa-calendar text-white" style="font-size: 2rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <h5><?php echo htmlspecialchars($event->title); ?></h5>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-calendar me-2"></i><?php echo date('F d, Y', strtotime($event->start_date)); ?>
                                <?php if (!empty($event->start_time)): ?>
                                    at <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                <?php endif; ?>
                            </p>
                            <?php if (!empty($event->location)): ?>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($event->location); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error/Message Display -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php echo $errors; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
                <div class="alert alert-warning">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Registration Form</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('events/register/' . $event->slug); ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="<?php echo set_value('first_name'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="<?php echo set_value('last_name'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo set_value('email'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo set_value('phone'); ?>">
                            </div>
                            <div class="col-12">
                                <label for="affiliation" class="form-label">Affiliation / Organization</label>
                                <input type="template" class="form-control" id="affiliation" name="affiliation" 
                                       value="<?php echo set_value('affiliation'); ?>" 
                                       placeholder="e.g., Company name, University, etc.">
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>Complete Registration
                            </button>
                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="btn btn-outline-secondary btn-lg">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #666;
}
</style>
