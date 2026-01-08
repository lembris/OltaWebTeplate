<!-- Departments List -->
<style>
    .department-card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .department-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .dept-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    
    .dept-body {
        padding: 20px;
        background: #fff;
    }
    
    .dept-code {
        display: inline-block;
        background: rgba(102, 126, 234, 0.15);
        color: #667eea;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .dept-head {
        font-weight: 600;
        color: #333;
        margin: 10px 0 5px;
    }
    
    .dept-contact {
        font-size: 0.9rem;
        color: #666;
        margin: 5px 0;
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
        <h1 class="page-title">Departments</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Departments</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/departments/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Department
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

<!-- Search Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-9">
                <input type="text" name="keyword" class="form-control" 
                       placeholder="Search by name, code, or head name..." 
                       value="<?= $keyword ?>" autocomplete="off">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search me-2"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Departments Grid -->
<div class="row">
    <?php if (empty($departments)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-sitemap mb-3" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mb-0">No departments found</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($departments as $dept): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card department-card">
                <div class="dept-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-2"><?= htmlspecialchars($dept->name) ?></h5>
                            <span class="dept-code"><?= htmlspecialchars($dept->code) ?></span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('admin/departments/view/' . $dept->uid) ?>">
                                    <i class="fas fa-eye me-2"></i> View Details
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/departments/edit/' . $dept->uid) ?>">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('<?= base_url('admin/departments/delete/' . $dept->uid) ?>', 'department')">
                                    <i class="fas fa-trash me-2"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dept-body">
                    <div class="dept-head">
                        <i class="fas fa-user me-2" style="color: #667eea;"></i>
                        <?= htmlspecialchars($dept->head_name) ?>
                    </div>
                    
                    <?php if ($dept->head_email): ?>
                    <div class="dept-contact">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:<?= htmlspecialchars($dept->head_email) ?>">
                            <?= htmlspecialchars($dept->head_email) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($dept->head_phone): ?>
                    <div class="dept-contact">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:<?= htmlspecialchars($dept->head_phone) ?>">
                            <?= htmlspecialchars($dept->head_phone) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="status-badge <?= $dept->status ?>">
                            <?= ucfirst($dept->status) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


