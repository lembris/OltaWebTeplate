<!-- Faculty Member Details View -->
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 30px;
    }
    
    .faculty-photo-container {
        flex-shrink: 0;
    }
    
    .faculty-photo {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        border: 4px solid white;
        object-fit: cover;
    }
    
    .faculty-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        border: 4px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        font-size: 3rem;
    }
    
    .detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .detail-subtitle {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 15px;
    }
    
    .detail-meta {
        font-size: 0.9rem;
        opacity: 0.9;
        display: flex;
        gap: 20px;
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
    
    .status-badge.on_leave {
        background: rgba(241, 196, 15, 0.15);
        color: #f39c12;
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
        <h1 class="page-title">Faculty Member Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/faculty') ?>">Faculty & Staff</a></li>
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

<!-- Faculty Header -->
<div class="detail-header">
    <div class="faculty-photo-container">
        <?php if ($faculty->photo && file_exists('assets/images/faculty/' . $faculty->photo)): ?>
            <img src="<?= base_url('assets/images/faculty/' . $faculty->photo) ?>" 
                 alt="<?= htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name) ?>" 
                 class="faculty-photo">
        <?php else: ?>
            <div class="faculty-photo-placeholder">
                <i class="fas fa-user"></i>
            </div>
        <?php endif; ?>
    </div>
    <div>
        <div class="detail-title">
            <?= htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name) ?>
        </div>
        <div class="detail-subtitle">
            <?= htmlspecialchars($faculty->title) ?>
        </div>
        <div class="detail-meta">
            <?php if ($faculty->department_name): ?>
            <div>
                <i class="fas fa-sitemap me-2"></i>
                <?= htmlspecialchars($faculty->department_name) ?>
            </div>
            <?php endif; ?>
            <div>
                <span class="status-badge <?= $faculty->status ?>">
                    <?= ucfirst(str_replace('_', ' ', $faculty->status)) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Faculty Information -->
<div class="row">
    <div class="col-md-8">
        <!-- Contact Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-phone"></i>
                Contact Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:<?= htmlspecialchars($faculty->email) ?>">
                            <?= htmlspecialchars($faculty->email) ?>
                        </a>
                    </span>
                </div>
                <?php if ($faculty->phone): ?>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        <a href="tel:<?= htmlspecialchars($faculty->phone) ?>">
                            <?= htmlspecialchars($faculty->phone) ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Office Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-building"></i>
                Office Information
            </div>
            <div class="info-card-body">
                <?php if ($faculty->office_location): ?>
                <div class="info-row">
                    <span class="info-label">Office Location:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($faculty->office_location) ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($faculty->office_hours): ?>
                <div class="info-row">
                    <span class="info-label">Office Hours:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($faculty->office_hours) ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($faculty->specialization): ?>
                <div class="info-row">
                    <span class="info-label">Specialization:</span>
                    <span class="info-value">
                        <?= htmlspecialchars($faculty->specialization) ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Biography -->
        <?php if ($faculty->bio): ?>
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user-circle"></i>
                Biography
            </div>
            <div class="info-card-body">
                <div class="description-text">
                    <?= $faculty->bio ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Qualifications -->
        <?php if ($faculty->qualifications): ?>
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-certificate"></i>
                Qualifications & Credentials
            </div>
            <div class="info-card-body">
                <div class="description-text">
                    <?= $faculty->qualifications ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Professional Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-briefcase"></i>
                Professional Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Title:</span>
                    <span class="info-value"><?= htmlspecialchars($faculty->title) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Department:</span>
                    <span class="info-value"><?= htmlspecialchars($faculty->department_name) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge <?= $faculty->status ?>">
                            <?= ucfirst(str_replace('_', ' ', $faculty->status)) ?>
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
                        <?= date('M d, Y \a\t h:i A', strtotime($faculty->created_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Updated:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($faculty->updated_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value"><?= $faculty->id ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= base_url('admin/faculty/edit/' . $faculty->uid) ?>" class="btn btn-primary flex-fill">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="<?= base_url('admin/faculty') ?>" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <button type="button" class="btn btn-danger w-100 mt-3" onclick="confirmDelete('<?= base_url('admin/faculty/delete/' . $faculty->uid) ?>', 'faculty member')">
            <i class="fas fa-trash me-2"></i> Delete Member
        </button>
    </div>
</div>


