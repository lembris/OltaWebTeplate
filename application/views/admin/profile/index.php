    <!-- Page Content -->
    <div class="admin-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">My Profile</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="<?= base_url('admin/profile/edit') ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="<?= isset($admin) && $admin->avatar ? base_url($admin->avatar) : 'https://via.placeholder.com/150' ?>" 
                                 alt="User Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h3 class="card-title"><?= htmlspecialchars(isset($admin) ? $admin->full_name : $admin_name) ?></h3>
                        <p class="text-muted mb-3">
                            <span class="status-badge active"><?= htmlspecialchars($admin_role) ?></span>
                        </p>
                        <p class="text-muted small mb-3"><?= htmlspecialchars($admin_email) ?></p>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('admin/profile/edit') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </a>
                            <a href="<?= base_url('admin/profile/change_password') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-key me-1"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars(isset($admin) ? $admin->full_name : $admin_name) ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars(isset($admin) ? $admin->username : '') ?></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars($admin_email) ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <p class="form-control-plaintext">
                                    <span class="status-badge active"><?= htmlspecialchars($admin_role) ?></span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Account Status</label>
                                <p class="form-control-plaintext">
                                    <span class="status-badge active">Active</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Member Since</label>
                                <p class="form-control-plaintext">
                                    <?php 
                                    if (isset($admin) && !empty($admin->created_at)) {
                                        echo date('M d, Y', strtotime($admin->created_at));
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Last Login</label>
                                <p class="form-control-plaintext">
                                    <?php 
                                    if (isset($admin) && !empty($admin->last_login)) {
                                        echo date('M d, Y H:i A', strtotime($admin->last_login));
                                    } else {
                                        echo 'Never';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6 col-sm-6">
                                <a href="<?= base_url('admin/profile/edit') ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-edit me-1"></i> Edit Profile
                                </a>
                            </div>
                            <div class="col-6 col-sm-6">
                                <a href="<?= base_url('admin/profile/change_password') ?>" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-key me-1"></i> Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
