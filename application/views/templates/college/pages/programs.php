<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Programs Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 sidebar">
                <!-- Search Form -->
                <div class="sidebar-box">
                    <form action="<?= base_url('programs') ?>" method="GET" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" name="keyword" class="form-control" placeholder="Search programs..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                        </div>
                    </form>
                </div>

                <!-- Department Filter -->
                <div class="sidebar-box ftco-animate">
                    <h3 class="heading-sidebar">Departments</h3>
                    <ul class="categories">
                        <li><a href="<?= base_url('programs') ?>">All Departments <span class="fa fa-chevron-right"></span></a></li>
                        <?php if (!empty($departments)): ?>
                            <?php foreach ($departments as $department): ?>
                                <li>
                                    <a href="<?= base_url('programs?department=' . urlencode($department->code)) ?>">
                                        <?= htmlspecialchars($department->name) ?> 
                                        <span class="fa fa-chevron-right"></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Level Filter -->
                <div class="sidebar-box ftco-animate">
                    <h3 class="heading-sidebar">Program Level</h3>
                    <ul class="categories">
                        <li><a href="<?= base_url('programs') ?>">All Levels <span class="fa fa-chevron-right"></span></a></li>
                        <li><a href="<?= base_url('programs?level=certificate') ?>">Certificate <span class="fa fa-chevron-right"></span></a></li>
                        <li><a href="<?= base_url('programs?level=diploma') ?>">Diploma <span class="fa fa-chevron-right"></span></a></li>
                        <li><a href="<?= base_url('programs?level=degree') ?>">Degree <span class="fa fa-chevron-right"></span></a></li>
                        <li><a href="<?= base_url('programs?level=masters') ?>">Masters <span class="fa fa-chevron-right"></span></a></li>
                    </ul>
                </div>
            </div>

            <!-- Programs Content -->
            <div class="col-lg-9">
                <?php if (!empty($programs)): ?>
                    <div class="row">
                        <?php foreach ($programs as $program): ?>
                            <div class="col-md-6 ftco-animate">
                                <div class="project-wrap">
                                    <?php 
                                    // Determine image URL
                                    $program_image = !empty($program->image) ? $program->image : '';
                                    if (!empty($program_image) && file_exists(FCPATH . 'assets/img/programs/' . $program_image)) {
                                        $image_url = base_url('assets/img/programs/' . $program_image);
                                    } else {
                                        $image_url = base_url('assets/img/dmi_journey.jpg');
                                    }
                                    $program_slug = !empty($program->slug) ? $program->slug : $program->code;
                                    ?>
                                    <a href="<?= base_url('programs/' . $program_slug) ?>" class="img" style="background-image: url('<?= $image_url ?>');">
                                        <span class="price"><?= htmlspecialchars($program->level ?? 'Program') ?></span>
                                    </a>
                                    <div class="text p-4">
                                        <h3><a href="<?= base_url('programs/' . $program_slug) ?>"><?= htmlspecialchars($program->name) ?></a></h3>
                                        <p class="duration">
                                            <span><i class="fa fa-clock-o"></i> <?= htmlspecialchars($program->duration ?? 'Duration N/A') ?></span>
                                        </p>
                                        <ul class="course-info">
                                            <?php if (!empty($program->capacity)): ?>
                                                <li><i class="fa fa-users"></i> <?= $program->capacity ?> Students</li>
                                            <?php endif; ?>
                                            <?php if (!empty($program->tuition_fee)): ?>
                                                <li><i class="fa fa-money"></i> <?= number_format($program->tuition_fee) ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (!empty($pagination)): ?>
                        <div class="row mt-5">
                            <div class="col text-center">
                                <div class="block-27">
                                    <?= $pagination ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle fa-2x mb-3 d-block"></i>
                                <h4>No Programs Found</h4>
                                <p>We couldn't find any programs matching your criteria. Please try a different search or filter.</p>
                                <a href="<?= base_url('programs') ?>" class="btn btn-primary mt-3">View All Programs</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>
