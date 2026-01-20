<div class="page-header">
    <div>
        <h1 class="page-title"><?= $partner ? 'Edit Partner' : 'Add Partner' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/partners') ?>">Partners</a></li>
                <li class="breadcrumb-item active"><?= $partner ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/partners') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('message')): ?>
    <div class="alert alert-<?= $this->session->flashdata('message_type') ?> alert-dismissible fade show">
        <?= $this->session->flashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart($form_action, ['id' => 'partnerForm']) ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-handshake me-2"></i>Partner Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Partner Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               value="<?= set_value('name', $partner->name ?? '') ?>" 
                               required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type ?>" 
                                            <?= set_select('type', $type, ($partner->type ?? '') === $type) ?>>
                                            <?= ucfirst($type) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" 
                                       name="display_order" 
                                       class="form-control" 
                                       value="<?= set_value('display_order', $partner->display_order ?? 0) ?>" 
                                       min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="short_description" 
                               class="form-control" 
                               value="<?= set_value('short_description', $partner->short_description ?? '') ?>" 
                               maxlength="255"
                               required>
                        <small class="text-muted">Brief description for listings (max 255 characters)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="8"><?= set_value('description', $partner->description ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="url" 
                                       name="website" 
                                       class="form-control" 
                                       value="<?= set_value('website', $partner->website ?? '') ?>" 
                                       placeholder="https://">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" 
                                       name="country" 
                                       class="form-control" 
                                       value="<?= set_value('country', $partner->country ?? '') ?>" 
                                       placeholder="e.g., Tanzania, India">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" 
                                       name="contact_email" 
                                       class="form-control" 
                                       value="<?= set_value('contact_email', $partner->contact_email ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Phone</label>
                                <input type="text" 
                                       name="contact_phone" 
                                       class="form-control" 
                                       value="<?= set_value('contact_phone', $partner->contact_phone ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" 
                                  class="form-control" 
                                  rows="2"><?= set_value('address', $partner->address ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Publish
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured" 
                                   value="1" 
                                   <?= set_checkbox('is_featured', '1', ($partner->is_featured ?? 0) == 1) ?>>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured</strong>
                                <br><small class="text-muted">Show on homepage</small>
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="status" 
                                   id="status" 
                                   value="1" 
                                   <?= set_checkbox('status', '1', ($partner->status ?? 'active') == 'active') ?>>
                            <label class="form-check-label" for="status">
                                <strong>Active</strong>
                                <br><small class="text-muted">Make visible on website</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Template</label>
                        <select name="template" class="form-select">
                            <option value="all" <?= set_select('template', 'all', ($partner->template ?? '') == 'all') ?>>All Templates</option>
                            <option value="medical" <?= set_select('template', 'medical', ($partner->template ?? '') == 'medical') ?>>Medical</option>
                            <option value="college" <?= set_select('template', 'college', ($partner->template ?? '') == 'college') ?>>College</option>
                            <option value="tourism" <?= set_select('template', 'tourism', ($partner->template ?? '') == 'tourism') ?>>Tourism</option>
                        </select>
                        <small class="text-muted">Only applies to specific template unless "All" is selected</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $partner ? 'Update Partner' : 'Add Partner' ?>
                        </button>
                        <a href="<?= base_url('admin/partners') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Logo
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($partner->logo)): ?>
                                <img src="<?= base_url('assets/img/partners/' . $partner->logo) ?>" 
                                     alt="Current Logo" 
                                     id="logoPreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px; width: 100%; object-fit: contain; background: #f8f9fa; padding: 10px;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="logoPreviewPlaceholder"
                                     style="height: 120px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <p class="mb-0">No logo uploaded</p>
                                    </div>
                                </div>
                                <img src="" 
                                     alt="Preview" 
                                     id="logoPreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px; width: 100%; object-fit: contain; display: none; background: #f8f9fa; padding: 10px;">
                            <?php endif; ?>
                        </div>

                        <input type="file" 
                               name="logo" 
                               id="logo" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Recommended: 200x200px. Max 2MB. JPG, PNG, WebP</small>
                    </div>
                </div>
            </div>

            <?php if ($partner): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $partner->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><small><?= $partner->uid ?></small></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($partner->created_at) ? date('M d, Y', strtotime($partner->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($partner->updated_at) ? date('M d, Y H:i', strtotime($partner->updated_at)) : 'N/A' ?></td>
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
    document.getElementById('logo').addEventListener('change', function() {
        const placeholder = document.getElementById('logoPreviewPlaceholder');
        const preview = document.getElementById('logoPreview');
        
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
