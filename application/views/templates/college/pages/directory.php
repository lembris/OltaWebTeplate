<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Directory Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 sidebar">
                <!-- Search Form -->
                <div class="sidebar-box">
                    <form action="<?= base_url('directory/search') ?>" method="GET" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" name="q" class="form-control" placeholder="Search directory..." value="<?= htmlspecialchars($keyword ?? '') ?>" required>
                        </div>
                    </form>
                </div>

                <!-- Type Filter -->
                <div class="sidebar-box ftco-animate">
                    <h3 class="heading-sidebar">Directory Type</h3>
                    <ul class="categories">
                        <li><a href="<?= base_url('directory') ?>">All Types <span class="fa fa-chevron-right"></span></a></li>
                        <?php if (!empty($types)): ?>
                            <?php foreach ($types as $t): ?>
                                <li>
                                    <a href="<?= base_url('directory/by_type/' . $t->type) ?>">
                                        <?= ucfirst(htmlspecialchars($t->type)) ?> 
                                        <span class="fa fa-chevron-right"></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Directory Content -->
            <div class="col-lg-9">
                <?php if (!empty($entries)): ?>
                    <div class="row">
                        <?php foreach ($entries as $entry): ?>
                            <div class="col-md-6 ftco-animate">
                                <div class="project-wrap">
                                    <a href="<?= base_url('directory/' . $entry->uid) ?>" class="img" style="background-image: url('<?= !empty($entry->image) ? base_url('assets/img/directory/' . $entry->image) : get_template_image('staff-1.jpg') ?>');">
                                        <span class="price"><?= ucfirst(htmlspecialchars($entry->type ?? 'Contact')) ?></span>
                                    </a>
                                    <div class="text p-4">
                                        <h3><a href="<?= base_url('directory/' . $entry->uid) ?>"><?= htmlspecialchars($entry->name) ?></a></h3>
                                        
                                        <?php if (!empty($entry->email)): ?>
                                            <p class="mb-2">
                                                <i class="fa fa-envelope"></i> 
                                                <a href="mailto:<?= htmlspecialchars($entry->email) ?>" class="text-muted">
                                                    <?= htmlspecialchars($entry->email) ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($entry->phone)): ?>
                                            <p class="mb-2">
                                                <i class="fa fa-phone"></i> 
                                                <a href="tel:<?= htmlspecialchars($entry->phone) ?>" class="text-muted">
                                                    <?= htmlspecialchars($entry->phone) ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($entry->location)): ?>
                                            <p class="mb-3">
                                                <i class="fa fa-map-marker"></i> 
                                                <span class="text-muted">
                                                    <?= htmlspecialchars($entry->location) ?>
                                                </span>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('directory/' . $entry->uid) ?>" class="btn btn-sm btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle fa-2x mb-3 d-block"></i>
                                <h4>No Entries Found</h4>
                                <p>We couldn't find any directory entries matching your criteria. Please try a different search or filter.</p>
                                <a href="<?= base_url('directory') ?>" class="btn btn-primary mt-3">View All Entries</a>
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

