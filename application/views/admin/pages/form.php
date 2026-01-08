<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page ? 'Edit Page' : 'Create Page' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/pages') ?>">Pages</a></li>
                <li class="breadcrumb-item active"><?= $page ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart($form_action, ['id' => 'pageForm']) ?>
    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Page Content
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control" 
                               value="<?= set_value('title', $page->title ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('page/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $page->slug ?? '') ?>" 
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" 
                                  class="form-control" 
                                  rows="3" 
                                  maxlength="500"
                                  placeholder="Brief summary of the page content"><?= set_value('excerpt', $page->excerpt ?? '') ?></textarea>
                        <small class="text-muted">Max 500 characters. Used for previews and listings.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control ckeditor" 
                                  rows="15"><?= set_value('content', $page->content ?? '') ?></textarea>
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
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="generatePageSEO()" title="Quick generation">
                            <i class="fas fa-bolt me-1"></i>Auto-Generate
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="generatePageSEOAI()" title="AI-powered generation">
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
                               value="<?= set_value('seo_title', $page->seo_title ?? '') ?>" 
                               maxlength="70">
                        <small class="text-muted">Recommended: 50-60 characters. Leave empty to use page title.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SEO Description</label>
                        <textarea name="seo_description" 
                                  class="form-control" 
                                  rows="3" 
                                  maxlength="160"><?= set_value('seo_description', $page->seo_description ?? '') ?></textarea>
                        <small class="text-muted">Recommended: 150-160 characters.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SEO Keywords</label>
                        <input type="text" 
                               name="seo_keywords" 
                               class="form-control" 
                               value="<?= set_value('seo_keywords', $page->seo_keywords ?? '') ?>" 
                               placeholder="keyword1, keyword2, keyword3">
                        <small class="text-muted">Comma-separated keywords for search engines.</small>
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
                            <option value="published" <?= set_select('status', 'published', ($page->status ?? 'draft') === 'published') ?>>Published</option>
                            <option value="draft" <?= set_select('status', 'draft', ($page->status ?? 'draft') === 'draft') ?>>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Template</label>
                        <select name="template" class="form-select">
                            <?php foreach ($templates as $key => $label): ?>
                                <option value="<?= $key ?>" <?= set_select('template', $key, ($page->template ?? 'default') === $key) ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" 
                               name="sort_order" 
                               class="form-control" 
                               value="<?= set_value('sort_order', $page->sort_order ?? 0) ?>" 
                               min="0">
                        <small class="text-muted">Lower numbers appear first.</small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="show_in_footer" 
                                   id="show_in_footer" 
                                   value="1" 
                                   <?= set_checkbox('show_in_footer', '1', ($page->show_in_footer ?? 0) == 1) ?>>
                            <label class="form-check-label" for="show_in_footer">
                                <strong>Show in Footer</strong>
                                <br><small class="text-muted">Display link in website footer</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="show_in_header" 
                                   id="show_in_header" 
                                   value="1" 
                                   <?= set_checkbox('show_in_header', '1', ($page->show_in_header ?? 0) == 1) ?>>
                            <label class="form-check-label" for="show_in_header">
                                <strong>Show in Header</strong>
                                <br><small class="text-muted">Display link in website header/navigation</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $page ? 'Update Page' : 'Create Page' ?>
                        </button>
                        <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary">
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
                            <?php if (!empty($page->featured_image)): ?>
                                <img src="<?= base_url('assets/img/pages/' . $page->featured_image) ?>" 
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

            <!-- Page Info (Edit Mode) -->
            <?php if ($page): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Page Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><code><?= $page->uid ?></code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $page->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($page->created_at) ? date('M d, Y', strtotime($page->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($page->updated_at) ? date('M d, Y H:i', strtotime($page->updated_at)) : 'N/A' ?></td>
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
