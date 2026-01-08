<!-- Directory Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/directory') ?>">Directory</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/directory') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart(isset($entry) && $entry ? 'admin/directory/edit/' . $entry->uid : 'admin/directory/create', ['id' => 'directoryForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-address-book me-2"></i>Basic Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Entry Type <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('type') ? 'is-invalid' : '' ?>" 
                                    name="type" 
                                    required>
                                <option value="">Select Type</option>
                                <?php foreach ($types as $key => $label): ?>
                                    <option value="<?= $key ?>" 
                                        <?= set_select('type', $key, isset($entry) && $entry && $entry->type == $key) ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('type')): ?>
                                <div class="text-danger small mt-1"><?= form_error('type') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   name="name" 
                                   value="<?= set_value('name', isset($entry) && $entry ? $entry->name : '') ?>" 
                                   placeholder="e.g., Computer Science Department"
                                   required>
                            <?php if (form_error('name')): ?>
                                <div class="text-danger small mt-1"><?= form_error('name') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Person</label>
                        <input type="text" 
                               class="form-control" 
                               name="contact_person" 
                               value="<?= set_value('contact_person', isset($entry) && $entry ? $entry->contact_person : '') ?>" 
                               placeholder="e.g., Dr. John Smith">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                                   name="email" 
                                   value="<?= set_value('email', isset($entry) && $entry ? $entry->email : '') ?>" 
                                   placeholder="e.g., info@example.com">
                            <?php if (form_error('email')): ?>
                                <div class="text-danger small mt-1"><?= form_error('email') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" 
                                   class="form-control" 
                                   name="phone" 
                                   value="<?= set_value('phone', isset($entry) && $entry ? $entry->phone : '') ?>" 
                                   placeholder="e.g., +1 (555) 123-4567"
                                   maxlength="20">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alternate Phone</label>
                        <input type="tel" 
                               class="form-control" 
                               name="alternate_phone" 
                               value="<?= set_value('alternate_phone', isset($entry) && $entry ? $entry->alternate_phone : '') ?>" 
                               placeholder="e.g., +1 (555) 987-6543"
                               maxlength="20">
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-2"></i>Location Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location/Building</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="location" 
                                   value="<?= set_value('location', isset($entry) && $entry ? $entry->location : '') ?>" 
                                   placeholder="e.g., Science Building">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="room_number" 
                                   value="<?= set_value('room_number', isset($entry) && $entry ? $entry->room_number : '') ?>" 
                                   placeholder="e.g., 301"
                                   maxlength="50">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="url" 
                               class="form-control" 
                               name="website" 
                               value="<?= set_value('website', isset($entry) && $entry ? $entry->website : '') ?>" 
                               placeholder="e.g., https://example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="8"><?= set_value('description', isset($entry) && $entry ? $entry->description : '') ?></textarea>
                        <small class="text-muted">Additional information about this directory entry.</small>
                    </div>
                </div>
            </div>

            <!-- Profile Image -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Profile Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($entry->image ?? null)): ?>
                                <img src="<?= base_url('assets/img/directory/' . $entry->image) ?>" 
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
                        <small class="text-muted">Recommended: 300x300px. Max 2MB. JPG, PNG, WebP</small>
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
                            <option value="active" <?= set_select('status', 'active', !isset($entry) || !$entry || $entry->status == 'active') ?>>
                                Active
                            </option>
                            <option value="inactive" <?= set_select('status', 'inactive', isset($entry) && $entry && $entry->status == 'inactive') ?>>
                                Inactive
                            </option>
                        </select>
                        <small class="text-muted">Active entries appear in public directory listings.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($entry) && $entry ? 'Update Entry' : 'Create Entry' ?>
                        </button>
                        <a href="<?= base_url('admin/directory') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Directory Info (Edit Mode) -->
            <?php if (isset($entry) && $entry): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Entry Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $entry->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Type:</td>
                            <td><?= ucfirst($entry->type) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($entry->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($entry->updated_at)) ?></td>
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
                        <h6 class="text-primary small">Entry Types</h6>
                        <p class="small text-muted">Department, Faculty, Staff, Office, or Service. Choose the appropriate category.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary small">Location Details</h6>
                        <p class="small text-muted">Provide building name and room number for easy student access.</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">Description</h6>
                        <p class="small text-muted">Use the rich editor to add hours, services, or other relevant details.</p>
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
