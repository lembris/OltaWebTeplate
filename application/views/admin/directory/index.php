<!-- Directory List -->
<style>
    .directory-card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .directory-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .directory-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
    }
    
    .directory-type {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .directory-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .directory-body {
        padding: 20px;
    }
    
    .directory-info {
        margin: 10px 0;
        font-size: 0.9rem;
        color: #666;
    }
    
    .directory-info i {
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
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Directory</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Directory</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/directory/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Entry
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
                       placeholder="Search by name, email, phone, location..." 
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

<!-- Directory Grid -->
<div class="row">
    <?php if (empty($directory)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-address-book mb-3" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mb-0">No directory entries found</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($directory as $entry): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card directory-card">
                <div class="directory-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="directory-type"><?= ucfirst($entry->type) ?></span>
                            <h5 class="directory-name"><?= htmlspecialchars($entry->name) ?></h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('admin/directory/view/' . $entry->uid) ?>">
                                    <i class="fas fa-eye me-2"></i> View Details
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/directory/edit/' . $entry->uid) ?>">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('<?= base_url('admin/directory/delete/' . $entry->uid) ?>', 'directory entry')">
                                    <i class="fas fa-trash me-2"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="directory-body">
                    <?php if ($entry->email): ?>
                    <div class="directory-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?= htmlspecialchars($entry->email) ?>">
                            <?= htmlspecialchars($entry->email) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($entry->phone): ?>
                    <div class="directory-info">
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?= htmlspecialchars($entry->phone) ?>">
                            <?= htmlspecialchars($entry->phone) ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($entry->location): ?>
                    <div class="directory-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($entry->location) ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($entry->room_number): ?>
                    <div class="directory-info">
                        <i class="fas fa-door-open"></i>
                        Room <?= htmlspecialchars($entry->room_number) ?>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="status-badge <?= $entry->status ?>">
                            <?= ucfirst($entry->status) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


