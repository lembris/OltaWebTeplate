<!-- Faculty Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/faculty') ?>">Faculty & Staff</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/faculty') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart(isset($faculty) && $faculty ? 'admin/faculty/edit/' . $faculty->uid : 'admin/faculty/create', ['id' => 'facultyForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user me-2"></i>Personal Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('first_name') ? 'is-invalid' : '' ?>" 
                                   name="first_name" 
                                   value="<?= set_value('first_name', isset($faculty) && $faculty ? $faculty->first_name : '') ?>" 
                                   placeholder="e.g., John"
                                   required>
                            <?php if (form_error('first_name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('first_name') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('last_name') ? 'is-invalid' : '' ?>" 
                                   name="last_name" 
                                   value="<?= set_value('last_name', isset($faculty) && $faculty ? $faculty->last_name : '') ?>" 
                                   placeholder="e.g., Doe"
                                   required>
                            <?php if (form_error('last_name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('last_name') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                               name="email" 
                               value="<?= set_value('email', isset($faculty) && $faculty ? $faculty->email : '') ?>" 
                               placeholder="e.g., john.doe@example.com"
                               required>
                        <?php if (form_error('email')): ?>
                            <div class="text-danger small mt-1"><?= form_error('email') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" 
                               class="form-control" 
                               name="phone" 
                               value="<?= set_value('phone', isset($faculty) && $faculty ? $faculty->phone : '') ?>" 
                               placeholder="e.g., +1 (555) 123-4567"
                               maxlength="20">
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-briefcase me-2"></i>Professional Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" 
                                   name="title" 
                                   value="<?= set_value('title', isset($faculty) && $faculty ? $faculty->title : '') ?>" 
                                   placeholder="e.g., Associate Professor"
                                   required>
                            <?php if (form_error('title')): ?>
                                <div class="text-danger small mt-1"><?= form_error('title') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('department_id') ? 'is-invalid' : '' ?>" 
                                    name="department_id" 
                                    required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->id ?>" 
                                        <?= set_select('department_id', $dept->id, isset($faculty) && $faculty && $faculty->dept_id == $dept->id) ?>>
                                        <?= htmlspecialchars($dept->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('department_id')): ?>
                                <div class="text-danger small mt-1"><?= form_error('department_id') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Specialization</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="specialization" 
                                   value="<?= set_value('specialization', isset($faculty) && $faculty ? $faculty->specialization : '') ?>" 
                                   placeholder="e.g., Machine Learning">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Office Location</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="office_location" 
                                   value="<?= set_value('office_location', isset($faculty) && $faculty ? $faculty->office_location : '') ?>" 
                                   placeholder="e.g., Room 301, Building A">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Office Hours</label>
                        <input type="text" 
                               class="form-control" 
                               name="office_hours" 
                               value="<?= set_value('office_hours', isset($faculty) && $faculty ? $faculty->office_hours : '') ?>" 
                               placeholder="e.g., Monday-Friday 2:00 PM - 4:00 PM">
                    </div>
                </div>
            </div>

            <!-- Biography -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-align-left me-2"></i>Biography
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Biography</label>
                        <textarea name="bio" 
                                  id="bio" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('bio', isset($faculty) && $faculty ? $faculty->bio : '') ?></textarea>
                        <small class="text-muted">Include professional background, achievements, and research interests.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qualifications & Credentials</label>
                        <textarea name="qualifications" 
                                  id="qualifications" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('qualifications', isset($faculty) && $faculty ? $faculty->qualifications : '') ?></textarea>
                        <small class="text-muted">List degrees, certifications, publications, and professional memberships.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Status
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= set_select('status', 'active', !isset($faculty) || !$faculty || $faculty->status == 'active') ?>>
                                Active
                            </option>
                            <option value="inactive" <?= set_select('status', 'inactive', isset($faculty) && $faculty && $faculty->status == 'inactive') ?>>
                                Inactive
                            </option>
                            <option value="on_leave" <?= set_select('status', 'on_leave', isset($faculty) && $faculty && $faculty->status == 'on_leave') ?>>
                                On Leave
                            </option>
                        </select>
                        <small class="text-muted">Controls visibility on the public faculty directory.</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" <?= set_checkbox('is_featured', 1, isset($faculty) && $faculty && $faculty->is_featured) ?>>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured</strong>
                            </label>
                        </div>
                        <small class="text-muted">Featured faculty appear on the About page and homepage.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($faculty) && $faculty ? 'Update Faculty Member' : 'Create Faculty Member' ?>
                        </button>
                        <a href="<?= base_url('admin/faculty') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Faculty Photo -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Photo
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (isset($faculty) && $faculty && $faculty->photo && file_exists('assets/images/faculty/' . $faculty->photo)): ?>
                                <img src="<?= base_url('assets/images/faculty/' . $faculty->photo) ?>" 
                                     alt="Faculty Photo" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="imagePreviewPlaceholder"
                                     style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p class="mb-0">No photo uploaded</p>
                                    </div>
                                </div>
                                <img src="" 
                                     alt="Preview" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover; display: none;">
                            <?php endif; ?>
                        </div>

                        <input type="file" 
                               name="photo" 
                               id="photo" 
                               class="form-control" 
                               accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">Max 5MB. JPG, PNG, GIF recommended.</small>
                    </div>
                </div>
            </div>

            <!-- Faculty Info (Edit Mode) -->
            <?php if (isset($faculty) && $faculty): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Faculty Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $faculty->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($faculty->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($faculty->updated_at)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo preview with placeholder handling
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
