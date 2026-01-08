<?php $this->load->view('includes/header', $data); ?>
<?php $this->load->view('includes/navigation', $data); ?>

<div class="container-fluid page-wrapper">
    <div class="page-header mb-4">
        <h1><?php echo $page_title; ?></h1>
        <p class="text-muted">Explore our comprehensive academic offerings</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form method="get" action="<?php echo base_url('programs/search'); ?>" class="search-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search programs..." required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($programs)): ?>
        <div class="row">
            <?php foreach ($programs as $program): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 program-card">
                        <?php if (!empty($program->image)): ?>
                            <img src="<?php echo base_url($program->image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($program->name); ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-info text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-graduation-cap fa-3x"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($program->name); ?></h5>
                            <p class="card-text small text-muted">
                                <strong>Code:</strong> <?php echo htmlspecialchars($program->code); ?>
                            </p>
                            <p class="card-text small text-muted">
                                <strong>Level:</strong> <?php echo ucfirst($program->level); ?>
                            </p>
                            <p class="card-text small text-muted">
                                <strong>Department:</strong> <?php echo htmlspecialchars($program->department_name); ?>
                            </p>
                            <?php if (!empty($program->duration_months)): ?>
                                <p class="card-text small text-muted">
                                    <strong>Duration:</strong> <?php echo $program->duration_months; ?> months
                                </p>
                            <?php endif; ?>
                            <a href="<?php echo base_url('programs/view/' . $program->id); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No programs found.
        </div>
    <?php endif; ?>
</div>

<?php $this->load->view('includes/footer', $data); ?>
