<div class="page-header">
    <div>
        <h1 class="page-title"><?= $specialty ? 'Edit Medical Specialty' : 'Create Medical Specialty' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/specialties') ?>">Medical Specialties</a></li>
                <li class="breadcrumb-item active"><?= $specialty ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/specialties') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart($form_action, ['id' => 'specialtyForm']) ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Specialty Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control" 
                               value="<?= set_value('name', $specialty->name ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('specialty/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $specialty->slug ?? '') ?>" 
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from name</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('category', $key, ($specialty->category ?? '') === $key) ?>>
                                            <?= $label ?>
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
                                       value="<?= set_value('display_order', $specialty->display_order ?? 0) ?>" 
                                       min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="short_description" 
                               class="form-control" 
                               value="<?= set_value('short_description', $specialty->short_description ?? '') ?>" 
                               maxlength="255"
                               required>
                        <small class="text-muted">Brief description for listings and cards (max 255 characters)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('description', $specialty->description ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Features (one per line)</label>
                        <textarea name="features" 
                                  class="form-control" 
                                  rows="5"
                                  placeholder="Feature 1&#10;Feature 2&#10;Feature 3"><?php 
                                    if (!empty($specialty->features)): 
                                        $features_arr = json_decode($specialty->features);
                                        if (is_array($features_arr)) {
                                            echo implode("\n", $features_arr);
                                        }
                                    endif;
                                  ?></textarea>
                        <small class="text-muted">Enter each feature on a new line</small>
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
                                   <?= set_checkbox('is_featured', '1', ($specialty->is_featured ?? 0) == 1) ?>>
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
                                   <?= set_checkbox('status', '1', ($specialty->status ?? 'active') == 'active') ?>>
                            <label class="form-check-label" for="status">
                                <strong>Active</strong>
                                <br><small class="text-muted">Make visible on website</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $specialty ? 'Update Specialty' : 'Create Specialty' ?>
                        </button>
                        <a href="<?= base_url('admin/specialties') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Icon & Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Bootstrap Icon Class</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-gear"></i></span>
                            <input type="text" 
                                   name="icon" 
                                   class="form-control" 
                                   value="<?= set_value('icon', $specialty->icon ?? '') ?>" 
                                   placeholder="e.g., bi-heart-pulse">
                        </div>
                        <small class="text-muted">Enter Bootstrap Icons class name</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <div class="image-preview mb-3">
                            <?php if (!empty($specialty->image)): ?>
                                <img src="<?= base_url('assets/img/specialties/' . $specialty->image) ?>" 
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
                        <small class="text-muted">Recommended: 800x600px. Max 2MB. JPG, PNG, WebP</small>
                    </div>
                </div>
            </div>

            <?php if ($specialty): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $specialty->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><small><?= $specialty->uid ?></small></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($specialty->created_at) ? date('M d, Y', strtotime($specialty->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($specialty->updated_at) ? date('M d, Y H:i', strtotime($specialty->updated_at)) : 'N/A' ?></td>
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
    generateSlug('name', 'slug');
    
    document.getElementById('image').addEventListener('change', function() {
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
