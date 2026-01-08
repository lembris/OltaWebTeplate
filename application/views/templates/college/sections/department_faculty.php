<!-- ============================================
     DEPARTMENTS/FACULTIES SECTION - Dynamic
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Explore Our Departments</span>
                <h2 class="mb-4">Academic Departments & Faculties</h2>
            </div>
        </div>
        <div class="row">
            <?php if(!empty($departments)): ?>
                <?php foreach($departments as $dept): ?>
                <?php 
                    // Handle department data (both object and array)
                    $dept_id = is_object($dept) ? $dept->id : ($dept['id'] ?? '');
                    $dept_name = is_object($dept) ? $dept->name : ($dept['name'] ?? '');
                    $dept_code = is_object($dept) ? $dept->code : ($dept['code'] ?? '');
                    $dept_image = is_object($dept) ? ($dept->image ?? '') : ($dept['image'] ?? '');
                    $dept_head = is_object($dept) ? $dept->head_name : ($dept['head_name'] ?? '');
                    $dept_description = is_object($dept) ? ($dept->description ?? '') : ($dept['description'] ?? '');
                ?>
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="staffcard">
                        <div class="img img-2" style="background-image: url(<?php echo !empty($dept_image) ? base_url($dept_image) : get_template_image('work-' . ($dept_id % 3 + 1) . '.jpg'); ?>);"></div>
                        <div class="stafftext p-4 text-center">
                            <h3><a href="<?php echo base_url('directory?dept=' . $dept_code); ?>"><?php echo $dept_name; ?></a></h3>
                            <p><?php echo word_limiter(strip_tags($dept_description), 10, '...'); ?></p>
                            <p class="staff-position">Led by <?php echo $dept_head; ?></p>
                            <p><a href="<?php echo base_url('directory?dept=' . $dept_code); ?>" class="btn btn-sm btn-primary">View Programs</a></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback: Default Departments -->
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="staffcard">
                        <div class="img img-2" style="background-image: url(<?php echo get_template_image('work-1.jpg'); ?>);"></div>
                        <div class="stafftext p-4 text-center">
                            <h3><a href="<?php echo base_url('directory'); ?>">Computer Science</a></h3>
                            <p>Software engineering, AI, and data science</p>
                            <p class="staff-position">Led by expert faculty</p>
                            <p><a href="<?php echo base_url('directory'); ?>" class="btn btn-sm btn-primary">View Programs</a></p>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-6 col-lg-4 ftco-animate">
                            <div class="staffcard">
                            <div class="img img-2" style="background-image: url(<?php echo get_template_image('work-2.jpg'); ?>);"></div>
                            <div class="stafftext p-4 text-center">
                             <h3><a href="<?php echo base_url('directory'); ?>">Engineering</a></h3>
                             <p>Electrical, mechanical, and civil engineering</p>
                             <p class="staff-position">Industry-leading curriculum</p>
                             <p><a href="<?php echo base_url('directory'); ?>" class="btn btn-sm btn-primary">View Programs</a></p>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-6 col-lg-4 ftco-animate">
                            <div class="staffcard">
                            <div class="img img-2" style="background-image: url(<?php echo get_template_image('work-3.jpg'); ?>);"></div>
                            <div class="stafftext p-4 text-center">
                             <h3><a href="<?php echo base_url('directory'); ?>">Business & Administration</a></h3>
                             <p>MBA, BBA, and management programs</p>
                             <p class="staff-position">Global perspective education</p>
                             <p><a href="<?php echo base_url('directory'); ?>" class="btn btn-sm btn-primary">View Programs</a></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="<?php echo base_url('directory'); ?>" class="btn btn-primary">Explore All Departments</a>
            </div>
        </div>
    </div>
</section>