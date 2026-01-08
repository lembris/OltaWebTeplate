<?php
/**
 * College Template - Program Detail Page
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Program Detail Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 ftco-animate">
                <!-- Program Image -->
                <?php 
                $program_image = !empty($program->image) ? base_url('assets/img/programs/' . $program->image) : get_template_image('work-1.jpg');
                ?>
                <img src="<?php echo $program_image; ?>" alt="<?php echo htmlspecialchars($program->name); ?>" class="img-fluid mb-4">
                
                <!-- Program Info Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 col-6 mb-3">
                         <div class="bg-light p-3 text-center">
                             <i class="fa fa-clock-o fa-2x mb-2" style="color: var(--primary-color);"></i>
                             <h6>Duration</h6>
                             <p class="mb-0">
                                 <?php 
                                 $duration = $program->duration_months ?? 24;
                                 echo ($duration >= 12) ? floor($duration / 12) . ' Year' . (floor($duration / 12) > 1 ? 's' : '') : $duration . ' Months';
                                 ?>
                             </p>
                         </div>
                     </div>
                     <div class="col-md-3 col-6 mb-3">
                         <div class="bg-light p-3 text-center">
                             <i class="fa fa-graduation-cap fa-2x mb-2" style="color: var(--primary-color);"></i>
                             <h6>Level</h6>
                             <p class="mb-0"><?php echo htmlspecialchars($program->level ?? 'Diploma'); ?></p>
                         </div>
                     </div>
                     <div class="col-md-3 col-6 mb-3">
                         <div class="bg-light p-3 text-center">
                             <i class="fa fa-users fa-2x mb-2" style="color: var(--primary-color);"></i>
                             <h6>Capacity</h6>
                             <p class="mb-0"><?php echo $program->intake_capacity ?? 50; ?> Students</p>
                         </div>
                     </div>
                     <div class="col-md-3 col-6 mb-3">
                         <div class="bg-light p-3 text-center">
                             <i class="fa fa-money fa-2x mb-2" style="color: var(--primary-color);"></i>
                             <h6>Tuition</h6>
                             <p class="mb-0"><?php echo !empty($program->tuition_fee) ? number_format($program->tuition_fee) . ' TZS' : 'Contact Us'; ?></p>
                         </div>
                     </div>
                </div>
                
                <!-- Program Description -->
                <div class="program-description mb-5">
                    <h3>Program Overview</h3>
                    <?php if (!empty($program->description)): ?>
                        <?php echo $program->description; ?>
                    <?php else: ?>
                        <p>This program is designed to provide students with comprehensive knowledge and practical skills in their chosen field of study. Our curriculum is developed in consultation with industry experts to ensure graduates are well-prepared for the workforce.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Requirements -->
                <?php if (!empty($program->requirements)): ?>
                <div class="program-requirements mb-5">
                    <h3>Entry Requirements</h3>
                    <?php echo $program->requirements; ?>
                </div>
                <?php else: ?>
                <div class="program-requirements mb-5">
                    <h3>Entry Requirements</h3>
                    <ul>
                        <li>Completed secondary education (Form IV or Form VI)</li>
                        <li>Minimum grade requirements as specified</li>
                        <li>Valid identification documents</li>
                        <li>Application form and fees</li>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Courses/Modules -->
                <?php if (!empty($courses)): ?>
                <div class="program-courses mb-5">
                    <h3>Program Courses</h3>
                    <div class="table-responsive">
                         <table class="table table-striped">
                             <thead class="text-white" style="background-color: var(--primary-color);">
                                 <tr>
                                     <th>Code</th>
                                     <th>Course Name</th>
                                     <th>Credits</th>
                                     <th>Semester</th>
                                 </tr>
                             </thead>
                            <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                    <tr>
                                         <td><?php echo htmlspecialchars($course->course_code ?? ''); ?></td>
                                         <td><?php echo htmlspecialchars($course->course_name ?? ''); ?></td>
                                         <td><?php echo $course->credits ?? 3; ?></td>
                                         <td><?php echo $course->semester ?? '-'; ?></td>
                                     </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No courses available for this program.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Career Opportunities -->
                <div class="program-careers mb-5">
                    <h3>Career Opportunities</h3>
                    <?php if (!empty($program->career_opportunities)): ?>
                        <?php echo $program->career_opportunities; ?>
                    <?php else: ?>
                        <p>Graduates of this program can pursue careers in various sectors including:</p>
                        <ul>
                            <li>Public and private sector organizations</li>
                            <li>Non-governmental organizations</li>
                            <li>Self-employment and entrepreneurship</li>
                            <li>Further academic studies</li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Apply CTA -->
                <div class="apply-cta text-white p-4 text-center" style="background-color: var(--primary-color);">
                    <h4>Ready to Start Your Journey?</h4>
                    <p class="mb-3">Apply now and take the first step towards your future career.</p>
                    <a href="<?php echo base_url('enquiry?program=' . urlencode($program->code ?? $program->id)); ?>" class="btn btn-white">Apply Now</a>
                </div>
            </div>
            
            <!-- Sidebar -->
             <div class="col-lg-4 sidebar ftco-animate">
                 <!-- Quick Apply -->
                 <div class="sidebar-box text-white p-4" style="background-color: var(--primary-color);">
                     <h3 class="text-white">Quick Apply</h3>
                     <p>Interested in this program? Start your application today.</p>
                     <a href="<?php echo base_url('enquiry?program=' . urlencode($program->code ?? $program->id)); ?>" class="btn btn-white btn-block">Apply Now</a>
                 </div>
                
                <!-- Program Details -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Program Details</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Code:</strong> <?php echo htmlspecialchars($program->code ?? 'N/A'); ?></li>
                        <li class="mb-2"><strong>Department:</strong> <?php echo htmlspecialchars($program->department_name ?? 'General'); ?></li>
                        <li class="mb-2"><strong>Mode:</strong> <?php echo htmlspecialchars($program->study_mode ?? 'Full-time'); ?></li>
                        <li class="mb-2"><strong>Start Date:</strong> <?php echo htmlspecialchars($program->intake_date ?? 'January/September'); ?></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Need Help?</h3>
                    <p>Contact our admissions office for more information.</p>
                    <div class="block-23">
                        <ul>
                            <?php if (!empty($phone_number)): ?>
                            <li><a href="tel:<?php echo $consult_number_call ?? ''; ?>"><span class="icon fa fa-phone"></span><span class="text"><?php echo $phone_number; ?></span></a></li>
                            <?php endif; ?>
                            <?php if (!empty($email_address)): ?>
                            <li><a href="mailto:<?php echo $email_address; ?>"><span class="icon fa fa-envelope"></span><span class="text"><?php echo $email_address; ?></span></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Related Programs -->
                <?php if (!empty($related_programs)): ?>
                <div class="sidebar-box bg-light p-4 mt-4">
                    <h3 class="heading-sidebar">Related Programs</h3>
                    <?php foreach ($related_programs as $related): ?>
                    <div class="block-21 mb-3 d-flex">
                         <?php $rel_img = !empty($related->image) ? base_url('assets/img/programs/' . $related->image) : get_template_image('work-2.jpg'); ?>
                         <a class="blog-img mr-3" style="background-image: url(<?php echo $rel_img; ?>); width: 80px; height: 80px; background-size: cover;"></a>
                        <div class="text">
                            <h4 class="heading" style="font-size: 14px;"><a href="<?php echo base_url('programs/' . ($related->code ?? $related->id)); ?>"><?php echo htmlspecialchars($related->name); ?></a></h4>
                            <span class="badge badge-secondary"><?php echo htmlspecialchars($related->level ?? 'Diploma'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
