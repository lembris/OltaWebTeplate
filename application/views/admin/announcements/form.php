<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $announcement ? 'Edit Announcement' : 'Create Announcement' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/announcements') ?>">Announcements</a></li>
                <li class="breadcrumb-item active"><?= $announcement ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/announcements') ?>" class="btn btn-outline-secondary">
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

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart($form_action, ['id' => 'announcementForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Announcement Content
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control" 
                               value="<?= set_value('title', $announcement->title ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('announcements/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $announcement->slug ?? '') ?>" 
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" 
                                  class="form-control" 
                                  rows="2" 
                                  maxlength="500"
                                  placeholder="Brief summary of the announcement"><?= set_value('excerpt', $announcement->excerpt ?? '') ?></textarea>
                        <small class="text-muted">Max 500 characters.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control ckeditor" 
                                  rows="10"><?= set_value('content', $announcement->content ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Appearance & Link -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-palette me-2"></i>Appearance & Action
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select" id="announcementType">
                                    <?php foreach ($types as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('type', $key, ($announcement->type ?? 'info') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Icon</label>
                                <select name="icon" class="form-select" id="announcementIcon">
                                    <?php foreach ($icons as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('icon', $key, ($announcement->icon ?? 'fa-bullhorn') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Icon Preview</label>
                                <div class="form-control bg-light text-center" id="iconPreview">
                                    <i class="fas <?= $announcement->icon ?? 'fa-bullhorn' ?> fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Link URL</label>
                                <input type="url" 
                                       name="link_url" 
                                       class="form-control" 
                                       value="<?= set_value('link_url', $announcement->link_url ?? '') ?>" 
                                       placeholder="https://example.com/page">
                                <small class="text-muted">Optional. Add a call-to-action link.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Link Text</label>
                                <input type="text" 
                                       name="link_text" 
                                       class="form-control" 
                                       value="<?= set_value('link_text', $announcement->link_text ?? '') ?>" 
                                       placeholder="Learn More">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scheduling -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar me-2"></i>Scheduling
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date & Time</label>
                                <input type="datetime-local" 
                                       name="start_date" 
                                       class="form-control" 
                                       value="<?= set_value('start_date', isset($announcement->start_date) ? date('Y-m-d\TH:i', strtotime($announcement->start_date)) : '') ?>">
                                <small class="text-muted">Leave empty to start immediately</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date & Time</label>
                                <input type="datetime-local" 
                                       name="end_date" 
                                       class="form-control" 
                                       value="<?= set_value('end_date', isset($announcement->end_date) ? date('Y-m-d\TH:i', strtotime($announcement->end_date)) : '') ?>">
                                <small class="text-muted">Leave empty for no expiration</small>
                            </div>
                        </div>
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
                                   <?= set_checkbox('published', '1', ($announcement->published ?? 0) == 1) ?>>
                            <label class="form-check-label" for="published">
                                <strong>Published</strong>
                                <br><small class="text-muted">Make this announcement visible</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" 
                               name="sort_order" 
                               class="form-control" 
                               value="<?= set_value('sort_order', $announcement->sort_order ?? 0) ?>" 
                               min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $announcement ? 'Update' : 'Create' ?> Announcement
                        </button>
                        <a href="<?= base_url('admin/announcements') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Display Location -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-desktop me-2"></i>Display Location
                </div>
                <div class="card-body">
                    <?php 
                    $selected_locations = isset($announcement->display_location) ? explode(',', $announcement->display_location) : ['homepage'];
                    ?>
                    <?php foreach ($locations as $key => $label): ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="display_location[]" 
                                   value="<?= $key ?>" 
                                   id="loc_<?= $key ?>"
                                   <?= in_array($key, $selected_locations) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="loc_<?= $key ?>">
                                <?= $label ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <small class="text-muted">Select where this announcement should appear</small>
                </div>
            </div>

            <!-- Target Audience -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Target Audience
                </div>
                <div class="card-body">
                    <select name="target_audience" class="form-select">
                        <?php foreach ($audiences as $key => $label): ?>
                            <option value="<?= $key ?>" 
                                <?= set_select('target_audience', $key, ($announcement->target_audience ?? 'all') === $key) ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Featured Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($announcement->image)): ?>
                                <img src="<?= base_url('assets/uploads/announcements/' . $announcement->image) ?>" 
                                     alt="Current Image" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="imagePreviewPlaceholder"
                                     style="height: 100px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <p class="mb-0 small">No image</p>
                                    </div>
                                </div>
                                <img src="" 
                                     alt="Preview" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px; width: 100%; object-fit: cover; display: none;">
                            <?php endif; ?>
                        </div>

                        <input type="file" 
                               name="image" 
                               id="image" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Optional. Max 5MB.</small>
                    </div>
                </div>
            </div>

            <!-- Announcement Info (Edit Mode) -->
            <?php if ($announcement): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $announcement->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Views:</td>
                            <td><strong><?= number_format($announcement->views ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Clicks:</td>
                            <td><strong><?= number_format($announcement->clicks ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($announcement->created_at) ? date('M d, Y', strtotime($announcement->created_at)) : 'N/A' ?></td>
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
    generateSlug('title', 'slug');
    
    // Icon preview
    document.getElementById('announcementIcon').addEventListener('change', function() {
        const icon = this.value;
        document.getElementById('iconPreview').innerHTML = '<i class="fas ' + icon + ' fa-2x"></i>';
    });
    
    // Image preview
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
