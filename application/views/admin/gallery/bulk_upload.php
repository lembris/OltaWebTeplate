<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Bulk Upload Images</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/gallery') ?>">Gallery</a></li>
                <li class="breadcrumb-item active">Bulk Upload</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/gallery') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Gallery
        </a>
    </div>
</div>

<!-- Upload Card -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-upload me-2"></i>Upload Multiple Images
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/gallery/bulk_upload') ?>" method="POST" enctype="multipart/form-data" id="bulkUploadForm">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Drop Zone -->
                    <div class="bulk-upload-area" id="bulkUploadArea">
                        <div class="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt fa-4x mb-3 text-primary"></i>
                            <h4>Drag & Drop Images Here</h4>
                            <p class="text-muted mb-3">or click to browse files</p>
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imagesInput').click()">
                                <i class="fas fa-folder-open me-2"></i>Select Files
                            </button>
                        </div>
                        <input type="file" 
                               name="images[]" 
                               id="imagesInput" 
                               accept="image/jpeg,image/png,image/gif,image/webp"
                               multiple
                               class="d-none">
                    </div>

                    <!-- Preview Grid -->
                    <div class="preview-grid mt-4" id="previewGrid" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><span id="fileCount">0</span> files selected</h5>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllFiles()">
                                <i class="fas fa-times me-1"></i>Clear All
                            </button>
                        </div>
                        <div class="row g-3" id="previewImages"></div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Upload Settings</h5>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label fw-bold">Category</label>
                                <input type="text" 
                                       name="category" 
                                       id="category" 
                                       class="form-control"
                                       placeholder="e.g., Medical Equipment, Healthcare Facilities, Medical Team"
                                       value="<?= set_value('category') ?>"
                                       list="categoryList">
                                <?php if (!empty($categories)): ?>
                                <datalist id="categoryList">
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat->category) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                                <?php endif; ?>
                                <small class="text-muted">All images will be assigned this category</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i> Mark as Featured
                                    </label>
                                </div>
                                <small class="text-muted">Featured images appear on homepage</small>
                            </div>

                            <hr>

                            <div class="upload-info">
                                <p class="mb-2"><i class="fas fa-info-circle text-info me-2"></i><strong>Supported formats:</strong></p>
                                <p class="text-muted small mb-2">JPG, JPEG, PNG, GIF, WEBP</p>
                                
                                <p class="mb-2"><i class="fas fa-file-image text-info me-2"></i><strong>Max file size:</strong></p>
                                <p class="text-muted small mb-2">5MB per image</p>
                                
                                <p class="mb-2"><i class="fas fa-images text-info me-2"></i><strong>Max files:</strong></p>
                                <p class="text-muted small">Up to 20 images at once</p>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary w-100" id="uploadBtn" disabled>
                                <i class="fas fa-upload me-2"></i>Upload Images
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.bulk-upload-area {
    border: 3px dashed #ddd;
    border-radius: 16px;
    padding: 50px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fafafa;
}

.bulk-upload-area:hover {
    border-color: #0d6efd;
    background: rgba(13, 110, 253, 0.02);
}

.bulk-upload-area.dragover {
    border-color: #0d6efd;
    background: rgba(13, 110, 253, 0.08);
    transform: scale(1.01);
}

.preview-item {
    position: relative;
}

.preview-item img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preview-item .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    opacity: 0;
    transition: opacity 0.2s;
}

.preview-item:hover .remove-btn {
    opacity: 1;
}

.preview-item .file-name {
    font-size: 0.75rem;
    color: #666;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin-top: 5px;
}

.upload-info p {
    margin-bottom: 0.25rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('bulkUploadArea');
    const imagesInput = document.getElementById('imagesInput');
    const previewGrid = document.getElementById('previewGrid');
    const previewImages = document.getElementById('previewImages');
    const fileCount = document.getElementById('fileCount');
    const uploadBtn = document.getElementById('uploadBtn');
    
    let selectedFiles = [];

    // Click to upload
    uploadArea.addEventListener('click', function() {
        imagesInput.click();
    });

    // Handle file selection
    imagesInput.addEventListener('change', function() {
        handleFiles(this.files);
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
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        const maxFiles = 20;

        Array.from(files).forEach(file => {
            if (selectedFiles.length >= maxFiles) {
                alert('Maximum 20 files allowed');
                return;
            }

            if (!validTypes.includes(file.type)) {
                alert(`${file.name} is not a valid image format`);
                return;
            }

            if (file.size > maxSize) {
                alert(`${file.name} exceeds 5MB limit`);
                return;
            }

            // Check for duplicates
            if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                return;
            }

            selectedFiles.push(file);
        });

        updatePreview();
    }

    function updatePreview() {
        if (selectedFiles.length === 0) {
            previewGrid.style.display = 'none';
            uploadBtn.disabled = true;
            return;
        }

        previewGrid.style.display = 'block';
        uploadBtn.disabled = false;
        fileCount.textContent = selectedFiles.length;
        previewImages.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-4 col-md-3 col-lg-2';
            col.innerHTML = `
                <div class="preview-item">
                    <img src="" alt="${file.name}" id="preview-${index}">
                    <button type="button" class="remove-btn" onclick="removeFile(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="file-name" title="${file.name}">${file.name}</div>
                </div>
            `;
            previewImages.appendChild(col);

            // Read and display image
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`preview-${index}`).src = e.target.result;
            };
            reader.readAsDataURL(file);
        });

        // Update the actual input
        updateFileInput();
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imagesInput.files = dt.files;
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
    };

    window.clearAllFiles = function() {
        selectedFiles = [];
        updatePreview();
    };
});
</script>
