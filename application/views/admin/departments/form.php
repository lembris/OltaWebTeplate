<!-- Departments Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/departments') ?>">Departments</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/departments') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart(isset($department) && $department ? 'admin/departments/edit/' . $department->uid : 'admin/departments/create', ['id' => 'departmentForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-sitemap me-2"></i>Department Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   name="name" 
                                   value="<?= set_value('name', isset($department) && $department ? $department->name : '') ?>" 
                                   placeholder="e.g., Computer Science"
                                   required>
                            <?php if (form_error('name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('name') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department Code <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('code') ? 'is-invalid' : '' ?>" 
                                   name="code" 
                                   value="<?= set_value('code', isset($department) && $department ? $department->code : '') ?>" 
                                   placeholder="e.g., CS"
                                   maxlength="50"
                                   required>
                            <small class="text-muted">Unique identifier. Must be unique across departments.</small>
                            <?php if (form_error('code')): ?>
                                <div class="text-danger small mt-1"><?= form_error('code') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('description', isset($department) && $department ? $department->description : '') ?></textarea>
                        <small class="text-muted">Describe the department's mission, focus areas, and objectives.</small>
                    </div>
                </div>
            </div>

            <!-- Head of Department -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie me-2"></i>Head of Department
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Head Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= form_error('head_name') ? 'is-invalid' : '' ?>" 
                               name="head_name" 
                               value="<?= set_value('head_name', isset($department) && $department ? $department->head_name : '') ?>" 
                               placeholder="e.g., Dr. John Doe"
                               required>
                        <?php if (form_error('head_name')): ?>
                            <div class="text-danger small mt-1"><?= form_error('head_name') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="head_email" 
                                   value="<?= set_value('head_email', isset($department) && $department ? $department->head_email : '') ?>" 
                                   placeholder="e.g., john.doe@example.com">
                            <small class="text-muted">Department head's contact email.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" 
                                   class="form-control" 
                                   name="head_phone" 
                                   value="<?= set_value('head_phone', isset($department) && $department ? $department->head_phone : '') ?>" 
                                   placeholder="e.g., +1 (555) 123-4567"
                                   maxlength="20">
                            <small class="text-muted">Department head's contact phone.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Image -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Department Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($department->image ?? null)): ?>
                                <img src="<?= base_url('assets/img/departments/' . $department->image) ?>" 
                                     alt="Current Image" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="imagePreviewPlaceholder"
                                     style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p class="mb-0">No image uploaded</p>
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
                               name="image" 
                               id="image" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Recommended: 600x400px. Max 2MB. JPG, PNG, WebP</small>
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
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= set_select('status', 'active', !isset($department) || !$department || $department->status == 'active') ?>>
                                Active
                            </option>
                            <option value="inactive" <?= set_select('status', 'inactive', isset($department) && $department && $department->status == 'inactive') ?>>
                                Inactive
                            </option>
                        </select>
                        <small class="text-muted">Active departments are visible on the website.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($department) && $department ? 'Update Department' : 'Create Department' ?>
                        </button>
                        <a href="<?= base_url('admin/departments') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Department Info (Edit Mode) -->
            <?php if (isset($department) && $department): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Department Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $department->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($department->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($department->updated_at)) ?></td>
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
                        <h6 class="text-primary small">Department Code</h6>
                        <p class="small text-muted">Use abbreviations like CS, ENG, BUS. This must be unique.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary small">Description</h6>
                        <p class="small text-muted">Use the rich editor to format your description with headings, lists, and links.</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">Status</h6>
                        <p class="small text-muted">Only active departments appear in public listings and faculty assignments.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview with placeholder handling
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
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
    }
});
</script>
