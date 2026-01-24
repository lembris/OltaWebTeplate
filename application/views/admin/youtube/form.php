<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= isset($video) ? 'Edit Video' : 'Add YouTube Video' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/youtube') ?>">YouTube Videos</a></li>
                <li class="breadcrumb-item active"><?= isset($video) ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/youtube') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-palette me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">This video will be saved for "<?= ucfirst($active_template) ?>" theme. Videos can be marked as "all" to appear on all themes.</span>
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

<div class="row">
    <div class="col-lg-8">
        <form action="<?= $form_action ?>" method="POST" class="card">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
            
            <div class="card-header">
                <span><i class="fas fa-video me-2"></i>Video Details</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" 
                                   id="title" name="title" value="<?= set_value('title', isset($video) ? $video->title : '') ?>" 
                                   placeholder="Video title" required>
                            <?= form_error('title', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">YouTube URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control <?= form_error('youtube_url') ? 'is-invalid' : '' ?>" 
                                   id="youtube_url" name="youtube_url" value="<?= set_value('youtube_url', isset($video) ? $video->youtube_url : '') ?>" 
                                   placeholder="https://www.youtube.com/watch?v=..." required>
                            <?= form_error('youtube_url', '<div class="invalid-feedback">', '</div>') ?>
                            <small class="text-muted">Paste a YouTube video link (youtube.com or youtu.be)</small>
                            
                            <?php if (isset($video) && $video->youtube_video_id): ?>
                            <div class="mt-2">
                                <img src="https://img.youtube.com/vi/<?= $video->youtube_video_id ?>/hqdefault.jpg" 
                                     alt="Video preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Optional description..."><?= set_value('description', isset($video) ? $video->description : '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   value="<?= set_value('category', isset($video) ? $video->category : '') ?>" 
                                   placeholder="e.g., Events, Tutorials, Promos">
                            <small class="text-muted">Group videos by category</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" 
                                   value="<?= set_value('display_order', isset($video) ? $video->display_order : 0) ?>" 
                                   min="0" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                               value="1" <?= set_checkbox('is_featured', '1', isset($video) ? $video->is_featured : FALSE) ?>>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning mr-1"></i>Featured Video
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               value="1" <?= set_checkbox('is_active', '1', isset($video) ? $video->is_active : TRUE) ?>>
                        <label class="form-check-label" for="is_active">
                            Active (publish this video)
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?= isset($video) ? 'Update' : 'Add' ?> Video
                </button>
                <a href="<?= base_url('admin/youtube') ?>" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-info-circle me-2"></i>Information</span>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    <i class="fas fa-link me-1"></i> 
                    <strong>Supported URLs:</strong>
                </p>
                <ul class="small text-muted mb-3">
                    <li>youtube.com/watch?v=VIDEO_ID</li>
                    <li>youtu.be/VIDEO_ID</li>
                    <li>youtube.com/embed/VIDEO_ID</li>
                </ul>
                
                <hr>
                
                <h6>Categories</h6>
                <p class="small text-muted mb-1">Group your videos:</p>
                <?php if (!empty($categories)): ?>
                <div class="mb-3">
                    <?php foreach ($categories as $cat): ?>
                    <span class="badge bg-info mr-1 mb-1"><?= htmlspecialchars($cat->category) ?> (<?= $cat->video_count ?>)</span>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="small text-muted mb-0">No categories yet. Add videos with categories to organize them.</p>
                <?php endif; ?>
                
                <hr>
                
                <h6>Featured Videos</h6>
                <p class="small text-muted mb-0">Featured videos appear with a star icon and may be highlighted on the site.</p>
                
                <hr>
                
                <h6>Display Order</h6>
                <p class="small text-muted mb-0">Lower numbers appear first. Use 0 for default ordering.</p>
            </div>
        </div>
    </div>
</div>
