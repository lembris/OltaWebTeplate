<!-- User Details View -->
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
    
    .detail-role {
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
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-right: 20px;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">User Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
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

<!-- User Header -->
<div class="detail-header">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
            <div class="user-avatar">
                <?php if ($user->photo && file_exists('assets/images/users/' . $user->photo)): ?>
                    <img src="<?= base_url('assets/images/users/' . $user->photo) ?>" alt="<?= htmlspecialchars($user->full_name) ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                <?php else: ?>
                    <i class="fas fa-user"></i>
                <?php endif; ?>
            </div>
            <div>
                <div class="detail-title"><?= htmlspecialchars($user->full_name) ?></div>
                <div class="detail-role"><?= htmlspecialchars($user->role_name ?? 'Unknown') ?></div>
            </div>
        </div>
        <span class="status-badge <?= $user->status ?>">
            <?= ucfirst($user->status) ?>
        </span>
    </div>
</div>

<!-- User Information -->
<div class="row">
    <div class="col-md-8">
        <!-- Account Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user-circle"></i>
                Account Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value"><?= htmlspecialchars($user->full_name) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Username:</span>
                    <span class="info-value"><code><?= htmlspecialchars($user->username) ?></code></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:<?= htmlspecialchars($user->email) ?>">
                            <?= htmlspecialchars($user->email) ?>
                        </a>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role:</span>
                    <span class="info-value">
                        <span class="badge bg-info"><?= htmlspecialchars($user->role_name ?? 'Unknown') ?></span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge <?= $user->status ?>">
                            <?= ucfirst($user->status) ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-address-book"></i>
                Contact Information
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        <?php if ($user->phone): ?>
                            <a href="tel:<?= htmlspecialchars($user->phone) ?>">
                                <?= htmlspecialchars($user->phone) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    <span class="info-value">
                        <?= $user->address ? htmlspecialchars($user->address) : '<span class="text-muted">Not provided</span>' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Activity Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-clock"></i>
                Activity
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Last Login:</span>
                    <span class="info-value">
                        <?= $user->last_login ? date('M d, Y \a\t h:i A', strtotime($user->last_login)) : '<span class="text-muted">Never</span>' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-info-circle"></i>
                Metadata
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Created:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($user->created_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Updated:</span>
                    <span class="info-value">
                        <?= date('M d, Y \a\t h:i A', strtotime($user->updated_at)) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value"><?= $user->id ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= base_url('admin/users/edit/' . $user->uid) ?>" class="btn btn-primary flex-fill">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <button type="button" class="btn btn-danger w-100 mt-3" onclick="confirmDelete('<?= base_url('admin/users/delete/' . $user->uid) ?>', 'user')">
            <i class="fas fa-trash me-2"></i> Delete User
        </button>
    </div>
</div>
