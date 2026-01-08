<!-- Department Details View -->
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    
    .detail-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .detail-code {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .info-card {
        border: none;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }
    
    .info-card-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        color: #667eea;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-card-body {
        padding: 20px;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #666;
        min-width: 150px;
    }
    
    .info-value {
        color: #333;
        flex: 1;
        word-break: break-word;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-badge.active {
        background: rgba(39, 174, 96, 0.15);
        color: #27ae60;
    }
    
    .status-badge.inactive {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .description-text {
        line-height: 1.6;
        color: #555;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Department Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/departments') ?>">Departments</a></li>
                <li class="breadcrumb-item active">View Details</li>
            </ol>
        </nav>
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

<!-- Department Header -->
<div class="detail-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="detail-title"><?= htmlspecialchars($department->name) ?></div>
            <div class="detail-code"><?= htmlspecialchars($department->code) ?></div>
        </div>
        <span class="status-badge <?= $department->status ?>">
            <?= ucfirst($department->status) ?>
        </span>
    </div>
</div>

<!-- Department Information -->
<div class="row">
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-info-circle"></i>
                Basic Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Department Name:</span>
                    <span class="info-value"><?= htmlspecialchars($department->name) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Department Code:</span>
                    <span class="info-value"><?= htmlspecialchars($department->code) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge <?= $department->status ?>">
                            <?= ucfirst($department->status) ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Head of Department -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user-tie"></i>
                Head of Department
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?= htmlspecialchars($department->head_name) ?></span>
                </div>
                <?php if ($department->head_email): ?>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:<?= htmlspecialchars($department->head_email) ?>">
                            <?= htmlspecialchars($department->head_email) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
                <?php if ($department->head_phone): ?>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        <a href="tel:<?= htmlspecialchars($department->head_phone) ?>">
                            <?= htmlspecialchars($department->head_phone) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <?php if ($department->description): ?>
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-file-alt"></i>
                Description
            </div>
            <div class="info-card-body">
                <div class="description-text">
                    <?= $department->description ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Metadata -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-clock"></i>
                Metadata
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Created:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($department->created_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Updated:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($department->updated_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value"><?= $department->id ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= base_url('admin/departments/edit/' . $department->uid) ?>" class="btn btn-primary flex-fill">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="<?= base_url('admin/departments') ?>" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <button type="button" class="btn btn-danger w-100 mt-3" onclick="confirmDelete('<?= base_url('admin/departments/delete/' . $department->uid) ?>', 'department')">
            <i class="fas fa-trash me-2"></i> Delete Department
        </button>
    </div>
</div>


