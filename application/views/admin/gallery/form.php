<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= isset($image) && $image ? 'Edit' : 'Add' ?> Gallery Image</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/gallery') ?>">Gallery</a></li>
                <li class="breadcrumb-item active"><?= isset($image) && $image ? 'Edit' : 'Add' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/gallery') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Gallery
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-image me-2"></i><?= isset($image) && $image ? 'Edit Image Details' : 'Upload New Image' ?>
    </div>
    <div class="card-body">
        <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
            <?= validation_errors() ?>
        </div>
        <?php endif; ?>

        <form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" id="galleryForm">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
            <div class="row">
                <!-- Left Column - Image -->
                <div class="col-lg-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Image <?= isset($image) && $image ? '' : '<span class="text-danger">*</span>' ?></label>
                        
                        <div class="image-upload-area" id="imageUploadArea">
                            <?php if (isset($image) && $image && !empty($image->src)): ?>
                            <div class="current-image" id="currentImage">
                                <img src="<?= base_url($image->src) ?>" alt="Current image" class="img-fluid">
                                <div class="image-change-overlay">
                                    <span><i class="fas fa-camera me-2"></i>Change Image</span>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                <p class="mb-1">Click or drag image here</p>
                                <small class="text-muted">JPG, PNG, GIF, WEBP (max 5MB)</small>
                            </div>
                            <?php endif; ?>
                            
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img src="" alt="Preview" id="previewImg">
                                <button type="button" class="btn btn-sm btn-danger remove-preview" onclick="removePreview()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <input type="file" 
                                   name="image" 
                                   id="imageInput" 
                                   accept="image/jpeg,image/png,image/gif,image/webp"
                                   class="d-none"
                                   <?= isset($image) && $image ? '' : 'required' ?>>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Recommended: 1200×800px or larger for best quality
                        </small>
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="title" 
                                       name="title" 
                                       value="<?= isset($image) ? htmlspecialchars($image->title) : set_value('title') ?>"
                                       placeholder="Enter image title"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $label): ?>
                                    <option value="<?= $key ?>" 
                                        <?= (isset($image) && $image->category === $key) || set_value('category') === $key ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Brief description of the image"><?= isset($image) ? htmlspecialchars($image->description) : set_value('description') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <label for="alt_text" class="form-label fw-bold mb-0">Alt Text (SEO)</label>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-info" onclick="generateGallerySEO()" title="Quick generation">
                                    <i class="fas fa-bolt"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="generateGallerySEOAI()" title="AI-powered generation">
                                    <i class="fas fa-wand-magic-sparkles"></i>
                                </button>
                            </div>
                        </div>
                        <input type="text" 
                               class="form-control" 
                               id="alt_text" 
                               name="alt_text" 
                               value="<?= isset($image) ? htmlspecialchars($image->alt_text) : set_value('alt_text') ?>"
                               placeholder="Descriptive text for accessibility and SEO">
                        <small class="text-muted">Leave empty to use title as alt text</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="display_order" class="form-label fw-bold">Display Order</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="display_order" 
                                       name="display_order" 
                                       value="<?= isset($image) ? $image->display_order : set_value('display_order', '0') ?>"
                                       min="0">
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Options</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               <?= (isset($image) && $image->is_active) || (!isset($image)) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-eye me-1"></i> Active (Visible on site)
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input featured-switch" 
                                               type="checkbox" 
                                               id="is_featured" 
                                               name="is_featured" 
                                               value="1"
                                               <?= isset($image) && $image->is_featured ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_featured">
                                            <i class="fas fa-star me-1"></i> Featured (Show on homepage)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('admin/gallery') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i><?= isset($image) && $image ? 'Update Image' : 'Upload Image' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.image-upload-area {
    border: 2px dashed #ddd;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.image-upload-area:hover {
    border-color: #0d6efd;
    background: rgba(13, 110, 253, 0.02);
}

.image-upload-area.dragover {
    border-color: #0d6efd;
    background: rgba(13, 110, 253, 0.05);
}

.upload-placeholder {
    padding: 30px;
}

.current-image,
.image-preview {
    position: relative;
    width: 100%;
}

.current-image img,
.image-preview img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    object-fit: contain;
}

.image-change-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 10px;
    text-align: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 0 0 8px 8px;
}

.current-image:hover .image-change-overlay {
    opacity: 1;
}

.remove-preview {
    position: absolute;
    top: 10px;
    right: 10px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.featured-switch:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const currentImage = document.getElementById('currentImage');

    // Click to upload
    uploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    // Handle file selection
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            displayPreview(this.files[0]);
        }
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            imageInput.files = e.dataTransfer.files;
            displayPreview(e.dataTransfer.files[0]);
        }
    });

    function displayPreview(file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, GIF, WEBP)');
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            imagePreview.style.display = 'block';
            if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
            if (currentImage) currentImage.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    // Auto-fill alt text from title
    document.getElementById('title').addEventListener('blur', function() {
        const altText = document.getElementById('alt_text');
        if (!altText.value) {
            altText.value = this.value;
        }
    });
});

function removePreview() {
    event.stopPropagation();
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const currentImage = document.getElementById('currentImage');
    
    if (currentImage) {
        currentImage.style.display = 'block';
    } else if (uploadPlaceholder) {
        uploadPlaceholder.style.display = 'block';
    }
}
</script>
