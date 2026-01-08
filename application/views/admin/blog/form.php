<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $post ? 'Edit Blog Post' : 'Create Blog Post' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/blog') ?>">Blog Posts</a></li>
                <li class="breadcrumb-item active"><?= $post ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline-secondary">
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

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <?= $this->session->flashdata('warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart($form_action, ['id' => 'blogForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Post Content
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control" 
                               value="<?= set_value('title', $post->title ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('blog/post/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $post->slug ?? '') ?>" 
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('category', $key, ($post->category ?? '') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" 
                                       name="author" 
                                       class="form-control" 
                                       value="<?= set_value('author', $post->author ?? '') ?>" 
                                       placeholder="Author name">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" 
                                  class="form-control" 
                                  rows="3" 
                                  maxlength="500"
                                  placeholder="Brief summary of the post (for listings and previews)"><?= set_value('excerpt', $post->excerpt ?? '') ?></textarea>
                        <small class="text-muted">Max 500 characters. Used in blog listings and social sharing.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control ckeditor" 
                                  rows="15"><?= set_value('content', $post->content ?? '') ?></textarea>
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
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="generateBlogSEO()" title="Quick generation">
                            <i class="fas fa-bolt me-1"></i>Auto-Generate
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="generateBlogSEOAI()" title="AI-powered generation">
                            <i class="fas fa-wand-magic-sparkles me-1"></i>AI Polish
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">SEO Title</label>
                        <input type="text" 
                               name="seo_title" 
                               class="form-control" 
                               value="<?= set_value('seo_title', $post->seo_title ?? '') ?>" 
                               maxlength="70">
                        <small class="text-muted">Recommended: 50-60 characters. Leave empty to use post title.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SEO Description</label>
                        <textarea name="seo_description" 
                                  class="form-control" 
                                  rows="3" 
                                  maxlength="160"><?= set_value('seo_description', $post->seo_description ?? '') ?></textarea>
                        <small class="text-muted">Recommended: 150-160 characters. Leave empty to use excerpt.</small>
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
                                   name="published" 
                                   id="published" 
                                   value="1" 
                                   <?= set_checkbox('published', '1', ($post->published ?? 0) == 1) ?>>
                            <label class="form-check-label" for="published">
                                <strong>Published</strong>
                                <br><small class="text-muted">Make this post visible on the website</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $post ? 'Update Post' : 'Create Post' ?>
                        </button>
                        <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Featured Image Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Featured Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($post->featured_image)): ?>
                                <img src="<?= base_url('assets/img/blog/' . $post->featured_image) ?>" 
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
                               name="featured_image" 
                               id="featured_image" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Recommended: 1200x630px. Max 2MB. JPG, PNG, WebP</small>
                    </div>
                </div>
            </div>

            <!-- Post Info (Edit Mode) -->
            <?php if ($post): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Post Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $post->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Views:</td>
                            <td><strong><?= number_format($post->views ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($post->created_at) ? date('M d, Y', strtotime($post->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($post->updated_at) ? date('M d, Y H:i', strtotime($post->updated_at)) : 'N/A' ?></td>
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
    // Auto-generate slug from title
    generateSlug('title', 'slug');
    
    // Image preview with placeholder handling
    document.getElementById('featured_image').addEventListener('change', function() {
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
