    <!-- Page Content -->
    <div class="admin-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Profile</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/profile') ?>">My Profile</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Update Your Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" novalidate>
                            <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= form_error('full_name') ? 'is-invalid' : '' ?>" 
                                       id="full_name" name="full_name" 
                                       value="<?= set_value('full_name', $admin->full_name) ?>" required>
                                <?php if (form_error('full_name')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= form_error('full_name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Username (Read-only) -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-muted">(Cannot be changed)</span></label>
                                <input type="text" class="form-control" id="username" value="<?= htmlspecialchars($admin->username) ?>" readonly>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                                       id="email" name="email" 
                                       value="<?= set_value('email', $admin->email) ?>" required>
                                <?php if (form_error('email')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= form_error('email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Avatar -->
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Profile Picture</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this, 'avatarPreview')">
                                        <small class="text-muted d-block mt-2">
                                            Supported formats: JPG, JPEG, PNG, GIF (Max 2MB)
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img id="avatarPreview" 
                                             src="<?= $admin->avatar ? base_url($admin->avatar) : 'https://via.placeholder.com/120' ?>" 
                                             alt="Avatar Preview" 
                                             style="max-width: 120px; max-height: 120px; border-radius: 8px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <!-- Role (Read-only) -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-muted">(Cannot be changed)</span></label>
                                <div>
                                    <span class="status-badge active"><?= htmlspecialchars($admin->role) ?></span>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <a href="<?= base_url('admin/profile') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i> Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">Update Your Information</h6>
                            <p class="mb-0">
                                Keep your profile information up to date. You can change your full name, email, and profile picture at any time.
                            </p>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Profile Picture Guidelines</h6>
                            <ul class="mb-0 ps-3">
                                <li>Use a clear, professional photo</li>
                                <li>Recommended size: 500x500 pixels</li>
                                <li>Maximum file size: 2MB</li>
                                <li>Accepted formats: JPG, PNG, GIF</li>
                            </ul>
                        </div>

                        <div class="alert alert-secondary" role="alert">
                            <h6 class="alert-heading">Need to Change Password?</h6>
                            <p class="mb-0">
                                <a href="<?= base_url('admin/profile/change_password') ?>" class="alert-link">Click here to change your password</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
