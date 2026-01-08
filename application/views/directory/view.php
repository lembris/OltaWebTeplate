<?php 
    $this->load->helper('template');
    $active_template = get_active_template();
    
    // Prepare data for nested views
    $header_data = array_merge(
        get_defined_vars(),
        isset($data) ? $data : []
    );
?>
<?php $this->load->view('templates/' . $active_template . '/header', $header_data); ?>
<?php $this->load->view('templates/' . $active_template . '/navigation', $header_data); ?>

<!-- Hero Section -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo get_template_image('bg_2.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="<?php echo base_url(); ?>">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="<?php echo base_url('directory'); ?>">Directory <i class="fa fa-chevron-right"></i></a></span>
                    <span><?php echo htmlspecialchars($entry->name); ?> <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread"><?php echo htmlspecialchars($entry->name); ?></h1>
            </div>
        </div>
    </div>
</section>

<!-- Entry Details Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 ftco-animate">
                <div class="card">
                    <div class="card-body">
                        <!-- Entry Header -->
                        <div class="mb-4 pb-4 border-bottom">
                            <h2 class="mb-2"><?php echo htmlspecialchars($entry->name); ?></h2>
                            <p class="mb-0">
                                <span class="badge bg-secondary"><?php echo ucfirst($entry->type); ?></span>
                            </p>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h4>Contact Information</h4>
                            <div class="row">
                                <?php if (!empty($entry->email)): ?>
                                    <div class="col-md-6 mb-3">
                                        <strong>Email:</strong>
                                        <p>
                                            <a href="mailto:<?php echo htmlspecialchars($entry->email); ?>">
                                                <?php echo htmlspecialchars($entry->email); ?>
                                            </a>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($entry->phone)): ?>
                                    <div class="col-md-6 mb-3">
                                        <strong>Phone:</strong>
                                        <p>
                                            <a href="tel:<?php echo htmlspecialchars($entry->phone); ?>">
                                                <?php echo htmlspecialchars($entry->phone); ?>
                                            </a>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($entry->contact_person)): ?>
                                    <div class="col-md-6 mb-3">
                                        <strong>Contact Person:</strong>
                                        <p><?php echo htmlspecialchars($entry->contact_person); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($entry->extension)): ?>
                                    <div class="col-md-6 mb-3">
                                        <strong>Extension:</strong>
                                        <p><?php echo htmlspecialchars($entry->extension); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <?php if (!empty($entry->location) || !empty($entry->room_number)): ?>
                            <div class="mb-4">
                                <h4>Location</h4>
                                <div class="row">
                                    <?php if (!empty($entry->location)): ?>
                                        <div class="col-md-6 mb-3">
                                            <strong>Building/Area:</strong>
                                            <p><?php echo htmlspecialchars($entry->location); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($entry->room_number)): ?>
                                        <div class="col-md-6 mb-3">
                                            <strong>Room Number:</strong>
                                            <p><?php echo htmlspecialchars($entry->room_number); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <?php if (!empty($entry->description)): ?>
                            <div class="mb-4">
                                <h4>Description</h4>
                                <p><?php echo nl2br(htmlspecialchars($entry->description)); ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Office Hours -->
                        <?php if (!empty($entry->office_hours)): ?>
                            <div class="mb-4">
                                <h4>Office Hours</h4>
                                <p><?php echo nl2br(htmlspecialchars($entry->office_hours)); ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Services -->
                        <?php if (!empty($entry->services)): ?>
                            <div class="mb-4">
                                <h4>Services Offered</h4>
                                <p><?php echo nl2br(htmlspecialchars($entry->services)); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Back Link -->
                <div class="mt-4">
                    <a href="<?php echo base_url('directory'); ?>" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Directory
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Quick Contact Card -->
                <div class="sidebar-box" style="background-color: var(--primary-color); color: white; padding: 20px; border-radius: 8px;">
                    <h3 style="color: white; margin-bottom: 15px;">Quick Contact</h3>
                    
                    <div class="quick-contact-item mb-3">
                        <strong>Type:</strong>
                        <p class="mb-0"><?php echo ucfirst($entry->type); ?></p>
                    </div>

                    <?php if (!empty($entry->email)): ?>
                        <div class="quick-contact-item mb-3">
                            <strong>Email:</strong>
                            <p class="mb-0">
                                <a href="mailto:<?php echo htmlspecialchars($entry->email); ?>" style="color: white; text-decoration: underline;">
                                    <?php echo htmlspecialchars($entry->email); ?>
                                </a>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($entry->phone)): ?>
                        <div class="quick-contact-item mb-3">
                            <strong>Phone:</strong>
                            <p class="mb-0">
                                <a href="tel:<?php echo htmlspecialchars($entry->phone); ?>" style="color: white; text-decoration: underline;">
                                    <?php echo htmlspecialchars($entry->phone); ?>
                                </a>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($entry->location)): ?>
                        <div class="quick-contact-item mb-3">
                            <strong>Location:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($entry->location); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($entry->room_number)): ?>
                        <div class="quick-contact-item">
                            <strong>Room:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($entry->room_number); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Related Departments -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Related Departments</h3>
                    <p class="text-muted small">Browse other directory entries by type</p>
                    <div class="list-group list-group-flush">
                        <a href="<?php echo base_url('directory'); ?>" class="list-group-item list-group-item-action">
                            View All Directory
                        </a>
                        <a href="<?php echo base_url('directory/by_type/' . $entry->type); ?>" class="list-group-item list-group-item-action">
                            More <?php echo ucfirst($entry->type); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('templates/' . $active_template . '/footer', $data); ?>
