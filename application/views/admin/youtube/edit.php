<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Edit YouTube Video</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin-youtube') ?>">YouTube Videos</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Form Card -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-video me-2"></i>Video Details</h5>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin-youtube/edit/' . $video->uid) ?>" id="videoForm">
                    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>

                    <div class="mb-4">
                        <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>"
                               placeholder="Enter video title"
                               value="<?= set_value('title') ?: $video->title ?>"
                               required>
                        <?php if (form_error('title')): ?>
                        <div class="invalid-feedback d-block">
                            <?= form_error('title') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="youtube_url" class="form-label">YouTube URL <span class="text-danger">*</span></label>
                        <input type="url" 
                               name="youtube_url" 
                               id="youtube_url" 
                               class="form-control <?= form_error('youtube_url') ? 'is-invalid' : '' ?>"
                               placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                               value="<?= set_value('youtube_url') ?: $video->youtube_url ?>"
                               required>
                        <?php if (form_error('youtube_url')): ?>
                        <div class="invalid-feedback d-block">
                            <?= form_error('youtube_url') ?>
                        </div>
                        <?php endif; ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Paste the full YouTube URL
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" 
                               name="category" 
                               id="category" 
                               class="form-control"
                               placeholder="e.g., Health Tips, Educational, Wellness"
                               value="<?= set_value('category') ?: ($video->category ?: '') ?>"
                               list="categoryList">
                        <?php if (!empty($categories)): ?>
                        <datalist id="categoryList">
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat->category) ?>">
                            <?php endforeach; ?>
                        </datalist>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter video description"><?= set_value('description') ?: ($video->description ?: '') ?></textarea>
                        <?php if (form_error('description')): ?>
                        <div class="invalid-feedback d-block">
                            <?= form_error('description') ?>
                        </div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Max 2000 characters</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       <?= $video->is_active ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    Active (visible on website)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured"
                                       value="1"
                                       <?= $video->is_featured ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_featured">
                                    <i class="fas fa-star text-warning"></i> Featured (show on homepage)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Video
                        </button>
                        <a href="<?= base_url('admin-youtube') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Card -->
    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h5>
            </div>
            <div class="card-body">
                <div class="video-preview">
                    <div id="previewThumbnail">
                        <img id="thumbnailImg" src="<?= $video->thumbnail_url ?>" alt="Thumbnail" class="img-fluid rounded">
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-youtube text-danger me-1"></i>
                            Video ID: <strong><?= htmlspecialchars($video->youtube_video_id) ?></strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('youtube_url');
    const thumbnailImg = document.getElementById('thumbnailImg');

    // Extract YouTube video ID and update preview
    function extractVideoId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        return match && match[2].length === 11 ? match[2] : null;
    }

    urlInput.addEventListener('input', function() {
        const videoId = extractVideoId(this.value);
        if (videoId) {
            const thumbnailUrl = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
            thumbnailImg.src = thumbnailUrl;
        }
    });

    // Form submission with validation
    document.getElementById('videoForm').addEventListener('submit', function(e) {
        const urlInput = document.getElementById('youtube_url').value;
        if (!urlInput || !extractVideoId(urlInput)) {
            e.preventDefault();
            alert('Please enter a valid YouTube URL');
            return false;
        }
    });
});
</script>

<style>
.video-preview {
    border-radius: 8px;
}

.sticky-top {
    z-index: 1020;
}

@media (max-width: 991px) {
    .sticky-top {
        position: static;
        margin-top: 2rem;
    }
}
</style>
