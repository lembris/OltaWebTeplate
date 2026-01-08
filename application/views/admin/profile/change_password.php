    <!-- Page Content -->
    <div class="admin-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Change Password</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/profile') ?>">My Profile</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-key me-2"></i> Update Your Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" novalidate>
                            <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= form_error('current_password') ? 'is-invalid' : '' ?>" 
                                           id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (form_error('current_password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= form_error('current_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= form_error('new_password') ? 'is-invalid' : '' ?>" 
                                           id="new_password" name="new_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Password must be at least 6 characters long.
                                </small>
                                <?php if (form_error('new_password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= form_error('new_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" 
                                           id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (form_error('confirm_password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= form_error('confirm_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i> Change Password
                                </button>
                                <a href="<?= base_url('admin/profile') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Requirements Sidebar -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Password Requirements</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading mb-2">Strong Password Guidelines</h6>
                            <ul class="mb-0 ps-3">
                                <li>Minimum 6 characters</li>
                                <li>Mix of uppercase and lowercase letters</li>
                                <li>Include numbers (0-9)</li>
                                <li>Include special characters (!@#$%^&*)</li>
                                <li>Avoid using common words or personal information</li>
                            </ul>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">Security Tips</h6>
                            <ul class="mb-0 ps-3">
                                <li>Never share your password with anyone</li>
                                <li>Change your password regularly</li>
                                <li>Use unique passwords for different accounts</li>
                                <li>Don't use the same password as other websites</li>
                                <li>Log out from shared computers</li>
                            </ul>
                        </div>

                        <div class="alert alert-secondary" role="alert">
                            <h6 class="alert-heading">Forgot Your Password?</h6>
                            <p class="mb-0">
                                <a href="<?= base_url('admin/auth/forgot_password') ?>" class="alert-link">Click here to reset your password</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.type === 'password' ? 'text' : 'password';
    field.type = type;
}
</script>
