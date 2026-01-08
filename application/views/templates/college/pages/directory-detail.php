<?php
/**
 * College Template - Directory Detail Page
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Directory Detail Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 ftco-animate">
                <!-- Entry Image -->
                <?php 
                $entry_image = !empty($entry->image) ? base_url('assets/img/directory/' . $entry->image) : get_template_image('staff-1.jpg');
                ?>
                <img src="<?php echo $entry_image; ?>" alt="<?php echo htmlspecialchars($entry->name); ?>" class="img-fluid mb-4 rounded">
                
                <!-- Entry Info Cards -->
                <div class="row mb-4">
                    <?php if (!empty($entry->email)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="bg-light p-3">
                            <i class="fa fa-envelope fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h6>Email</h6>
                            <p class="mb-0">
                                <a href="mailto:<?php echo htmlspecialchars($entry->email); ?>">
                                    <?php echo htmlspecialchars($entry->email); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($entry->phone)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="bg-light p-3">
                            <i class="fa fa-phone fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h6>Phone</h6>
                            <p class="mb-0">
                                <a href="tel:<?php echo htmlspecialchars($entry->phone); ?>">
                                    <?php echo htmlspecialchars($entry->phone); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($entry->alternate_phone)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="bg-light p-3">
                            <i class="fa fa-phone fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h6>Alternative Phone</h6>
                            <p class="mb-0">
                                <a href="tel:<?php echo htmlspecialchars($entry->alternate_phone); ?>">
                                    <?php echo htmlspecialchars($entry->alternate_phone); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($entry->location)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="bg-light p-3">
                            <i class="fa fa-map-marker fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h6>Location</h6>
                            <p class="mb-0"><?php echo htmlspecialchars($entry->location); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <?php if (!empty($entry->description)): ?>
                <div class="mb-5">
                    <h3>About</h3>
                    <?php echo $entry->description; ?>
                </div>
                <?php endif; ?>
                
                <!-- Contact Person -->
                <?php if (!empty($entry->contact_person)): ?>
                <div class="mb-5">
                    <h3>Contact Person</h3>
                    <p><?php echo htmlspecialchars($entry->contact_person); ?></p>
                </div>
                <?php endif; ?>
                
                <!-- Website -->
                <?php if (!empty($entry->website)): ?>
                <div class="mb-5">
                    <h3>Website</h3>
                    <p>
                        <a href="<?php echo htmlspecialchars($entry->website); ?>" target="_blank" class="btn btn-primary">
                            <i class="fa fa-globe"></i> Visit Website
                        </a>
                    </p>
                </div>
                <?php endif; ?>
                
                <!-- Room Number -->
                <?php if (!empty($entry->room_number)): ?>
                <div class="mb-5">
                    <h3>Room Number</h3>
                    <p><?php echo htmlspecialchars($entry->room_number); ?></p>
                </div>
                <?php endif; ?>
                
                <!-- Related Faculty Section -->
                <?php if (!empty($related_faculty)): ?>
                <div class="mb-5 pb-5 border-top pt-5">
                    <h3 class="mb-4">Department Faculty & Staff</h3>
                    <div class="row">
                        <?php foreach ($related_faculty as $faculty): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <!-- Faculty Image -->
                                <?php 
                                $faculty_image = !empty($faculty->photo) ? base_url('assets/img/faculty/' . $faculty->photo) : get_template_image('staff-1.jpg');
                                ?>
                                <img src="<?php echo $faculty_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name); ?>" style="height: 250px; object-fit: cover;">
                                
                                <!-- Faculty Info -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name); ?>
                                    </h5>
                                    <p class="card-text text-muted mb-3">
                                        <strong><?php echo htmlspecialchars($faculty->title); ?></strong>
                                    </p>
                                    
                                    <!-- Specialization -->
                                    <?php if (!empty($faculty->specialization)): ?>
                                    <p class="card-text small mb-3">
                                        <strong>Specialization:</strong><br>
                                        <?php echo htmlspecialchars($faculty->specialization); ?>
                                    </p>
                                    <?php endif; ?>
                                    
                                    <!-- Office Location -->
                                    <?php if (!empty($faculty->office_location)): ?>
                                    <p class="card-text small mb-3">
                                        <i class="fa fa-map-marker" style="color: var(--primary-color);"></i>
                                        <?php echo htmlspecialchars($faculty->office_location); ?>
                                    </p>
                                    <?php endif; ?>
                                    
                                    <!-- Office Hours -->
                                    <?php if (!empty($faculty->office_hours)): ?>
                                    <p class="card-text small mb-3">
                                        <i class="fa fa-clock-o" style="color: var(--primary-color);"></i>
                                        <?php echo htmlspecialchars($faculty->office_hours); ?>
                                    </p>
                                    <?php endif; ?>
                                    
                                    <!-- Contact Links -->
                                    <div class="mt-3">
                                        <?php if (!empty($faculty->email)): ?>
                                        <a href="mailto:<?php echo htmlspecialchars($faculty->email); ?>" class="btn btn-sm btn-outline-primary mr-2 mb-2">
                                            <i class="fa fa-envelope"></i> Email
                                        </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($faculty->phone)): ?>
                                        <a href="tel:<?php echo htmlspecialchars($faculty->phone); ?>" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fa fa-phone"></i> Call
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Back Link -->
                <div class="mt-5 pt-5 border-top">
                    <a href="<?php echo base_url('directory'); ?>" class="btn btn-outline-secondary">
                        <i class="fa fa-chevron-left"></i> Back to Directory
                    </a>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Quick Contact -->
                <div class="sidebar-box text-white p-4" style="background-color: var(--primary-color);">
                    <h3 class="text-white">Quick Contact</h3>
                    <p>Get in touch with this office or department.</p>
                    <?php if (!empty($entry->email)): ?>
                    <a href="mailto:<?php echo htmlspecialchars($entry->email); ?>" class="btn btn-white btn-block mb-2">
                        <i class="fa fa-envelope"></i> Send Email
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($entry->phone)): ?>
                    <a href="tel:<?php echo htmlspecialchars($entry->phone); ?>" class="btn btn-white btn-block">
                        <i class="fa fa-phone"></i> Call Now
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Entry Details -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Details</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Type:</strong><br>
                            <?php echo ucfirst(htmlspecialchars($entry->type ?? 'N/A')); ?>
                        </li>
                        
                        <?php if (!empty($entry->location)): ?>
                        <li class="mb-2">
                            <strong>Location:</strong><br>
                            <?php echo htmlspecialchars($entry->location); ?>
                        </li>
                        <?php endif; ?>
                        
                        <?php if (!empty($entry->room_number)): ?>
                        <li class="mb-2">
                            <strong>Room:</strong><br>
                            <?php echo htmlspecialchars($entry->room_number); ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Contact Information -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Contact Information</h3>
                    <div class="block-23">
                        <ul>
                            <?php if (!empty($entry->phone)): ?>
                            <li>
                                <a href="tel:<?php echo htmlspecialchars($entry->phone); ?>" style="color: #333;">
                                    <span class="icon fa fa-phone"></span>
                                    <span class="text" style="color: #333;"><?php echo htmlspecialchars($entry->phone); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (!empty($entry->alternate_phone)): ?>
                            <li>
                                <a href="tel:<?php echo htmlspecialchars($entry->alternate_phone); ?>" style="color: #333;">
                                    <span class="icon fa fa-phone"></span>
                                    <span class="text" style="color: #333;"><?php echo htmlspecialchars($entry->alternate_phone); ?> (Alt)</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (!empty($entry->email)): ?>
                            <li>
                                <a href="mailto:<?php echo htmlspecialchars($entry->email); ?>" style="color: #333;">
                                    <span class="icon fa fa-envelope"></span>
                                    <span class="text" style="color: #333;"><?php echo htmlspecialchars($entry->email); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (!empty($entry->website)): ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($entry->website); ?>" target="_blank" style="color: #333;">
                                    <span class="icon fa fa-globe"></span>
                                    <span class="text" style="color: #333;">Website</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
