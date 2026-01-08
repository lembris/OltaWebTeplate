<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $package ? 'Edit Package' : 'Create Package' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/packages') ?>">Packages</a></li>
                <li class="breadcrumb-item active"><?= $package ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/packages') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart($form_action, ['id' => 'packageForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Basic Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Package Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control" 
                               value="<?= set_value('name', $package->name ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('safari/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $package->slug ?? '') ?>" 
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
                                            <?= set_select('category', $key, ($package->category ?? '') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="duration_days" 
                                       class="form-control" 
                                       value="<?= set_value('duration_days', $package->duration_days ?? '') ?>" 
                                       min="1" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" 
                                  class="form-control" 
                                  rows="2" 
                                  maxlength="255"><?= set_value('short_description', $package->short_description ?? '') ?></textarea>
                        <small class="text-muted">Max 255 characters. Used for package cards.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('description', $package->description ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Destinations</label>
                        <input type="text" 
                               name="destinations" 
                               class="form-control" 
                               value="<?= set_value('destinations', isset($package->destinations) ? implode(', ', json_decode($package->destinations, true) ?: []) : '') ?>" 
                               placeholder="Serengeti, Ngorongoro, Zanzibar">
                        <small class="text-muted">Comma-separated list of destinations</small>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-dollar-sign me-2"></i>Pricing
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Base Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           name="base_price" 
                                           class="form-control" 
                                           value="<?= set_value('base_price', $pricing->base_price ?? '') ?>" 
                                           step="0.01" 
                                           min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Price Per Person ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           name="price_per_person" 
                                           class="form-control" 
                                           value="<?= set_value('price_per_person', $pricing->price_per_person ?? '') ?>" 
                                           step="0.01" 
                                           min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Single Supplement ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           name="single_supplement" 
                                           class="form-control" 
                                           value="<?= set_value('single_supplement', $pricing->single_supplement ?? '') ?>" 
                                           step="0.01" 
                                           min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-search me-2"></i>SEO Settings
                    </div>
                    <div class="btn-group" role="group" style="gap: 5px;">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="generatePackageSEO()" title="Quick generation">
                            <i class="fas fa-bolt me-1"></i>Auto-Generate
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="generatePackageSEOAI()" title="AI-powered generation">
                            <i class="fas fa-wand-magic-sparkles me-1"></i>AI Polish
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" 
                               name="meta_title" 
                               class="form-control" 
                               value="<?= set_value('meta_title', $package->meta_title ?? '') ?>" 
                               maxlength="70">
                        <small class="text-muted">Recommended: 50-60 characters</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" 
                                  class="form-control" 
                                  rows="3" 
                                  maxlength="160"><?= set_value('meta_description', $package->meta_description ?? '') ?></textarea>
                        <small class="text-muted">Recommended: 150-160 characters</small>
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
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1" 
                                   <?= set_checkbox('is_active', '1', ($package->is_active ?? 1) == 1) ?>>
                            <label class="form-check-label" for="is_active">
                                <strong>Active</strong>
                                <br><small class="text-muted">Make this package visible on the website</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured" 
                                   value="1" 
                                   <?= set_checkbox('is_featured', '1', ($package->is_featured ?? 0) == 1) ?>>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured</strong>
                                <br><small class="text-muted">Show in featured sections</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $package ? 'Update Package' : 'Create Package' ?>
                        </button>
                        <a href="<?= base_url('admin/packages') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Package Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($package->image)): ?>
                                <img src="<?= base_url('assets/img/packages/' . $package->image) ?>" 
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
                               accept="image/*" 
                               onchange="previewImage(this, 'imagePreview')">
                        <small class="text-muted">Recommended: 800x600px. Max 2MB. JPG, PNG, WebP</small>
                    </div>
                </div>
            </div>

            <!-- Gallery Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-images me-2"></i>Package Gallery
                </div>
                <div class="card-body">
                    <!-- Existing Gallery Images -->
                    <?php 
                    $gallery_images = !empty($package->gallery) ? json_decode($package->gallery, true) : [];
                    if (!empty($gallery_images)): 
                    ?>
                    <div class="mb-4">
                        <label class="form-label"><strong>Current Gallery Images</strong></label>
                        <div class="row g-2" id="galleryPreview">
                            <?php foreach ($gallery_images as $img): ?>
                            <div class="col-6 col-sm-4">
                                <div class="gallery-item position-relative">
                                    <img src="<?= base_url('assets/img/packages/gallery/' . $img) ?>" 
                                         alt="Gallery Image" 
                                         class="img-fluid rounded" 
                                         style="width: 100%; height: 120px; object-fit: cover;">
                                    <button type="button" 
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 delete-gallery-btn" 
                                            data-image="<?= htmlspecialchars($img) ?>"
                                            onclick="deleteGalleryImage(this, event)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <input type="hidden" 
                                           name="delete_gallery[]" 
                                           class="delete-gallery-input" 
                                           value="">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr>
                    </div>
                    <?php endif; ?>

                    <!-- New Gallery Upload -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Add Gallery Images</strong></label>
                        
                        <!-- Drag & Drop Area -->
                        <div id="galleryDropZone" class="gallery-drop-zone mb-3">
                            <div class="drop-zone-content">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                                <h5>Drag & Drop Images Here</h5>
                                <p class="text-muted mb-2">or click to select files</p>
                                <small class="text-muted d-block">Max 2MB each. JPG, PNG, WebP</small>
                            </div>
                            <input type="file" 
                                   name="gallery[]" 
                                   id="gallery" 
                                   class="gallery-file-input" 
                                   accept="image/*" 
                                   multiple
                                   style="display: none;">
                        </div>

                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="mb-3" style="display: none;">
                            <div class="progress mb-2">
                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Uploading... <span id="progressText">0%</span></small>
                        </div>

                        <!-- Gallery Preview for New Images -->
                        <div id="newGalleryPreview" class="row g-2"></div>
                    </div>
                </div>
            </div>

            <!-- Package Info (Edit Mode) -->
            <?php if ($package): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Package Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><code style="font-size: 0.85em;"><?= htmlspecialchars($package->uid) ?></code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $package->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($package->created_at) ? date('M d, Y', strtotime($package->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($package->updated_at) ? date('M d, Y H:i', strtotime($package->updated_at)) : 'N/A' ?></td>
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
    // Auto-generate slug from name
    generateSlug('name', 'slug');
    
    // Image preview with placeholder handling
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

    // Gallery Drop Zone
    const dropZone = document.getElementById('galleryDropZone');
    const fileInput = document.getElementById('gallery');
    
    if (dropZone && fileInput) {
        // Click to open file dialog
        dropZone.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when dragging over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, function() {
                dropZone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, function() {
                dropZone.classList.remove('dragover');
            }, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }, false);

        // Handle file selection
        fileInput.addEventListener('change', function() {
            previewGalleryImages(this);
        });
    }
});

// Preview gallery images
function previewGalleryImages(input) {
    const preview = document.getElementById('newGalleryPreview');
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4';
                col.innerHTML = `
                    <div class="gallery-item position-relative">
                        <img src="${e.target.result}" 
                             alt="Preview" 
                             class="img-fluid rounded" 
                             style="width: 100%; height: 120px; object-fit: cover;">
                        <span class="badge bg-primary position-absolute bottom-0 end-0 m-1">New</span>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Delete gallery image
function deleteGalleryImage(btn, event) {
    event.preventDefault();
    const image = btn.getAttribute('data-image');
    const hiddenInput = btn.nextElementSibling;
    const galleryItem = btn.closest('.col-6');
    
    // Mark for deletion
    hiddenInput.value = image;
    
    // Fade out and remove
    galleryItem.style.opacity = '0.5';
    btn.innerHTML = '<i class="fas fa-check"></i>';
    btn.classList.remove('btn-danger');
    btn.classList.add('btn-success');
}
</script>

<style>
/* Gallery Drop Zone */
.gallery-drop-zone {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
}

.gallery-drop-zone:hover {
    border-color: #0d6efd;
    background: #e7f1ff;
}

.gallery-drop-zone.dragover {
    border-color: #0d6efd;
    background: #cfe2ff;
    box-shadow: 0 0 10px rgba(13, 110, 253, 0.3);
    transform: scale(1.02);
}

.gallery-drop-zone .drop-zone-content {
    pointer-events: none;
    user-select: none;
}

.gallery-drop-zone i {
    color: #0d6efd;
    transition: all 0.3s ease;
}

.gallery-drop-zone:hover i,
.gallery-drop-zone.dragover i {
    transform: scale(1.1);
    color: #0a58ca;
}

.gallery-drop-zone h5 {
    color: #1a1a2e;
    font-weight: 600;
    margin-bottom: 8px;
}

.gallery-drop-zone p {
    font-size: 0.95rem;
}

/* Gallery Item Preview */
.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.gallery-item img {
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.gallery-item .delete-gallery-btn {
    z-index: 10;
    border-radius: 50%;
    padding: 4px 8px;
    font-size: 0.8rem;
}

/* Upload Progress */
.progress {
    height: 25px;
    background-color: #e9ecef;
}

.progress-bar {
    font-weight: 600;
    line-height: 25px;
    color: white;
}
</style>
