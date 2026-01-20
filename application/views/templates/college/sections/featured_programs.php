<!-- DIGITAL MEDIA PROGRAMS HIGHLIGHT -->
<!-- ============================================
     DIGITAL MEDIA PROGRAMS SECTION - Dynamic
     ============================================ -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Specialized Digital Training</span>
                <h2 class="mb-4">Our Digital Media Programs</h2>
                <p class="mb-5">Hands-on training with industry-standard tools and equipment</p>
            </div>
        </div>
        <div class="row">
            <?php
            // Assuming you have these variables available from your controller:
            // $certificate_programs, $diploma_programs, $short_courses
            
            // If programs are not passed separately, group them from $programs array
            if(isset($programs) && !empty($programs)):
                $certificate_programs = array_filter($programs, function($program) {
                    $level = is_object($program) ? $program->level : ($program['level'] ?? '');
                    return $level === 'certificate';
                });
                
                $diploma_programs = array_filter($programs, function($program) {
                    $level = is_object($program) ? $program->level : ($program['level'] ?? '');
                    return $level === 'diploma';
                });
                
                // For short courses, you might need a different query or logic
                // This is just an example - adjust based on your actual data structure
                $short_courses = []; // You would populate this differently
            endif;
            ?>
            
            <!-- Certificate Programs -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title" style="color: var(--theme-primary);">
                            <span class="fa fa-certificate mr-2"></span>Certificate Programs
                        </h4>
                        
                        <?php if(!empty($certificate_programs)): ?>
                            <ul class="list-unstyled mt-3">
                                <?php foreach($certificate_programs as $program): 
                                    $program_name = is_object($program) ? $program->name : ($program['name'] ?? '');
                                    $program_code = is_object($program) ? $program->code : ($program['code'] ?? '');
                                    $program_slug = is_object($program) ? ($program->slug ?? $program_code) : ($program['slug'] ?? $program['code'] ?? '');
                                    $duration = is_object($program) ? ($program->duration_months ?? '') : ($program['duration_months'] ?? '');
                                ?>
                                <li class="mb-2">
                                    <span class="text-success">✓</span>
                                    <?php if(!empty($program_slug)): ?>
                                        <a href="<?php echo base_url('programs/' . $program_slug); ?>" class="text-dark">
                                            <?php echo $program_name; ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo $program_name; ?>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="text-muted small mt-3">
                                Duration: <?php echo !empty($duration) ? $duration . ' months' : '3-6 months'; ?>
                            </p>
                        <?php else: ?>
                            <!-- Fallback if no certificate programs found -->
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2">✓ Graphic Design & Digital Printing</li>
                                <li class="mb-2">✓ Video Production & Editing</li>
                                <li class="mb-2">✓ Social Media Management</li>
                                <li class="mb-2">✓ 2D Animation & Motion Graphics</li>
                                <li>✓ Professional Photography</li>
                            </ul>
                            <p class="text-muted small mt-3">Duration: 3-6 months</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Diploma Programs -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title" style="color: var(--theme-primary);">
                            <span class="fa fa-graduation-cap mr-2"></span>Diploma Programs
                        </h4>
                        
                        <?php if(!empty($diploma_programs)): ?>
                            <ul class="list-unstyled mt-3">
                                <?php foreach($diploma_programs as $program): 
                                    $program_name = is_object($program) ? $program->name : ($program['name'] ?? '');
                                    $program_code = is_object($program) ? $program->code : ($program['code'] ?? '');
                                    $program_slug = is_object($program) ? ($program->slug ?? $program_code) : ($program['slug'] ?? $program['code'] ?? '');
                                    $duration = is_object($program) ? ($program->duration_months ?? '') : ($program['duration_months'] ?? '');
                                ?>
                                <li class="mb-2">
                                    <span class="text-success">✓</span>
                                    <?php if(!empty($program_slug)): ?>
                                        <a href="<?php echo base_url('programs/' . $program_slug); ?>" class="text-dark">
                                            <?php echo $program_name; ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo $program_name; ?>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="text-muted small mt-3">
                                Duration: <?php echo !empty($duration) ? $duration . ' months' : '1-2 years'; ?>
                            </p>
                        <?php else: ?>
                            <!-- Fallback if no diploma programs found -->
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2">✓ Digital Film & TV Production</li>
                                <li class="mb-2">✓ Multimedia Design (UI/UX)</li>
                                <li class="mb-2">✓ Animation & Game Design</li>
                                <li class="mb-2">✓ Digital Journalism & Media</li>
                                <li>✓ Digital Marketing Strategy</li>
                            </ul>
                            <p class="text-muted small mt-3">Duration: 1-2 years</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Short Courses / Workshops -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title" style="color: var(--theme-primary);">
                            <span class="fa fa-bolt mr-2"></span>Workshops & Short Courses
                        </h4>
                        
                        <?php if(!empty($short_courses)): ?>
                            <ul class="list-unstyled mt-3">
                                <?php foreach($short_courses as $course): 
                                    $course_name = is_object($course) ? $course->name : ($course['name'] ?? '');
                                    $course_id = is_object($course) ? $course->id : ($course['id'] ?? '');
                                ?>
                                <li class="mb-2">
                                    <span class="text-success">✓</span>
                                    <?php if(!empty($course_id)): ?>
                                        <a href="<?php echo base_url('courses/' . $course_id); ?>" class="text-dark">
                                            <?php echo $course_name; ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo $course_name; ?>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="text-muted small mt-3">Duration: 1-4 weeks</p>
                        <?php else: ?>
                            <!-- Fallback if no short courses found -->
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2">✓ Adobe Creative Suite Masterclass</li>
                                <li class="mb-2">✓ Drone Videography</li>
                                <li class="mb-2">✓ Podcast Production</li>
                                <li class="mb-2">✓ Smartphone Content Creation</li>
                                <li>✓ Corporate Social Media Training</li>
                            </ul>
                            <p class="text-muted small mt-3">Duration: 1-4 weeks</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Optional: View All Programs Button -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="<?php echo base_url('programs'); ?>" class="btn btn-primary">
                    View All Programs & Courses
                </a>
            </div>
        </div>
    </div>
</section>
