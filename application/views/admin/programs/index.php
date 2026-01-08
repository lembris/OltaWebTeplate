<!-- Academic Programs List -->
<style>
    .program-card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .program-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .prog-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    
    .prog-body {
        padding: 20px;
        background: #fff;
    }
    
    .prog-code {
        display: inline-block;
        background: rgba(245, 87, 108, 0.15);
        color: #f5576c;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .prog-meta {
        font-size: 0.9rem;
        color: #666;
        margin: 8px 0;
    }
    
    .level-badge {
        display: inline-block;
        background: rgba(245, 87, 108, 0.1);
        color: #f5576c;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 10px;
    }
    
    .status-badge.active {
        background: rgba(39, 174, 96, 0.15);
        color: #27ae60;
    }
    
    .status-badge.inactive {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Academic Programs</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Academic Programs</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/programs/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Program
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filters Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="keyword" class="form-control" 
                       placeholder="Search by name, code, or description..." 
                       value="<?= isset($keyword) ? $keyword : '' ?>" autocomplete="off">
            </div>
            <div class="col-md-3">
                <select name="department" class="form-select">
                    <option value="">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept->id ?>" 
                            <?= (isset($dept_filter) && $dept_filter == $dept->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="level" class="form-select">
                    <option value="">All Levels</option>
                    <?php foreach ($levels as $level): ?>
                        <option value="<?= $level ?>" 
                            <?= (isset($level_filter) && $level_filter == $level) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($level) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search me-2"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Programs Grid -->
<div class="row">
    <?php if (empty($programs)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-graduation-cap mb-3" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mb-0">No academic programs found</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($programs as $program): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card program-card">
                <div class="prog-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-2"><?= htmlspecialchars($program->name) ?></h5>
                            <span class="prog-code"><?= htmlspecialchars($program->code) ?></span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('admin/programs/view/' . $program->uid) ?>">
                                    <i class="fas fa-eye me-2"></i> View Details
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/programs/edit/' . $program->uid) ?>">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"
                                    onclick="confirmDelete('<?= base_url('admin/programs/delete/' . $program->uid) ?>', 'program'); return false;">
                                    <i class="fas fa-trash me-2"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="prog-body">
                    <div class="prog-meta">
                        <i class="fas fa-sitemap me-2" style="color: #f5576c;"></i>
                        <strong><?= htmlspecialchars($program->department_name) ?></strong>
                    </div>
                    
                    <div class="prog-meta">
                        <i class="fas fa-book me-2" style="color: #f5576c;"></i>
                        <span class="level-badge"><?= htmlspecialchars($program->level) ?></span>
                    </div>
                    
                    <div class="prog-meta">
                        <i class="fas fa-hourglass-half me-2" style="color: #f5576c;"></i>
                        <?= $program->duration_months ?> months
                    </div>
                    
                    <?php if ($program->description): ?>
                    <div class="prog-meta">
                        <small class="text-muted"><?= htmlspecialchars(substr($program->description, 0, 80)) ?><?= strlen($program->description) > 80 ? '...' : '' ?></small>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="status-badge <?= $program->status ?>">
                            <?= ucfirst($program->status) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


