<?php $this->load->view('includes/header'); ?>

<div class="container-fluid page-wrapper">
    <div class="page-header mb-4">
        <h1><?php echo $page_title; ?></h1>
        <p class="text-muted">Search results for "<?php echo htmlspecialchars($keyword); ?>"</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form method="get" action="<?php echo base_url('faculty/search'); ?>" class="search-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search faculty..." value="<?php echo htmlspecialchars($keyword); ?>" required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="faculty-grid">
        <?php if (!empty($results)): ?>
            <div class="row">
                <?php foreach ($results as $member): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 faculty-card">
                            <?php if (!empty($member->photo)): ?>
                                <img src="<?php echo base_url($member->photo); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?></h5>
                                <p class="card-text small text-muted"><?php echo htmlspecialchars($member->title); ?></p>
                                <p class="card-text small"><?php echo htmlspecialchars($member->department_name); ?></p>
                                <a href="<?php echo base_url('faculty/view/' . $member->uid); ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($total_pages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('faculty/search?q=' . urlencode($keyword) . '&page=1'); ?>">First</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('faculty/search?q=' . urlencode($keyword) . '&page=' . ($current_page - 1)); ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo base_url('faculty/search?q=' . urlencode($keyword) . '&page=' . $i); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('faculty/search?q=' . urlencode($keyword) . '&page=' . ($current_page + 1)); ?>">Next</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('faculty/search?q=' . urlencode($keyword) . '&page=' . $total_pages); ?>">Last</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">
                No faculty members found matching "<?php echo htmlspecialchars($keyword); ?>".
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('includes/footer'); ?>
