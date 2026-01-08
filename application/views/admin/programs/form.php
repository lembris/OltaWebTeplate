<!-- Academic Program Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/programs') ?>">Academic Programs</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/programs') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart(isset($program) && $program ? 'admin/programs/edit/' . $program->uid : 'admin/programs/create', ['id' => 'programForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-2"></i>Basic Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   name="name" 
                                   value="<?= set_value('name', isset($program) && $program ? $program->name : '') ?>" 
                                   placeholder="e.g., Bachelor of Science in Computer Science"
                                   required>
                            <?php if (form_error('name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('name') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Code <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('code') ? 'is-invalid' : '' ?>" 
                                   name="code" 
                                   value="<?= set_value('code', isset($program) && $program ? $program->code : '') ?>" 
                                   placeholder="e.g., BSCS"
                                   required>
                            <?php if (form_error('code')): ?>
                                <div class="text-danger small mt-1"><?= form_error('code') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('department_id') ? 'is-invalid' : '' ?>" 
                                    name="department_id" 
                                    required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->id ?>" 
                                        <?= set_select('department_id', $dept->id, isset($program) && $program && $program->department_id == $dept->id) ?>>
                                        <?= htmlspecialchars($dept->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('department_id')): ?>
                                <div class="text-danger small mt-1"><?= form_error('department_id') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Level <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('level') ? 'is-invalid' : '' ?>" 
                                    name="level" 
                                    required>
                                <option value="">Select Level</option>
                                <?php foreach ($levels as $level): ?>
                                    <option value="<?= $level ?>" 
                                        <?= set_select('level', $level, isset($program) && $program && $program->level == $level) ?>>
                                        <?= htmlspecialchars($level) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('level')): ?>
                                <div class="text-danger small mt-1"><?= form_error('level') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duration <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control <?= form_error('duration_months') ? 'is-invalid' : '' ?>" 
                                   name="duration_months" 
                                   min="1"
                                   value="<?= set_value('duration_months', isset($program) && $program ? $program->duration_months : '') ?>"
                                   placeholder="e.g., 48"
                                   required>
                            <span class="input-group-text">Months</span>
                        </div>
                        <?php if (form_error('duration_months')): ?>
                            <div class="text-danger small mt-1"><?= form_error('duration_months') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Description & Details -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-align-left me-2"></i>Description & Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Program Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="8"><?= set_value('description', isset($program) && $program ? $program->description : '') ?></textarea>
                        <small class="text-muted">Additional information about this academic program.</small>
                    </div>
                </div>
            </div>

            <!-- Program Image -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Program Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($program->image ?? null)): ?>
                                <img src="<?= base_url('assets/img/programs/' . $program->image) ?>" 
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
                            <option value="active" <?= set_select('status', 'active', !isset($program) || !$program || $program->status == 'active') ?>>
                                Active
                            </option>
                            <option value="inactive" <?= set_select('status', 'inactive', isset($program) && $program && $program->status == 'inactive') ?>>
                                Inactive
                            </option>
                        </select>
                        <small class="text-muted">Active programs are visible publicly. Inactive programs are hidden.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($program) && $program ? 'Update Program' : 'Create Program' ?>
                        </button>
                        <a href="<?= base_url('admin/programs') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Program Info (Edit Mode) -->
            <?php if (isset($program) && $program): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Program Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $program->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Code:</td>
                            <td><?= htmlspecialchars($program->code) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($program->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($program->updated_at)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tips -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary small">Program Code</h6>
                        <p class="small text-muted">A unique code (abbreviation) to identify this program. Must be unique across all programs.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary small">Program Level</h6>
                        <p class="small text-muted">The educational level of the program (Certificate, Diploma, Degree, etc.)</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">Description</h6>
                        <p class="small text-muted">Use the rich editor to add overview, objectives, career prospects, or other relevant details.</p>
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
