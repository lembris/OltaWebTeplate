<!-- Directory Entry Details View -->
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    
    .detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .type-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.3);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 10px;
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
        <h1 class="page-title">Directory Entry Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/directory') ?>">Directory</a></li>
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

<!-- Entry Header -->
<div class="detail-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="detail-title">
                <?= htmlspecialchars($entry->name) ?>
            </div>
            <span class="type-badge"><?= ucfirst($entry->type) ?></span>
            <div style="margin-top: 15px;">
                <span class="status-badge <?= $entry->status ?>">
                    <?= ucfirst($entry->status) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Entry Information -->
<div class="row">
    <div class="col-md-8">
        <!-- Contact Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-phone"></i>
                Contact Information
            </div>
            <div class="info-card-body">
                <?php if ($entry->contact_person): ?>
                <div class="info-row">
                    <span class="info-label">Contact Person:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($entry->contact_person) ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($entry->email): ?>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:<?= htmlspecialchars($entry->email) ?>">
                            <?= htmlspecialchars($entry->email) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($entry->phone): ?>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        <a href="tel:<?= htmlspecialchars($entry->phone) ?>">
                            <?= htmlspecialchars($entry->phone) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($entry->alternate_phone): ?>
                <div class="info-row">
                    <span class="info-label">Alternate Phone:</span>
                    <span class="info-value">
                        <a href="tel:<?= htmlspecialchars($entry->alternate_phone) ?>">
                            <?= htmlspecialchars($entry->alternate_phone) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Location Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-map-marker-alt"></i>
                Location Information
            </div>
            <div class="info-card-body">
                <?php if ($entry->location): ?>
                <div class="info-row">
                    <span class="info-label">Location:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($entry->location) ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($entry->room_number): ?>
                <div class="info-row">
                    <span class="info-label">Room Number:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($entry->room_number) ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($entry->website): ?>
                <div class="info-row">
                    <span class="info-label">Website:</span>
                    <span class="info-value">
                        <a href="<?= htmlspecialchars($entry->website) ?>" target="_blank" rel="noopener noreferrer">
                            <?= htmlspecialchars($entry->website) ?>
                            <i class="fas fa-external-link-alt ms-1" style="font-size: 0.75rem;"></i>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <?php if ($entry->description): ?>
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-align-left"></i>
                Description
            </div>
            <div class="info-card-body">
                <div class="description-text">
                    <?= $entry->description ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Entry Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-info"></i>
                Entry Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Type:</span>
                    <span class="info-value"><?= ucfirst($entry->type) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge <?= $entry->status ?>">
                            <?= ucfirst($entry->status) ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

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
                        <?= date('M d, Y \a\t h:i A', strtotime($entry->created_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Updated:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($entry->updated_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value"><?= $entry->id ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= base_url('admin/directory/edit/' . $entry->uid) ?>" class="btn btn-primary flex-fill">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="<?= base_url('admin/directory') ?>" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <button type="button" class="btn btn-danger w-100 mt-3" onclick="confirmDelete('<?= base_url('admin/directory/delete/' . $entry->uid) ?>', 'directory entry')">
            <i class="fas fa-trash me-2"></i> Delete Entry
        </button>
    </div>
</div>


