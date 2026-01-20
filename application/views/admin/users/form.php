<!-- Users Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
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

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart(isset($user) && $user ? 'admin/users/edit/' . $user->uid : 'admin/users/create', ['id' => 'userForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Account Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user me-2"></i>Account Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('full_name') ? 'is-invalid' : '' ?>" 
                                   name="full_name" 
                                   value="<?= set_value('full_name', isset($user) && $user ? $user->full_name : '') ?>" 
                                   placeholder="e.g., John Doe"
                                   required>
                            <?php if (form_error('full_name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('full_name') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" 
                                   name="username" 
                                   value="<?= set_value('username', isset($user) && $user ? $user->username : '') ?>" 
                                   placeholder="e.g., johndoe"
                                   required>
                            <small class="text-muted">Unique username for login.</small>
                            <?php if (form_error('username')): ?>
                                <div class="text-danger small mt-1"><?= form_error('username') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                                   name="email" 
                                   value="<?= set_value('email', isset($user) && $user ? $user->email : '') ?>" 
                                   placeholder="e.g., john.doe@example.com"
                                   required>
                            <small class="text-muted">Must be a unique email address.</small>
                            <?php if (form_error('email')): ?>
                                <div class="text-danger small mt-1"><?= form_error('email') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?= isset($user) && $user ? 'Password (leave blank to keep current)' : 'Password' ?> <?= !isset($user) ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="password" 
                                   class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                                   name="password" 
                                   placeholder="<?= isset($user) && $user ? 'Enter new password (optional)' : 'Enter password' ?>"
                                   <?= !isset($user) ? 'required' : '' ?>>
                            <small class="text-muted">Minimum 6 characters.</small>
                            <?php if (form_error('password')): ?>
                                <div class="text-danger small mt-1"><?= form_error('password') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-address-book me-2"></i>Contact Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" 
                                   class="form-control" 
                                   name="phone" 
                                   value="<?= set_value('phone', isset($user) && $user ? $user->phone : '') ?>" 
                                   placeholder="e.g., +1 (555) 123-4567"
                                   maxlength="20">
                            <small class="text-muted">User's contact phone number.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="address" 
                                   value="<?= set_value('address', isset($user) && $user ? $user->address : '') ?>" 
                                   placeholder="e.g., 123 Main Street">
                            <small class="text-muted">User's residential or office address.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Picture -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-camera me-2"></i>Profile Picture
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="image-preview text-center">
                                <?php if (isset($user) && $user && $user->photo && file_exists('assets/images/users/' . $user->photo)): ?>
                                    <img src="<?= base_url('assets/images/users/' . $user->photo) ?>" 
                                         alt="Profile Photo" 
                                         id="imagePreview" 
                                         class="rounded-circle mb-3" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto" 
                                         id="imagePreviewPlaceholder"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                    </div>
                                    <img src="" 
                                         alt="Preview" 
                                         id="imagePreview" 
                                         class="rounded-circle mb-3" 
                                         style="width: 150px; height: 150px; object-fit: cover; display: none;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Upload Photo</label>
                            <input type="file" 
                                   name="photo" 
                                   id="photo" 
                                   class="form-control" 
                                   accept="image/jpeg,image/png,image/gif">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Maximum file size: 2MB. Allowed formats: JPG, PNG, GIF.
                            </small>
                            <?php if (isset($user) && $user && $user->photo): ?>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                                    <label class="form-check-label text-danger" for="remove_photo">
                                        <i class="fas fa-trash me-1"></i>Remove current photo
                                    </label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Publish
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select <?= form_error('role') ? 'is-invalid' : '' ?>" required>
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $role_id => $role_name): ?>
                                <option value="<?= $role_id ?>" <?= set_select('role', (string)$role_id, isset($user) && $user && (string)$user->role_id === (string)$role_id) ?>>
                                    <?= htmlspecialchars($role_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">User role determines access level and permissions.</small>
                        <?php if (form_error('role')): ?>
                            <div class="text-danger small mt-1"><?= form_error('role') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select <?= form_error('status') ? 'is-invalid' : '' ?>" required>
                            <option value="active" <?= set_select('status', 'active', !isset($user) || !$user || $user->status == 'active') ?>>
                                Active
                            </option>
                            <option value="inactive" <?= set_select('status', 'inactive', isset($user) && $user && $user->status == 'inactive') ?>>
                                Inactive
                            </option>
                        </select>
                        <small class="text-muted">Only active users can log in to the system.</small>
                        <?php if (form_error('status')): ?>
                            <div class="text-danger small mt-1"><?= form_error('status') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Template Theme</label>
                        <select name="template" class="form-select">
                            <option value="all" <?= set_select('template', 'all', !isset($user) || !$user || $user->template == 'all') ?>>
                                All Templates
                            </option>
                            <option value="medical" <?= set_select('template', 'medical', isset($user) && $user && $user->template == 'medical') ?>>
                                Medical Template Only
                            </option>
                            <option value="college" <?= set_select('template', 'college', isset($user) && $user && $user->template == 'college') ?>>
                                College Template Only
                            </option>
                            <option value="tourism" <?= set_select('template', 'tourism', isset($user) && $user && $user->template == 'tourism') ?>>
                                Tourism Template Only
                            </option>
                        </select>
                        <small class="text-muted">User will only see this template's content.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($user) && $user ? 'Update User' : 'Create User' ?>
                        </button>
                        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info (Edit Mode) -->
            <?php if (isset($user) && $user): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>User Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $user->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($user->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($user->updated_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Login:</td>
                            <td><?= $user->last_login ? date('M d, Y H:i', strtotime($user->last_login)) : 'Never' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Form Help -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary small">Username</h6>
                        <p class="small text-muted mb-0">Unique identifier for login. Use lowercase alphanumeric characters.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary small">Role</h6>
                        <p class="small text-muted mb-0">Determines what the user can access in the system.</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">Status</h6>
                        <p class="small text-muted mb-0">Only active users can log into the system.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo preview
    document.getElementById('photo').addEventListener('change', function() {
        const placeholder = document.getElementById('imagePreviewPlaceholder');
        const preview = document.getElementById('imagePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
