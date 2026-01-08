<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $notice ? 'Edit Notice' : 'Create Notice' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/notices') ?>">Notices</a></li>
                <li class="breadcrumb-item active"><?= $notice ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/notices') ?>" class="btn btn-outline-secondary">
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

<?= form_open_multipart($form_action, ['id' => 'noticeForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Notice Content
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control" 
                               value="<?= set_value('title', $notice->title ?? '') ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('notices/') ?></span>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="form-control" 
                                   value="<?= set_value('slug', $notice->slug ?? '') ?>" 
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('category', $key, ($notice->category ?? '') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <?php foreach ($priorities as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('priority', $key, ($notice->priority ?? 'normal') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Target Audience</label>
                                <select name="target_audience" class="form-select">
                                    <?php foreach ($audiences as $key => $label): ?>
                                        <option value="<?= $key ?>" 
                                            <?= set_select('target_audience', $key, ($notice->target_audience ?? 'all') === $key) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" 
                                  class="form-control" 
                                  rows="2" 
                                  maxlength="500"
                                  placeholder="Brief summary of the notice"><?= set_value('excerpt', $notice->excerpt ?? '') ?></textarea>
                        <small class="text-muted">Max 500 characters. Used in notice listings.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control ckeditor" 
                                  rows="12"><?= set_value('content', $notice->content ?? '') ?></textarea>
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
                                <label class="form-label">Start Date</label>
                                <input type="date" 
                                       name="start_date" 
                                       class="form-control" 
                                       value="<?= set_value('start_date', isset($notice->start_date) ? date('Y-m-d', strtotime($notice->start_date)) : '') ?>">
                                <small class="text-muted">Leave empty to start immediately when published</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" 
                                       name="end_date" 
                                       class="form-control" 
                                       value="<?= set_value('end_date', isset($notice->end_date) ? date('Y-m-d', strtotime($notice->end_date)) : '') ?>">
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
                                   <?= set_checkbox('published', '1', ($notice->published ?? 0) == 1) ?>>
                            <label class="form-check-label" for="published">
                                <strong>Published</strong>
                                <br><small class="text-muted">Make this notice visible</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="pinned" 
                                   id="pinned" 
                                   value="1" 
                                   <?= set_checkbox('pinned', '1', ($notice->pinned ?? 0) == 1) ?>>
                            <label class="form-check-label" for="pinned">
                                <strong>Pinned</strong>
                                <br><small class="text-muted">Keep at top of notice list</small>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $notice ? 'Update Notice' : 'Create Notice' ?>
                        </button>
                        <a href="<?= base_url('admin/notices') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Attachment Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-paperclip me-2"></i>Attachment
                </div>
                <div class="card-body">
                    <?php if (!empty($notice->attachment)): ?>
                        <div class="mb-3">
                            <div class="alert alert-info mb-2">
                                <i class="fas fa-file me-2"></i>
                                <a href="<?= base_url('assets/uploads/notices/' . $notice->attachment) ?>" target="_blank">
                                    <?= htmlspecialchars($notice->attachment_name ?? $notice->attachment) ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="file" 
                               name="attachment" 
                               id="attachment" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif">
                        <small class="text-muted">PDF, DOC, XLS, PPT, TXT, Images. Max 10MB.</small>
                    </div>
                </div>
            </div>

            <!-- Notice Info (Edit Mode) -->
            <?php if ($notice): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Notice Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $notice->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Views:</td>
                            <td><strong><?= number_format($notice->views ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($notice->created_at) ? date('M d, Y', strtotime($notice->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($notice->updated_at) ? date('M d, Y H:i', strtotime($notice->updated_at)) : 'N/A' ?></td>
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
});
</script>
