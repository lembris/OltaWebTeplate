<!-- Faculty & Staff List -->
<style>
    .faculty-card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .faculty-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .faculty-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
    }
    
    .faculty-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .faculty-title {
        font-size: 0.9rem;
        opacity: 0.95;
        margin: 5px 0 0;
    }
    
    .faculty-photo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.3);
        flex-shrink: 0;
    }
    
    .faculty-photo-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: rgba(255,255,255,0.8);
        border: 3px solid rgba(255,255,255,0.3);
        flex-shrink: 0;
    }
    
    .faculty-body {
        padding: 20px;
    }
    
    .faculty-info {
        margin: 10px 0;
        font-size: 0.9rem;
        color: #666;
    }
    
    .faculty-info i {
        color: #667eea;
        width: 20px;
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
    
    .status-badge.on_leave {
        background: rgba(241, 196, 15, 0.15);
        color: #f39c12;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Faculty & Staff</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Faculty & Staff</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/faculty/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Faculty Member
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
                       placeholder="Search by name, email, or specialization..." 
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

<!-- Faculty Grid -->
<div class="row">
    <?php if (empty($faculty)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-users mb-3" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mb-0">No faculty members found</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($faculty as $member): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card faculty-card">
                <div class="faculty-header">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <!-- Avatar -->
                        <?php if ($member->photo && file_exists('assets/images/faculty/' . $member->photo)): ?>
                            <img src="<?= base_url('assets/images/faculty/' . $member->photo) ?>" 
                                 alt="<?= htmlspecialchars($member->first_name) ?>" 
                                 class="faculty-photo">
                        <?php else: ?>
                            <div class="faculty-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex-grow-1">
                            <h5 class="faculty-name">
                                <?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>
                            </h5>
                            <div class="faculty-title"><?= htmlspecialchars($member->title) ?></div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('admin/faculty/view/' . $member->uid) ?>">
                                    <i class="fas fa-eye me-2"></i> View Details
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/faculty/edit/' . $member->uid) ?>">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('<?= base_url('admin/faculty/delete/' . $member->uid) ?>', 'faculty member')">
                                    <i class="fas fa-trash me-2"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="faculty-body">
                    <?php if ($member->email): ?>
                    <div class="faculty-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?= htmlspecialchars($member->email) ?>">
                            <?= htmlspecialchars($member->email) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($member->phone): ?>
                    <div class="faculty-info">
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?= htmlspecialchars($member->phone) ?>">
                            <?= htmlspecialchars($member->phone) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($member->department_name): ?>
                    <div class="faculty-info">
                        <i class="fas fa-sitemap"></i>
                        <?= htmlspecialchars($member->department_name) ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($member->specialization): ?>
                    <div class="faculty-info">
                        <i class="fas fa-graduation-cap"></i>
                        <?= htmlspecialchars($member->specialization) ?>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="status-badge <?= $member->status ?>">
                            <?= ucfirst(str_replace('_', ' ', $member->status)) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


