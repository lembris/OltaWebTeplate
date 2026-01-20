<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= isset($item) ? 'Edit ' . ucfirst($section) : 'Add ' . ucfirst($section) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/about_content/' . $section) ?>"><?= ucfirst($section) ?></a></li>
                <li class="breadcrumb-item active"><?= isset($item) ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/about_content/' . $section) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
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
        <form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="card">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
            
            <div class="card-header">
                <span><i class="fas fa-<?= $section === 'timeline' ? 'history' : ($section === 'accreditations' ? '-certificate' : 'question-circle') ?> me-2"></i><?= ucfirst($section) ?> Details</span>
            </div>
            <div class="card-body">
                <?php if ($section === 'timeline'): ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('year') ? 'is-invalid' : '' ?>" 
                                   id="year" name="year" value="<?= set_value('year', isset($item) ? $item->year : '') ?>" 
                                   placeholder="e.g., 2015, 2023" required>
                            <?= form_error('year', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   value="<?= set_value('icon', isset($item) ? $item->icon : 'fa-calendar') ?>" 
                                   placeholder="e.g., fa-rocket, fa-building">
                            <small class="text-muted">FontAwesome 4.7 icons (fa-*)</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" 
                                   id="title" name="title" value="<?= set_value('title', isset($item) ? $item->title : '') ?>" 
                                   placeholder="e.g., Foundation Established" required>
                            <?= form_error('title', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Describe this milestone..." required><?= set_value('description', isset($item) ? $item->description : '') ?></textarea>
                            <?= form_error('description', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                </div>
                
                <?php elseif ($section === 'accreditations'): ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Organization Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" value="<?= set_value('name', isset($item) ? $item->name : '') ?>" 
                                   placeholder="e.g., NACTE" required>
                            <?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="url" class="form-control" id="website_url" name="website_url" 
                                   value="<?= set_value('website_url', isset($item) ? $item->website_url : '') ?>" 
                                   placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Brief description of this accreditation..."><?= set_value('description', isset($item) ? $item->description : '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Allowed: gif, jpg, jpeg, png, svg, webp (max 2MB)</small>
                            
                            <?php if (isset($item) && !empty($item->logo)): ?>
                                <div class="mt-2">
                                    <img src="<?= base_url('assets/img/about/' . $item->logo) ?>" 
                                         alt="Current logo" class="rounded"
                                         style="max-width: 100px; max-height: 100px; object-fit: contain; border: 1px solid #ddd; padding: 5px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <?php elseif ($section === 'faq'): ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('question') ? 'is-invalid' : '' ?>" 
                                   id="question" name="question" value="<?= set_value('question', isset($item) ? $item->question : '') ?>" 
                                   placeholder="e.g., How do I apply?" required>
                            <?= form_error('question', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   value="<?= set_value('category', isset($item) ? $item->category : '') ?>" 
                                   placeholder="e.g., Admissions, Academics, Career">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= form_error('answer') ? 'is-invalid' : '' ?>" 
                                      id="answer" name="answer" rows="5" 
                                      placeholder="Provide a detailed answer..." required><?= set_value('answer', isset($item) ? $item->answer : '') ?></textarea>
                            <?= form_error('answer', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Common Fields -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" 
                                   value="<?= set_value('display_order', isset($item) ? $item->display_order : 0) ?>" 
                                   min="0" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" 
                               value="1" <?= set_checkbox('status', '1', isset($item) ? $item->status === 'active' : TRUE) ?>>
                        <label class="form-check-label" for="status">
                            Active (publish this <?= $section === 'faq' ? 'FAQ' : ($section === 'accreditations' ? 'accreditation' : 'item') ?>)
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?= isset($item) ? 'Update' : 'Create' ?> <?= ucfirst($section) ?>
                </button>
                <a href="<?= base_url('admin/about_content/' . $section) ?>" class="btn btn-outline-secondary ms-2">
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
                    <i class="fas fa-palette me-1"></i> 
                    <strong>Theme:</strong> <?= ucfirst($active_template) ?>
                </p>
                <p class="small text-muted mb-3">
                    This <?= rtrim($section, 's') ?> will be automatically associated with the 
                    <strong><?= ucfirst($active_template) ?></strong> theme.
                </p>
                
                <hr>
                
                <h6>Display Order</h6>
                <p class="small text-muted mb-3">Lower numbers appear first. Use 0 for default ordering.</p>
                
                <hr>
                
                <?php if ($section === 'timeline'): ?>
                <h6>Icon Classes</h6>
                <p class="small text-muted mb-1">Common icons:</p>
                <ul class="small text-muted mb-0">
                    <li>fa-calendar - Events</li>
                    <li>fa-rocket - Launch/Growth</li>
                    <li>fa-building - Campus</li>
                    <li>fa-graduation-cap - Graduation</li>
                    <li>fa-certificate - Award</li>
                </ul>
                <?php elseif ($section === 'faq'): ?>
                <h6>Categories</h6>
                <p class="small text-muted mb-1">Group FAQs by:</p>
                <ul class="small text-muted mb-0">
                    <li>Admissions</li>
                    <li>Academics</li>
                    <li>Career</li>
                    <li>General</li>
                </ul>
                <?php elseif ($section === 'accreditations'): ?>
                <h6>Logo Guidelines</h6>
                <ul class="small text-muted mb-0">
                    <li>Use transparent PNG or SVG</li>
                    <li>Min 100x100px recommended</li>
                    <li>Max file size: 2MB</li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
