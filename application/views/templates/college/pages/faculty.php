<!-- Faculty Page Custom Styles -->
<style>
    .faculty-card {
        position: relative;
        border-radius: 8px !important;
        overflow: hidden !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    
    .faculty-card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.12) !important;
        transform: translateY(-4px);
    }
    
    .faculty-card img {
        display: block;
        width: 100%;
        height: auto;
    }
</style>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>



<!-- Faculty Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Search & Filter Bar -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background: #f8f9fa;">
                    <div class="card-body">
                        <form action="<?= base_url('faculty/search') ?>" method="GET" id="filterForm" class="filter-form">
                            <div class="row align-items-end g-3">
                                <div class="col-md-6">
                                    <label for="searchInput" class="form-label fw-600 mb-2">Search Faculty</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text border-0 bg-white">
                                            <i class="fa fa-search text-muted"></i>
                                        </span>
                                        <input type="text" id="searchInput" name="q" class="form-control border-0 pl-0" placeholder="Name, email, or specialization..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            <i class="fa fa-search mr-2"></i>Search
                                        </button>
                                        <a href="<?= base_url('faculty') ?>" class="btn btn-outline-secondary btn-lg">
                                            <i class="fa fa-redo mr-2"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h4 class="mb-0">
                            <?php if (!empty($keyword)): ?>
                                Search Results for "<strong><?= htmlspecialchars($keyword) ?></strong>"
                            <?php else: ?>
                                <strong>All Faculty & Staff Members</strong>
                            <?php endif; ?>
                        </h4>
                        <p class="text-muted small mt-1">
                            Showing <?= !empty($faculty) ? count($faculty) : 0 ?> of <?= isset($total_pages) ? ($current_page - 1) * 12 + count($faculty) : '0' ?> members
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($faculty)): ?>
            <div style="display: grid; gap: 20px;">
                <?php foreach ($faculty as $member): ?>
                    <div class="faculty-card-horizontal" style="background: #faf8f6; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; gap: 24px; align-items: flex-start; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
                        
                        <!-- Left: Image -->
                        <div style="flex-shrink: 0;">
                            <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($member->photo)): ?>
                                    <img src="<?= base_url('assets/images/faculty/' . $member->photo) ?>" 
                                         alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/favicon.png'); ?>
                                    <img src="<?= $favicon_url ?>" 
                                         alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" 
                                         style="width: 100%; height: 100%; object-fit: cover; padding: 12px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Center: Info -->
                        <div style="flex-grow: 1;">
                            <h4 class="card-title fw-700 mb-1" style="font-size: 1.3rem; color: #1a1a2e; margin: 0;">
                                <?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>
                            </h4>
                            
                            <p style="margin: 6px 0; font-size: 0.9rem; color: var(--theme-primary, #C7805C); font-weight: 600;">
                                <?= htmlspecialchars($member->title ?? 'Staff') ?>
                            </p>

                            <div style="display: flex; gap: 16px; margin: 12px 0; flex-wrap: wrap;">
                                <?php if (!empty($member->department_name)): ?>
                                    <span style="font-size: 0.85rem; color: #666;">
                                        <strong>Dept:</strong> <?= htmlspecialchars($member->department_name) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($member->email)): ?>
                                    <span style="font-size: 0.85rem; color: #666;">
                                        <i class="fa fa-envelope" style="color: var(--theme-secondary, #90B3A7); margin-right: 4px;"></i>
                                        <a href="mailto:<?= htmlspecialchars($member->email) ?>" style="color: #666; text-decoration: none;">
                                            <?= htmlspecialchars($member->email) ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($member->specialization)): ?>
                                <p style="font-size: 0.9rem; color: #777; margin: 8px 0;">
                                    <i class="fa fa-flask" style="color: var(--theme-secondary, #90B3A7); margin-right: 6px;"></i>
                                    <?= htmlspecialchars($member->specialization) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Right: Buttons -->
                        <div style="flex-shrink: 0; display: flex; gap: 12px; flex-direction: column; min-width: 110px;">
                            <a href="<?= base_url('faculty/view/' . $member->uid) ?>" class="btn btn-primary btn-sm" style="font-weight: 600; border: none; white-space: nowrap; padding: 8px 16px; width: 100%; text-align: center;">
                                <i class="fa fa-eye mr-2"></i>View
                            </a>
                            <button class="btn btn-outline-primary btn-sm" style="font-weight: 600; white-space: nowrap; padding: 8px 16px; width: 100%; text-align: center;">
                                <i class="fa fa-star mr-2"></i>Review
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($total_pages) && $total_pages > 1): ?>
                <div class="row mt-6 mb-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation" class="d-flex justify-content-center">
                            <ul class="pagination pagination-lg shadow-sm rounded">
                                <?php if ($current_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=1') ?>" title="First page">
                                            <i class="fa fa-chevron-left"></i> First
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . ($current_page - 1)) ?>" title="Previous page">
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-left"></i> First</span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-left"></i></span>
                                    </li>
                                <?php endif; ?>

                                <?php 
                                    $start = max(1, $current_page - 2);
                                    $end = min($total_pages, $current_page + 2);
                                    
                                    if ($start > 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif;
                                    
                                    for ($i = $start; $i <= $end; $i++): ?>
                                        <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= base_url('faculty?page=' . $i) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor;
                                    
                                    if ($end < $total_pages): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . ($current_page + 1)) ?>" title="Next page">
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . $total_pages) ?>" title="Last page">
                                            Last <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-right"></i></span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">Last <i class="fa fa-chevron-right"></i></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <p class="text-center text-muted small mt-3">
                            Page <?= $current_page ?> of <?= $total_pages ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-light p-5 text-center">
                        <div class="mb-4">
                            <i class="fa fa-search" style="font-size: 60px; color: #ccc;"></i>
                        </div>
                        <h4 class="card-title mb-2 fw-700">No Faculty Members Found</h4>
                        <p class="card-text text-muted mb-4">
                            <?php if (!empty($keyword)): ?>
                                We couldn't find any faculty members matching "<strong><?= htmlspecialchars($keyword) ?></strong>". 
                                <br>Try refining your search or browse all faculty.
                            <?php else: ?>
                                We are currently updating our faculty directory. Please check back soon.
                            <?php endif; ?>
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="<?= base_url('faculty') ?>" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-left mr-2"></i>View All Faculty
                            </a>
                            <?php if (!empty($keyword)): ?>
                                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                                    <i class="fa fa-undo mr-2"></i>Go Back
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>


<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

